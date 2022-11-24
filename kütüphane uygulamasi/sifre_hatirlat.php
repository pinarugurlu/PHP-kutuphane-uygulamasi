<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Hatırlat Sayfası</title>
	<link rel="stylesheet" href="CSS/css.css" type="text/css">


</head>

<body>
<div class="header">
  <h3>Ansiklopedi Uygulaması</h3>
</div>
<div class="navbar">
<a href="giris.php" class="right">Giriş</a>
</div>
<div class="row">
  <div class="side">
    <!--Hatırlat Sayfası-->
    <div class="form">
        <form action="" method="post">
            <h2 id="logoYazi">Kullanıcı Şifre Hatırlat</h2>
            <input type="email" id="eposta" name="eposta" placeholder="E-posta">
            <br><br>
            <input type="submit" id="sifreHatirlat" name="submit" value="Hatırlat">
       <br>
	   </form>
</div>
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Medoo/Medoo.php';

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

// Load Composer's autoloader
require 'vendor/autoload.php';

$eposta = "";
$sifre  = "";

if (isset($_POST["eposta"])) {
    if ($_POST["eposta"] != "") {
        $eposta = $_POST["eposta"];
        $sifre = $database->get("391565_tbl_kullanici_yazar", "*", ["eposta" => $eposta]);
        if (isset($sifre) == 0) {
            echo '<script>alert("Böyle bir eposta yok!");</script>';
        } else {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
                $mail->isSMTP();                                           
                $mail->Host       = 'smtp.gmail.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'pinar391565@gmail.com';                     
                $mail->Password   = 'Pinar123';                               
                $mail->SMTPSecure = 'tls';         
                $mail->Port       = 587;                                    

                //Recipients
                $mail->setFrom('pinar391565@gmail.com', 'Pınar Uğurlu');
                $mail->addAddress($sifre["eposta"], $sifre["ad"]); // gidecek kişinin mail adresi, adı soyadı
                $mail->CharSet = 'UTF-8';


                // Mailin içeriği
                $mail->isHTML(true);                      // Set email format to HTML
                $mail->Subject = 'Şifre Hatırlatma';     // e-postanın konusu
                $mail->Body    = '<p>Şifreniz: ' . $sifre["sifre"] . '</p>';
                $mail->Body    = '<p><b>Sayın </b>' . $sifre["ad_soyad"] . ',<br><br><b>Şifreniz: </b>' . $sifre["sifre"];


                $mail->send();
                echo '<script>alert("E-posta gönderildi");</script>';
                echo '<script>window.location = "giris.php";</script>';
            } catch (Exception $e) {
                echo "Mesaj Gönderilemedi. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        echo '<script>alert("E-posta alanı boş bırakılamaz!");</script>';
    }
}

?>
</div>
</div>
<?php include('footer.html');?>
</body>

</html>