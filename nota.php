<!-- nota.php -->
<?php
// Include the file containing the functions
include_once("koneksi.php");

// Fetch information for the invoice
$periksaId = $_GET['id_invoice'];
$periksaInfo = getPeriksaInfo($periksaId);
$selectedObats = explode(",", $periksaInfo['id_obat']);
$selectedObatsInfo = getSelectedObatsInfo($selectedObats);
$jasaDokter = 150000; // Default jasa dokter

// Fetch patient information
$patientId = $periksaInfo['id_pasien'];
$patientInfo = getPatientInfo($patientId);

// Fetch doctor information
$doctorId = $periksaInfo['id_dokter'];
$doctorInfo = getDoctorInfo($doctorId);

// Calculate total invoice
$totalInvoice = $jasaDokter;
foreach ($selectedObatsInfo as $obat) {
    $totalInvoice += $obat['harga'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
    <!-- Include Bootstrap CSS -->
    <!-- Bootstrap Offline -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"> 
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous">
    <style>
       body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: black; /* Mengganti warna teks menjadi hitam */
        }

        p {
            margin-bottom: 8px;
            color: black; /* Mengganti warna teks menjadi hitam */
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 4px;
            color: black; /* Mengganti warna teks menjadi hitam */
        }

        strong {
            color: black; /* Mengganti warna teks menjadi hitam */
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody + tbody {
            border: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nota Pembayaran</h2>

        <!-- Display invoice details -->
        <div class="row">
            <div class="col-md-6">
                <p><strong>No. Periksa:</strong> <?php echo isset($periksaInfo['id']) ? $periksaInfo['id'] : ''; ?></p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Tanggal Periksa:</strong> <?php echo isset($periksaInfo['tgl_periksa']) ? $periksaInfo['tgl_periksa'] : ''; ?></p>
            </div>
        </div>

        <!-- Patient and Doctor Information -->
        <div class="row">
            <div class="col-md-6">
                <p><strong>Pasien:</strong></p>
                <p>Nama Pasien: <?php echo $patientInfo['nama']; ?></p>
                <p>Alamat: <?php echo $patientInfo['alamat']; ?></p>
                <p>Nomer HP: <?php echo $patientInfo['no_hp']; ?></p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Dokter:</strong></p>
                <p>Nama Dokter: <?php echo $doctorInfo['nama']; ?></p>
                <p>Alamat: <?php echo $doctorInfo['alamat']; ?></p>
                <p>Nomer HP: <?php echo $doctorInfo['no_hp']; ?></p>
            </div>
        </div>

        <!-- Invoice Details -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jasa Dokter</td>
                    <td>Rp <?php echo number_format($jasaDokter, 0, ',', '.'); ?></td>
                </tr>
                <?php foreach ($selectedObatsInfo as $obat): ?>
                <tr>
                    <td><?php echo $obat['nama_obat'] . ' ' . $obat['kemasan']; ?></td>
                    <td>Rp <?php echo number_format($obat['harga'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Subtotal and Total -->
        <p><strong>Subtotal Obat:</strong> Rp <?php echo number_format(array_sum(array_column($selectedObatsInfo, 'harga')), 0, ',', '.'); ?></p>
        <p><strong>Total:</strong> Rp <?php echo number_format($totalInvoice, 0, ',', '.'); ?></p>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-yQfxKTAz0JdEjzW5jJeXVEJfZ7pIxgsrxCKfVcZzYUAfxPm8zp+Qu3t2k5t8lWVg" crossorigin="anonymous"></script>
    </div>
</body>
</html>