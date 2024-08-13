<?php

namespace App\Http\Controllers;

use App\Models\Producten;
use App\Models\Category;
use Illuminate\Http\Request;


class OverzichtController extends Controller
{
    //

    public function index()
    {

        $producten = Producten::with('category')->get();
        $categories = Category::all();

        return view('overzicht', [
            'producten' => $producten,
            'categories' => $categories,
        ]);
    }

}
