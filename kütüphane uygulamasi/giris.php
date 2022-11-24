<?php
require 'Medoo/Medoo.php';
session_start();
// Using Medoo namespace
use Medoo\Medoo;

$database = new Medoo([
    // required
    'database_type' => 'mysql',
    'database_name' => 'php_final',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/css.css" type="text/css">
    <title>Giriş Sayfası</title>
  

</head>

<body>
<div class="header">
  <h3>Ansiklopedi Uygulaması</h3>
</div>
<div class="navbar">
</div>
<div class="row">
  <div class="side">
    <!--Giriş Sayfası-->
    <div class="form">
        <form action="" method="post">
            <h3>Giriş Formu</h3>
            <hr>
            <label>E-posta</label>
            <input type="email" name="eposta">
            <br><br>
            <label>Şifre</label>
            <input type="password" name="sifre">
            <br><br>
            <hr>
            <input type="submit" name="submit" value="Giriş Yap" style="width: 10%;"><br><br>
        </form>
        <a href="sifre_hatirlat.php"><button style="width: 10%;">Şifre Hatırlat</button></a><br><br>
        <a href="kayit.html"><button style="width: 10%;">Kayıt Ol</button></a>
    </div>

    <?php
    $eposta = "";
    $sifre  = "";

    if (isset($_POST["eposta"]) && isset($_POST["sifre"])) {
        if ($_POST["eposta"] != "" && $_POST["sifre"] != "") {
            $eposta = $_POST["eposta"];
            $sifre  = $_POST["sifre"];
            $giris_yapan = $database->select("391565_tbl_kullanici_yazar", "*", ["AND" => ["eposta" => $eposta, "sifre" => $sifre]]);
		   if ($giris_yapan['0']['id']) {
                //kullanıcının hesabı mevcutsa kullanıcı hesabının aktifliğini sorgula
                if ($giris_yapan['0']["aktif_mi"] == "1") {
                    $_SESSION['kullaniciID'] = $giris_yapan['0']["id"];
                   header("Location:anasayfa.php");
                    exit;
                } else {
                    echo '<script>alert("Hesabınız Aktif Değil. E-postanızdan Hesabınızı Aktive Edin.")</script>';
                }
            } else {
                echo '<script>alert("Kullanıcı Bilgileriniz Hatalı, Tekrar Deneyiniz.")</script>';
            }
        } else {
            echo '<script>alert("Lütfen Boş Alanları Eksiksiz Bir Biçimde Doldurunuz.")</script>';
        }
    }

    ?>
  </div>
</div>
<?php include('footer.html');?>
</body>

</html>

