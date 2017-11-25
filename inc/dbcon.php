<?
	/*********************************/
			// İlker Şahin //
	/*********************************/
	
	error_reporting(0);
	
	header('Content-Type: text/html; charset=utf-8');
	
	$k_id = "dbusername"; // kullanıcı adı - db username
	$k_pass = "dbpassword"; // kullanıcı şifre - db password
	$k_host = "localhost"; // sunucu - host (general : localhost)
	$k_db = "database"; // veritabanı adı - database name
	
	try {
		$db = new PDO("mysql:host={$k_host};dbname={$k_db};", $k_id, $k_pass);
		
		$db->exec("SET NAMES 'utf8';");
		$db->exec("SET CHARSET 'utf8;'");
	} catch ( PDOException $e ){
		 // die($e->getMessage());
		 die("DATABASE NOT FOUND!");
	}

	session_start();
	setlocale(LC_TIME, "turkish"); 
	date_default_timezone_set('Europe/Istanbul'); 

	$malware = $db->query("SELECT Id FROM security WHERE ip = '".$_SERVER['REMOTE_ADDR']."'", PDO::FETCH_ASSOC);
	if( $malware->rowCount() > 0 )
	{
		die("IP BLOCKED.");
	}

	function QueryFilter($str)
	{
		$str = str_replace("*", "[INJ]",$str);
		$str = str_replace("UNION", "[INJ]",$str);
		$str = str_replace("SELECT", "[INJ]",$str);
		$str = str_replace("WHERE", "[INJ]",$str);
		$str = str_replace("UPDATE", "[INJ]",$str);
		$str = str_replace("INSERT", "[INJ]",$str);
		$str = str_replace("ORDER", "[INJ]",$str);
		$str = str_replace("MODIFY", "[INJ]",$str);
		$str = str_replace("RENAME", "[INJ]",$str);
		$str = str_replace("DECLARE", "[INJ]",$str);
		$str = str_replace("TABLE_NAME", "[INJ]",$str);
		$str = str_replace("COLUMN_NAME", "[INJ]",$str);
		$str = str_replace("COLUMNS", "[INJ]",$str);
		$str = str_replace("DATA_TYPE", "[INJ]",$str);
		$str = str_replace("CHARACTER", "[INJ]",$str);
		$str = str_replace("LENGTH", "[INJ]",$str);
		$str = str_replace("FETCH", "[INJ]",$str);
		$str = str_replace("STATUS", "[INJ]",$str);
		$str = str_replace("union", "[INJ]",$str);
		$str = str_replace("select", "[INJ]",$str);
		$str = str_replace("update", "[INJ]",$str);
		$str = str_replace("inster", "[INJ]",$str);
		$str = str_replace("order", "[INJ]",$str);
		$str = str_replace("modify", "[INJ]",$str);
		$str = str_replace("rename", "[INJ]",$str);
		$str = str_replace("declare", "[INJ]",$str);
		$str = str_replace("table_name", "[INJ]",$str);
		$str = str_replace("column_table", "[INJ]",$str);
		$str = str_replace("columns", "[INJ]",$str);
		$str = str_replace("data_type", "[INJ]",$str);
		$str = str_replace("character", "[INJ]",$str);
		$str = str_replace("length", "[INJ]",$str);
		$str = str_replace("fetch", "[INJ]",$str);
		$str = str_replace("status", "[INJ]",$str);
		$str = str_replace("adf.ly", "[INJ]",$str);
		return $str;
	}
	
	$gelenurladresi = QueryFilter($_SERVER["REQUEST_URI"]);

	if (strpos($gelenurladresi, '[INJ]') !== false) {
		veriEkle(array("ip", "browser", "http_url", "sdate"), array($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['REQUEST_URI'], @date("Y-m-d H:i:s")), "security_count");
		$getvt = tabloCek("security_count", "*", "WHERE ip = '{$_SERVER['REMOTE_ADDR']}'");
		$vtsayac = $getvt->rowCount();
		$sayacsayisi = 5 - intval($vtsayac);
		if($sayacsayisi <= 0) {
		  veriEkle(array("ip","host","browser","sdate"), array($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_HOST'], $_SERVER['HTTP_USER_AGENT'], @date("Y-m-d H:i:s")), "security");
		}
		die("Geçersiz İstek !");
	}

	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
		// SSL connection
		$weburl = 'https://'.$_SERVER["SERVER_NAME"].'/';
	} else {
		$weburl = 'http://'.$_SERVER["SERVER_NAME"].'/';
	}
	
	function getversiyon(){
		return 'Yönetim Paneli v7.2.1';
	}
	
	function permalink($s){   
		$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','?',';','*','+','^','"','#','$','%','&','{','[',']','}','*','|','>','<',"'",'~','@','!',':',';','â','’','Ä');
		$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','','','','','','','','','','','','','','','','','','','','','','','','','','','ı');
		$s = str_replace($tr,$eng,$s);
		$s = strtolower($s);
		$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
		$s = preg_replace('/\s+/', '-', $s);
		$s = preg_replace('|-+|', '-', $s);
		$s = preg_replace('/#/', '', $s);
		$s = str_replace('.', '', $s);
		$s = trim($s, '-');
		return $s;
	}
	
	function QueryFilterClear($str)
	{
		$str = str_replace("*", "",$str);
		$str = str_replace("<", "",$str);
		$str = str_replace(">", "",$str);
		$str = str_replace(";", "",$str);
		$str = str_replace("(", "",$str);
		$str = str_replace(")", "",$str);
		$str = str_replace("UNION", "",$str);
		$str = str_replace("SELECT", "",$str);
		$str = str_replace("WHERE", "",$str);
		$str = str_replace("UPDATE", "",$str);
		$str = str_replace("INSERT", "",$str);
		$str = str_replace("ORDER", "",$str);
		$str = str_replace("MODIFY", "",$str);
		$str = str_replace("RENAME", "",$str);
		$str = str_replace("DECLARE", "",$str);
		$str = str_replace("TABLE_NAME", "",$str);
		$str = str_replace("COLUMN_NAME", "",$str);
		$str = str_replace("COLUMNS", "",$str);
		$str = str_replace("DATA_TYPE", "",$str);
		$str = str_replace("CHARACTER", "",$str);
		$str = str_replace("LENGTH", "",$str);
		$str = str_replace("FETCH", "",$str);
		$str = str_replace("STATUS", "",$str);
		$str = str_replace("union", "",$str);
		$str = str_replace("select", "",$str);
		$str = str_replace("update", "",$str);
		$str = str_replace("inster", "",$str);
		$str = str_replace("order", "",$str);
		$str = str_replace("modify", "",$str);
		$str = str_replace("rename", "",$str);
		$str = str_replace("declare", "",$str);
		$str = str_replace("table_name", "",$str);
		$str = str_replace("column_table", "",$str);
		$str = str_replace("columns", "",$str);
		$str = str_replace("data_type", "",$str);
		$str = str_replace("character", "",$str);
		$str = str_replace("length", "",$str);
		$str = str_replace("fetch", "",$str);
		$str = str_replace("status", "",$str);
		$str = str_replace("adf.ly", "",$str);
		return $str;
	}
	
	function ninja($str){
		$str = QueryFilterClear($str);
		return $str;
	}
	
	function git($adres){
		echo "<script>document.location.href='".$adres."';</script>";
		die();
	}
	
	function islemKaydi($tur, $aciklama)
	{
		global $db;
		
		$query = $db->prepare("INSERT INTO islemler SET
		tarih = ?,
		personel = ?,
		tur = ?,
		aciklama = ?");
		$insert = $query->execute(array(
			@date("Y-m-d H:i:s"), "{$GLOBALS["user"]["Id"]}", "{$tur}", "{$GLOBALS["user"]["isim"]}, {$aciklama}" 
		));
		return;
	}
	
	function tabloCek($tablo, $alanlar, $manuel)
	{
		global $db;
		
		$veri = $db->query("SELECT {$alanlar} FROM {$tablo} {$manuel}", PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function cmd($sorgu)
	{
		global $db;
		
		$veri = $db->query($sorgu);
		return $veri;
	}
	
	function tabloCMD($sorgu)
	{
		global $db;
		
		$veri = $db->query($sorgu, PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function veriCMD($sorgu)
	{
		global $db;
		
		$veri = $db->query($sorgu)->fetch(PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function veriCek($tablo, $alanlar, $sutun, $id)
	{
		global $db;
		
		$veri = $db->query("SELECT {$alanlar} FROM {$tablo} WHERE {$sutun} = '{$id}'")->fetch(PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function veriSil($tablo, $sutun, $id)
	{
		global $db;
		
		$query = $db->prepare("DELETE FROM {$tablo} WHERE {$sutun} = :edc");
		$delete = $query->execute(array(
		   'edc' => $id
		));
		
		if ( $delete )
			return true;
		else
			return false;
	}
	
	function veriEkle($sutunlar, $veriler, $tablo)
	{
		global $db;
		
		$other = array();
		$sorgu = "";
		$count = count($veriler);
		$a = 0;
		for($i = 0; $i < $count; $i++)
		{
			$a++;
			if($a == $count)
				$sorgu .= $sutunlar[$i]." = ?";
			else
				$sorgu .= $sutunlar[$i]." = ?,";
		}
		
		$query = $db->prepare("INSERT INTO {$tablo} SET {$sorgu}");
		$insert = $query->execute($veriler);
		
		if ( $insert )
			return true;
		else
			return false;
	}
	
	function veriGuncelle($sutunlar, $veriler, $tablo, $hedef, $no)
	{
		global $db;
		
		$other = array();
		$sorgu = "";
		$a = 0;
		$count = count($veriler);
		for($i = 0; $i < $count; $i++)
		{
			$a++;
			if($a == $count)
				$sorgu .= $sutunlar[$i]." = :a_".$sutunlar[$i];
			else
				$sorgu .= $sutunlar[$i]." = :a_".$sutunlar[$i].",";
		}
		
		$b = 0;
		foreach( $sutunlar as $sutun )
		{
			$other["a_".$sutun] = $veriler[$b];
			$b++;
		}
		
		$other["no"] = $no;
		
		$query = $db->prepare("UPDATE {$tablo} SET {$sorgu} WHERE {$hedef} = :no");
		$update = $query->execute($other);
		
		if ( $update )
			return true;
		else
			return false;
	}
	
	function resimUpload($filePic, $oldImg, $thumb, $path, $size)
	{
		$processPath			=		$path."/";
		$path					=		$path;
		
		if(!empty($oldImg))
		{
			@unlink($processPath . $oldImg);
			@unlink($processPath . "thumb/" . $oldImg);
		}
		
		$upload = new Upload($filePic);
		if ($upload->uploaded) {
			$filename = md5(microtime());
			
			$uzanti = pathinfo($filePic["name"]);
			$uzanti = $uzanti["extension"];
			
			$size = explode(",", $size);
			$n_x  = $size[0];
			$n_y  = $size[1];
			
			$upload->image_resize = true;
			
			if( $n_x > 0 && $n_y > 0 )
				$upload->image_ratio_crop = true;
			else
				$upload->image_ratio_y = true;
			
			if( $n_x > 0 )
			{
				$upload->image_x = $n_x;
			}
			
			if( $n_y > 0 )
			{
				$upload->image_y = $n_y;
			}
			
			$upload->file_new_name_body	=	$filename;
			$upload->Process($processPath);
			
			switch( $uzanti ) {
				case "png": $ctype="image/png"; break;
				case "jpeg": $ctype="image/jpeg"; break;
				case "jpg": $ctype="image/jpeg"; break;
				default: { $upload->image_convert = png; $ctype="image/png"; } break;
			}
		}
		
		if( $thumb == true ) {
			$upload = new Upload($filePic);
			if ($upload->uploaded) {
				$upload->image_resize = true;
				$upload->image_ratio_crop = true;
				
				$upload->image_x = 310;
				$upload->image_y = 217;
				
				$upload->file_new_name_body	=	$filename;
				$upload->Process($processPath . "thumb/");
			}
		}
		
		return $filename.".".$uzanti;
	}
	
	function dateTimeConvertTR($datetime)
	{
		if( !empty($datetime) )
		{
			$tarihVeSaat	=	explode(" ", $datetime);
			$tarih			=	$tarihVeSaat[0];
			$saat			=	$tarihVeSaat[1];
			
			$parcala		=	explode(".", $tarih);
			$tarih			=	$parcala[2]."-".$parcala[1]."-".$parcala[0];
			$saat			.=	":00";
			
			$yenitarih		=	$tarih." ".$saat;
			
			return $yenitarih;
		} else
			return null;
	}
	
	function tarih($date)
   {
		$explode = explode(" ", $date);
		$explode2 = explode("-", $explode[0]);
		$zaman = substr($explode[1], 0, 5);
		
		switch($explode2[1])
		{
		   case "1":	$ay = "Ocak";		break;
		   case "2":	$ay = "Şubat";	break;
		   case "3":	$ay = "Mart";		break;
		   case "4":	$ay = "Nisan";		break;
		   case "5":	$ay = "Mayıs";		break;
		   case "6":	$ay = "Haziran";	break;
		   case "7":	$ay = "Temmuz";	break;
		   case "8":	$ay = "Ağustos";	break;
		   case "9":	$ay = "Eylül";		break;
		   case "10":	$ay = "Ekim";		break;
		   case "11":	$ay = "Kasım";		break;
		   case "12":	$ay = "Aralık";		break;
		}

		if( !empty($zaman) )
			$zaman = ", " . $zaman;
		
		return $explode2[2]." ".$ay." ".$explode2[0].$zaman;
   }
   
   function tarihAy($month)
   {
	   switch($month)
	   {
		   case "1":	$ay = "Ocak";		break;
		   case "2":	$ay = "Şubat";	break;
		   case "3":	$ay = "Mart";		break;
		   case "4":	$ay = "Nisan";		break;
		   case "5":	$ay = "Mayıs";		break;
		   case "6":	$ay = "Haziran";	break;
		   case "7":	$ay = "Temmuz";	break;
		   case "8":	$ay = "Ağustos";	break;
		   case "9":	$ay = "Eylül";		break;
		   case "10":	$ay = "Ekim";		break;
		   case "11":	$ay = "Kasım";		break;
		   case "12":	$ay = "Aralık";		break;
	   }
		
		return $ay;
   }
   
   function realTime ( $zaman ){
	   $zaman =  strtotime($zaman);
	   $zaman_farki = time() - $zaman;
	   $saniye = $zaman_farki;
	   $dakika = round($zaman_farki/60);
	   $saat = round($zaman_farki/3600);
	   $gun = round($zaman_farki/86400);
	   $hafta = round($zaman_farki/604800);
	   $ay = round($zaman_farki/2419200);
	   $yil = round($zaman_farki/29030400);
	   if( $saniye < 60 ){
		  if ($saniye == 0){
			 return "az önce";
		  } else {
			 return $saniye .' saniye önce';
		  }
	   } else if ( $dakika < 60 ){
		  return $dakika .' dakika önce';
	   } else if ( $saat < 24 ){
		  return $saat.' saat önce';
	   } else if ( $gun < 7 ){
		  return $gun .' gün önce';
	   } else if ( $hafta < 4 ){
		  return $hafta.' hafta önce';
	   } else if ( $ay < 12 ){
		  return $ay .' ay önce';
	   } else {
		  return $yil.' yıl önce';
	   }
	}
	
	function openUrlWithWindow($url)
	{
		?>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript">
		$.ajax({
			type: 'POST',
			url: '<?=$url?>',
			success: function (data) {
				
			}
		});
		</script>
		<?php
	}
	
	function userTrack()
	{
		if( empty($_SESSION["user"]) )
			git("/giris");
		else
			return true;
	}
	
	function logControl()
	{
		if( empty($_SESSION["user"]) )
			return false;
		else
			return true;
	}
	
	function edcAlert($text) {
		echo '
			swal({
			  title: "Ops..",
			  text: "'.$text.'",
			  type: "info",
			  showConfirmButton: true
			});
		';
	}
?>