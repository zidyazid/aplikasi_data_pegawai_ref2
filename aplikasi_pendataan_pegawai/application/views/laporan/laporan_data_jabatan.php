<html>

<head>
    <title>Laporan Jabatan</title>
</head>

<body>
    <div align="center">
        <h2>Laporan Data Jabatan</h2>
        <hr>
        <table border="2" width=”300?>
            <tr>
                <th>No</th>
                <th>Id jabatan</th>
                <th>Jabatan</th>
                <th>Tunjangan</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($getAllData as $v) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $v['kode_jabatan'] ?></td>
                    <td><?= $v['nama_jabatan'] ?></td>
                    <td><?= $v['tunjangan'] ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>