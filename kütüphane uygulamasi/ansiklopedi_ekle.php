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
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/css.css" type="text/css">
    <title>Ansiklopedi Ekle</title>
</head>
<?php include('header.html');?>
<div class="row">
  <div class="side">
        <form action="" method="post">
		<table border='1' align='center'>
		<tr>
			<td colspan='2' align='center'> Ansiklopedi Ekle</td>
		</tr>
		<tr>
			<td>Yazar</td>
			<td>			
				<?php
					$yazarlar = $database->select(
						'391565_tbl_kullanici_yazar', 
						array('id', 'ad_soyad')
					);

					echo "<select name='yazar'><option>--Yazar Seçiniz--</option>";
					foreach($yazarlar as $yazar){
						 echo "<option value='" . $yazar['id'] ."'>" . $yazar['ad_soyad'] ."</option>";
						 }
					echo "</select>";
				?>
			</td>
		</tr>
		<tr>
			<td>Ad</td>
			<td>			
				<input type="text" name="ad">
			</td>
		</tr>
		<tr>
			<td>Alan</td>
			<td>			
				<input type="text" name="alan">
			</td>
		</tr>
		<tr>
			<td>Yayın Evi</td>
			<td>			
				 <input type="text" name="yayin_evi">
			</td>
		</tr>
		<tr>
			<td colspan="2"> <input type="submit" name="submit" value="Ekle"></td>
		</tr>
	</table>
</form>	

	
	
	
    <?php
    $yazar_id = "";
    $ad = "";
    $yayin_evi = "";
    $alan = "";
if ($_POST){
    if (isset($_POST['yayin_evi']) && isset($_POST['ad']) && isset($_POST['alan']) && isset($_POST['yazar'])) {
        if ($_POST['yayin_evi'] != "" && $_POST['ad'] != "" && $_POST['alan'] != "" && $_POST['yazar'] != "") {
            
            $ad  = $_POST['ad'];
            $alan  = $_POST['alan'];
			$yayin_evi      = $_POST['yayin_evi'];
			$yazar_id  = $_POST['yazar'];

            $database->insert("391565_tbl_ansiklopedi", ["ad" => $ad, "alan" => $alan, "yayin_evi" => $yayin_evi]);
            $kaydedilen_ansiklopedi_id = $database->id();
			$database->insert("391565_tbl_yazar_ansiklopedi", ["yazar_id" => $yazar_id, "eser_id" => $kaydedilen_ansiklopedi_id]);
            if ($kaydedilen_ansiklopedi_id > 0 ) {
                echo '<script>alert("Ansiklopedi kaydedildi.");</script>';
                header("Location:ansiklopedi.php");
            } else {
                echo '<script>alert("Hata Kayıt Gerçekleştirilemedi.");</script>';
            }
        } else {
            echo '<script>alert("Alanları Eksiksiz Bir Biçimde Doldurunuz!");</script>';
        }
    }
	else {
		 echo '<script>alert("Alanları Eksiksiz Bir Biçimde Doldurunuz!");</script>';
	}
	}
    ?>
  </div>
</div>
<?php include('footer.html');?>
<body>

</body>
</html>