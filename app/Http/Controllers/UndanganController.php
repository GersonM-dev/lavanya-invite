<?php

namespace App\Http\Controllers;

use App\Models\Undangan;
use Illuminate\Http\Request;

class UndanganController extends Controller
{
    public function show(Undangan $undangan)
    {
        // Blade will read $undangan and build the Alpine config
        return view('undangan', compact('undangan'));
    }
}
