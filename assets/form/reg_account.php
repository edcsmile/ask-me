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
$toplamPostSayisi = 5; // Formda kullandığınız toplam input sayısı
$form["inputs"] = count($postlar);

foreach ( $postlar as $post )
{
	$post = ninja($post);
}
/* Güvenlik */

if( $form["inputs"] < 5 )
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
	
	if( $_POST["gender"] == "0" || $_POST["gender"] == "" )
		$ItsNotEmpty = false;
	
	if( $ItsNotEmpty && count($postlar) == 6 )
	{
		$ad_soyad		=	$postlar["realname"];
		$username		=	$postlar["username"];
		$email			=	$postlar["email"];
		$password		=	$postlar["password"];
		$repassword		=	$postlar["repassword"];
		$cinsiyet		=	$postlar["gender"];
		
		if( !isValidEmail($email) )
			$form["message"] = "Lütfen geçerli bir e-mail adresi giriniz..";
		else if( $password != $repassword )
			$form["message"] = "Şifreler uyuşmuyor..";
		else if( strlen($username) > 20 )
			$form["message"] = "Kullanıcı adınız 20 karakterden fazla olamaz..";
		else if( strlen($password) > 15 )
			$form["message"] = "Şifreniz 15 karakterden fazla olamaz..";
		else {
			$usernameKontrol = veriCek("users", "username", "username", $username);
			$emailKontrol = veriCek("users", "email", "email", $email);
			
			if( $usernameKontrol ) { // Bu kullanıcı adı müsait değil
				$form["message"] = "Maalesef, bu kullanıcı adı zaten kayıtlı.";
			}
			else if( $emailKontrol ) // Bu email müsait değil
			{
				$form["message"] = "Maalesef, bu mail zaten kayıtlı.";
			}
			else { // Kullanıcı adı ve e-mail kullanılabilir
				$ad_soyad	=	initialLetters($ad_soyad);
			
				$sutun	=	array("real_name", "username", "email", "password", "gender", "reg_date");
				$cevap	=	array($ad_soyad, $username, $email, $password, $cinsiyet, @date("Y-m-d H:i:s"));
				
				if( veriEkle($sutun, $cevap, "users") )
				{
					$form["noti"] = 1;
					$form["hood"] = "Evet!!";
					$form["type"] = "success";
					$form["message"] = "Başarıyla kayıt oluşturulmuştur.";
				} else {
					$form["noti"] = 0;
					$form["type"] = "warning";
					$form["message"] = "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..";
				}
			}
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