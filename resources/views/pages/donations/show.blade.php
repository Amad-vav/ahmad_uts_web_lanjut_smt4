<x-app-layout>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-4xl font-bold text-white">Detail Donasi</h1>
            <p class="text-slate-300 mt-2">Informasi lengkap donasi yang tercatat.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('donations.index') }}" class="rounded-full bg-slate-800 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">Kembali ke Daftar</a>
            <a href="{{ route('donations.edit', $donation) }}" class="rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500 transition">Edit</a>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-3xl bg-slate-950/70 p-6 border border-white/10 shadow-lg">
            <div class="space-y-4 text-slate-200">
                <div>
                    <h2 class="text-lg font-semibold text-white">Donasi ke Masjid</h2>
                    <p class="mt-1 text-slate-400">{{ $donation->mosque->name ?? '—' }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Nama Donatur</h2>
                    <p class="mt-1 text-slate-400">{{ $donation->name }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Email</h2>
                    <p class="mt-1 text-slate-400">{{ $donation->email ?? '—' }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Jumlah</h2>
                    <p class="mt-1 text-slate-400">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Catatan</h2>
                    <p class="mt-1 text-slate-400">{{ $donation->message ?: '—' }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Tanggal</h2>
                    <p class="mt-1 text-slate-400">{{ $donation->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-3xl bg-slate-950/70 p-6 border border-white/10 shadow-lg">
            <h2 class="text-lg font-semibold text-white">Pengaturan</h2>
            <p class="mt-3 text-slate-400">Gunakan tombol di atas untuk mengubah atau menghapus catatan donasi ini.</p>
            <div class="mt-6 space-y-3">
                <a href="{{ route('donations.edit', $donation) }}" class="block rounded-2xl bg-indigo-600 px-5 py-3 text-center text-sm font-semibold text-white hover:bg-indigo-500 transition">Edit Donasi</a>
                <form action="{{ route('donations.destroy', $donation) }}" method="POST" onsubmit="return confirm('Hapus donasi ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-2xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white hover:bg-rose-500 transition">Hapus Donasi</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
