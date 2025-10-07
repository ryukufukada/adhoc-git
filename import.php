<?php
// --- SCRIPT IMPOR ---
require_once 'koneksi.php';
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

// Data CSV Baru Anda
$csvData = <<<CSV
NO,NAMA,ID,ASAL_ORG,JABATAN,PN,KEPRES_NO_TGL,TGL_KEPRES,SK_KMA_DIRJEN,TGL_SK,MASA_JAB,STATUS
1,"Hendra Adi Pramono, S.H., M.H.",3578090810760004,"x`","AD HOC PERIKANAN","PN Jakarta Utara","KEPRES NO 128/P TAHUN 2019","21-11-2019","17/KMA/SK/II/2020","04-02-2020","1X","PERPANJANGAN 2X 04-02-2020 HABIS 04-02-2030"
2,"Warsita, S.H.",3515082010720008,"","AD HOC PERIKANAN","PN Jakarta Utara","96/P Tahun 2022","12-09-2022","326/KMA/SK/XI/2022","11-11-2022","1X","PERPANJANGAN 2X 11-11-2022 HABIS 11-11-2032"
3,"Ir. Arnofi",1371082911630002,"","AD HOC PERIKANAN","PN Jakarta Utara","96/P Tahun 2022","12-09-2022","326/KMA/SK/XI/2022","11-11-2022","1X","PERPANJANGAN 2X 11-11-2022 HABIS 11-11-2032"
4,"Sugeng Widodo, S.H.",3515070202640005,"TNI AL","AD HOC PERIKANAN","PN Medan","KEPRES NO 128/P TAHUN 2019","21-11-2019","17/KMA/SK/II/2020","04-02-2020","1X","PERPANJANGAN 2X 04-02-2020 HABIS 04-02-2030"
5,"Ir Robert Napitupulu, S.H., MSc.",1271172509620001,"DINAS KELAUTAN DAN PERIKANAN","AD HOC PERIKANAN","PN Medan","KEPRES NO 128/P TAHUN 2019","21-11-2019","17/KMA/SK/II/2020","04-02-2020","1X","PERPANJANGAN 2X 04-02-2020 HABIS 04-02-2030"
6,"Soniady Drajat Sadarisman, S.H., M.H.",3273162705690002,"","AD HOC PERIKANAN","PN Medan","KEPRES NO 137/P TAHUN 2020","30-12-2020","04/KMA/SK/I/2021","14-01-2021","1X","PERPANJANGAN 2X 14-01-2021 HABIS 14-01-2031"
7,"Ir. Raja Pasaribu, M.Sc.",3275022202600015,"","AD HOC PERIKANAN","PN Medan","KEPRES NO 137/P TAHUN 2020","30-12-2020","04/KMA/SK/I/2021","14-01-2021","1X","PERPANJANGAN 2X 14-01-2021 HABIS 14-01-2031"
8,"Syaiful Anam, S.H., M.H.",3578183101760001,"","AD HOC PERIKANAN","PN Medan","KEPRES NO 137/P TAHUN 2020","30-12-2020","04/KMA/SK/I/2021","14-01-2021","1X","PERPANJANGAN 2X 14-01-2021 HABIS 14-01-2031"
9,"Sigit Wibowo, S.Pi., M.Pi",3313131809790001,"","AD HOC PERIKANAN","PN Tanjung Pinang","96/P Tahun 2022","12-09-2022","326/KMA/SK/XI/2022","11-11-2022","1X","PERPANJANGAN 2X 11-11-2022 HABIS 11-11-2032"
10,"Handono, S.H.",3578130101650008,"","AD HOC PERIKANAN","PN Tanjung Pinang","96/P Tahun 2022","12-09-2022","326/KMA/SK/XI/2022","11-11-2022","1X","PERPANJANGAN 2X 11-11-2022 HABIS 11-11-2032"
41,"Anthony Soediarto, S.H., M.Hum.",3404101012550004,"","AD HOC PERIKANAN","PN Merauke","KEPRES NO 137/P TAHUN 2020","30-12-2020","04/KMA/SK/I/2021","14-01-2021","1X","PERPANJANGAN 2X 14-01-2021 HABIS 14-01-2031"
CSV;

// 1. Ambil data pengadilan untuk mapping
$pengadilanResult = $conn->query("SELECT id, nama_pengadilan FROM pengadilan");
$pengadilanMap = [];
while ($row = $pengadilanResult->fetch_assoc()) {
    $pengadilanMap[trim($row['nama_pengadilan'])] = $row['id'];
}

// 2. Kosongkan tabel
$conn->query("SET FOREIGN_KEY_CHECKS=0");
$conn->query("TRUNCATE TABLE hakim_perikanan");
$conn->query("TRUNCATE TABLE kebutuhan_perikanan");
$conn->query("SET FOREIGN_KEY_CHECKS=1");

// 3. Siapkan statement INSERT
$stmt = $conn->prepare("INSERT INTO hakim_perikanan (nama_hakim, nik, asal_org, id_pengadilan, kepres_no_tgl, tgl_kepres, sk_kma_dirjen, tgl_sk, masa_jab, status_perpanjangan, tanggal_habis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$lines = explode("\n", trim($csvData));
array_shift($lines); // Hapus header
$counter = 0;

foreach ($lines as $line) {
    $data = str_getcsv($line);
    
    $id_pengadilan = $pengadilanMap[trim($data[5])] ?? null;
    if (!$id_pengadilan) continue; // Lewati jika PN tidak ditemukan

    $tgl_kepres = !empty($data[7]) ? date('Y-m-d', strtotime($data[7])) : null;
    $tgl_sk = !empty($data[9]) ? date('Y-m-d', strtotime($data[9])) : null;
    
    $tanggal_habis = null;
    if (strpos($data[11], 'HABIS') !== false) {
        $parts = explode('HABIS', $data[11]);
        $dateStr = trim(end($parts));
        $dateObj = date_create_from_format('d-m-Y', $dateStr);
        if ($dateObj) {
            $tanggal_habis = $dateObj->format('Y-m-d');
        }
    }
    
    $stmt->bind_param("sssisssssss", $data[1], $data[2], $data[3], $id_pengadilan, $data[6], $tgl_kepres, $data[8], $tgl_sk, $data[10], $data[11], $tanggal_habis);
    $stmt->execute();
    $counter++;
}

$stmt->close();
$conn->close();

echo "<h1>Impor Selesai!</h1><p><b>{$counter}</b> data hakim berhasil diimpor.</p>";
echo '<a href="perikanan_db.php">Kembali ke Halaman Utama</a>';
?>