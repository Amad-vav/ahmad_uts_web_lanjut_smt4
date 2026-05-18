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

    <div class="flex items-center justify-between mb-6 px-4 sm:px-6 lg:px-8">
        <div>
            <h1 class="text-5xl font-extrabold tracking-tight" style="font-family: Orbitron, sans-serif; background: linear-gradient(90deg,#7c3aed,#06b6d4); -webkit-background-clip: text; color: transparent;">Jum'at Berkah</h1>
            <p class="text-slate-300 mt-2">Temukan masjid yang menerima sumbangan makanan dan dukung kegiatan berbagi.</p>
        </div>
        <div class="space-x-2">
            <a href="#scroll-list" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-pink-500 text-white px-4 py-2 rounded-full shadow-lg transform hover:scale-105 transition">Jelajahi Masjid</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-6 lg:px-8">
        <div class="lg:col-span-2">
            <div id="map" class="w-full h-96 rounded-xl shadow-lg"></div>
        </div>
        <div>
            <div class="bg-blue-50 rounded-xl p-4 shadow-inner border border-blue-100">
                <h2 class="text-xl font-semibold mb-3 text-gray-900">Ringkasan Program</h2>
                <p class="text-gray-700">Program <strong>Jum'at Berkah</strong> menghubungkan donatur dengan masjid-masjid yang membagikan makanan untuk mereka yang membutuhkan. Anda bisa menyumbang makanan langsung atau memberi donasi uang untuk menunjang operasional.</p>

                <div class="mt-4">
                    <h3 class="font-medium text-gray-900">Cara Berkontribusi</h3>
                    <ul class="mt-2 text-gray-700 list-disc list-inside">
                        <li>Temukan masjid terdekat di peta</li>
                        <li>Hubungi kontak masjid untuk koordinasi makanan</li>
                        <li>Atau sumbang uang secara online melalui halaman donasi</li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-xl shadow-lg border border-gray-200">
                <h3 class="font-semibold text-lg text-gray-900">Statistik Singkat</h3>
                <div class="mt-3 space-y-2 text-gray-700">
                    <div class="flex justify-between"><span>Masjid Terdaftar</span><span class="font-semibold">{{ $mosques->count() }}</span></div>
                    <div class="flex justify-between"><span>Total Donasi (tercatat)</span><span class="font-semibold">{{ number_format($totalDonations ?: 0, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Jumlah Donasi</span><span class="font-semibold">{{ $totalDonationCount }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <div id="scroll-list" class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-6 lg:px-8">
        @foreach($mosques as $mosque)
            <div class="bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-white/6 hover:shadow-[0_8px_30px_rgba(124,58,237,0.12)] transition-transform hover:-translate-y-1">
                <h4 class="text-lg font-semibold text-white">{{ $mosque->name }}</h4>
                <p class="text-slate-300 text-sm mt-1">{{ $mosque->address }}</p>
                <p class="mt-3 text-slate-300 text-sm">{{ Str::limit($mosque->description, 120) }}</p>
                <div class="mt-4 space-y-2 text-slate-300 text-sm">
                    <div class="flex justify-between"><span>Donasi tercatat</span><span class="font-semibold">{{ $mosque->donations_count }}</span></div>
                    <div class="flex justify-between"><span>Total dana</span><span class="font-semibold">Rp {{ number_format($mosque->donations_sum_amount ?: 0, 0, ',', '.') }}</span></div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <a href="{{ url('/mosque/'.$mosque->id) }}" class="text-indigo-300 hover:text-indigo-200 font-medium">Lihat detail</a>
                    <a href="{{ url('/mosque/'.$mosque->id.'/donate') }}" class="bg-gradient-to-r from-indigo-600 to-pink-500 text-white px-3 py-2 rounded-full text-sm font-medium shadow">Donasi</a>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const mosques = @json($mosques);

        const firstMosque = mosques.length > 0 ? mosques[0] : null;
        const mapCenter = [firstMosque?.lat ?? -6.2, firstMosque?.lng ?? 106.816666];
        const map = L.map('map').setView(mapCenter, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        mosques.forEach(m => {
            if (m.lat && m.lng) {
                const marker = L.marker([m.lat, m.lng]).addTo(map);
                marker.bindPopup(`<b>${m.name}</b><br>${m.address ?? ''}<br><a href="/mosque/${m.id}">Lihat detail</a>`);
            }
        });
    </script>
    @endpush

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush
</x-app-layout>
