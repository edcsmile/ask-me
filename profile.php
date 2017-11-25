<?php
$site_url = "http://$_SERVER[HTTP_HOST]";

require_once("interface.php");

if( !empty($_GET["nickname"]) )
{
	if( $_GET["nickname"] == $_SESSION["user"]["username"] )
	{
		$username 		= $_SESSION["user"]["username"];
		$id				= $_SESSION["user"]["id"];
		$usernick		= $_SESSION["user"]["username"];
		
		$realname 		= $_SESSION["user"]["real_name"];
		$profile_img 	= $_SESSION["user"]["profile"];
		
		$cinsiyet 		= $_SESSION["user"]["gender"];
		if( $cinsiyet == "1" ) {
			$cins		= "male";
			$cinsiyet	= "Erkek"; 
		} else {
			$cins		= "female";
			$cinsiyet	= "Kadın";
		}
		
		$profile_edit	= '<a class="profile_edit" href="/profil-duzenle" alt="Düzenle"> <i class="fa fa-cog" aria-hidden="true"></i> </a>';
		$no				=	2;
	} else {
		$nickname 		= $_GET["nickname"];
		$nickname 		= veriCek("users", "real_name, username, profile, gender, id", "username", $nickname);
		
		if( !$nickname )
			git("/");
		
		$id				= $nickname["id"];
		$usernick		= $nickname["username"];
		$realname 		= $nickname["real_name"];
		$username 		= $nickname["username"];
		$profile_img 	= $nickname["profile"];
		
		$cinsiyet 		= $nickname["gender"];
		if( $cinsiyet == "1" ) {
			$cins		= "male";
			$cinsiyet	= "Erkek"; 
		} else {
			$cins		= "female";
			$cinsiyet	= "Kadın";
		}
		
		$profile_edit	= "";
		$no				= -1;
	}
} else {
	if( !empty($_SESSION["user"]))
	{
		$id				= $_SESSION["user"]["id"];
		$usernick		= $_SESSION["user"]["username"];
		$realname 		= $_SESSION["user"]["real_name"];
		$username 		= $_SESSION["user"]["username"];
		$profile_img 	= $_SESSION["user"]["profile"];
		
		$cinsiyet 		= $_SESSION["user"]["gender"];
		if( $cinsiyet == "1" ) {
			$cins		= "male";
			$cinsiyet	= "Erkek"; 
		} else {
			$cins		= "female";
			$cinsiyet	= "Kadın";
		}
		
		$profile_edit	= '<a class="profile_edit" href="/profil-duzenle" alt="Düzenle"> <i class="fa fa-cog" aria-hidden="true"></i> </a>';
		$no				=	2;
	}
	else
	{
		git("/giris");
	}
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<base href="<?=$site_url?>"  />
		<?=$site->head($username);?>
		<link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert.css">
	</head>
	<body>
		<?=$site->navbar($no);?>
		<div class="container">
			<div class="edc col-md-8">
				<h3 class="account-header"> <?=$profile_edit?> <i class="fa fa-<?=$cins?>" aria-hidden="true"></i> <?=$username?> | <?=$realname?></h3>
				<div class="col-md-12 padding-left-0 user">
					<div class="profile_img">
						<a href="/profil/<?=$username?>/bilgi"> <img src="uploads/users/<?=(!empty($profile_img))?$profile_img:'user.png'?>" alt="<?=$realname?>" /> </a>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-12 padding-left-0 user-questions">
					<h3 class="eafdbf83003466fd9008a48378328571"><a href="profil/<?=$usernick?>/soru-liste">Sorular</a> / <a href="profil/<?=$usernick?>/cevap-liste">Cevaplar</a></h3>
					<?php
						if( !empty($_GET["soru"]) )
							$myAktivites = tabloCek("users_posts", "*", "WHERE user_id = '{$id}' ORDER BY id DESC");
						else if( !empty($_GET["cevap"]) )
							$myReplies = tabloCek("users_posts_answers", "*", "WHERE user_id = '{$id}' GROUP BY post_id ORDER BY id DESC");
						else
							$myAktivites = tabloCek("users_posts", "*", "WHERE user_id = '{$id}' ORDER BY id DESC");

						
						$goruntulenecekToplamItem = 10;
						
						if( !empty($_GET["soru"]) )
							$totalDuyuru = $myAktivites->rowCount();
						else if( !empty($_GET["cevap"]) )
							$totalDuyuru = $myReplies->rowCount();
						else
							$totalDuyuru = $myAktivites->rowCount();
						
						$toplam_sayfa = ceil($totalDuyuru / $goruntulenecekToplamItem);
						
						$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
						if($sayfa < 1) $sayfa = 1; 
						if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
						
						$limit = ($sayfa - 1) * $goruntulenecekToplamItem;
						
						if( !empty($_GET["soru"]) )
							$myAktivites = tabloCek("users_posts", "*", "WHERE user_id = '{$id}' ORDER BY id DESC LIMIT {$limit}, {$goruntulenecekToplamItem}");
						else if( !empty($_GET["cevap"]) )
							$myReplies = tabloCek("users_posts_answers", "*", "WHERE user_id = '{$id}' GROUP BY post_id ORDER BY id DESC LIMIT {$limit}, {$goruntulenecekToplamItem}");
						else
							$myAktivites = tabloCek("users_posts", "*", "WHERE user_id = '{$id}' ORDER BY id DESC LIMIT {$limit}, {$goruntulenecekToplamItem}");
						
						foreach( $myAktivites as $post ) {
							$out	= "";
							$answer	= "";
							
							$user	=	veriCek("users", "username, real_name", "id", $post["user_id"]);
							$answer	=	tabloCek("users_posts_answers", "id", "WHERE post_id = '{$post["id"]}'");
							
							$getCategories = explode(",", $post["category"]);
							foreach( $getCategories as $cat )
							{
								$cat	=	veriCek("category_rows", "seo_name, name, target", "id", $cat);
								$tar	=	veriCek("category_name", "name", "id", $cat["target"]);
								$out	.=	'<a href="/kategori/'.$cat["seo_name"].'"> <div class="category"> '.$tar["name"].' | '.$cat["name"].' </div> </a>';
							}
					?>
						<div class="ask">
							<?php if( $post["status"] == "0" ) { ?>
							<span class="qa-a-count qa-a-count-zero">
								<span class="qa-a-count-data"> <?=$answer->rowCount()?> </span> <span class="qa-a-count-pad"> Cevap </span>
							</span>
							<?php } else { ?>
							<span class="qa-a-count qa-a-count-zero check">
								<i class="fa fa-check"></i>
							</span>
							<?php } ?>
							<div class="title"> <a href="/soru/<?=$post["seo_title"]?>"> <?=$post["title"]?> </a> </div>
							<div class="date"> <a href="/profil/<?=$user["username"]?>"><b><?=$user["real_name"]?></b></a> <i class="fa fa-paper-plane"></i> <?=realTime($post["tarih"])?></div>
							<?=$out?>
							<div class="clear"></div>
						</div>
					<?php }
					
					foreach( $myReplies as $post ) {
							$post	= veriCek("users_posts", "*", "id", $post["post_id"]);
							
							$out	= "";
							$answer	= "";
							
							$user	=	veriCek("users", "username, real_name", "id", $post["user_id"]);
							$answer	=	tabloCek("users_posts_answers", "id", "WHERE post_id = '{$post["id"]}'");
							
							$getCategories = explode(",", $post["category"]);
							foreach( $getCategories as $cat )
							{
								$cat	=	veriCek("category_rows", "seo_name, name, target", "id", $cat);
								$tar	=	veriCek("category_name", "name", "id", $cat["target"]);
								$out	.=	'<a href="/kategori/'.$cat["seo_name"].'"> <div class="category"> '.$tar["name"].' | '.$cat["name"].' </div> </a>';
							}
					?>
						<div class="ask">
							<?php if( $post["status"] == "0" ) { ?>
							<span class="qa-a-count qa-a-count-zero">
								<span class="qa-a-count-data"> <?=$answer->rowCount()?> </span> <span class="qa-a-count-pad"> Cevap </span>
							</span>
							<?php } else { ?>
							<span class="qa-a-count qa-a-count-zero check">
								<i class="fa fa-check"></i>
							</span>
							<?php } ?>
							<div class="title"> <a href="/soru/<?=$post["seo_title"]?>"> <?=$post["title"]?> </a> </div>
							<div class="date"> <a href="/profil/<?=$user["username"]?>"><b><?=$user["real_name"]?></b></a> <i class="fa fa-paper-plane"></i> <?=realTime($post["tarih"])?></div>
							<?=$out?>
							<div class="clear"></div>
						</div>
					<?php }
					
					if( !empty($_GET["soru"]) ) {
						if( $totalDuyuru == 0 )
							echo "Bu kullanıcı ait kayıtlı bir soru bulunamamıştır.";
					}
					else if( !empty($_GET["cevap"]) ) {
						if( $totalDuyuru == 0 )
							echo "Bu kullanıcı ait kayıtlı bir cevap bulunamamıştır.";
					}
					else {
						if( $totalDuyuru == 0 )
							echo "Bu kullanıcı ait kayıtlı bir soru bulunamamıştır.";
					}
					?>
				</div>
				<?php if( $toplam_sayfa > 1 ) { ?>
					<nav aria-label="Page navigation">
						<ul class="pagination">
							<?php
							$sayfa_goster = 7;
						 
							$en_az_orta = ceil($sayfa_goster/2);
							$en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
							 
							$sayfa_orta = $sayfa;
							if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
							if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
							 
							$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
							$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
							 
							if($sol_sayfalar < 1) $sol_sayfalar = 1;
							if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
							 
							if( !empty($_GET["soru"]) )
								$link = "/profil/".$usernick."/soru-liste/";
							else if( !empty($_GET["cevap"]) )
								$link = "/profil/".$usernick."/cevap-liste/";
							else
								$link = "/profil/".$usernick."/soru-liste/";
							 
							if($sayfa != 1) echo '<li><a href="'.$link.'1">İlk</a></li>';

							for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
								if($sayfa == $s) {
									echo "<li class='active'><a href='javascript:void(0)'>{$s}</a></li>"; 
								} else {
									echo "<li><a href='{$link}{$s}'>{$s}</a></li>";
								}
							}
							
							if($sayfa != $toplam_sayfa) echo "<li><a href='{$link}{$toplam_sayfa}'>Son</a></li>";
							?>
						</ul>
					</nav>
				<?php } ?>
			</div>
			<?=$site->category();?>
		</div>
		<?=$site->footer();?>
	</body>
	<?=$site->scripts();?>
	<script type="text/javascript" src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/account.js"></script>
	<script type="text/javascript">
	<?php
		if( $_SESSION["ok"] == true )
		{
			echo '
				swal({
				  title: "Evet!!",
				  text: "Değişiklikler başarıyla güncellenmiştir.",
				  type: "success",
				  showConfirmButton: true
				});
			';
			
			unset($_SESSION["ok"]);
		}
	?>
	</script>
</html>