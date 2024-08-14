<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Illuminate\Http\Request;
use App\Models\Producten;

class ExportController extends Controller
{
    public function authenticate()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->setRedirectUri(route('google.callback'));
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);

        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return redirect()->route('google.authenticate')->withErrors('Authorization code not found.');
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->setRedirectUri(route('google.callback'));
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);

        $accessToken = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($accessToken['error'])) {
            return redirect()->route('google.authenticate')->withErrors('Invalid authorization code or token error.');
        }

        session()->put('google_access_token', $accessToken);
        return redirect()->route('export'); // Redirect to the export process
    }

    public function export()
{
    if (!session()->has('google_access_token')) {
        return redirect()->route('google.authenticate')->withErrors('You need to authenticate with Google first.');
    }

    $accessToken = session('google_access_token');

    $client = new Google_Client();
    $client->setAuthConfig(storage_path('app/google/credentials.json'));
    $client->setAccessToken($accessToken);

    $service = new Google_Service_Sheets($client);

    // Fetch products data
    $products = Producten::all()->map(function ($product) {
        return [
            $product->product_name,
            $product->quantity,
            $product->category ? $product->category->name : 'N/A',
        ];
    })->toArray();

    // Add headers if necessary
    $values = [
        ['Product Name', 'Quantity', 'Category'], // Header row
        ...$products
    ];

    //dd($values);


    // Create a new Google Sheets document
    $spreadsheet = new Google_Service_Sheets_Spreadsheet([
        'properties' => [
            'title' => 'Product Export',
        ],
    ]);

    $spreadsheet = $service->spreadsheets->create($spreadsheet);
    $sheetId = $spreadsheet->spreadsheetId;

    // Prepare data for the sheet
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);

    $params = [
        'valueInputOption' => 'RAW'
    ];

    // Use the default sheet name 'Sheet1' or change it if necessary
    $sheetRange = 'Sheet1!A1';
    $service->spreadsheets_values->update($sheetId, $sheetRange, $body, $params);

    // Create a URL to download the sheet as Excel
    $downloadUrl = 'https://docs.google.com/spreadsheets/d/' . $sheetId . '/export?format=xlsx';

    return redirect()->away($downloadUrl);
}

}
