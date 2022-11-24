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
    <title>Güncelle</title>
</head>
<?php include('header.html');?>
<div class="row">
  <div class="side">	
    <?php
	$ansiklopedi_id=$_GET['id'];
	$yazar_id=$_GET['yazar_id'];
	$ansiklopedi = $database->select(
					'391565_tbl_ansiklopedi', 
					array('id', 'ad','alan','yayin_evi'),["id" => $ansiklopedi_id]
				);
	$yazarlar = $database->select(
		'391565_tbl_kullanici_yazar', 
		array('id', 'ad_soyad')
	);
	$secili_yazar = $database->select(
		'391565_tbl_kullanici_yazar', 
		array('id', 'ad_soyad'), ["id" =>$yazar_id]);

    ?>     
			
<div class='form'>
<form action='' method='post'>
<table border='1' align='center'>
			<tr>
				<td colspan='2' align='center'> Ansiklopedi Güncelleme</td>
			</tr>
			<tr>
				<td>Ad</td>
				<td>
					<?php
						echo "<input type='text' name='ad' value='".$ansiklopedi['0']['ad']."'>";
					?> 
				</td>
			</tr>
			<tr>
				<td>Alan</td>
				<td>
					<?php
						echo "<input type='text' name='alan' value='".$ansiklopedi['0']['alan']."'>";
					?> </td>
			</tr>
			<tr>
				<td>Yayın evi</td>
				<td>
					<?php
						echo "<input type='text' name='yayin_evi' value='".$ansiklopedi['0']['yayin_evi']."'>";
					?> 
				</td>
			</tr>
			<tr>
				<td>Yazar</td>
				<td>
				<select name='yazar'>
				<?php
					foreach($yazarlar as $yazar){
						if($secili_yazar['0']['id'] == $yazar['id']){
							echo "<option selected value='".$yazar['id']."'>".$yazar['ad_soyad']."</option>";
						}
						else{
							echo "<option value='".$yazar['id']."'>".$yazar['ad_soyad']."</option>";
						}
					 }
				?>  
				</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type='submit' value='Kaydet'></td>
			</tr>
		</table>
	</form>
</div>
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
				$yayin_evi = $_POST['yayin_evi'];
				$yazar_id  = $_POST['yazar'];

				$database->update("391565_tbl_ansiklopedi", ["ad" => $ad, "alan" => $alan, "yayin_evi" => $yayin_evi],["id" =>$ansiklopedi_id] );
				$database->delete("391565_tbl_yazar_ansiklopedi", [ "eser_id" => array($ansiklopedi_id)]);
				$database->insert("391565_tbl_yazar_ansiklopedi", ["yazar_id" => $yazar_id, "eser_id" => $ansiklopedi_id]);
				echo '<script>alert("Ansiklopedi güncellendi.");</script>';
				header("Location:ansiklopedi.php");
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