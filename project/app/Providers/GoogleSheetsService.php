<?php

namespace App\Providers;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_SpreadsheetProperties;
use Google_Service_Sheets_ValueRange;

class GoogleSheetsService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $this->client->setAccessType('offline'); // Optional: For long-lived refresh tokens
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function createSheet($title)
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => new Google_Service_Sheets_SpreadsheetProperties([
                'title' => $title,
            ]),
        ]);

        $response = $this->service->spreadsheets->create($spreadsheet);
        return $response->spreadsheetId;
    }

    public function updateSheet($spreadsheetId, $data)
    {
        $range = 'Sheet1'; // Default sheet name
        $valueRange = new Google_Service_Sheets_ValueRange();
        $valueRange->setValues($data);

        $params = [
            'valueInputOption' => 'RAW',
        ];

        $this->service->spreadsheets_values->update($spreadsheetId, $range, $valueRange, $params);
    }

    public function getSheet($spreadsheetId)
    {
        $url = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=xlsx";
        return $url;
    }
}

