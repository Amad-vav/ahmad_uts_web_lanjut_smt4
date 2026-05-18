<x-app-layout>
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-emerald-600 px-4 py-3 text-slate-900 shadow">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 rounded-xl bg-rose-600 px-4 py-3 text-white shadow">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-gradient-to-br from-slate-900/40 to-slate-800/30 p-6 rounded-3xl shadow-xl border border-white/10">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h1 class="text-4xl font-bold text-white">Donasi untuk {{ $mosque->name }}</h1>
                <p class="text-slate-300 mt-2">Isi form donasi untuk membantu operasional dan kegiatan berbagi di masjid ini.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/mosque/'.$mosque->id) }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full text-sm text-white transition">Detail Masjid</a>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-slate-800/60 hover:bg-slate-800/80 px-4 py-2 rounded-full text-sm text-white transition">Kembali ke Daftar</a>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div id="map-donate" class="w-full h-72 rounded-3xl shadow-lg"></div>
                <div class="p-5 bg-slate-900/60 rounded-3xl border border-white/10">
                    <h2 class="text-xl font-semibold text-white">Tentang Masjid</h2>
                    <p class="text-slate-300 mt-3">{{ $mosque->description ?: 'Deskripsi belum tersedia untuk masjid ini.' }}</p>
                    <div class="mt-4 space-y-2 text-slate-300">
                        <div><strong>Alamat:</strong> {{ $mosque->address ?: 'Tidak tersedia' }}</div>
                        <div><strong>Kontak:</strong> {{ $mosque->contact ?: 'Tidak tersedia' }}</div>
                        <div class="pt-4 border-t border-white/10">
                            <div class="text-slate-400 text-sm">Donasi tercatat</div>
                            <div class="mt-2 flex flex-col gap-2 text-white text-sm">
                                <div class="flex justify-between"><span>Jumlah donasi</span><span>{{ $mosque->donations_count }}</span></div>
                                <div class="flex justify-between"><span>Total dana</span><span>Rp {{ number_format($mosque->donations_sum_amount ?: 0, 0, ',', '.') }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white/5 rounded-3xl border border-white/10 shadow-inner backdrop-blur-sm">
                <h2 class="text-2xl font-semibold text-white">Form Donasi</h2>
                <p class="text-slate-300 mt-2">Isi data Anda untuk mencatat donasi ke masjid ini.</p>
                <form id="donateForm" method="POST" action="{{ url('/donate') }}" class="mt-6 space-y-4">
                    @csrf
                    <input type="hidden" name="mosque_id" value="{{ $mosque->id }}">

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Nama</label>
                        <input name="name" required class="w-full mt-2 p-3 rounded-2xl bg-slate-950/60 border border-white/10 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Email (opsional)</label>
                        <input name="email" type="email" class="w-full mt-2 p-3 rounded-2xl bg-slate-950/60 border border-white/10 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Jumlah (Rp)</label>
                        <input name="amount" type="number" required min="1" class="w-full mt-2 p-3 rounded-2xl bg-slate-950/60 border border-white/10 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-200">Catatan (opsional)</label>
                        <textarea name="message" rows="4" class="w-full mt-2 p-3 rounded-2xl bg-slate-950/60 border border-white/10 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-6 py-3 text-white shadow-lg hover:bg-emerald-400 transition">Donasi Sekarang</button>
                    </div>
                </form>

                <p class="mt-4 text-sm text-slate-400">Donasi Anda akan langsung tercatat dan dilampirkan ke masjid ini.</p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const m = @json($mosque);
        const donateMap = L.map('map-donate').setView([m.lat || -6.2, m.lng || 106.8], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(donateMap);
        if (m.lat && m.lng) {
            L.marker([m.lat, m.lng]).addTo(donateMap).bindPopup(m.name).openPopup();
        }
    </script>
    @endpush
</x-app-layout>
