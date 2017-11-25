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
		
		/* Bilgiler */
		$dogdugu_sehir	=  $_SESSION["user"]["dogdugu_sehir"];
		$okul			=  $_SESSION["user"]["okul"];
		$kodlama_dilleri=  $_SESSION["user"]["kodlama_dilleri"];
		$web_site		=  $_SESSION["user"]["web_site"];
		$yasadigi_sehir	=  $_SESSION["user"]["yasadigi_sehir"];
		$meslek			=  $_SESSION["user"]["meslek"];
		$programlar		=  $_SESSION["user"]["programlar"];
		$hakkinda		=  $_SESSION["user"]["hakkinda"];
		/* Bilgiler */
		
		$profile_edit	= '<a class="profile_edit" href="/profil-duzenle" alt="Düzenle"> <i class="fa fa-cog" aria-hidden="true"></i> </a>';
		$no				=	2;
	} else {
		$nickname 		= $_GET["nickname"];
		$nickname 		= veriCek("users", "real_name, username, profile, gender, id,
		dogdugu_sehir, okul, kodlama_dilleri, web_site, yasadigi_sehir, meslek, programlar, hakkinda", "username", $nickname);
		
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
		
		/* Bilgiler */
		$dogdugu_sehir	=  $nickname["dogdugu_sehir"];
		$okul			=  $nickname["okul"];
		$kodlama_dilleri=  $nickname["kodlama_dilleri"];
		$web_site		=  $nickname["web_site"];
		$yasadigi_sehir	=  $nickname["yasadigi_sehir"];
		$meslek			=  $nickname["meslek"];
		$programlar		=  $nickname["programlar"];
		$hakkinda		=  $nickname["hakkinda"];
		/* Bilgiler */
		
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
		
		/* Bilgiler */
		$dogdugu_sehir	=  $_SESSION["user"]["dogdugu_sehir"];
		$okul			=  $_SESSION["user"]["okul"];
		$kodlama_dilleri=  $_SESSION["user"]["kodlama_dilleri"];
		$web_site		=  $_SESSION["user"]["web_site"];
		$yasadigi_sehir	=  $_SESSION["user"]["yasadigi_sehir"];
		$meslek			=  $_SESSION["user"]["meslek"];
		$programlar		=  $_SESSION["user"]["programlar"];
		$hakkinda		=  $_SESSION["user"]["hakkinda"];
		/* Bilgiler */
		
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
						<img src="uploads/users/<?=(!empty($profile_img))?$profile_img:'user.png'?>" alt="<?=$realname?>" />
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-6 padding-left-0 user-about">
					<ul class="text-align-left">
						<li>
							<label>Ad Soyad</label> <br />
							<?=$realname?>
						</li>
						<li>
							<label>Doğduğu Şehir</label> <br />
							<?=(!empty($dogdugu_sehir))?$dogdugu_sehir:'-'?>
						</li>
						<li>
							<label>Okul / Öğrenim Durumu</label> <br />
							<?=(!empty($okul))?$okul:'-'?>
						</li>
						<li>
							<label>Bildiği Kodlama Dilleri</label> <br />
							<?=(!empty($kodlama_dilleri))?$kodlama_dilleri:'-'?>
						</li>
						<li>
							<label>Web Sitesi</label> <br />
							<?=(!empty($web_site))?'<a target="_blank" href="'.$web_site.'">'.$web_site.'</a>':'-'?>
						</li>
					</ul>
				</div>
				<div class="col-md-6 padding-left-0 user-about">
					<ul class="text-align-right left-about-border"
						<li>
							<label>Cinsiyet</label> <br />
							<?=$cinsiyet?>
						</li>
						<li>
							<label>Yaşadığı Şehir</label> <br />
							<?=(!empty($yasadigi_sehir))?$yasadigi_sehir:'-'?>
						</li>
						<li>
							<label>Meslek</label> <br />
							<?=(!empty($meslek))?$meslek:'-'?>
						</li>
						<li>
							<label>Kullandığı Programlar</label> <br />
							<?=(!empty($programlar))?$programlar:'-'?>
						</li>
						<li class="social_icons">
							<label>Sosyal Ağlar</label> <br />
							<?php
							$getsocial = tabloCek("users_social", "*", "WHERE user_id = ".$id." ORDER BY id DESC");
							$totalSoci = $getsocial->rowCount();
							
							foreach( $getsocial as $social ) {
							?>
								<a target="_blank" href="<?=$social["username"]?>"> <i class="fa fa-<?=$social["type"]?>" aria-hidden="true"></i> </a>
							<?php } ?>
							<?=($totalSoci==0)?'-':''?>
							<div class="clear"></div>
						</li>
					</ul>
				</div>
				<div class="col-md-12 padding-left-0 user-about" style="margin-top:0;">
					<ul class="text-align-left">
						<li>
							<label>Hakkında</label> <br />
							<?=(!empty($hakkinda))?$hakkinda:'-'?>
						</li>
					</ul>
				</div>
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