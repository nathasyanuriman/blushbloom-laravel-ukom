<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index() 
    { 
        return view('home', [
            'services' => Service::where('is_active', true)->orderBy('price')->take(3)->get()
        ]); 
    }

    public function services() 
    { 
        return view('services.index', [
            'services' => Service::where('is_active', true)->orderBy('price')->get()
        ]); 
    }
}