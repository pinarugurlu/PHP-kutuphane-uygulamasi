-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 24 Şub 2021, 11:41:20
-- Sunucu sürümü: 10.4.17-MariaDB
-- PHP Sürümü: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `php_final`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `391565_tbl_ansiklopedi`
--

CREATE TABLE `391565_tbl_ansiklopedi` (
  `id` int(11) NOT NULL,
  `ad` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `alan` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `yayin_evi` varchar(500) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `391565_tbl_ansiklopedi`
--

INSERT INTO `391565_tbl_ansiklopedi` (`id`, `ad`, `alan`, `yayin_evi`) VALUES
(2, 'aefthtfgh', 'ergthrbf', 'pinar');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `391565_tbl_kullanici_yazar`
--

CREATE TABLE `391565_tbl_kullanici_yazar` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `eposta` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `fotograf` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `aktif_mi` tinyint(4) NOT NULL DEFAULT 0,
  `aktivasyon` varchar(1000) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `391565_tbl_kullanici_yazar`
--

INSERT INTO `391565_tbl_kullanici_yazar` (`id`, `ad_soyad`, `eposta`, `sifre`, `fotograf`, `aktif_mi`, `aktivasyon`) VALUES
(1, 'pinar', 'pinar.ugurlu42@gmail.com', '123', 'resimler/1 PAPATYA.jpg', 1, 'f5e3200c448a58ad3c208abc05479ff48c8b0c96c94628c54a5ac9001c34432a'),
(2, 'pinar', 'esmaugurlu42@gmail.com', '123', 'resimler/1 PAPATYA.jpg', 1, '35e423ea4d17400cf0d74b6b473aa23785097367dd5ebf673b9029d2017f327d');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `391565_tbl_yazar_ansiklopedi`
--

CREATE TABLE `391565_tbl_yazar_ansiklopedi` (
  `id` int(11) NOT NULL,
  `yazar_id` int(11) NOT NULL,
  `eser_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `391565_tbl_yazar_ansiklopedi`
--

INSERT INTO `391565_tbl_yazar_ansiklopedi` (`id`, `yazar_id`, `eser_id`) VALUES
(0, 2, 2);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `391565_tbl_ansiklopedi`
--
ALTER TABLE `391565_tbl_ansiklopedi`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `391565_tbl_kullanici_yazar`
--
ALTER TABLE `391565_tbl_kullanici_yazar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `391565_tbl_yazar_ansiklopedi`
--
ALTER TABLE `391565_tbl_yazar_ansiklopedi`
  ADD KEY `yazar_id` (`yazar_id`),
  ADD KEY `eser_id` (`eser_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `391565_tbl_ansiklopedi`
--
ALTER TABLE `391565_tbl_ansiklopedi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `391565_tbl_kullanici_yazar`
--
ALTER TABLE `391565_tbl_kullanici_yazar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `391565_tbl_yazar_ansiklopedi`
--
ALTER TABLE `391565_tbl_yazar_ansiklopedi`
  ADD CONSTRAINT `391565_tbl_yazar_ansiklopedi_ibfk_1` FOREIGN KEY (`yazar_id`) REFERENCES `391565_tbl_kullanici_yazar` (`id`),
  ADD CONSTRAINT `391565_tbl_yazar_ansiklopedi_ibfk_2` FOREIGN KEY (`eser_id`) REFERENCES `391565_tbl_ansiklopedi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
