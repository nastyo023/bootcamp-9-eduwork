        // Array 50 Data Produk Estetik, Organik, dan Berwarna dari Lumina
        const products = [
            { id: 1, name: 'Sofa Minimalis Astrid Peach Orange', price: 2450000, category: 'Furnitur', description: 'Sofa 2-seater bermotif tenun peach cerah bertekstur linen tebal dengan kaki kayu oak kokoh yang ceria.', colorIndex: 0 },
            { id: 2, name: 'Lampu Meja Sandwood Sunny Gold', price: 320000, category: 'Penerangan', description: 'Kap lampu katun kuning cerah hangat berpadu dengan dudukan silinder kayu jati solid yang kontras.', colorIndex: 1 },
            { id: 3, name: 'Vase Keramik Terracotta Duo Bright', price: 185000, category: 'Dekorasi', description: 'Set isi dua vas keramik tanah liat lokal buatan tangan dengan warna terakota dan orange cerah.', colorIndex: 2 },
            { id: 4, name: 'Selimut Rajut Cozy Sunset Pink', price: 420000, category: 'Tekstil', description: 'Selimut rajutan tebal bertekstur bulu domba mikro bernuansa sunset merah muda yang estetik.', colorIndex: 3 },
            { id: 5, name: 'Monstera Pot Mint Green Clay', price: 150000, category: 'Tanaman', description: 'Tanaman Monstera segar dengan daun berlubang indah dalam pot warna hijau mint cerah.', colorIndex: 4 },
            { id: 6, name: 'Meja Kopi Bundar Warm Oakwood', price: 1250000, category: 'Furnitur', description: 'Meja bundar minimalis modern berlapis veneer kayu kuning cerah mengkilap tahan goresan.', colorIndex: 1 },
            { id: 7, name: 'Lampu Gantung Anyaman Bambu Kuning', price: 490000, category: 'Penerangan', description: 'Lentera gantung buatan pengrajin lokal untuk memancarkan cahaya keemasan hangat yang bertenaga.', colorIndex: 0 },
            { id: 8, name: 'Cermin Rattan Sunburst Gold', price: 299000, category: 'Dekorasi', description: 'Cermin rotan dekoratif diameter 55cm bercorak cahaya matahari yang menyala-nyala ceria.', colorIndex: 2 },
            { id: 9, name: 'Karpet Bulu Coral Pink Lembut', price: 345000, category: 'Tekstil', description: 'Karpet mini halus bergaya faux fur berkualitas tinggi berwarna coral yang segar di mata.', colorIndex: 3 },
            { id: 10, name: 'Ficus Lyrata Pot Keramik Tosca', price: 280000, category: 'Tanaman', description: 'Tanaman hias ketapang biola besar dengan daun rimbun di pot warna biru tosca mengkilap.', colorIndex: 4 },
            
            { id: 11, name: 'Kursi Goyang Nordic Sunset Orange', price: 2100000, category: 'Furnitur', description: 'Kursi goyang ergonomis dengan busa tebal berlapis kain oranye pastel yang sangat memukau.', colorIndex: 0 },
            { id: 12, name: 'Lampu Lantai Brass Gold Arc', price: 850000, category: 'Penerangan', description: 'Lampu baca melengkung tinggi dengan finishing logam kuningan emas murni yang bercahaya terang.', colorIndex: 1 },
            { id: 13, name: 'Lukisan Abstrak Kanvas Sunset', price: 550000, category: 'Dekorasi', description: 'Lukisan kanvas tekstur timbul 3D bergaya minimalis bernuansa langit jingga senja hangat.', colorIndex: 2 },
            { id: 14, name: 'Bantal Sofa Linen Coral Set (Isi 2)', price: 180000, category: 'Tekstil', description: 'Dua sarung bantal linen premium ukuran 45x45 cm berwarna coral sunset yang cerah hidup.', colorIndex: 3 },
            { id: 15, name: 'Tanaman Ivy Gantung Pot Tosca', price: 95000, category: 'Tanaman', description: 'Tanaman rambat hias Ivy dengan pot gantung minimalis bertali anyaman rami warna-warni.', colorIndex: 4 },
            { id: 16, name: 'Rak Modular Kayu Bright Pine', price: 1890000, category: 'Furnitur', description: 'Rak susun serbaguna dari serat kayu pinus warna kuning muda cerah alami yang ramah lingkungan.', colorIndex: 1 },
            { id: 17, name: 'Diffuser Aromaterapi Eko-Led Gold', price: 240000, category: 'Penerangan', description: 'Humidifier elektrik berpenutup kayu estetik dengan lampu LED warna-warni dinamis dan terang.', colorIndex: 0 },
            { id: 18, name: 'Nampan Saji Kayu Jati Sunset', price: 125000, category: 'Dekorasi', description: 'Nampan kayu jati dengan lekukan halus dan aksen warna oranye cerah pada pegangannya.', colorIndex: 2 },
            { id: 19, name: 'Tirai Jendela Linen Sunny Peach', price: 290000, category: 'Tekstil', description: 'Tirai jendela katun halus berwarna peach cerah yang menyebarkan sinar matahari secara estetik.', colorIndex: 3 },
            { id: 20, name: 'Lidah Mertua Pot Terakota Oranye', price: 110000, category: 'Tanaman', description: 'Tanaman lidah mertua yang andal menyaring polusi, dipadukan pot clay bercat oranye segar.', colorIndex: 4 },
            
            { id: 21, name: 'Meja Rias Compact Peach Gold', price: 1650000, category: 'Furnitur', description: 'Meja rias fungsional dengan laci bergaris emas mengkilap dan cermin bundar berlampu LED.', colorIndex: 0 },
            { id: 22, name: 'Lampu LED Strip Amber Gold Glow', price: 155000, category: 'Penerangan', description: 'Lampu strip LED berperekat kuat dengan warna emas temaram hangat yang sangat hidup.', colorIndex: 1 },
            { id: 23, name: 'Tempat Lilin Kuningan Emas Antik', price: 140000, category: 'Dekorasi', description: 'Penyangga lilin ramping bergaya klasik Eropa dengan warna emas menyala mengkilap.', colorIndex: 2 },
            { id: 24, name: 'Sajadah Beludru Coral Peach', price: 220000, category: 'Tekstil', description: 'Sajadah empuk berbahan rajut beludru tebal bermotif geometri modern berwarna peach merona.', colorIndex: 3 },
            { id: 25, name: 'Sukulen Mini Trio Pot Jingga', price: 85000, category: 'Tanaman', description: 'Set tiga jenis tanaman sukulen mini dalam pot tanah liat panggang berwarna jingga cerah.', colorIndex: 4 },
            { id: 26, name: 'Kabinet Anyaman Rattan Bright Peach', price: 2750000, category: 'Furnitur', description: 'Lemari kabinet samping dengan aksen pintu rotan yang dikombinasikan dengan cat peach estetik.', colorIndex: 1 },
            { id: 27, name: 'Lampu Gantung Matte Gold Dome', price: 580000, category: 'Penerangan', description: 'Lampu langit gantung minimalis berbodi aluminium matte emas yang sangat artistik.', colorIndex: 0 },
            { id: 28, name: 'Hiasan Dinding Makrame Rainbow', price: 175000, category: 'Dekorasi', description: 'Karya anyaman makrame rajut tangan berbahan tali katun tebal dengan variasi warna pelangi lembut.', colorIndex: 2 },
            { id: 29, name: 'Alas Piring Rajutan Jerami Oranye', price: 65000, category: 'Tekstil', description: 'Set piring tatakan meja rajutan anyaman eceng gondok tebal dengan aksen lilitan oranye.', colorIndex: 3 },
            { id: 30, name: 'Tanaman Keladi Red Star Pot Putih', price: 135000, category: 'Tanaman', description: 'Keladi hias eksotis berdaun corak bintang merah muda menyala kontras yang segar.', colorIndex: 4 },

            { id: 31, name: 'Stool Bulat Puff Velvet Coral', price: 390000, category: 'Furnitur', description: 'Kursi stool tanpa sandaran dengan busa royal berlapis beludru coral pink yang anggun.', colorIndex: 0 },
            { id: 32, name: 'Lampu Belajar Arsitek Swing Gold', price: 280000, category: 'Penerangan', description: 'Desain lampu meja fleksibel bersendi putar logam murni berwarna emas yang bersinar.', colorIndex: 1 },
            { id: 33, name: 'Jam Dinding Kayu Sunflower Yellow', price: 195000, category: 'Dekorasi', description: 'Jam dinding senyap non-ticking berbentuk bunga matahari berwarna kuning menyala.', colorIndex: 2 },
            { id: 34, name: 'Keset Batu Diatomite Coral Wave', price: 115000, category: 'Tekstil', description: 'Keset berbahan batu alami diatomite berpori tebal dengan warna pink-coral yang cerah.', colorIndex: 3 },
            { id: 35, name: 'Aloe Vera Pot Clay Sunflower Yellow', price: 95000, category: 'Tanaman', description: 'Tanaman lidah buaya dewasa serbaguna dalam pot keramik bercat kuning cerah.', colorIndex: 4 },
            { id: 36, name: 'Gantungan Baju Minimalis Bright Oak', price: 320000, category: 'Furnitur', description: 'Hanger baju berdiri vertikal berbahan kayu ek muda halus kokoh dengan rak bawah.', colorIndex: 1 },
            { id: 37, name: 'Lampu Malam Jamur Neon Glow', price: 125000, category: 'Penerangan', description: 'Lampu tidur LED bentuk jamur imut dengan sensor otomatis dan cahaya tosca terang.', colorIndex: 0 },
            { id: 38, name: 'Kotak Tissue Tutup Kayu Sunny Gold', price: 75000, category: 'Dekorasi', description: 'Kotak wadah tisu bodi plastik kuning cerah dengan tutup kayu pinus asli.', colorIndex: 2 },
            { id: 39, name: 'Bantal Duduk Memory Foam Orange', price: 165000, category: 'Tekstil', description: 'Bantalan bokong ortopedi empuk berlapis kain oranye berpori sirkulasi udara.', colorIndex: 3 },
            { id: 40, name: 'Pakis Boston Gantung Rimbun Segar', price: 140000, category: 'Tanaman', description: 'Tanaman pakis gantung hijau rimbun segar dalam pot gantung berwarna pink lembut.', colorIndex: 4 },

            { id: 41, name: 'Meja Tulis Hazelwood Bright Orange', price: 1990000, category: 'Furnitur', description: 'Meja kerja ramping minimalis dengan laci ganda beraksen oranye cerah merona.', colorIndex: 0 },
            { id: 42, name: 'Lampu Sorot Galeri Gold Bright', price: 420000, category: 'Penerangan', description: 'Lampu sorot terarah yang cocok menyorot pigura foto, berlapis warna emas mengkilap.', colorIndex: 1 },
            { id: 43, name: 'Penahan Buku Patung Orange Stone', price: 210000, category: 'Dekorasi', description: 'Sepasang bookend berat patung kepala abstrak bertekstur warna oranye terakota.', colorIndex: 2 },
            { id: 44, name: 'Taplak Meja Boho Linen Sunny Yellow', price: 185000, category: 'Tekstil', description: 'Runner meja makan panjang katun rajut bermotif rumbai kuning matahari yang estetik.', colorIndex: 3 },
            { id: 45, name: 'Kaktus Koboi Pot Premium Mint', price: 360000, category: 'Tanaman', description: 'Kaktus tegak lurus tinggi 1 meter dalam pot premium berwarna mint segar.', colorIndex: 4 },
            { id: 46, name: 'Kursi Makan Nordic Birch Orange', price: 780000, category: 'Furnitur', description: 'Kursi makan bersandaran ergonomis melengkung berlapis kain rajut oranye pastel.', colorIndex: 1 },
            { id: 47, name: 'Lilin LED Api Goyang Gold Glow', price: 90000, category: 'Penerangan', description: 'Lilin elektrik tanpa sumbu yang memancarkan cahaya keemasan hangat bergoyang riil.', colorIndex: 0 },
            { id: 48, name: 'Nampan Cermin Kosmetik Bright Gold', price: 245000, category: 'Dekorasi', description: 'Nampan alas cermin kristal dengan rangka kuningan berlapis warna emas bercahaya.', colorIndex: 2 },
            { id: 49, name: 'Quilt Cover Set Cotton Coral Pink', price: 560000, category: 'Tekstil', description: 'Set penutup quilt dari katun murni rajutan satin yang dingin berwarna coral pink cerah.', colorIndex: 3 },
            { id: 50, name: 'Begonia Polkadot Pot Mint Green', price: 125000, category: 'Tanaman', description: 'Tanaman begonia hias berdaun hijau totol putih perak dalam pot gantung hijau tosca.', colorIndex: 4 }
        ];

        // Palet warna baru: Jauh lebih cerah, kontras, dan berwarna-warni estetik (Anti-Pucat)
        const pastelPalettes = [
            { bg: '#FFF0EB', stroke: '#FF6F59' }, // Coral Peach (Cerah/Hangat)
            { bg: '#FFF9E8', stroke: '#F4B251' }, // Sunshine Gold (Terang/Ceria)
            { bg: '#EBF7F4', stroke: '#3EAB94' }, // Fresh Mint (Segar/Sejuk)
            { bg: '#FDF0F4', stroke: '#EC5B96' }, // Blossom Pink (Berwarna/Anggun)
            { bg: '#ECEBF8', stroke: '#7064E8' }  // Sky Lavender (Modis/Artistik)
        ];

        // Fungsi membuat ilustrasi SVG sederhana yang rapi dan serasi dengan warna cerah
        function generateProductSVG(product) {
            const palette = pastelPalettes[product.colorIndex % pastelPalettes.length];
            const categoryIcon = {
                'Furnitur': `
                    <!-- Sketsa Kursi Minimalis -->
                    <path d="M50 140 H150 M60 140 V100 H140 V140 M70 100 C70 60, 130 60, 130 100 M60 115 H140" stroke-width="3" />
                    <path d="M80 140 V160 M120 140 V160" stroke-width="4.5" />
                `,
                'Penerangan': `
                    <!-- Sketsa Lampu Gantung -->
                    <line x1="100" y1="30" x2="100" y2="80" stroke-width="3.5"/>
                    <path d="M65 110 C65 85, 135 85, 135 110 Z" stroke-width="3.5"/>
                    <circle cx="100" cy="118" r="12" fill="${palette.stroke}"/>
                `,
                'Dekorasi': `
                    <!-- Sketsa Vas Keramik -->
                    <path d="M80 140 C80 75, 120 75, 120 140 Z" stroke-width="4"/>
                    <ellipse cx="100" cy="142" rx="25" ry="5"/>
                    <path d="M100 75 Q115 45, 120 35 M100 75 Q85 45, 75 35" stroke-width="2.5"/>
                `,
                'Tekstil': `
                    <!-- Sketsa Lipatan Kain -->
                    <path d="M55 75 H145 C150 75, 150 95, 145 95 H55 C50 95, 50 75, 55 75 Z" stroke-width="3"/>
                    <path d="M60 95 H140 C145 95, 145 115, 140 115 H60 C55 115, 55 95, 60 95 Z" stroke-width="3"/>
                    <path d="M55 115 H145 C150 115, 150 135, 145 135 H55" stroke-width="3" />
                `,
                'Tanaman': `
                    <!-- Sketsa Tanaman Hias -->
                    <path d="M100 140 V60 M100 105 Q125 85, 135 95 M100 115 Q75 95, 65 105 M100 80 Q120 55, 130 65 M100 85 Q80 65, 70 75" stroke-width="4.5" stroke-linecap="round"/>
                    <ellipse cx="100" cy="142" rx="18" ry="6" />
                `
            };

            return `data:image/svg+xml;utf8,
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="100%" height="100%">
                    <rect width="100%" height="100%" fill="${encodeURIComponent(palette.bg)}" />
                    <g stroke="${encodeURIComponent(palette.stroke)}" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="translate(0, 0)">
                        ${categoryIcon[product.category] || '<circle cx="100" cy="100" r="30"/>'}
                    </g>
                    <!-- Ornamen garis dekoratif cerah -->
                    <circle cx="35" cy="35" r="4" fill="${encodeURIComponent(palette.stroke)}" opacity="0.6"/>
                    <circle cx="165" cy="165" r="6" fill="${encodeURIComponent(palette.stroke)}" opacity="0.4"/>
                    <line x1="155" y1="35" x2="175" y2="35" stroke="${encodeURIComponent(palette.stroke)}" stroke-width="2" opacity="0.6"/>
                    <line x1="165" y1="25" x2="165" y2="45" stroke="${encodeURIComponent(palette.stroke)}" stroke-width="2" opacity="0.6"/>
                </svg>
            `;
        }

        // State manajemen filter & keranjang
        let cart = [];
        let activeFilters = {
            search: '',
            category: 'all',
            maxPrice: 5000000,
            sortBy: 'none'
        };

        // Mengambil referensi element DOM HTML
        const productsGrid = document.getElementById('productsGrid');
        const emptyState = document.getElementById('emptyState');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const priceRange = document.getElementById('priceRange');
        const priceRangeValue = document.getElementById('priceRangeValue');
        const sortFilter = document.getElementById('sortFilter');
        const btnResetFilters = document.getElementById('btnResetFilters');
        const activeFiltersLabel = document.getElementById('activeFiltersLabel');
        const productCounter = document.getElementById('productCounter');
        
        const cartCountBadge = document.getElementById('cartCountBadge');
        const cartItemsList = document.getElementById('cartItemsList');
        const emptyCartState = document.getElementById('emptyCartState');
        const cartTotalPrice = document.getElementById('cartTotalPrice');
        const btnCheckout = document.getElementById('btnCheckout');

        // Fungsi pembantu format Rupiah
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        // Fungsi utama menyaring produk dan merender ulang grid produk
        function updateAndRender() {
            let displayProducts = products.filter(product => {
                const matchesSearch = product.name.toLowerCase().includes(activeFilters.search.toLowerCase()) || 
                                     product.description.toLowerCase().includes(activeFilters.search.toLowerCase());
                const matchesCategory = activeFilters.category === 'all' || product.category === activeFilters.category;
                const matchesPrice = product.price <= activeFilters.maxPrice;
                
                return matchesSearch && matchesCategory && matchesPrice;
            });

            // Pengurutan harga
            if (activeFilters.sortBy === 'low-to-high') {
                displayProducts.sort((a, b) => a.price - b.price);
            } else if (activeFilters.sortBy === 'high-to-low') {
                displayProducts.sort((a, b) => b.price - a.price);
            }

            productCounter.textContent = displayProducts.length;

            // Render ke dalam grid card HTML
            if (displayProducts.length === 0) {
                productsGrid.innerHTML = '';
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
                
                let htmlContent = '';
                displayProducts.forEach(product => {
                    const svgImage = generateProductSVG(product);
                    htmlContent += `
                        <div class="col">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <span class="category-badge">${product.category}</span>
                                    <img src="${svgImage}" alt="${product.name}" class="product-img">
                                </div>
                                <div class="card-body p-4 d-flex flex-column">
                                    <h6 class="card-title fw-bold mb-1 text-truncate text-dark" title="${product.name}">${product.name}</h6>
                                    <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px; line-height: 1.4;">
                                        ${product.description}
                                    </p>
                                    <div class="mt-auto">
                                        <div class="price-text mb-3">${formatRupiah(product.price)}</div>
                                        <button class="btn btn-cozy-primary w-100 rounded-pill py-2.5 fw-bold shadow-sm" onclick="addToCart(${product.id})">
                                            <i class="bi bi-bag-plus-fill me-1"></i> Beli Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                productsGrid.innerHTML = htmlContent;
            }

            // Memperbarui indikator status pencarian / filter aktif
            let labels = [];
            if (activeFilters.search) labels.push(`"${activeFilters.search}"`);
            if (activeFilters.category !== 'all') labels.push(`${activeFilters.category}`);
            if (activeFilters.maxPrice < 5000000) labels.push(`≤ ${formatRupiah(activeFilters.maxPrice)}`);
            
            if (labels.length > 0) {
                activeFiltersLabel.innerHTML = `Filter aktif: ${labels.join(' + ')}`;
            } else {
                activeFiltersLabel.textContent = 'Menampilkan Semua Koleksi';
            }
        }

        // Fungsi Tambah ke Keranjang
        window.addToCart = function(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const existingItem = cart.find(item => item.product.id === productId);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ product, quantity: 1 });
            }

            updateCartUI();

            // Memperlihatkan Toast sukses penambahan
            const toastElement = document.getElementById('cartToast');
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        };

        // Fungsi hapus dari keranjang
        function removeFromCart(productId) {
            cart = cart.filter(item => item.product.id !== productId);
            updateCartUI();
        }

        // Mengubah kuantitas item dalam keranjang
        function updateQuantity(productId, delta) {
            const item = cart.find(item => item.product.id === productId);
            if (!item) return;

            item.quantity += delta;
            if (item.quantity <= 0) {
                removeFromCart(productId);
            } else {
                updateCartUI();
            }
        }

        // Pembaruan Antarmuka Keranjang Belanja (Modal)
        function updateCartUI() {
            const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCountBadge.textContent = totalCount;

            if (cart.length === 0) {
                emptyCartState.classList.remove('d-none');
                cartItemsList.innerHTML = '';
                cartTotalPrice.textContent = formatRupiah(0);
                btnCheckout.disabled = true;
            } else {
                emptyCartState.classList.add('d-none');
                btnCheckout.disabled = false;

                let cartHtml = '';
                let grandTotal = 0;

                cart.forEach(item => {
                    const totalItemPrice = item.product.price * item.quantity;
                    grandTotal += totalItemPrice;
                    const svgImage = generateProductSVG(item.product);

                    cartHtml += `
                        <div class="cart-card p-3 shadow-sm">
                            <div class="row align-items-center g-3">
                                <div class="col-3 col-sm-2">
                                    <img src="${svgImage}" class="img-fluid rounded-3" alt="${item.product.name}">
                                </div>
                                <div class="col-9 col-sm-5">
                                    <h6 class="fw-bold mb-1 text-truncate text-dark" style="font-size:0.9rem;">${item.product.name}</h6>
                                    <small class="text-muted d-block mb-1">${formatRupiah(item.product.price)}</small>
                                </div>
                                <div class="col-6 col-sm-3 d-flex align-items-center justify-content-sm-center">
                                    <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 28px; height: 28px; padding:0; display:flex; align-items:center; justify-content:center;" onclick="updateQuantity(${item.product.id}, -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <span class="mx-3 fw-bold small text-dark">${item.quantity}</span>
                                    <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 28px; height: 28px; padding:0; display:flex; align-items:center; justify-content:center;" onclick="updateQuantity(${item.product.id}, 1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <div class="col-6 col-sm-2 text-end">
                                    <div class="fw-bold text-success small mb-2" style="color: var(--brand-mint) !important;">${formatRupiah(totalItemPrice)}</div>
                                    <button class="btn btn-sm btn-link text-danger p-0 text-decoration-none small" onclick="removeFromCart(${item.product.id})">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                cartItemsList.innerHTML = cartHtml;
                cartTotalPrice.textContent = formatRupiah(grandTotal);
            }
        }

        // Pasang pendengar kejadian (Listeners)
        searchInput.addEventListener('input', (e) => {
            activeFilters.search = e.target.value;
            updateAndRender();
        });

        categoryFilter.addEventListener('change', (e) => {
            activeFilters.category = e.target.value;
            updateAndRender();
        });

        priceRange.addEventListener('input', (e) => {
            activeFilters.maxPrice = parseInt(e.target.value);
            priceRangeValue.textContent = formatRupiah(activeFilters.maxPrice);
            updateAndRender();
        });

        sortFilter.addEventListener('change', (e) => {
            activeFilters.sortBy = e.target.value;
            updateAndRender();
        });

        // Reset Filter klik handler
        btnResetFilters.addEventListener('click', () => {
            searchInput.value = '';
            categoryFilter.value = 'all';
            priceRange.value = 5000000;
            priceRangeValue.textContent = formatRupiah(5000000);
            sortFilter.value = 'none';

            activeFilters = {
                search: '',
                category: 'all',
                maxPrice: 5000000,
                sortBy: 'none'
            };

            updateAndRender();
        });

        // Event checkout pesanan
        btnCheckout.addEventListener('click', () => {
            const cartModalEl = document.getElementById('cartModal');
            const modal = bootstrap.Modal.getInstance(cartModalEl);
            if (modal) {
                modal.hide();
            }

            cart = [];
            updateCartUI();

            const checkoutToastEl = document.getElementById('checkoutToast');
            const toast = new bootstrap.Toast(checkoutToastEl);
            toast.show();
        });

        // Memuat pertama kali pada halaman siap (DOM Loaded)
        window.onload = function() {
            priceRangeValue.textContent = formatRupiah(priceRange.value);
            updateAndRender();
            updateCartUI();
        };