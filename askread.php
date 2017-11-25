<?php
$site_url = "http://$_SERVER[HTTP_HOST]";

require_once("interface.php");

if( empty( $_GET["page"] ) )
	git("/404");
else {
	$post	=	veriCek("users_posts", "*", "seo_title", $_GET["page"]);
	$user	=	veriCek("users", "username, real_name", "id", $post["user_id"]);
	
	if( !$post )
		git("/404");
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<base href="<?=$site_url?>"  />
		<?=$site->head("Mouse konumuna obje ışınlamak?");?>
		<link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert.css">
	</head>
	<body>
		<?=$site->navbar(3);?>
		<div class="container">
			<div class="edc askread col-md-8">
				<div class="categorys">
					<h5> Kategori/ler </h5>
					<?php
					$getCategories = explode(",", $post["category"]);
					foreach( $getCategories as $cat )
					{
						$cat	=	veriCek("category_rows", "seo_name, name, target", "id", $cat);
						$tar	=	veriCek("category_name", "name", "id", $cat["target"]);
						echo '<a href="/kategori/'.$cat["seo_name"].'"> <div class="category"> '.$tar["name"].' | '.$cat["name"].' </div> </a>';
					}
					?>
					<div class="clear"></div>
				</div>
				<div class="ask">
					<div class="title"> <?=$post["title"]?> </div>
					<div class="date"> <?=realTime($post["tarih"])?></div>
					<div class="content">
						<?=$post["content"]?>
					</div>
					<div class="date float-right"> <a href="/profil/<?=$user["username"]?>"><b><?=$user["real_name"]?></b></a> </div>
					<div class="clear"></div>
				</div>
				<?php
					$answers	=	tabloCek("users_posts_answers", "*", "WHERE post_id = '{$post["id"]}'");
					
					if( $answers->rowCount() > 0 ) {
						
						$goruntulenecekToplamItem = 10;
						$totalDuyuru = $answers->rowCount();
						$toplam_sayfa = ceil($totalDuyuru / $goruntulenecekToplamItem);
						
						$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
						if($sayfa < 1) $sayfa = 1; 
						if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
						
						$limit = ($sayfa - 1) * $goruntulenecekToplamItem;
						
						$answers	=	tabloCek("users_posts_answers", "*", "WHERE post_id = '{$post["id"]}' LIMIT {$limit}, {$goruntulenecekToplamItem}");
						
						foreach( $answers as $set ) {
							$answerer_user	=	veriCek("users", "username, real_name", "id", $set["user_id"]);
				?>
				<div class="reply ask">
					<div class="date"> <a href="/profil/<?=$answerer_user["username"]?>"><b><?=$answerer_user["real_name"]?></b></a>, <?=realTime($set["tarih"])?>
						<?php if( $set["likely"] != "0" ) { ?>
						<div class="settings liker float-right">
							<?php
								$likeKontrol	=	veriCMD("SELECT * FROM users_likers WHERE answer_id = '{$set["id"]}' AND user_id = '{$_SESSION["user"]["id"]}'");
								
								if( $likeKontrol || $set["user_id"] == $_SESSION["user"]["id"] ) {
							?>
								(<?=$set["likely"]?>)
							<?php } else { ?>
								<?php if( logControl() ) {  ?>
									<a class="e119ca50b0c39ff197a982d013bac7a8" data-target="<?=$set["id"]?>" href="#" title="Puan ver"> (<?=$set["likely"]?>) <i class="fa fa-thumbs-up" aria-hidden="true"></i> </a>
								<?php } else { ?>
									(<?=$set["likely"]?>)
								<?php } ?>
							<?php } ?>
						</div>
						<?php } else {
							if( $set["user_id"] != $_SESSION["user"]["id"] && logControl() ) {
						?>
						<div class="settings liker float-right">
							<a class="e119ca50b0c39ff197a982d013bac7a8" data-target="<?=$set["id"]?>" href="#" title="Puan ver"> <i class="fa fa-thumbs-up" aria-hidden="true"></i> </a>
						</div>
						<?php } } ?>
					</div>
					<div class="content">
						<?=$set["content"]?>
					</div>
					<?php if( $post["user_id"] == $_SESSION["user"]["id"] ) { ?>
					<div class="settings float-right">
						<?php
						if( $post["status"] == "0" && $set["user_id"] != $_SESSION["user"]["id"] ) {
							?>
							<a class="5e6a96cc7bf9108cd89ufd3c44aedk8c" data-target="<?=$set["id"]?>" href="#" title="Aradığın cevap bu mu?"> Doğru cevap olarak işaretle </a>
							<?php
						}
						?>
					</div>
					<?php }
					if( $set["rightly"] == "1" ) { ?>
					<div class="settings float-right">
						<b>Doğru Cevap</b>
					</div>
					<?php
					}
					?>
					<div class="clear"></div>
				</div>
				<?php } }
					
					if( $toplam_sayfa > 1 ) {
				?>
					<nav aria-label="Page navigation">
						<ul class="pagination">
							<?php
							$cSoru = $post["seo_title"];
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
							 
							if($sayfa != 1) echo '<li><a href="/soru/'.$cSoru.'/1">İlk</a></li>';

							for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
								if($sayfa == $s) {
									echo "<li class='active'><a href='javascript:void(0)'>{$s}</a></li>"; 
								} else {
									echo "<li><a href='/soru/{$cSoru}/{$s}'>{$s}</a></li>";
								}
							}
							
							if($sayfa != $toplam_sayfa) echo "<li><a href='/soru/{$cSoru}/{$toplam_sayfa}'>Son</a></li>";
							?>
						</ul>
					</nav>
				<?php }
				
				if( logControl() ) {
				?>
				<div class="newReply">
					<form class="form" action="/soru/<?=$post["seo_title"]?>" method="POST">
						<input type="hidden" name="post_id" value="<?=$post["id"]?>" />
						<input type="hidden" name="567904efe9e64d9faf3e41ef402cb568" value="<?=$post["seo_title"]?>" />
						<div class="form-group">
						  <label for="comment">Yeni Cevap</label>
						  <textarea class="form-control ckeditor" rows="5" name="comment"></textarea>
						</div>
						<button type="submit" class="btn btn-default send">Gönder</button>
					</form>
				</div>
				<?php } else { ?>
				<br />
				<p>
					Bu soruyu yorumlamak için <a href="/giris">giriş</a> yapmalısınız..
				</p>
				<?php } ?>
			</div>
			<?=$site->category();?>
		</div>
		<?=$site->footer();?>
	</body>
	<?=$site->scripts();?>
	<script type="text/javascript" src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/plugins/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="assets/js/asksettings.js"></script>
	<script type="text/javascript">
		<?php
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			userTrack();
			
			$where_to	=	$_POST["567904efe9e64d9faf3e41ef402cb568"];
			
			$post_id	=	$_POST["post_id"];
			$comment	=	$_POST["comment"];
			$tarih		=	@date("Y-m-d H:i:s");
			
			if( empty($comment) ) {
				edcAlert("Cevap bölümünü unuttun..");
				unset($_SESSION["securiy"]);
			}
			else {
				$sutunlar	=	array("post_id", "user_id", "content", "tarih");
				$cevap		=	array($post_id, $_SESSION["user"]["id"], $comment, $tarih);
				
				if( $_SESSION["securiy"] != "1" && veriEkle($sutunlar, $cevap, "users_posts_answers", "id", $profile_id) )
				{
					$_SESSION["securiy"] = "1";
					
					echo '
						swal({
						  title: "",
						  text: "Cevabınız gönderilmiştir..",
						  type: "success",
						  showConfirmButton: false
						});
						
						setInterval(function(){ location.href = "/soru/'.$where_to.'"; }, 700);
					';
				} else {
					// echo 'swal("Oops...", "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..", "warning");';
					header("Location: '/soru/{$where_to}'");
					unset($_SESSION["securiy"]);
				}
			}
		} else {
			unset($_SESSION["securiy"]);
		}
		?>
	</script>
</html>