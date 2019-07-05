<?php

require 'functions.php';

if( isset($_POST["register"]) ) {

    if( registrasi($_POST) > 0 ) {
        echo "<script>
                alert('user baru berhasil di tambahkan!');
            </script>";
    } else {
        echo mysqli_error($conn);
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="p-5">
    <h1 class="display-4">Halaman Registrasi</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control col-sm-3" name="username" id="username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control col-sm-3" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="konfirmasi">Konfirmasi Password</label>
            <input type="password" class="form-control col-sm-3" name="konfirmasi" id="konfirmasi">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Register!</button>
    </form>
</div>
    
</body>
</html>