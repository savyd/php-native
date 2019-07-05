<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

require "functions.php";

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {

    // var_dump($_POST);
    // var_dump($_FILES);
    // die;

    // cek apakah data berhasil di tambahkan atau tidak
    if(tambah($_POST) > 0){
        echo "
            <script>
                alert('Data Berhahsil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal ditambahkan!');
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
    <title>Tambah Data</title>
</head>
<body>

<div class="p-5">
    <h1>Tambah Data Karyawan</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nrp">NRP :</label>
            <input type="text" class="form-control col-sm-3" name="nrp" id="nrp" placeholder="Enter NRP">
        </div>
        <div class="form-group">
            <label for="nama">Nama Lengkap :</label>
            <input type="text" class="form-control col-sm-3" name="nama" id="nama" placeholder="Enter nama lengkap">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="text" class="form-control col-sm-3" name="email" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan:</label>
            <input type="text" class="form-control col-sm-3" name="jabatan" id="jabatan" placeholder="Enter jabatan">
        </div>
        <div class="form-group">
            <label for="gambar">Gambar :</label>
            <input type="file" class="form-control col-sm-3" name="gambar" id="gambar">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

    
</body>
</html>