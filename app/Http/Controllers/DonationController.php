<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Mosque;

class DonationController extends Controller
{
    public function create($id)
    {
        $mosque = Mosque::withCount('donations')
            ->withSum('donations', 'amount')
            ->findOrFail($id);

        return view('pages.donate', compact('mosque'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mosque_id' => 'required|exists:mosques,id',
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string',
        ]);

        Donation::create($data);

        $mosque = Mosque::find($data['mosque_id']);
        $mosqueName = $mosque ? $mosque->name : 'masjid ini';

        return back()->with('success', 'Donasi tercatat untuk ' . $mosqueName . '. Terima kasih!');
    }
}
