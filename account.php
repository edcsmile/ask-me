<?php
require_once("interface.php");
if( !empty($_SESSION["user"]))
	git("/profil");
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<?=$site->head("Kayıt / Giriş");?>
		<link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert.css">
	</head>
	<body>
		<?=$site->navbar(2);?>
		<div class="container">
			<div class="login edc col-md-8">
				<h3 class="account-header"> <i class="fa fa-sign-in" aria-hidden="true"></i> Giriş Yap</h3>
				<form class="form e-form" action="www.coderbing.com" method="POST">
					<div class="form-group">
						<label>E-Mail / Kullanıcı Adı</label> <br />
						<input type="text" name="username" class="form-control" placeholder="Kayıtlı olduğunuz e-mail adresi veya kullanıcı adı" />
					</div>
					<div class="form-group">
						<label>Şifre</label> <br />
						<input type="password" name="password" class="form-control" placeholder="Şifreniz" />
					</div>
					<button type="submit" class="btn btn-default e-send">Giriş Yap</button>
					<p></p>
					<a href="kayitol" class="new-register"> Hesabım yok, <b>kayıt olmak</b> istiyorum. </a>
				</form>
			</div>
			<div class="register edc col-md-8" style="display: none;">
				<h3 class="account-header"> <i class="fa fa-users" aria-hidden="true"></i> Kayıt Ol</h3>
				<form class="form y-form" action="www.coderbing.com" method="POST">
					<div class="form-group">
						<label>Ad Soyad</label> <br />
						<input type="text" name="realname" class="form-control" placeholder="Görüntülenecek ad ve soyadınız" />
					</div>
					<div class="form-group">
						<label>Cinsiyet</label> <br />
						<select name="gender" class="form-control">
							<option value="0" selected disabled>Seçiniz</option>
							<option value="1">Erkek</option>
							<option value="2">Kadın</option>
						</select>
					</div>
					<div class="form-group">
						<label>Kullanıcı Adı</label> <br />
						<input type="text" name="username" class="form-control" placeholder="Giriş yapacağınız kullanıcı adı" maxlength="20" />
					</div>
					<div class="form-group">
						<label>E-Mail</label> <br />
						<input type="text" name="email" class="form-control" placeholder="E-Mail adresiniz" />
					</div>
					<div class="form-group">
						<label>Şifre</label> <br />
						<input type="password" name="password" class="form-control" placeholder="Giriş yapacağınız şifre" maxlength="15" />
					</div>
					<div class="form-group">
						<label>Şifre Tekrar</label> <br />
						<input type="password" name="repassword" class="form-control" placeholder="Şifrenizi tekrar girin" maxlength="15" />
					</div>
					<button type="submit" class="btn btn-default y-send">Kayıt Ol</button>
					<p></p>
					<a href="girisyap" class="new-login"> Hesabım zaten var. <b>Giriş yapmak</b> istiyorum. </a>
				</form>
			</div>
			<?=$site->category();?>
		</div>
		<?=$site->footer();?>
	</body>
	<?=$site->scripts();?>
	<script type="text/javascript" src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/account.js"></script>
</html>