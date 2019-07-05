<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


// membuat fungsi untuk mengambil tabel
function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);

    // membuat array untuk  menampung semua row yg di baca
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    return $rows;
} 


function tambah($data){

    global $conn;
    
    // ambil data dari tiap element
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jabatan = htmlspecialchars($data["jabatan"]);

    // upload gambar 
    $gambar = upload();
    if( !$gambar ){
        return false;
    }

    // query insert data
    $query = "INSERT INTO mahasiswa 
                VALUES
              ('', '$nama', '$nrp', '$email', '$jabatan', '$gambar') 
            ";

    mysqli_query($conn, $query);
    
    // cek apakah data berhasil di tambahkan atau tidak
    // mysqli_effected_rows($conn); => fungsi untuk mengecek transaksi data
        // -1 = gagal || 1 = berhasil 
    return mysqli_affected_rows($conn);
}



function upload() {
    
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yg di upload
    if( $error === 4 ) {
        echo"<script>
                alert('gambar belum di upload!');
            </script>";
        return false;
    }

    // cek apakah yang di upload adalah gambar
    $eksensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if( !in_array($ekstensiGambar, $eksensiGambarValid) ) {
        echo"<script>
                alert('yang anda upload bukan gambar');
            </script>";
        return false;
    }

    // cek jika ukuran gambar 
    if( $ukuranFile > 1000000 ) {
        echo"<script>
                alert('Ukuran gambar terlalu besar!');
            </script>";
        return false;
    }



    // lolos pengecekan, gambar siap di upload
    // ganerete nama gambar baru
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // var_dump($namaFileBaru); die;


    move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

    return $namaFileBaru;

}





function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}



function ubah($data) {
    global $conn;

    // ambil data dari tiap element
    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jabatan = htmlspecialchars($data["jabatan"]);
    

    // cek apakah upload gambar baru?
    if( $_FILES["gambar"]["error"] === 4 ) {
        $gambar = $data["gambarLama"];
    } else {
        $gambar = upload();
    }

    // query update data
    $query = "UPDATE mahasiswa SET
                nrp = '$nrp',
                nama = '$nama',
                email = '$email',
                jabatan = '$jabatan',
                gambar = '$gambar'
                WHERE id = $id
            ";

    mysqli_query($conn, $query);
    
    // cek apakah data berhasil di tambahkan atau tidak
    // mysqli_effected_rows($conn); => fungsi untuk mengecek transaksi data
        // -1 = gagal || 1 = berhasil 
    return mysqli_affected_rows($conn);

}



function cari($keyword) {
    $query = "SELECT * FROM mahasiswa
                WHERE
                nama LIKE '%$keyword%' OR
                nrp LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                jabatan LIKE '%$keyword%'   
            ";
    return query($query);
}


function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi = mysqli_real_escape_string($conn, $data["konfirmasi"]);


    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username' ");
    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('unsername sudah tersedia!');
            </script>";
        return false;
    }


    // cek konfirmasi password
    if( $password !== $konfirmasi ) {
        echo "<script>
                alert('Konfirmasi Password tidak sesuai!');
            </script>";
        return false;
    }

    // enskripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke data base
    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);

}