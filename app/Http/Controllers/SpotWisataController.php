<?php

namespace App\Http\Controllers;

use App\Models\SpotWisata;
use Illuminate\View\View;

class SpotWisataController extends Controller
{
    public function index(): View
    {
        $spots = SpotWisata::orderBy('id')->get();

        return view('pages.spot-wisata', compact('spots'));
    }

    public function show(SpotWisata $spot): View
    {
        $spotLainnya = SpotWisata::query()
            ->where('id', '!=', $spot->id)
            ->orderBy('id')
            ->limit(3)
            ->get();

        return view('pages.spot-wisata-detail', compact('spot', 'spotLainnya'));
    }
}
