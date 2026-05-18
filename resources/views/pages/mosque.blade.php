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

    <div class="bg-gradient-to-br from-slate-900/50 to-slate-800/30 p-6 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold">{{ $mosque->name }}</h2>
                <p class="text-slate-300 mt-1">{{ $mosque->address }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full text-sm text-white transition">← Kembali</a>
                <a href="{{ url('/mosque/'.$mosque->id.'/donate') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-pink-500 text-white px-4 py-2 rounded-full text-sm font-medium shadow">Donasi</a>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div id="map-single" class="w-full h-64 rounded-lg"></div>
            </div>
            <div class="p-4 bg-slate-900/30 rounded-lg">
                <h3 class="font-semibold text-lg">Tentang</h3>
                <p class="text-slate-300 mt-2">{{ $mosque->description ?: 'Deskripsi belum tersedia untuk masjid ini.' }}</p>

                <h4 class="mt-4 font-medium">Kontak</h4>
                <p class="text-slate-300">{{ $mosque->contact ?: 'Tidak tersedia' }}</p>

                <div class="mt-4 pt-4 border-t border-white/10">
                    <h4 class="font-semibold text-lg text-white">Donasi Tercatat</h4>
                    <div class="mt-3 text-slate-300 text-sm space-y-2">
                        <div class="flex justify-between"><span>Jumlah donasi</span><span>{{ $mosque->donations_count }}</span></div>
                        <div class="flex justify-between"><span>Total dana</span><span>Rp {{ number_format($mosque->donations_sum_amount ?: 0, 0, ',', '.') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const m = @json($mosque);
        const map = L.map('map-single').setView([m.lat || -6.2, m.lng || 106.8], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
        if (m.lat && m.lng) {
            L.marker([m.lat, m.lng]).addTo(map).bindPopup(m.name).openPopup();
        }
    </script>
    @endpush
</x-app-layout>
