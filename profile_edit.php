<?php
ob_start();
require_once("interface.php");

userTrack();

if( !empty($_SESSION["user"]))
{
	$id 		= $_SESSION["user"]["id"];
	$realname 		= $_SESSION["user"]["real_name"];
	$username 		= $_SESSION["user"]["username"];
	$email 			= $_SESSION["user"]["email"];
	$profile_img 	= $_SESSION["user"]["profile"];
	
	$cinsiyet 		= $_SESSION["user"]["gender"];
	
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
}
else
{
	git("/giris");
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<?=$site->head("Profil Düzenle");?>
		<link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert.css">
	</head>
	<body>
		<?=$site->navbar(2);?>
		<div class="container">
			<div class="register edc col-md-8">
				<h3 class="account-header"> <i class="fa fa-address-card" aria-hidden="true"></i> Profil Güncelle</h3>
				<form class="form" action="/profil-duzenle" enctype="multipart/form-data" method="POST">
					<div class="form-group">
						<label>Profil Resmi</label> <br />
						<img src="uploads/users/<?=(!empty($profile_img))?$profile_img:'user.png'?>" alt="<?=$realname?>" width="150px" height="150px" />
						<input type="file" name="profile_pimg" class="form-control"/>
						<p>Resim, <b>150x150 Piksel</b> boyutunda olmalıdır.</p>
					</div>
					<div class="form-group">
						<label>Ad Soyad</label> <br />
						<input type="text" name="realname" value="<?=$realname?>" class="form-control" placeholder="Görüntülenecek ad ve soyadınız"/>
					</div>
					<div class="form-group">
						<label>Cinsiyet</label> <br />
						<select name="gender" class="form-control">
							<option value="0" disabled>Seçiniz</option>
							<option value="1" <?=($cinsiyet == "1")?'selected':''?>>Erkek</option>
							<option value="2" <?=($cinsiyet == "2")?'selected':''?>>Kadın</option>
						</select>
					</div>
					<div class="form-group">
						<label>Kullanıcı Adı</label> <br />
						<input type="text" name="username" value="<?=$username?>" class="form-control" readonly/>
					</div>
					<div class="form-group">
						<label>Doğduğun Şehir</label> <br />
						<input type="text" name="dogdugu_sehir" value="<?=$dogdugu_sehir?>" class="form-control" placeholder="Kimliğe kayıtlı doğum yeri" />
					</div>
					<div class="form-group">
						<label>Yaşadığın Şehir</label> <br />
						<input type="text" name="yasadigi_sehir" value="<?=$yasadigi_sehir?>" class="form-control" placeholder="Yaşadığınız şehir" />
					</div>
					<div class="form-group">
						<label>Okul / Öğrenim Durumu</label> <br />
						<input type="text" name="okul" value="<?=$okul?>" class="form-control" placeholder="Okuyorsanız eğer okul adı, bittiyse son okulunuz" />
					</div>
					<div class="form-group">
						<label>Meslek</label> <br />
						<input type="text" name="meslek" value="<?=$meslek?>" class="form-control" placeholder="Mesleğiniz veya ilgili olduğunuz meslek" />
					</div>
					<div class="form-group">
						<label>Bildiğin Kodlama Dilleri</label> <br />
						<input type="text" name="kodlama_dilleri" value="<?=$kodlama_dilleri?>" class="form-control" placeholder="Tecrübeli olduğunuz kodlama dilleri" />
					</div>
					<div class="form-group">
						<label>Kullandığın Programlar</label> <br />
						<input type="text" name="programlar" value="<?=$programlar?>" class="form-control" placeholder="Aktif kullandığınız programların adları" />
					</div>
					<div class="form-group">
						<label>Web Siten</label> <br />
						<input type="text" name="web_site" value="<?=$web_site?>" class="form-control" placeholder="Mevcut ise aktif web site adresiniz" />
					</div>
					<div class="form-group social_icons">
						<label>Sosyal Ağlar</label> <br />
						<div class="socials">
						<?php
						$getsocial = tabloCek("users_social", "*", "WHERE user_id = ".$id);
						
						foreach( $getsocial as $social ) {
						?>
							<a target="_blank" href="<?=$social["username"]?>"> <i class="fa fa-<?=$social["type"]?>" aria-hidden="true"></i> <div class="social_del" target="<?=$social["id"]?>">X</div> </a>
						<?php } ?>
						</div>
						<div class="clear"></div>
						<select name="social_type" class="form-control" style="margin-top: 10px;">
							<option value="none" selected disabled>Yeni Ekle</option>
							<option value="facebook">Facebook</option>
							<option value="twitter">Twitter</option>
							<option value="youtube-play">YouTube</option>
							<option value="instagram">Instagram</option>
							<option value="linkedin">Linkedin</option>
							<option value="google-plus">Google</option>
							<option value="reddit">Reddit</option>
							<option value="spotify">Spotify</option>
							<option value="soundcloud">Soundcloud</option>
							<option value="vk">Vk</option>
							<option value="vine">Vine</option>
							<option value="twitch">Twitch</option>
							<option value="tumblr">Tumblr</option>
							<option value="vimeo">Vimeo</option>
							<option value="flickr">Flickr</option>
							<option value="foursquare">Foursquare</option>
							<option value="github">Github</option>
						</select>
						<input type="text" name="social_username" class="form-control" placeholder="Tam Link. Bkz : https://www.facebook.com/CoderBing" />
						<button class="btn btn-success social_add">Ekle</button>
					</div>
					<div class="form-group">
						<label>Hakkında</label> <br />
						<textarea name="hakkinda" class="form-control" cols="30" rows="5"><?=$hakkinda?></textarea>
					</div>
					<div class="form-group">
						<label>E-Mail</label> <br />
						<input type="text" value="<?=$email?>" class="form-control" readonly/>
					</div>
					<a href="#." class="da846c239291918242939a451a1e9da3">Şifre değiştirmek istiyorum.</a>
					<p></p>
					<div class="clear"></div>
					<div class="form-group cpass">
						<label>Yeni Şifre</label> <br />
						<input type="password" name="password" class="form-control" placeholder="Giriş yapacağınız şifre" maxlength="15" />
					</div>
					<div class="form-group cpass">
						<label>Yeni Şifre Tekrar</label> <br />
						<input type="password" name="repassword" class="form-control" placeholder="Şifrenizi tekrar girin" maxlength="15" />
					</div>
					<button type="submit" class="btn btn-success">Güncelle</button>
					<a href="/profil" class="btn btn-danger">İptal</a>
				</form>
			</div>
			<?=$site->category();?>
		</div>
		<?=$site->footer();?>
	</body>
	<?=$site->scripts();?>
	<script type="text/javascript" src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/account.js"></script>
	<script type="text/javascript">
		$("input[name=profile_pimg]").change(function(){
			var ext = $('input[type="file"]').val().split('.').pop().toLowerCase();
			if( $.inArray(ext, ['png','jpg','jpeg']) == -1 ) {
				$('input[type="file"]').val('');
				swal({
				  title: "Ops..",
				  text: "Resim formatı png, jpg veya jpeg türünde olmalıdır.",
				  type: "info",
				  showConfirmButton: true
				});
			} else {
				/*var _URL = window.URL || window.webkitURL;			
				var file, img;
				if ((file = this.files[0])) {
					img = new Image();
					img.onload = function () {
						if(this.width!=150 && this.height!=150){
							$('input[type="file"]').val('');
							swal({
							  title: "Ops..",
							  text: "Resim, 150x150 Piksel boyutunda olmalıdır.",
							  type: "info",
							  showConfirmButton: true
							});
						}
					};
					img.src = _URL.createObjectURL(file);
				}*/
			}
		});
		
		<?php
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$profile_id		=	$_SESSION["user"]["id"];
			$realname		=	$_POST["realname"];
			$username		=	$_POST["username"];
			$cinsiyet		=	$_POST["gender"];
			
			$newPass		=	$_POST["password"];
			$rNewPass 		=	$_POST["repassword"];
			
			$dogdugu_sehir	=  $_POST["dogdugu_sehir"];
			$okul			=  $_POST["okul"];
			$kodlama_dilleri=  $_POST["kodlama_dilleri"];
			$web_site		=  $_POST["web_site"];
			$yasadigi_sehir	=  $_POST["yasadigi_sehir"];
			$meslek			=  $_POST["meslek"];
			$programlar		=  $_POST["programlar"];
			$hakkinda		=  $_POST["hakkinda"];
			
			$sutunlar = array();
			$cevap = array();
			
			if( !empty( $dogdugu_sehir ) ) { array_push($sutunlar, "dogdugu_sehir"); array_push($cevap, $dogdugu_sehir); }
			if( !empty( $okul ) ) { array_push($sutunlar, "okul"); array_push($cevap, $okul); }
			if( !empty( $kodlama_dilleri ) ) { array_push($sutunlar, "kodlama_dilleri"); array_push($cevap, $kodlama_dilleri); }
			if( !empty( $web_site ) ) { array_push($sutunlar, "web_site"); array_push($cevap, $web_site); }
			if( !empty( $yasadigi_sehir ) ) { array_push($sutunlar, "yasadigi_sehir"); array_push($cevap, $yasadigi_sehir); }
			if( !empty( $meslek ) ) { array_push($sutunlar, "meslek"); array_push($cevap, $meslek); }
			if( !empty( $programlar ) ) { array_push($sutunlar, "programlar"); array_push($cevap, $programlar); }
			if( !empty( $hakkinda ) ) { array_push($sutunlar, "hakkinda"); array_push($cevap, $hakkinda); }
			
			if( !empty( $realname ) && strlen($realname) > 5 )
			{
				array_push($sutunlar, "real_name");
				array_push($cevap, $realname);
			}
			
			if( $cinsiyet != "0" )
			{
				array_push($sutunlar, "gender");
				array_push($cevap, $cinsiyet);
			}
			
			if( !empty( $newPass ) && $newPass != $rNewPass )
				edcAlert("Yeni şifreler birbiriyle uyuşmuyor.");
			else {
				if( !empty( $newPass ) )
				{
					array_push($sutunlar, "password");
					array_push($cevap, $newPass);
				}
			}
			
			if( !empty( $_FILES["profile_pimg"]["name"] ) )
			{
				if( $_FILES["profile_pimg"]["type"] == "image/jpeg" ||
					$_FILES["profile_pimg"]["type"] == "image/jpg" ||
					$_FILES["profile_pimg"]["type"] == "image/png") {
					
					require_once("inc/class.upload.php");
					if( $_SESSION["user"]["profile"] == "user.png" )
						$newPic = resimUpload($_FILES["profile_pimg"], "", false, "uploads/users", "150,150");
					else
						$newPic = resimUpload($_FILES["profile_pimg"], $_SESSION["user"]["profile"], false, "uploads/users", "150,150");
					
					array_push($sutunlar, "profile");
					array_push($cevap, $newPic);
					
				}
			}
			
			if( veriGuncelle($sutunlar, $cevap, "users", "id", $profile_id) )
			{
				$guncelProfil		= veriCek("users", "*", "id", $profile_id);
				$_SESSION["user"]	= $guncelProfil;
				$_SESSION["ok"]		= true;
				
				header("Location: /profil/{$username}/bilgi");
			} else
				echo 'swal("Oops...", "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..", "warning");';
		}
		?>
	</script>
</html>