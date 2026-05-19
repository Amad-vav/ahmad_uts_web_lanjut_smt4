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
            <h1 class="text-4xl font-bold text-white">Edit Donasi</h1>
            <p class="text-slate-300 mt-2">Perbarui data donasi yang sudah tercatat.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('donations.index') }}" class="rounded-full bg-slate-800 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">Kembali ke Daftar</a>
        </div>
    </div>

    <div class="rounded-3xl bg-slate-950/80 p-6 border border-white/10 shadow-lg">
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl bg-slate-900/50 p-6">
                <h2 class="text-xl font-semibold text-white">Masjid</h2>
                <p class="mt-2 text-slate-300">{{ $donation->mosque->name ?? '—' }}</p>
                <p class="mt-4 text-sm text-slate-400">Perbarui hanya jika ada kesalahan pada nama, email, jumlah, atau catatan.</p>
            </div>
            <div>
                <form method="POST" action="{{ route('donations.update', $donation) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Nama</label>
                        <input name="name" value="{{ old('name', $donation->name) }}" required class="w-full mt-2 rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
                        @error('name') <p class="mt-2 text-sm text-rose-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Email (opsional)</label>
                        <input name="email" type="email" value="{{ old('email', $donation->email) }}" class="w-full mt-2 rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
                        @error('email') <p class="mt-2 text-sm text-rose-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Jumlah (Rp)</label>
                        <input name="amount" type="number" min="1" value="{{ old('amount', $donation->amount) }}" required class="w-full mt-2 rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
                        @error('amount') <p class="mt-2 text-sm text-rose-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Catatan (opsional)</label>
                        <textarea name="message" rows="4" class="w-full mt-2 rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">{{ old('message', $donation->message) }}</textarea>
                        @error('message') <p class="mt-2 text-sm text-rose-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-6 py-3 text-white shadow-lg hover:bg-indigo-500 transition">Simpan Perubahan</button>
                        <a href="{{ route('donations.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-800 px-6 py-3 text-white shadow-lg hover:bg-slate-700 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
