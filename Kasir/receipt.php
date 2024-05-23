<?php
session_start();
$nominal = $_SESSION['nominal'];
$totalHarga = $_SESSION['totalHarga'];
$kembalian = $nominal - $totalHarga;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="public/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        p {
            margin: 5px 0;
        }
        .text-center {
            text-align: center;
        }
        .mb-4 {
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Bukti Pembayaran</h2>
        <p>No. Transaksi #<?= rand(10, 1000000000) ?></p>
        <p>Tanggal #<?= date("Y-m-d H:i:s") ?></p>
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION["data_barang"] as $barang): ?>
                    <tr>
                        <td><?= $barang['nama'] ?></td>
                        <td>Rp <?= number_format($barang['harga'], 2, ',', '.') ?></td>
                        <td><?= $barang['jumlah'] ?></td>
                        <td>Rp <?= number_format($barang['total'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Uang Yang Dibayarkan:</strong> Rp <?= number_format($nominal, 2, ',', '.') ?></p>
        <p><strong>Total:</strong> Rp <?= number_format($totalHarga, 2, ',', '.') ?></p>
        <?php if ($kembalian > 0): ?>
            <p><strong>Kembalian:</strong> Rp <?= number_format($kembalian, 2, ',', '.') ?></p>
        <?php endif; ?>
        <a href="index.php" class="btn">Kembali</a>
        <button class="btn" onclick="window.print()">Print</button>
    </div>
</body>
</html>
