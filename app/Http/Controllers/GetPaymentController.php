<?php

namespace App\Http\Controllers;

use App\Models\DevisesAfricains;
use App\Models\PaysAfricain;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GetPaymentController extends Controller
{
    public function index(Request $request) : View {

        $countries = PaysAfricain::all();
        $currencies = DevisesAfricains::all();

        return view('welcome', compact('countries', 'currencies'));
    }
}
