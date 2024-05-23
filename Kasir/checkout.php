<?php
session_start();

$totalHarga = 0;
if (isset($_SESSION['data_barang']) && !empty($_SESSION['data_barang'])) {
    foreach ($_SESSION['data_barang'] as $barang) {
        $totalHarga += $barang['total'];
    }
    if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['btn-submit'])) {
        $nominal = $_POST["bayar"];
        if ($nominal < $totalHarga) {
            $kurang = $totalHarga - $nominal;
            $error_message = "Nominal uang yang dimasukkan kurang Rp " . number_format($kurang, 0, ',', '.');
        } else {
            $_SESSION['nominal'] = $nominal;
            $_SESSION['totalHarga'] = $totalHarga;
            header("Location: receipt.php?bayar=$nominal");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Sekarang</title>
    <link rel="stylesheet" href="public/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        h3 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        input[type="number"], button, a {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
        }
        button, a {
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            text-align: center;
        }
        button:hover, a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3>Bayar Sekarang</h3>
        <form method="post">
            <label for="bayar">Masukan Nominal Uang</label>
            <input type="number" name="bayar" required>
            <?php if (isset($totalHarga) && $totalHarga > 0): ?>
                <div>Total Yang Harus Dibayar: Rp <?= number_format($totalHarga, 0, ',', '.') ?></div>
            <?php else: ?>
                <p class='text text-danger text-center fw-bold'>Tidak ada barang yang harus dibayar</p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div class="alert"><?= $error_message ?></div>
            <?php endif; ?>
            <button type="submit" name="btn-submit">Bayar</button>
            <a href="index.php">Kembali</a>
        </form>
    </div>
</body>
</html>
