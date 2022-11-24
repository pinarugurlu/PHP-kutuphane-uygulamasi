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

// Doğrulama kodu üretme
$kod_bilesen1 = date('d.m.Y H:i:s');
$kod_bilesen2 = rand(0, 20000);
$aktivasyon_kod = hash('sha256', $kod_bilesen1 . $kod_bilesen2);

$ad_soyad   = "";
$eposta     = "";
$sifre      = "";

if (isset($_POST["ad_soyad"]) && isset($_POST["eposta"]) && isset($_POST["sifre"])) {
    if ($_POST["ad_soyad"] != "" && $_POST["eposta"] != "" && $_POST["sifre"] != "") {
        $ad_soyad   = $_POST["ad_soyad"];
        $eposta     = $_POST["eposta"];
        $sifre      = $_POST["sifre"];

        $hedef_dizin = "resimler/";
        $hedef_dosya = $hedef_dizin . basename($_FILES["fileToUpload"]["name"]);
        $yukleme_durumu = 1;
        $imageFileType = strtolower(pathinfo($hedef_dosya, PATHINFO_EXTENSION));

        
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $yukleme_durumu = 1;
            } else {
                echo "File is not an image.";
                $yukleme_durumu = 0;
            }
        }

        // Dosya boyutu 1 MB'den fazla ise hata verdirir
        if ($_FILES["fileToUpload"]["size"] > 1000000) {
            echo "Dosya boyutu 1 MegaByte'dan büyük.";
            $yukleme_durumu = 0;
        }

        // Belirli dosya formatlarının yüklenmesine izin veren koşul yapısı
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $yukleme_durumu = 0;
        }

        // Dosya yükleme koşulu sağlanamıyorsa dosya yüklemesine izin verme
        if ($yukleme_durumu == 0) {
            echo "Üzgünüz, dosyanız yüklenmedi.";
            // Bütün koşullar sağlanıyorsa dosyayı yükle
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $hedef_dosya)) {
                $database->insert("391565_tbl_kullanici_yazar", ["ad_soyad" => $ad_soyad, "eposta" => $eposta, "sifre" => $sifre, "fotograf" => $hedef_dosya, "aktivasyon" => $aktivasyon_kod]);
                echo htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " dosyası yüklendi.";
                $son_eklenen = $database->id();

                if ($son_eklenen > 0) {
                    $mail = new PHPMailer(true);
                    try {
						$mail->SMTPOptions = array(
                            'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                            )
                            );
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
                        $mail->addAddress($eposta, $ad_soyad); // gidecek kişinin mail adresi, adı soyadı
                        $mail->CharSet = 'UTF-8';

                        // Mailin içeriği
                        $mail->isHTML(true);                      
                        $mail->Subject = 'Aktivasyon e-postası'; // e-postanın konusu
                        $mail->Body    = 'Bu bir aktivasyon e-postasıdır.<br> Hesabınızı aktive etmek için linke tıklayınız.<br><a href="localhost/final_php/aktif_et.php?mail=' . $eposta . '&kod=' . $aktivasyon_kod . '">Tıklayınız</a>';
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        echo '<script>alert("Aktivasyon linkinizi e-postanıza gönderdik.");</script>';
                        echo '<script>window.location = "giris.php";</script>';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            } else {
                echo "Üzgünüz, dosyanız yüklerken bir sorun oluştu.";
            }
        }
    }else{
        echo '<script>alert("Boş Alanları Doldurunuz!");</script>';
        header("Refresh: 1; url=kayit.html");
    }
} else {
    echo 'Alanlar boş bırakılamaz';
}


?>
