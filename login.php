<?php
session_start();
require 'functions.php';

// cek cookie
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_connect($conn, "SELECT username FROM users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if( $key === hash('sha256', $row['password'])) {
        $_SESSION['login'] = true;
    }

}


if( isset($_SESSION["login"]) ) {
    header("location: index.php");
    exit;
}


if( isset($_POST["login"]) ) {
   
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");

    // cek username
    if( mysqli_num_rows($result) === 1 ) { // fungsi untuk cek apa ada baris yg di kembaikan

        // cek password
        $row = mysqli_fetch_assoc($result); //mengambil array dari data
        if( password_verify($password, $row["password"]) ) { // menyamakan password yg telah enkripsi password_hash()
            // set session
            $_SESSION["login"] = true;

            // cek remember me
            if( isset($_POST['remember']) ) {
                // buat cookie

                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username']) , time()+60);
            }

            header("location: index.php");
            exit;
        }
    
    }

    $error = true;

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>LOGIN</title>
</head>
<body>

<div class="p-5">
    <h1 class="display-4">Halaman Login</h1>

    <?php if( isset($error) ) : ?>
        <div class="alert alert-danger col-sm-3">
            Username / password salah!
        </div>
    <?php endif ?>

    <form action="" method="post" class="p-3">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control col-sm-3" name="username" id="username" require>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control col-sm-3" name="password" id="password" require>
        </div>
        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login!</button>
    </form>
</div>
    
</body>
</html>