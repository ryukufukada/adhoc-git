<?php
// --- Koneksi ke database ---
require_once '../koneksi.php';

// --- Query data usulan pindah hakim ---
$sql = "SELECT u.id, u.tanggal_usul, u.no_surat, u.tanggal_surat, u.status, u.keterangan_status, u.alasan, u.tujuan_usul_text, u.nama_berkas, h.nama_hakim, p_asal.nama_pengadilan AS nama_pengadilan_asal, p_tujuan.nama_pengadilan AS nama_pengadilan_tujuan
        FROM usulan_pindah u
        JOIN hakim_perikanan h ON u.id_hakim = h.id
        JOIN pengadilan p_asal ON u.id_pengadilan_asal = p_asal.id
        LEFT JOIN pengadilan p_tujuan ON u.id_pengadilan_tujuan = p_tujuan.id
        ORDER BY u.id DESC";
$result_usulan = $conn->query($sql);

$conn->close(); // Tutup koneksi setelah query
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Usulan Pindah Hakim</title>
    <!-- Bootstrap 5.3 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap');
        body {  
            font-family: "Karla", sans-serif;
            font-optical-sizing: auto;
            font-style: normal; }
        .status-badge { font-size: 0.85em; padding: 0.3em 0.7em; border-radius: 1em; }
        .table td, .table th { vertical-align: top; }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Header dan tombol kembali -->
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h1 class="h4 fw-bold text-dark mb-0">
                    <i class="fa-solid fa-file-lines me-2"></i> Daftar Usulan Pindah Hakim
                </h1>
                <a href="hakim_perikanan.php" class="btn btn-secondary">
                    <i class="fa-solid fa-gauge-high me-1"></i> Kembali
                </a>
            </div>
            <!-- Tabel data usulan -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Detail Usulan</th>
                            <th>Nama Hakim & Alasan</th>
                            <th>PN Asal</th>
                            <th>Usulan Tujuan</th>
                            <th>Status & Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_usulan && $result_usulan->num_rows > 0): while($usul = $result_usulan->fetch_assoc()): ?>
                            <tr>
                                <!-- Detail Usulan -->
                                <td>
                                    <div><b>Tgl Usul:</b> <?= date('d M Y', strtotime($usul['tanggal_usul'])) ?></div>
                                    <div class="text-muted small"><b>No. Surat:</b> <?= htmlspecialchars($usul['no_surat'] ?? 'N/A') ?></div>
                                    <div class="text-muted small"><b>Tgl Surat:</b> <?= !empty($usul['tanggal_surat']) ? date('d M Y', strtotime($usul['tanggal_surat'])) : 'N/A' ?></div>
                                    <?php if (!empty($usul['nama_berkas'])): ?>
                                        <div class="mt-2 small"><b>Berkas:</b> <a href="../uploads/<?= htmlspecialchars($usul['nama_berkas']) ?>" target="_blank" class="link-primary">Lihat</a></div>
                                    <?php endif; ?>
                                </td>
                                <!-- Nama Hakim & Alasan -->
                                <td>
                                    <div class="fw-semibold"><?= htmlspecialchars($usul['nama_hakim']) ?></div>
                                    <div class="text-muted small mt-1"><b>Alasan:</b> <?= htmlspecialchars($usul['alasan']) ?></div>
                                </td>
                                <!-- PN Asal -->
                                <td><?= htmlspecialchars($usul['nama_pengadilan_asal']) ?></td>
                                <!-- Usulan Tujuan -->
                                <td class="fw-semibold"><?= htmlspecialchars($usul['tujuan_usul_text'] ?? 'N/A') ?></td>
                                <!-- Status & Keterangan -->
                                <td>
                                    <?php
                                    // Tentukan warna badge status
                                    $status_class = 'bg-warning text-dark';
                                    if ($usul['status'] == 'Disetujui') $status_class = 'bg-success text-white';
                                    if ($usul['status'] == 'Ditolak') $status_class = 'bg-danger text-white';
                                    ?>
                                    <span class="status-badge <?= $status_class ?>">
                                        <?= htmlspecialchars($usul['status']) ?>
                                    </span>
                                    <?php if($usul['status'] == 'Disetujui'): ?>
                                        <div class="text-success small mt-2"><b>Tujuan Final:</b> <?= htmlspecialchars($usul['nama_pengadilan_tujuan'] ?? 'N/A') ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($usul['keterangan_status'])): ?>
                                        <div class="text-muted small mt-2"><b>Ket:</b> <?= htmlspecialchars($usul['keterangan_status']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <!-- Aksi -->
                                <td>
                                    <?php if($usul['status'] == 'Diajukan'): ?>
                                        <a href="proses_usulan.php?id=<?= $usul['id'] ?>" class="btn btn-sm btn-primary">Proses</a>
                                    <?php else: ?>
                                        <span class="text-muted small">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data usulan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>