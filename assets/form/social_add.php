<?php
/*********************************/
		// İlker Şahin //
/*********************************/

define("PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
require_once(PATH . "inc/dbcon.php");

$form["hood"] = "Oops..";
$form["type"] = "error";
$form["noti"] = 0;
$postlar = $_POST;
foreach ( $postlar as $post )
{
	$post = ninja($post);
}

if($postlar["type"] == "add")
{
	$user_id			=	$_SESSION["user"]["id"];
	$social_type		=	$postlar["social_type"];
	$social_user		=	$postlar["social_user"];

	if( $social_type != "none" && $social_type != "" && !empty($social_user) )
	{
		sleep(1);
		if( veriEkle(array("user_id", "type", "username"), array($user_id, $social_type, $social_user), "users_social") )
		{
			$form["noti"] = 1;
			$form["hood"] = "";
			$form["type"] = "success";
			$form["message"] = "Sosyal ağ eklenmiştir.";
		} else {
			$form["noti"] = 0;
			$form["type"] = "warning";
			$form["message"] = "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..";
		}
	} else {
		$form["noti"] = 0;
		$form["message"] = "Lütfen boş alanları doldurunuz..";
	}
} else if($postlar["type"] == "del")
{
	$social_id	=	$postlar["social_id"];
	sleep(1);
	if( veriSil("users_social", "id", $social_id) )
	{
		$form["noti"] = 1;
		$form["hood"] = "";
		$form["type"] = "success";
		$form["message"] = "Sosyal ağ kaldırılmıştır.";
	} else {
		$form["noti"] = 0;
		$form["type"] = "warning";
		$form["message"] = "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..";
	}
} else {
	git("/");
}

echo json_encode($form);
?>