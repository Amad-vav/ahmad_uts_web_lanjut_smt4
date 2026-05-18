<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mosque;

class MosqueController extends Controller
{
    public function index()
    {
        $mosques = Mosque::withCount('donations')
            ->withSum('donations', 'amount')
            ->orderBy('name')
            ->get();

        $totalDonations = $mosques->sum('donations_sum_amount');
        $totalDonationCount = $mosques->sum('donations_count');

        return view('pages.home', compact('mosques', 'totalDonations', 'totalDonationCount'));
    }

    public function show($id)
    {
        $mosque = Mosque::withCount('donations')
            ->withSum('donations', 'amount')
            ->findOrFail($id);

        return view('pages.mosque', compact('mosque'));
    }

    // JSON endpoint for maps
    public function apiList()
    {
        return Mosque::all();
    }
}
