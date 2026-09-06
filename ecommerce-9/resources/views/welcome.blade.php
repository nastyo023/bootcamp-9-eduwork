<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Commerce BNSP') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo / Brand -->
                <div class="flex items-center space-x-3">
                    <a href="/" class="text-xl font-bold text-indigo-600 tracking-wide">
                        🛒 {{ config('app.name', 'E-Commerce') }}
                    </a>
                </div>

                <!-- Navigation Auth Links -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
                                Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition px-3 py-2">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="py-8">

        <!-- 1. HERO CAROUSEL BANNER (Otomatis Bergeser) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
            <div x-data="{ 
                    activeSlide: 1, 
                    slides: [
                        { id: 1, title: 'Diskon Spesial Akhir Tahun!', desc: 'Dapatkan potongan harga hingga 50% untuk produk-produk pilihan.', bg: 'from-indigo-600 to-purple-600', buttonText: 'Belanja Sekarang' },
                        { id: 2, title: 'Koleksi Terbaru 2026', desc: 'Tampil gaya dan trendi dengan produk berkualitas tinggi dan terjamin.', bg: 'from-blue-600 to-teal-500', buttonText: 'Lihat Katalog' },
                        { id: 3, title: 'Gratis Ongkir Seluruh Indonesia', desc: 'Hemat belanja online tanpa mengkhawatirkan biaya pengiriman.', bg: 'from-rose-500 to-orange-500', buttonText: 'Klaim Promo' }
                    ],
                    timer: null,
                    startAutoSlide() {
                        this.timer = setInterval(() => {
                            this.activeSlide = this.activeSlide === this.slides.length ? 1 : this.activeSlide + 1;
                        }, 4000);
                    },
                    stopAutoSlide() {
                        clearInterval(this.timer);
                    }
                 }" 
                 x-init="startAutoSlide()"
                 @mouseenter="stopAutoSlide()"
                 @mouseleave="startAutoSlide()"
                 class="relative overflow-hidden rounded-2xl shadow-lg h-64 md:h-80">

                <!-- Slide Item Loop -->
                <template x-for="slide in slides" :key="slide.id">
                    <div x-show="activeSlide === slide.id"
                         x-transition:enter="transition ease-out duration-700 transform"
                         x-transition:enter-start="opacity-0 translate-x-full"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-500 transform"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-full"
                         :class="'absolute inset-0 bg-gradient-to-r ' + slide.bg + ' text-white flex items-center justify-between p-8 md:p-12'">
                         
                        <div class="max-w-xl space-y-3 z-10">
                            <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full uppercase tracking-wider font-semibold backdrop-blur-sm">Promo Hari Ini</span>
                            <h2 class="text-2xl md:text-4xl font-extrabold leading-tight" x-text="slide.title"></h2>
                            <p class="text-sm md:text-base text-white/90" x-text="slide.desc"></p>
                            <div class="pt-2">
                                <a href="#produk" class="inline-block bg-white text-gray-900 font-bold px-5 py-2.5 rounded-lg shadow hover:bg-gray-100 transition duration-200 text-sm">
                                    <span x-text="slide.buttonText"></span> &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Tombol Navigasi Kiri & Kanan -->
                <button @click="activeSlide = activeSlide === 1 ? slides.length : activeSlide - 1" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2.5 rounded-full backdrop-blur-sm transition z-20">
                    &#10094;
                </button>
                <button @click="activeSlide = activeSlide === slides.length ? 1 : activeSlide + 1" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2.5 rounded-full backdrop-blur-sm transition z-20">
                    &#10095;
                </button>

                <!-- Indicator Dots -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                    <template x-for="slide in slides" :key="slide.id">
                        <button @click="activeSlide = slide.id" 
                                :class="activeSlide === slide.id ? 'bg-white w-8' : 'bg-white/50 w-2.5'" 
                                class="h-2.5 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- 2. SECTION KATALOG PRODUK -->
        <div id="produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Katalog Produk</h2>
                    <p class="text-sm text-gray-500">Temukan barang impianmu dengan harga terbaik</p>
                </div>
            </div>

            <!-- Grid Produk (Bisa dihubungkan ke Controller/DB) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                            <div class="h-48 bg-gray-100 flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada gambar</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $product->name }}</h3>
                                <p class="text-gray-500 text-xs mb-3 line-clamp-2">{{ $product->description }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-600 font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('login') }}" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        + Keranjang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback Dummy Card jika DB belum dipanggil di Routewelcome -->
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="h-44 bg-gray-100 flex items-center justify-center text-4xl">
                                📦
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 text-md">Contoh Produk {{ $i }}</h3>
                                <p class="text-gray-400 text-xs my-1">Deskripsi singkat mengenai barang ini.</p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-indigo-600 font-bold text-sm">Rp150.000</span>
                                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-indigo-700 transition">
                                        Beli
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16 py-6 text-center text-xs text-gray-500">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </footer>

</body>
</html>