<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengecekan Sertifikasi Hakim AdHoc</title>
    <!-- Memuat Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Memuat Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Style untuk menyembunyikan halaman yang tidak aktif */
        .page {
            display: none;
        }
        /* Style untuk menampilkan halaman yang aktif */
        .page.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="container mx-auto p-4 max-w-4xl">

        <!-- ====================================================== -->
        <!--                         HALAMAN LOGIN                  -->
        <!-- ====================================================== -->
        <div id="loginPage" class="page active">
            <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg max-w-md mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengecekan Sertifikasi Hakim Karir</h1>
                    <p class="text-gray-500 mt-2">Silakan masuk untuk melanjutkan</p>
                </div>
                <form id="loginForm">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: admin" required>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: admin" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:scale-105">
                        Login
                    </button>
                    <p id="loginError" class="text-red-500 text-sm mt-4 text-center hidden">Username atau password salah.</p>
                </form>
            </div>
        </div>

        <!-- ====================================================== -->
        <!--                       HALAMAN DASHBOARD                -->
        <!-- Halaman ini tidak akan digunakan jika login admin berhasil -->
        <!-- ====================================================== -->
        <div id="dashboardPage" class="page">
            <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg">
                <div class="flex justify-between items-center mb-8 border-b pb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Dashboard Hakim</h1>
                    <button id="logoutBtn" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600 transition">Logout</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Nama Hakim</h3>
                        <p id="namaHakim" class="text-lg font-semibold text-gray-800 mt-1">Budi Santoso, S.H., M.H.</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">NIP</h3>
                        <p id="nipHakim" class="text-lg font-semibold text-gray-800 mt-1">197508172000031002</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Sertifikat Aktif</h3>
                        <p id="sertifikatHakim" class="text-lg font-semibold text-gray-800 mt-1">Hakim Tipikor</p>
                    </div>
                </div>
                <div class="text-center">
                    <button id="goToCekSertifikat" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition transform hover:scale-105">
                        Cek Daftar Sertifikasi
                    </button>
                </div>
            </div>
        </div>

        <!-- ====================================================== -->
        <!--                 HALAMAN CEK SERTIFIKAT                 -->
        <!-- Halaman ini tidak akan digunakan jika login admin berhasil -->
        <!-- ====================================================== -->
        <div id="cekSertifikatPage" class="page">
             <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg">
                <div class="flex justify-between items-center mb-8 border-b pb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Daftar Sertifikasi</h1>
                    <button id="backToDashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition">Kembali</button>
                </div>
                <div class="mb-6">
                    <label for="searchSertifikat" class="block text-sm font-medium text-gray-700 mb-2">Cari Sertifikasi</label>
                    <input type="text" id="searchSertifikat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Ketik nama sertifikasi...">
                </div>
                <div class="h-96 overflow-y-auto pr-4">
                    <ul id="sertifikatList" class="space-y-3">
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Hakim Tindak Pidana Korupsi (Tipikor)</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Hakim Hubungan Industrial</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Hakim Perikanan</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Hakim Niaga</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Hakim Pajak</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Hakim Anak</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Mediator</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Ekonomi Syariah</span></li>
                        <li class="p-4 bg-gray-50 rounded-lg flex items-center"><span class="font-medium text-gray-800">Sertifikasi Lingkungan Hidup</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- DOM Elements ---
        const pages = document.querySelectorAll('.page');
        const loginForm = document.getElementById('loginForm');
        const loginError = document.getElementById('loginError');
        const logoutBtn = document.getElementById('logoutBtn');
        const goToCekSertifikatBtn = document.getElementById('goToCekSertifikat');
        const backToDashboardBtn = document.getElementById('backToDashboard');
        const searchInput = document.getElementById('searchSertifikat');
        const sertifikatList = document.getElementById('sertifikatList').getElementsByTagName('li');

        // --- Fungsi untuk Navigasi Halaman ---
        function showPage(pageId) {
            pages.forEach(page => {
                page.classList.remove('active');
            });
            const activePage = document.getElementById(pageId);
            if (activePage) {
                activePage.classList.add('active');
            }
        }

        // --- Event Listener untuk Login ---
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form dari reload halaman
            const username = event.target.username.value;
            const password = event.target.password.value;

            // Logika login diubah untuk admin dan mengarah ke index.php
            if (username === 'admin' && password === 'admin') {
                loginError.classList.add('hidden');
                // Mengarahkan ke halaman index.php setelah login berhasil
                window.location.href = 'index.php';
            } else {
                loginError.classList.remove('hidden');
            }
        });

        // --- Event Listener untuk Logout ---
        logoutBtn.addEventListener('click', function() {
            loginForm.reset(); // Mengosongkan field username & password
            showPage('loginPage');
        });

        // --- Event Listener untuk Tombol Navigasi ---
        goToCekSertifikatBtn.addEventListener('click', function() {
            showPage('cekSertifikatPage');
        });

        backToDashboardBtn.addEventListener('click', function() {
            showPage('dashboardPage');
        });
        
        // --- Event Listener untuk Pencarian Sertifikat ---
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            
            for (let i = 0; i < sertifikatList.length; i++) {
                const item = sertifikatList[i];
                const text = item.textContent || item.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            }
        });

        // --- Halaman Awal ---
        // Memastikan halaman login yang ditampilkan pertama kali
        document.addEventListener('DOMContentLoaded', () => {
            showPage('loginPage');
        });

    </script>
</body>
</html>

