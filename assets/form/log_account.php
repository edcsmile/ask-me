<?php
/*********************************/
		// İlker Şahin //
/*********************************/

define("PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
require_once(PATH . "inc/dbcon.php");

$postlar = $_POST;
$form = array();
$ItsNotEmpty = true;

/* Güvenlik */
$form["hood"] = "Oops..";
$form["type"] = "error";
$form["noti"] = 0;
$form["security"] = false;
$toplamPostSayisi = 2; // Formda kullandığınız toplam input sayısı
$form["inputs"] = count($postlar);

foreach ( $postlar as $post )
{
	$post = ninja($post);
}
/* Güvenlik */

if( $form["inputs"] != $toplamPostSayisi )
{
	$form["noti"] = 0;
	$form["security"] = "attacked!";
	git("/");
	Die("mathafucka");
} else {
	sleep(1);
	$form["security"] = true; // İşleme devam
}

if( $form["security"] )
{
	foreach ( $postlar as $post )
	{
		if( empty($post) )
		{
			$ItsNotEmpty = false;
		}
	}
	
	if( $ItsNotEmpty )
	{
		$usernameAndMail		=	$postlar["username"];
		$password				=	$postlar["password"];
		
		$usernameKontrol = veriCek("users", "*", "username", $usernameAndMail);
		$emailKontrol = veriCek("users", "*", "email", $usernameAndMail);
		
		if( $usernameKontrol || $emailKontrol ) {
			
			if( $usernameKontrol && $usernameKontrol["password"] == $password || $emailKontrol && $emailKontrol["password"] == $password )
			{
				if( $usernameKontrol )
					$_SESSION["user"] = $usernameKontrol;
				else
					$_SESSION["user"] = $emailKontrol;
				
				$form["noti"] = 1;
				$form["hood"] = "Tebrikler!!";
				$form["type"] = "success";
				$form["message"] = "Başarıyla giriş yapılmıştır.";
			} else {
				$form["message"] = "Maalesef, girilen bilgiler yanlıştır.";
			}
		}
		else {
			$form["message"] = "Maalesef, bu bilgilere ait bir hesap bulunamamıştır.";
		}
	} else {
		$form["noti"] = 0;
		$form["message"] = "Lütfen boş alanları doldurunuz..";
	}
}

echo json_encode($form);
?>

<?php
/* Filters */
function initialLetters($metin) // Baş Harfleri Büyültmek için
{
	$metin = mb_convert_case($metin, MB_CASE_TITLE, "UTF-8");
	return $metin;
}

function isValidEmail($email){ // Mail Kontrolü
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		return true;
	}
	else {
		return false;
	}
}
?>