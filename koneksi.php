<?php
// --- PENGATURAN KONEKSI DATABASE ---
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Kosongkan jika tidak menggunakan password
$db_name = 'sertifikasi_hakim';

// --- BUAT KONEKSI ---
// Perintah ini mencoba terhubung ke server database MySQL.
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// --- CEK KONEKSI ---
// Jika ada error saat koneksi, hentikan script dan tampilkan pesan kesalahannya.
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

?>