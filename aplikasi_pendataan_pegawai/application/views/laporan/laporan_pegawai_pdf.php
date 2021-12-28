<html>

<head>
    <title>Laporan Jabatan</title>
</head>

<body>
    <div align="center">
        <h2>Laporan Data Pegawai</h2>
        <hr>
        <table border="2" width=”300?>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Tempat Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Status Pernikahan</th>
                <th>Jumlah Anak</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($allPegawai as $l) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $l['nama']; ?></td>
                    <td><?= $l['tanggal_lahir']; ?></td>
                    <td><?= $l['tempat_lahir']; ?></td>
                    <td><?= $l['jenis_kelamin']; ?></td>
                    <td><?= $l['agama']; ?></td>
                    <td><?= $l['status_pernikahan']; ?></td>
                    <td><?= $l['jumlah_anak']; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>