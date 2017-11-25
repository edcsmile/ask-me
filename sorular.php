<?php
$site_url = "http://$_SERVER[HTTP_HOST]";
require_once("interface.php");
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<base href="<?=$site_url?>"  />
		<?=$site->head("Anasayfa");?>
		<link rel="stylesheet" href="assets/plugins/bootstrap-select/css/bootstrap-select.css" />
	</head>
	<body>
		<?=$site->navbar(3);?>
		<div class="container">
			<div class="edc col-md-8">
				<div class="ask-settings" style="display: none">
					<a href="/bilgilendirme" class="col-md-6"> <div class="col-md-12"> Bilgilendirme / Faydalı Bilgiler </div> </a>
					<a href="/sabitkonu" class="col-md-6"> <div class="col-md-12"> Sabit Konular </div> </a>
				</div>
				<?php
					$users_posts = tabloCek("users_posts", "*", "ORDER BY id DESC");
					
					$goruntulenecekToplamItem = 15;
					$totalDuyuru = $users_posts->rowCount();
					$toplam_sayfa = ceil($totalDuyuru / $goruntulenecekToplamItem);
					
					$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
					if($sayfa < 1) $sayfa = 1; 
					if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
					
					$limit = ($sayfa - 1) * $goruntulenecekToplamItem;
					
					$users_posts = tabloCek("users_posts", "*", "ORDER BY id DESC LIMIT {$limit}, {$goruntulenecekToplamItem}");
					
					foreach( $users_posts as $post ) {
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
				<?php
					}
					
					if( $toplam_sayfa > 1 ) {
				?>
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
							 
							if($sayfa != 1) echo '<li><a href="/sorular/1">İlk</a></li>';

							for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
								if($sayfa == $s) {
									echo "<li class='active'><a href='javascript:void(0)'>{$s}</a></li>"; 
								} else {
									echo "<li><a href='/sorular/{$s}'>{$s}</a></li>";
								}
							}
							
							if($sayfa != $toplam_sayfa) echo "<li><a href='/sorular/{$toplam_sayfa}'>Son</a></li>";
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
	<script type="text/javascript" src="assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-select/js/i18n/defaults-tr_TR.js"></script>
	<script type="text/javascript" src="assets/plugins/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		$('.selectpicker').selectpicker();
	</script>
</html>