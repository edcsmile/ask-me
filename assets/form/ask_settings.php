<?php
/*********************************/
		// İlker Şahin //
/*********************************/

define("PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
require_once(PATH . "inc/dbcon.php");

sleep(1);

$form["hood"] = "Oops..";
$form["type"] = "error";
$form["message"] = "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..";
$form["noti"] = 0;

switch($_POST["stat"])
{
	case "rightly":
	{
		$answer_id	=	$_POST["answer_id"];
		$getAnswer	=	veriCek("users_posts_answers", "*", "id", $answer_id);

		if(veriGuncelle(array("rightly"), array(1), "users_posts_answers", "id", $answer_id))
		{
			veriGuncelle(array("status"), array(1), "users_posts", "id", $getAnswer["post_id"]);
			
			$form["noti"] = 1;
			$form["hood"] = "Harika!!";
			$form["type"] = "success";
			$form["message"] = "Doğru cevabı bulmanıza sevindik!";
		} else {
			$form["noti"] = 0;
		}
	}
	break;
	case "addLike":
	{
		$answer_id	=	$_POST["answer_id"];
		$getAnswer	=	veriCek("users_posts_answers", "*", "id", $answer_id);
		
		if(veriGuncelle(array("likely"), array($getAnswer["likely"]+1), "users_posts_answers", "id", $answer_id))
		{
			veriEkle(array("user_id", "answer_id"), array($_SESSION["user"]["id"], $answer_id), "users_likers");
			
			$form["noti"] = 1;
			$form["hood"] = "";
			$form["type"] = "success";
			$form["message"] = "Puan verilmiştir..";
		} else {
			$form["noti"] = 0;
		}
	}
	break;
	default: git("/"); break;
}

echo json_encode($form);
?>