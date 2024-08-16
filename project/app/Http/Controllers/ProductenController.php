<?php

namespace App\Http\Controllers;

use App\Models\Producten;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Notifications\ProductStockLevelNotification;
use App\Models\User;

class ProductenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producten = Producten::with('category')->get();
        $categories = Category::all();
        
        return view('producten', [
            'producten' => $producten,
            'categories' => $categories,
        ]);

    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
   {
    // Validate the incoming request data
    $request->validate([
        'product_name' => 'required|string|max:255',
        'quantity' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
    ]);

    // Create a new product
    $product = Producten::create([
        'product_name' => $request->input('product_name'),
        'quantity' => $request->input('quantity'),
        'category_id' => $request->input('category_id'),
    ]);

    // Check stock level and send notification if needed
    $this->checkStockLevel($product);

    // Redirect back with a success message
    return redirect()->route('producten.index')->with('success', 'Product created successfully.');
   }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producten  $producten
     * @return \Illuminate\Http\Response
     */
    public function edit(Producten $producten)
    {
        return view('producten.edit', ['product' => $producten]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producten  $producten
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producten $producten)
   {
    $request->validate([
        'product_name' => 'required|string|max:255',
        'quantity' => 'required|integer',
        'category_id' => 'nullable|exists:categories,id'
    ]);

    $producten->update($request->all());

    // Check stock level and send notification if needed
    $this->checkStockLevel($producten);

    return redirect()->route('producten.index')->with('success', 'Product updated successfully.');
   }


   protected function checkStockLevel($product)
{
    // Check if stock is above 5
    if ($product->quantity < 5) {
        $this->sendNotification($product, 'under');
    } 
}

protected function sendNotification($product, $level)
{
    // Get all users
    $users = User::all();

    // Loop through each user and send the notification
    foreach ($users as $user) {
        $user->notify(new ProductStockLevelNotification($product, $level));
    }
}




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producten  $producten
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producten $producten)
    {
        $producten->delete();

        // Redirect back with a success message
        return redirect()->route('producten.index')->with('success', 'Product deleted successfully.');
    }

    public function destroyAll()
    {
        Log::channel('command')->info('Something happened!');
        Producten::truncate();

     // Redirect back with a success message
     return redirect()->route('producten.index')->with('success', 'All products have been deleted successfully.');
    }
}
