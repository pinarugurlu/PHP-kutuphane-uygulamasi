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



// Load Composer's autoloader
require 'vendor/autoload.php';

	$ansiklopedi_id=$_GET['id'];
	$yazar_id=$_GET['yazar_id'];
	$database->delete("391565_tbl_yazar_ansiklopedi", [ "eser_id" => array($ansiklopedi_id)]);
	$database->delete("391565_tbl_ansiklopedi", [ "id" => array($ansiklopedi_id)]);	
    header("Location:ansiklopedi.php");
	echo '<script>alert("Ansiklopedi başarıyla silindi.");</script>';
	
?>
