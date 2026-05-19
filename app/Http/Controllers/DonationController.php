<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Mosque;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('mosque')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('pages.donations.index', compact('donations'));
    }

    public function show(Donation $donation)
    {
        $donation->load('mosque');

        return view('pages.donations.show', compact('donation'));
    }

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

        return back()->with('success', 'Donasi tercatat untuk '.$mosqueName.'. Terima kasih!');
    }

    public function edit(Donation $donation)
    {
        $donation->load('mosque');

        return view('pages.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string',
        ]);

        $donation->update($data);

        return redirect()->route('donations.index')->with('success', 'Donasi berhasil diperbarui.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()->route('donations.index')->with('success', 'Donasi berhasil dihapus.');
    }
}
