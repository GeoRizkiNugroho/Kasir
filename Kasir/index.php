<?php
session_start();

if (!isset($_SESSION["data_barang"])) 
{
    $_SESSION["data_barang"] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['btn-submit'])) 
    {
        $Nama = $_POST["nama"];
        $Harga = $_POST["harga"];
        $Jumlah = $_POST["jumlah"];
        $Total = $Harga * $Jumlah;

        $_SESSION["data_barang"][] = array("nama" => $Nama, "harga" => $Harga, "jumlah" => $Jumlah, "total" => $Total);
        $_SESSION['success_message'] = "Data berhasil ditambahkan";
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['btn-delete'])) 
    {
        $Index = $_POST["delete-index"];
        unset($_SESSION['data_barang'][$Index]);
        $_SESSION['data_barang'] = array_values($_SESSION['data_barang']);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
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
        h3, h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], button, a {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .alert {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
        }
        .alert-danger {
            background-color: #f44336;
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
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert">
                <?= $_SESSION['success_message'] ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <h3>Masukan Data Barang</h3>
        <form method="post">
            <input type="text" name="nama" placeholder="Nama Barang" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <input type="number" name="jumlah" placeholder="Jumlah" required>
            <button type="submit" name="btn-submit">Tambah</button>
        </form>

        <h3>List Barang</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION["data_barang"])): ?>
                    <?php foreach ($_SESSION["data_barang"] as $Index => $Barang): ?>
                        <tr>
                            <td><?= $Index + 1 ?></td>
                            <td><?= $Barang['nama'] ?></td>
                            <td><?= $Barang['harga'] ?></td>
                            <td><?= $Barang['jumlah'] ?></td>
                            <td>Rp <?= number_format($Barang['total'], 2, ',', '.') ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="delete-index" value="<?= $Index ?>">
                                    <button type="submit" name="btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Belum ada data barang.</td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="4">Total Barang</td>
                    <td colspan="2">
                        <?php
                        $TotalBarang = array_sum(array_column($_SESSION["data_barang"], 'jumlah'));
                        echo $TotalBarang;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">Total Harga</td>
                    <td colspan="2">
                        <?php
                        $TotalHarga = array_sum(array_column($_SESSION["data_barang"], 'total'));
                        echo "Rp " . number_format($TotalHarga, 2, ',', '.');
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="checkout.php">Check Out</a>
    </div>
</body>
</html>
