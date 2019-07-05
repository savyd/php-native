<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

require 'functions.php';

// ambil data di URL
$id = $_GET["id"];


// query data mahasiswa berdasarkan data mahasiswa
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


if( isset($_POST["submit"]) ) {

    // cek apakah data berhasil di tambahkan atau tidak
    if( ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('Data Berhahsil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal ubah!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Ubah Data</title>
</head>
<body>

<div class="p-5">
    <h1>Ubah Data Karyawan</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">

        <img src="../img/<?= $mhs['gambar'] ?>" width="100" class="my-2">
        <div class="form-group">
            <label for="gambar">Gambar :</label> 
            <input type="file" class="form-control col-sm-3" name="gambar" id="gambar">
        </div>

        <div class="form-group">
            <label for="nrp">NRP :</label>
            <input type="text" class="form-control col-sm-3" name="nrp" id="nrp" required value="<?= $mhs["nrp"] ?>">
        </div>
        <div class="form-group">
            <label for="nama">Nama Lengkap :</label>
            <input type="text" class="form-control col-sm-3" name="nama" id="nama" required value="<?= $mhs["nama"] ?>">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="text" class="form-control col-sm-3" name="email" id="email" required value="<?= $mhs["email"] ?>">
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan:</label>
            <input type="text" class="form-control col-sm-3" name="jabatan" id="jabatan" required value="<?= $mhs["jabatan"] ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ubah Data</button>
    </form>
</div>
    
</body>
</html>