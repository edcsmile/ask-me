<?php
require_once("interface.php");
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<?=$site->head("Anasayfa");?>
		<link rel="stylesheet" href="assets/plugins/bootstrap-select/css/bootstrap-select.css" />
	</head>
	<body>
		<?=$site->navbar(0);?>
		<div class="container">
			<div class="edc col-md-8">
				<div class="ask-settings" style="display: none">
					<a href="/bilgilendirme" class="col-md-6"> <div class="col-md-12"> Bilgilendirme / Faydalı Bilgiler </div> </a>
					<a href="/sabitkonu" class="col-md-6"> <div class="col-md-12"> Sabit Konular </div> </a>
				</div>
				<?php
					$users_posts = tabloCek("users_posts", "*", "ORDER BY id DESC LIMIT 7");
					
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
				<?php } ?>
				<nav aria-label="Page navigation">
				  <ul class="pagination">
					<li>
					  <a href="/sorular" aria-label="Previous">
						<span aria-hidden="true">Tümünü Gör &raquo;</span>
					  </a>
					</li>
				  </ul>
				</nav>
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