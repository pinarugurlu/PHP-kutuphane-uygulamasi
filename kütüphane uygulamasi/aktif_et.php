<?php
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


if (isset($_GET["mail"]) && isset($_GET["kod"])) {
    $eposta     = $_GET["mail"];
    $aktivasyon = $_GET["kod"];

    $kullanici = $database->get("391565_tbl_kullanici_yazar", "id", ["AND" => ["eposta" => $eposta, "aktivasyon" => $aktivasyon]]);
    if ($kullanici > 0) {
        $data = $database->update("391565_tbl_kullanici_yazar", ["aktif_mi" => 1], ["id" => $kullanici]);
        echo '<script>alert("Hesabınızın aktivasyonu gerçekleşti.")</script>';
        header("Refresh: 1; url=giris.php");
    }else{
        header("Location:giris.php?m=kod hatalı");
    }

}


?>