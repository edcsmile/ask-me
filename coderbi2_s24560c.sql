-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 25 Kas 2017, 14:52:01
-- Sunucu sürümü: 5.6.36-cll-lve
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `root_s24560c`
--

--
-- Tablo için tablo yapısı `category_name`
--

CREATE TABLE `category_name` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `siralama` int(11) DEFAULT '9999'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `category_name`
--

INSERT INTO `category_name` (`id`, `name`, `siralama`) VALUES
(1, 'Genel / Bilgilendirme', 1),
(2, 'Oyun Programlama', 2),
(3, 'Web Programlama', 3),
(4, 'Grafik / Animasyon', 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category_rows`
--

CREATE TABLE `category_rows` (
  `id` int(11) NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `seo_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `point` int(11) DEFAULT '0',
  `siralama` int(11) DEFAULT '9999'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `category_rows`
--

INSERT INTO `category_rows` (`id`, `target`, `seo_name`, `name`, `point`, `siralama`) VALUES
(1, '1', 'oyun-programlama', 'Oyun Programlama', 0, 2),
(2, '1', 'web-programlama', 'Web Programlama', 0, 3),
(3, '1', 'grafik-animasyon', 'Grafik / Animasyon', 0, 4),
(5, '2', 'unity-3d', 'Unity 3D', 0, 2),
(6, '2', 'c-sharp', 'C#', 0, 3),
(7, '2', 'javascript', 'JavaScript', 0, 4),
(9, '3', 'html-css', 'Html & Css', 0, 2),
(10, '3', 'php', 'Php', 0, 3),
(11, '3', 'jquery', 'jQuery', 0, 4),
(12, '1', 'genel', 'Genel', 1, 1),
(13, '4', 'adobe-photoshop', 'Adobe Photoshop', 1, 2),
(14, '4', 'animasyon-programlari', 'Animasyon Programları', 0, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personel`
--

CREATE TABLE `personel` (
  `Id` int(11) NOT NULL,
  `isim` varchar(50) DEFAULT NULL,
  `kadi` varchar(30) DEFAULT NULL,
  `sifre` varchar(20) DEFAULT NULL,
  `yetki` int(11) DEFAULT '1',
  `avatar` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Tablo döküm verisi `personel`
--

INSERT INTO `personel` (`Id`, `isim`, `kadi`, `sifre`, `yetki`, `avatar`) VALUES
(1, 'Yönetici', 'admin', '123321', 0, 'avatar2.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `security`
--

CREATE TABLE `security` (
  `Id` int(11) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `sdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `security_count`
--

CREATE TABLE `security_count` (
  `Id` int(11) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `http_url` varchar(255) DEFAULT NULL,
  `sdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Tablo döküm verisi `security_count`
--

INSERT INTO `security_count` (`Id`, `ip`, `browser`, `http_url`, `sdate`) VALUES
(1, '78.183.189.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36', '/assets/plugins/ckeditor/plugins/codesnippet/lib/highlight/assets/plugins/bootstrap-select/css/bootstrap-select.css', '2017-10-28 14:05:46'),
(2, '78.183.189.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36', '/assets/plugins/ckeditor/plugins/codesnippet/lib/highlight/assets/plugins/bootstrap-select/js/i18n/defaults-tr_TR.js', '2017-10-28 14:05:46'),
(3, '78.183.189.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36', '/assets/plugins/ckeditor/plugins/codesnippet/lib/highlight/assets/plugins/bootstrap-select/js/bootstrap-select.js', '2017-10-28 14:05:46'),
(4, '78.183.189.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36', '/assets/plugins/ckeditor/plugins/codesnippet/lib/highlight/assets/plugins/bootstrap-select/js/i18n/defaults-tr_TR.js', '2017-10-28 14:05:47');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `real_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `profile` varchar(255) DEFAULT 'user.png',
  `dogdugu_sehir` varchar(255) DEFAULT '',
  `yasadigi_sehir` varchar(255) DEFAULT '',
  `okul` varchar(255) DEFAULT '',
  `meslek` varchar(255) DEFAULT '',
  `kodlama_dilleri` text,
  `programlar` text,
  `web_site` varchar(255) DEFAULT '',
  `hakkinda` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `real_name`, `username`, `email`, `password`, `gender`, `reg_date`, `profile`, `dogdugu_sehir`, `yasadigi_sehir`, `okul`, `meslek`, `kodlama_dilleri`, `programlar`, `web_site`, `hakkinda`) VALUES
(1, 'İlker Şahin', 'edcsmile', 'thepartyneverends_@outlook.com', 'adminspecial', 1, '2017-05-27 16:59:36', '529fdb3fc0b5b02dd73aa71ee8ce169a.jpg', 'Samsun', 'Samsun', 'Samsun Teknik ve Anadolu Endüstri Meslek Lisesi', 'Oyun Geliştirme', 'Html5, Css3, Php, Asp.Net, JavaScript (jQuery), C#, Boo', 'Unity3D, Autodesk Max-Maya, Photoshop CS6, After Effects CS6, Marvelous Designer, Spine2D', 'http://www.coderbing.com/', 'Web & Game Developer'),
(15, 'Admin', 'admin', 'admin@hotmail.com', 'adminspecial', 1, '2017-10-28 15:35:28', 'user.png', '', '', '', '', NULL, NULL, '', NULL),
(16, 'Enes', 'Enes', 'enesmansor@gmail.com', 'dynamicuserpass', 1, '2017-10-29 02:43:42', 'user.png', '', '', '', '', NULL, NULL, '', NULL),
(17, 'Barış Akbaş', 'bariskbas', 'baris@coderbing.com', 'passgenerator', 1, '2017-11-17 15:17:58', 'user.png', '', '', '', '', NULL, NULL, '', NULL),
(18, 'Özgür Çetinkaya', 'herotürk', 'o.cetinkaya@outlook.com.tr', '05124152', 1, '2017-11-25 14:23:51', 'user.png', '', '', '', '', NULL, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_likers`
--

CREATE TABLE `users_likers` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `answer_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_posts`
--

CREATE TABLE `users_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `tarih` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `version` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `users_posts`
--

INSERT INTO `users_posts` (`id`, `user_id`, `category`, `seo_title`, `title`, `content`, `tarih`, `status`, `version`) VALUES
(1, 1, '12', 'soru-cevap-platformu-111831', 'Soru Cevap Platformu', '<p>Merak ettiğiniz konuları buradan sorabilir, konu &uuml;zerine bilgili olan arkadaşlardan fikir ve sonu&ccedil;lara ulaşabilirsiniz.</p>\r\n\r\n<p><a href=\"http://www.coderbing.com/\">Coder Bing</a></p>\r\n', '2017-10-28 14:13:59', 0, 0),
(2, 18, '13', 'logo-yapim-fiyatlarinizi-ogrenebilir-miyim-2068418', 'Logo yapım fiyatlarınızı öğrenebilir miyim?', '<p>Logo yapım fiyatlarınızı &ouml;ğrenebilir miyim?</p>\r\n', '2017-11-25 14:25:20', 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_posts_answers`
--

CREATE TABLE `users_posts_answers` (
  `id` int(11) NOT NULL,
  `post_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `content` text,
  `tarih` datetime DEFAULT NULL,
  `likely` int(11) DEFAULT '0',
  `rightly` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_social`
--

CREATE TABLE `users_social` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `users_social`
--

INSERT INTO `users_social` (`id`, `user_id`, `type`, `username`) VALUES
(15, 1, 'facebook', 'https://www.facebook.com/edcsmile'),
(16, 1, 'twitter', 'https://twitter.com/CoderBing'),
(17, 1, 'linkedin', 'https://www.linkedin.com/in/edcsmile'),
(18, 1, 'instagram', 'https://www.instagram.com/edcsmile/'),
(19, 16, 'facebook', 'ss'),
(20, 16, 'facebook', 'qw');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `category_name`
--
ALTER TABLE `category_name`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `category_rows`
--
ALTER TABLE `category_rows`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `personel`
--
ALTER TABLE `personel`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `security_count`
--
ALTER TABLE `security_count`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users_likers`
--
ALTER TABLE `users_likers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users_posts`
--
ALTER TABLE `users_posts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users_posts_answers`
--
ALTER TABLE `users_posts_answers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users_social`
--
ALTER TABLE `users_social`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `category_name`
--
ALTER TABLE `category_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `category_rows`
--
ALTER TABLE `category_rows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Tablo için AUTO_INCREMENT değeri `personel`
--
ALTER TABLE `personel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `security`
--
ALTER TABLE `security`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `security_count`
--
ALTER TABLE `security_count`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Tablo için AUTO_INCREMENT değeri `users_likers`
--
ALTER TABLE `users_likers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `users_posts`
--
ALTER TABLE `users_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `users_posts_answers`
--
ALTER TABLE `users_posts_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `users_social`
--
ALTER TABLE `users_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
