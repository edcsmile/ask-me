<?php
require_once("inc/dbcon.php");
session_start();

$site = new edcsmile();

class edcsmile {
	function head($baslik)
	{
		?>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<title><?=$baslik?> | Soru-Cevap Platformu #CoderBing</title>
		
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/normalized.css" />
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/css/style.css" />
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.css" />
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
		<link rel="icon" href="images/favicon.png" type="image/x-icon">
		<?
	}
	
	function navbar($i)
	{
		?>
		<div class="col-md-12 head">
			<div class="col-md-5 text-center logo">
				<div class="col-md-1"> <a href="/" alt="Coder Bing"> <img src="images/logo.png" alt="Coder Bing" /> </a> </div>
				<div class="col-md-5 tittle"> <a href="/" class="white">Soru Cevap Platformu</a> </div>
			</div>
			<div class="col-md-7 menu">
				<nav class="navbar navbar-default col-md-12">
				  <div class="container-fluid">
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav">
						<li <?=($i==0)?'class="active"':''?>><a href="/">Anasayfa</a></li>
						<li><a target="_blank" href="http://www.coderbing.com/">Coder Bing</a></li>
						<li <?=($i==3)?'class="active"':''?>><a href="/sorular">Sorular</a></li>
						<?php if( !empty($_SESSION["user"])) { ?>
						<li <?=($i==1)?'class="active"':''?>><a href="/soru-sor">Soru Sor</a></li>
						<li <?=($i==2)?'class="active"':''?>><a href="/profil">Profil</a></li>
						<li><a href="/cikis">Çıkış Yap</a></li>
						<?php } else { ?>
						<li <?=($i==2)?'class="active"':''?>><a href="/giris">Kayıt / Giriş</a></li>
						<?php } ?>
					  </ul>
					</div>
				  </div>
				</nav>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<?
	}
	
	function category()
	{
		$totalUser	=	cmd("SELECT COUNT(*) FROM users")->fetchColumn();
		$totalPost	=	cmd("SELECT COUNT(*) FROM users_posts")->fetchColumn();
		$totalAns	=	cmd("SELECT COUNT(*) FROM users_posts_answers")->fetchColumn();
		?>
		<div class="col-md-4">
			<div class="row chapter total-info">
				<div class="col-md-12">
					<span> <i class="fa fa-users" aria-hidden="true"></i> <b><?=$totalUser?></b> </span>
					<span> <i class="fa fa-question-circle" aria-hidden="true"></i> <b><?=$totalPost?></b> </span> 
					<span> <i class="fa fa-reply" aria-hidden="true"></i> <b><?=$totalAns?></b> </span>
				</div>
			</div>
			<?php
				$category_name	=	tabloCek("category_name", "*", "ORDER BY siralama ASC");
				
				foreach( $category_name as $anaPage ) {
			?>
			<div class="row chapter">
				<h2><?=$anaPage["name"]?></h2>
				<?php
				$category_rows	=	tabloCek("category_rows", "*", "WHERE target = '{$anaPage["id"]}' ORDER BY siralama ASC");
				
				if( $category_rows->rowCount() > 0 ) { ?>
				<ul>
					<?php foreach( $category_rows as $category ) { ?>
					<li><a href="/kategori/<?=$category["seo_name"]?>"><i class="fa fa-arrow-right" aria-hidden="true"></i> <?=$category["name"]?></a> <span class="qa-nav-cat-note"><?=$category["point"]?></span></li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?
	}
	
	function footer()
	{
		?>
		<div class="col-md-12 footer text-center">
			<div class="col-md-12">
				Soru Cevap Platformu | 2017 <a target="_blank" href="http://www.coderbing.com/"><b>CoderBing</b></a>.
			</div>
			<div class="clear"></div>
		</div>
		<?
	}
	
	function scripts()
	{
		?>
		<script type="text/javascript" src="assets/js/jquery.js"></script>
		<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.js"></script>
		<?
	}
}
?>