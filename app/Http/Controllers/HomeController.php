<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\BukuTamu;
use App\Models\SpotWisata;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $spots = SpotWisata::orderBy('id')->limit(3)->get();
        $ulasan = BukuTamu::orderByDesc('id')->limit(5)->get();
        $artikelTerbaru = Artikel::orderByDesc('id')->limit(2)->get();

        return view('pages.home', compact('spots', 'ulasan', 'artikelTerbaru'));
    }
}
