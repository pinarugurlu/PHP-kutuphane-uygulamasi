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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/css.css" type="text/css">
    <title>Ansiklopediler</title>

</head>
<body>
<?php include('header.html');?>

<div class="row">
  <div class="side">
<form action="" method="post">
	<table border='1' align='center'>
		<tr>
			<th colspan="2"><label>Listemek İstediğiniz Yazarı Seçiniz</label></th>
		</tr>
			<td>
				<select id='yazar' value='' name='yazar'><option>--Hepsi--</option>
					<?php
						$yazarlar = $database->select('391565_tbl_kullanici_yazar', array('id', 'ad_soyad'));
							foreach($yazarlar as $yazar){
								echo "<option value='" . $yazar['id'] ."'>" . $yazar['ad_soyad'] ."</option>";
							}
					?>
				</select>
			</td>
			<td> <input type="submit" name="filtrele" value="Filtrele" /> </td>
		</tr>
	</table>

</form>
	<br>
	<?php
	function listAnsiklopedi($secilmis_yazar_id){
		$database = new Medoo([
			// required
			'database_type' => 'mysql',
			'database_name' => 'php_final',
			'server' => 'localhost',
			'username' => 'root',
			'password' => ''
		]);
		
		$guncelle_link="";
		$sil_link="";
		$yazar="";
		$ansiklopedi_yazar_id ="";
		$yazar_id ="";
		$yazar_ad ="";
		$ansiklopediler="";
		
		if($secilmis_yazar_id>0){
			$ansiklopedi_ids = $database->select("391565_tbl_yazar_ansiklopedi", "eser_id",
			["yazar_id" => $secilmis_yazar_id,]);
			if($ansiklopedi_ids){
				$ansiklopediler = $database->select('391565_tbl_ansiklopedi', array('id', 'ad','alan','yayin_evi'), 
				["id" => array_values($ansiklopedi_ids),]);
			}
		}
		else{
			$ansiklopediler = $database->select('391565_tbl_ansiklopedi', array('id', 'ad','alan','yayin_evi'));
		}
		
		if($secilmis_yazar_id){
		echo "<table border='1' align='center'>
		<tr>
			<th>Ad</th>
			<th>Alan</th>
			<th>Yayın evi</th>
			<th>Yazar</td>
			<th>İşlemler</th>
		</tr>";

		if(!empty($ansiklopediler)){
		foreach($ansiklopediler as $ansiklopedi){			
			//Veritabanı işlemleri
			$ansiklopedi_yazar_id = $database->select("391565_tbl_yazar_ansiklopedi", "yazar_id", ["eser_id" =>$ansiklopedi['id']]);
			if($ansiklopedi_yazar_id){
				$yazar = $database->select("391565_tbl_kullanici_yazar", array("id","ad_soyad"), ["id" => $ansiklopedi_yazar_id['0']]); // yazar bilgisini vt den alıyorum.
				$yazar_ad = $yazar[0]['ad_soyad']; // yazar ad-soyad bilgisini değişkene atıyorum.
				$yazar_id = $yazar[0]['id'];// yazar id bilgisini değişkene atıyorum.
			}
			
			$guncelle_link= "ansiklopedi_guncelle.php?id=".$ansiklopedi['id']."&yazar_id=".$yazar_id;
			$sil_link= "ansiklopedi_sil.php?id=".$ansiklopedi['id']."&yazar_id=".$yazar_id;
			
			//Veritabanı işlemleri bitti
			 echo "<tr>
			 <td>" .$ansiklopedi['ad'] ."</td>
			 <td>" .$ansiklopedi['alan'] ."</td>
			 <td>" .$ansiklopedi['yayin_evi'] ."</td>
			 <td>".$yazar_ad."</td>
			 <td>  
				<a href='".$guncelle_link."'>Güncelle</a>
				<a href='".$sil_link."' onclick=uyari();>Sil</a>
			 </td>
			</tr>";
			 }
			}
			else{
				echo "<tr><td colspan='5'>Kayıt bulunamadı.</td></tr>";
			}
			echo "</table>";
		}
		
	}
	
     function filtreleAndiklopedi() {
      if ($_POST){
		if (isset($_POST['yazar'])) {
			if ($_POST['yazar'] != "") {
				$yazar_id = $_POST['yazar'];
				listAnsiklopedi($yazar_id);
		}
	 }}
	 }
	if(isset($_POST['filtrele'])) { 
         filtreleAndiklopedi();
    }
    
?>
<?php
	listAnsiklopedi(0);
?>

	</div>
</div>
<?php include('footer.html');?>
</body>
</html>
	<script language="JavaScript">
		function uyari() {
		 
		if (confirm("Bu kaydı silmek istediğinize emin misiniz?"))
		   return true;
		else 
		   return false;
		}
	</script>

