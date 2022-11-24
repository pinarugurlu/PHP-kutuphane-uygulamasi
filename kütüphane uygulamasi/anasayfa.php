<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();

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
if (!isset($_SESSION['kullaniciID']) || $_SESSION['kullaniciID'] == "") {
    header("Location:giris.php");
}

// Load Composer's autoloader
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Anasayfa</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="CSS/css.css" type="text/css">
</head>
<body>
<?php include('header.html');?>
<div class="row">
  <div class="side">
    <h3>Hakkımda</h3>
    <h5>Profil Fotoğrafı</h5>
	<?php 
		$kullanici = $database->get("391565_tbl_kullanici_yazar", "*", ["id" => $_SESSION['kullaniciID']]); 
	?>
    <span>
    <?php 
		echo '<img src="' . $kullanici['fotograf'] . '"alt="Profil Fotoğrafı" width="200" height="200">'; 
	?>
    </span><br>
     <h5>Ad Soyad: <?php echo $kullanici['ad_soyad'];?></h5>
	 <h5>E-posta: <?php echo $kullanici['eposta'];?></h5>
  </div>
  <div class="main">
  </div>
</div>

<?php include('footer.html');?>

</body>
</html>