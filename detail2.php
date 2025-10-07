<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengecekan Sertifikasi Hakim Adhoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            box-sizing: border-box;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b-4 border-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-gray-800">📋 Sistem Pengecekan Sertifikasi Hakim Adhoc</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="nav-btn bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors inline-block text-center">Dashboard</a>
                    <button onclick="showView('list')" class="nav-btn bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">List Hakim</button>
                    <button onclick="showView('search')" class="nav-btn bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">Pencarian</button>
                    <button onclick="showView('prototype')" class="nav-btn bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">Prototype</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard View -->
    <div id="dashboard-view" class="view-content">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="fade-in">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Dashboard Hakim Adhoc</h2>
                
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 card-hover">
                    <div class="flex items-center space-x-6">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            👨‍⚖️
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Dr. Ahmad Wijaya, S.H., M.H.</h3>
                            <p class="text-gray-600 text-lg">NIP: 198503152010011001</p>
                            <p class="text-green-600 font-semibold">Status: Hakim Adhoc Aktif</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                🏆
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Sertifikat</p>
                                <p class="text-2xl font-bold text-gray-900">5</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                ✅
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Sertifikat Aktif</p>
                                <p class="text-2xl font-bold text-gray-900">4</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                ⏰
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Akan Berakhir</p>
                                <p class="text-2xl font-bold text-gray-900">1</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certificates List -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Sertifikat Saya</h3>
                    <div class="space-y-4">
                        <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Sertifikat Hakim Adhoc Tipikor</h4>
                                    <p class="text-gray-600">No: CERT-TIPIKOR-2024-001</p>
                                    <p class="text-sm text-gray-500">Berlaku: 15 Januari 2024 - 15 Januari 2027</p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Aktif</span>
                            </div>
                        </div>
                        <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Sertifikat Hakim Adhoc Niaga</h4>
                                    <p class="text-gray-600">No: CERT-NIAGA-2023-045</p>
                                    <p class="text-sm text-gray-500">Berlaku: 10 Maret 2023 - 10 Maret 2026</p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Aktif</span>
                            </div>
                        </div>
                        <div class="border-l-4 border-yellow-500 bg-yellow-50 p-4 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Sertifikat Hakim Adhoc HAM</h4>
                                    <p class="text-gray-600">No: CERT-HAM-2022-089</p>
                                    <p class="text-sm text-gray-500">Berlaku: 20 Juni 2022 - 20 Juni 2025</p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Akan Berakhir</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List View -->
    <div id="list-view" class="view-content hidden">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="fade-in">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Daftar Hakim Adhoc</h2>
                
                <!-- Filter and Search -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama/NIP</label>
                            <input type="text" id="listSearch" placeholder="Ketik nama atau NIP..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" oninput="filterList()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Sertifikat</label>
                            <select id="listFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" onchange="filterList()">
                                <option value="">Semua Sertifikat</option>
                                <option value="tipikor">Tipikor</option>
                                <option value="niaga">Niaga</option>
                                <option value="ham">HAM</option>
                                <option value="pajak">Pajak</option>
                                <option value="lingkungan">Lingkungan</option>
                                <option value="hubungan-industrial">Hubungan Industrial</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" onchange="filterList()">
                                <option value="">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Akan Berakhir">Akan Berakhir</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button onclick="resetFilters()" class="w-full bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                🔄 Reset Filter
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span id="resultCount">Menampilkan semua hakim</span>
                    </div>
                </div>

                <!-- List of Judges -->
                <div id="judgesList" class="space-y-6">
                    <!-- Content will be populated by JavaScript -->
                </div>

                <!-- Available Certificate Types Info -->
                <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">📋 Jenis Sertifikasi yang Tersedia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">🏛️</span>
                                <h4 class="font-semibold text-blue-900">Tipikor</h4>
                            </div>
                            <p class="text-sm text-blue-700">Tindak Pidana Korupsi</p>
                            <p class="text-xs text-blue-600 mt-1">Masa berlaku: 3 tahun</p>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">💼</span>
                                <h4 class="font-semibold text-green-900">Niaga</h4>
                            </div>
                            <p class="text-sm text-green-700">Kepailitan & PKPU</p>
                            <p class="text-xs text-green-600 mt-1">Masa berlaku: 3 tahun</p>
                        </div>
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">⚖️</span>
                                <h4 class="font-semibold text-purple-900">HAM</h4>
                            </div>
                            <p class="text-sm text-purple-700">Hak Asasi Manusia</p>
                            <p class="text-xs text-purple-600 mt-1">Masa berlaku: 3 tahun</p>
                        </div>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">💰</span>
                                <h4 class="font-semibold text-yellow-900">Pajak</h4>
                            </div>
                            <p class="text-sm text-yellow-700">Sengketa Pajak</p>
                            <p class="text-xs text-yellow-600 mt-1">Masa berlaku: 3 tahun</p>
                        </div>
                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">🌱</span>
                                <h4 class="font-semibold text-emerald-900">Lingkungan</h4>
                            </div>
                            <p class="text-sm text-emerald-700">Lingkungan Hidup</p>
                            <p class="text-xs text-emerald-600 mt-1">Masa berlaku: 3 tahun</p>
                        </div>
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-3">🏢</span>
                                <h4 class="font-semibold text-orange-900">Hubungan Industrial</h4>
                            </div>
                            <p class="text-sm text-orange-700">Perselisihan Hubungan Industrial</p>
                            <p class="text-xs text-orange-600 mt-1">Masa berlaku: 3 tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search View -->
    <div id="search-view" class="view-content hidden">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="fade-in">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Pencarian Sertifikasi</h2>
                
                <!-- Search Form -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Hakim</label>
                            <input type="text" id="searchName" placeholder="Masukkan nama hakim..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                            <input type="text" id="searchNIP" placeholder="Masukkan NIP..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Sertifikat</label>
                            <select id="searchType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Jenis</option>
                                <option value="tipikor">Tipikor</option>
                                <option value="niaga">Niaga</option>
                                <option value="ham">HAM</option>
                                <option value="pajak">Pajak</option>
                                <option value="lingkungan">Lingkungan</option>
                            </select>
                        </div>
                    </div>
                    <button onclick="performSearch()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        🔍 Cari Sertifikasi
                    </button>
                </div>

                <!-- Search Results -->
                <div id="searchResults" class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Hasil Pencarian</h3>
                    <div id="resultsContainer">
                        <p class="text-gray-500 text-center py-8">Gunakan form pencarian di atas untuk mencari sertifikasi hakim adhoc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prototype View -->
    <div id="prototype-view" class="view-content hidden">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="fade-in">
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-yellow-600">⚠️</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Prototype Interface:</strong> Ini adalah contoh tampilan sistem setelah login. Interface ini hanya untuk demonstrasi dan tidak terhubung dengan database aktual.
                            </p>
                        </div>
                    </div>
                </div>

                <h2 class="text-3xl font-bold text-gray-900 mb-8">Interface Prototype - Sistem Sertifikasi</h2>
                
                <!-- Admin Dashboard -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Panel Administrator</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <button class="bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            👥 Kelola Hakim
                        </button>
                        <button class="bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors">
                            📜 Kelola Sertifikat
                        </button>
                        <button class="bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                            📊 Laporan
                        </button>
                        <button class="bg-orange-600 text-white px-4 py-3 rounded-lg hover:bg-orange-700 transition-colors">
                            ⚙️ Pengaturan
                        </button>
                    </div>
                </div>

                <!-- Certificate Management -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Manajemen Sertifikat</h3>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            ➕ Tambah Sertifikat
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Hakim</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Sertifikat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dr. Ahmad Wijaya, S.H., M.H.</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">198503152010011001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tipikor</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                        <button class="text-red-600 hover:text-red-900">Hapus</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Prof. Dr. Siti Nurhaliza, S.H., M.H.</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">197812201998032001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Niaga</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                        <button class="text-red-600 hover:text-red-900">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Certificate Types List -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Jenis Sertifikasi Tersedia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2">🏛️ Hakim Adhoc Tipikor</h4>
                            <p class="text-sm text-gray-600">Sertifikasi untuk menangani perkara tindak pidana korupsi</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2">💼 Hakim Adhoc Niaga</h4>
                            <p class="text-sm text-gray-600">Sertifikasi untuk menangani perkara kepailitan dan penundaan kewajiban pembayaran utang</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2">⚖️ Hakim Adhoc HAM</h4>
                            <p class="text-sm text-gray-600">Sertifikasi untuk menangani perkara pelanggaran hak asasi manusia</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2">💰 Hakim Adhoc Pajak</h4>
                            <p class="text-sm text-gray-600">Sertifikasi untuk menangani sengketa pajak</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2">🌱 Hakim Adhoc Lingkungan</h4>
                            <p class="text-sm text-gray-600">Sertifikasi untuk menangani perkara lingkungan hidup</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2">🏢 Hakim Adhoc Hubungan Industrial</h4>
                            <p class="text-sm text-gray-600">Sertifikasi untuk menangani perselisihan hubungan industrial</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data for search
        const certificateData = [
            {
                name: "Dr. Ahmad Wijaya, S.H., M.H.",
                nip: "198503152010011001",
                position: "Hakim Adhoc Senior",
                court: "Pengadilan Negeri Jakarta Pusat",
                certificates: [
                    { type: "tipikor", number: "CERT-TIPIKOR-2024-001", status: "Aktif", validUntil: "15 Januari 2027", issued: "15 Januari 2024" },
                    { type: "niaga", number: "CERT-NIAGA-2023-045", status: "Aktif", validUntil: "10 Maret 2026", issued: "10 Maret 2023" },
                    { type: "ham", number: "CERT-HAM-2022-089", status: "Akan Berakhir", validUntil: "20 Juni 2025", issued: "20 Juni 2022" }
                ]
            },
            {
                name: "Prof. Dr. Siti Nurhaliza, S.H., M.H.",
                nip: "197812201998032001",
                position: "Hakim Adhoc Ahli",
                court: "Pengadilan Negeri Surabaya",
                certificates: [
                    { type: "niaga", number: "CERT-NIAGA-2024-012", status: "Aktif", validUntil: "25 Februari 2027", issued: "25 Februari 2024" },
                    { type: "pajak", number: "CERT-PAJAK-2023-078", status: "Aktif", validUntil: "12 September 2026", issued: "12 September 2023" }
                ]
            },
            {
                name: "Dr. Budi Santoso, S.H., M.H.",
                nip: "198901102012011002",
                position: "Hakim Adhoc",
                court: "Pengadilan Negeri Bandung",
                certificates: [
                    { type: "lingkungan", number: "CERT-LING-2024-003", status: "Aktif", validUntil: "30 April 2027", issued: "30 April 2024" },
                    { type: "ham", number: "CERT-HAM-2023-156", status: "Aktif", validUntil: "18 November 2026", issued: "18 November 2023" }
                ]
            },
            {
                name: "Dr. Rina Kartika, S.H., M.H.",
                nip: "198706152015032002",
                position: "Hakim Adhoc",
                court: "Pengadilan Negeri Medan",
                certificates: [
                    { type: "tipikor", number: "CERT-TIPIKOR-2023-089", status: "Aktif", validUntil: "22 Agustus 2026", issued: "22 Agustus 2023" },
                    { type: "hubungan-industrial", number: "CERT-HI-2024-015", status: "Aktif", validUntil: "05 Mei 2027", issued: "05 Mei 2024" }
                ]
            },
            {
                name: "Prof. Dr. Hendra Kusuma, S.H., M.H., Ph.D",
                nip: "197503201999031001",
                position: "Hakim Adhoc Senior",
                court: "Pengadilan Negeri Yogyakarta",
                certificates: [
                    { type: "ham", number: "CERT-HAM-2024-067", status: "Aktif", validUntil: "14 Juli 2027", issued: "14 Juli 2024" },
                    { type: "lingkungan", number: "CERT-LING-2023-134", status: "Aktif", validUntil: "28 Oktober 2026", issued: "28 Oktober 2023" },
                    { type: "pajak", number: "CERT-PAJAK-2022-201", status: "Akan Berakhir", validUntil: "03 Desember 2025", issued: "03 Desember 2022" }
                ]
            },
            {
                name: "Dr. Maya Sari, S.H., M.H.",
                nip: "198912082017032001",
                position: "Hakim Adhoc",
                court: "Pengadilan Negeri Makassar",
                certificates: [
                    { type: "niaga", number: "CERT-NIAGA-2024-078", status: "Aktif", validUntil: "16 September 2027", issued: "16 September 2024" }
                ]
            },
            {
                name: "Dr. Agus Prasetyo, S.H., M.H.",
                nip: "198204102008011003",
                position: "Hakim Adhoc Senior",
                court: "Pengadilan Negeri Semarang",
                certificates: [
                    { type: "tipikor", number: "CERT-TIPIKOR-2022-156", status: "Tidak Aktif", validUntil: "11 Februari 2025", issued: "11 Februari 2022" },
                    { type: "hubungan-industrial", number: "CERT-HI-2023-092", status: "Aktif", validUntil: "07 Juni 2026", issued: "07 Juni 2023" }
                ]
            }
        ];

        function showView(viewName) {
            // Hide all views
            document.querySelectorAll('.view-content').forEach(view => {
                view.classList.add('hidden');
            });
            
            // Show selected view
            document.getElementById(viewName + '-view').classList.remove('hidden');
            
            // Update nav buttons
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove('bg-blue-800', 'bg-green-800', 'bg-purple-800', 'bg-indigo-800');
            });

            // Initialize list view if selected
            if (viewName === 'list') {
                displayJudgesList(certificateData);
            }
        }

        function displayJudgesList(data) {
            const container = document.getElementById('judgesList');
            const typeNames = {
                'tipikor': 'Tipikor',
                'niaga': 'Niaga', 
                'ham': 'HAM',
                'pajak': 'Pajak',
                'lingkungan': 'Lingkungan',
                'hubungan-industrial': 'Hubungan Industrial'
            };

            let html = '';
            data.forEach(judge => {
                const activeCerts = judge.certificates.filter(cert => cert.status === 'Aktif').length;
                const totalCerts = judge.certificates.length;

                html += `
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xl font-bold flex-shrink-0">
                                    👨‍⚖️
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1">${judge.name}</h3>
                                    <p class="text-gray-600 mb-1"><strong>NIP:</strong> ${judge.nip}</p>
                                    <p class="text-gray-600 mb-1"><strong>Jabatan:</strong> ${judge.position}</p>
                                    <p class="text-gray-600 mb-3"><strong>Pengadilan:</strong> ${judge.court}</p>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full font-medium">
                                            📜 ${totalCerts} Sertifikat
                                        </span>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-medium">
                                            ✅ ${activeCerts} Aktif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/2">
                                <h4 class="font-semibold text-gray-900 mb-3">Sertifikat yang Dimiliki:</h4>
                                <div class="space-y-2">
                `;

                judge.certificates.forEach(cert => {
                    const statusColor = cert.status === 'Aktif' ? 'green' : cert.status === 'Akan Berakhir' ? 'yellow' : 'red';
                    html += `
                        <div class="border-l-4 border-${statusColor}-500 bg-${statusColor}-50 p-3 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h5 class="font-medium text-gray-900">${typeNames[cert.type] || cert.type}</h5>
                                    <p class="text-sm text-gray-600">No: ${cert.number}</p>
                                    <p class="text-xs text-gray-500">Berlaku: ${cert.issued} - ${cert.validUntil}</p>
                                </div>
                                <span class="bg-${statusColor}-100 text-${statusColor}-800 px-2 py-1 rounded-full text-xs font-medium">
                                    ${cert.status}
                                </span>
                            </div>
                        </div>
                    `;
                });

                html += `
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
            updateResultCount(data.length);
        }

        function filterList() {
            const searchTerm = document.getElementById('listSearch').value.toLowerCase();
            const certFilter = document.getElementById('listFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            let filteredData = certificateData.filter(judge => {
                // Search by name or NIP
                const nameMatch = judge.name.toLowerCase().includes(searchTerm) || 
                                judge.nip.includes(searchTerm);
                
                // Filter by certificate type
                const certMatch = !certFilter || judge.certificates.some(cert => cert.type === certFilter);
                
                // Filter by status
                const statusMatch = !statusFilter || judge.certificates.some(cert => cert.status === statusFilter);

                return nameMatch && certMatch && statusMatch;
            });

            displayJudgesList(filteredData);
        }

        function resetFilters() {
            document.getElementById('listSearch').value = '';
            document.getElementById('listFilter').value = '';
            document.getElementById('statusFilter').value = '';
            displayJudgesList(certificateData);
        }

        function updateResultCount(count) {
            const total = certificateData.length;
            const countElement = document.getElementById('resultCount');
            if (count === total) {
                countElement.textContent = `Menampilkan semua ${total} hakim`;
            } else {
                countElement.textContent = `Menampilkan ${count} dari ${total} hakim`;
            }
        }

        function performSearch() {
            const searchName = document.getElementById('searchName').value.toLowerCase();
            const searchNIP = document.getElementById('searchNIP').value;
            const searchType = document.getElementById('searchType').value;
            
            let results = certificateData.filter(person => {
                const nameMatch = !searchName || person.name.toLowerCase().includes(searchName);
                const nipMatch = !searchNIP || person.nip.includes(searchNIP);
                const typeMatch = !searchType || person.certificates.some(cert => cert.type === searchType);
                
                return nameMatch && nipMatch && typeMatch;
            });

            displaySearchResults(results, searchType);
        }

        function displaySearchResults(results, filterType) {
            const container = document.getElementById('resultsContainer');
            
            if (results.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-8">Tidak ada hasil yang ditemukan</p>';
                return;
            }

            let html = '';
            results.forEach(person => {
                let certificates = person.certificates;
                if (filterType) {
                    certificates = certificates.filter(cert => cert.type === filterType);
                }

                certificates.forEach(cert => {
                    const statusColor = cert.status === 'Aktif' ? 'green' : 'yellow';
                    const typeNames = {
                        'tipikor': 'Tipikor',
                        'niaga': 'Niaga', 
                        'ham': 'HAM',
                        'pajak': 'Pajak',
                        'lingkungan': 'Lingkungan'
                    };

                    html += `
                        <div class="border-l-4 border-${statusColor}-500 bg-${statusColor}-50 p-4 rounded-r-lg mb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">${person.name}</h4>
                                    <p class="text-gray-600">NIP: ${person.nip}</p>
                                    <p class="text-gray-600">Sertifikat: ${typeNames[cert.type] || cert.type}</p>
                                    <p class="text-gray-600">No: ${cert.number}</p>
                                    <p class="text-sm text-gray-500">Berlaku hingga: ${cert.validUntil}</p>
                                </div>
                                <span class="bg-${statusColor}-100 text-${statusColor}-800 px-3 py-1 rounded-full text-sm font-medium">${cert.status}</span>
                            </div>
                        </div>
                    `;
                });
            });

            container.innerHTML = html;
        }

        // Initialize with dashboard view
        showView('dashboard');
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'985008d2e3a022a1',t:'MTc1ODg2MTExNS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
