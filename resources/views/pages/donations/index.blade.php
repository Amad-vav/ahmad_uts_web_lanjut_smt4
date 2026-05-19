<x-app-layout>
    @if(session('success'))
        <div class="mb-4 rounded-xl bg-emerald-600 px-4 py-3 text-slate-900 shadow">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 rounded-xl bg-rose-600 px-4 py-3 text-white shadow">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-4xl font-bold text-white">Manajemen Donasi</h1>
            <p class="text-slate-300 mt-2">Lihat semua donasi yang tercatat dan perbarui jika perlu.</p>
        </div>
        <a href="{{ url('/') }}" class="rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500 transition">Kembali ke Home</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-white/10 bg-slate-950/70 shadow-lg">
        <table class="min-w-full divide-y divide-white/10 text-sm text-left text-slate-200">
            <thead class="bg-slate-900/80 text-xs uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Masjid</th>
                    <th class="px-4 py-3">Nama Donatur</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Pesan</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10 bg-slate-950/70">
                @forelse($donations as $donation)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-4 py-4 font-medium text-white">{{ $donation->id }}</td>
                        <td class="px-4 py-4">{{ $donation->mosque->name ?? '—' }}</td>
                        <td class="px-4 py-4">{{ $donation->name }}</td>
                        <td class="px-4 py-4">{{ $donation->email ?? '—' }}</td>
                        <td class="px-4 py-4">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">{{ $donation->message ? \Illuminate\Support\Str::limit($donation->message, 40) : '—' }}</td>
                        <td class="px-4 py-4">{{ $donation->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4 space-x-2">
                            <a href="{{ route('donations.show', $donation) }}" class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-semibold text-slate-200 hover:bg-slate-700 transition">Lihat</a>
                            <a href="{{ route('donations.edit', $donation) }}" class="inline-flex rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-500 transition">Edit</a>
                            <form action="{{ route('donations.destroy', $donation) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus donasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-500 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-slate-400">Belum ada donasi yang tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $donations->links() }}
    </div>
</x-app-layout>
