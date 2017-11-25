<?php
ob_start();
require_once("interface.php");

userTrack();
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<?=$site->head("Soru Sor");?>
		<link rel="stylesheet" href="assets/plugins/bootstrap-select/css/bootstrap-select.css" />
		<link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert.css">
	</head>
	<body>
		<?=$site->navbar(1);?>
		<div class="container">
			<div class="edc col-md-8">
				<form class="form" action="/soru-sor" method="POST">
					<div class="form-group">
						<label for="comment">Kategori</label> <br />
						<select name="category[]" class="form-group selectpicker" multiple data-max-options="5">
							<?php
							$category_name	=	tabloCek("category_name", "*", "ORDER BY siralama ASC");
				
							foreach( $category_name as $anaPage ) { ?>
							<optgroup label="<?=$anaPage["name"]?>" data-max-options="3">
							<?php
							$category_rows	=	tabloCek("category_rows", "*", "WHERE target = '{$anaPage["id"]}' ORDER BY siralama ASC");
							
							if( $category_rows->rowCount() > 0 ) {
								foreach( $category_rows as $category ) {
								?>
								<option value="<?=$category["id"]?>"><?=$category["name"]?></option>
								<?php
								}
							}
							?>
							</optgroup>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
					  <label for="comment">Başlık</label>
					  <input class="form-control" type="text" name="title" value="<?=$_POST["title"]?>" />
					</div>
					<div class="form-group">
					  <label for="comment">Sorunuz</label>
					  <textarea class="form-control ckeditor" rows="5" name="comment"><?=$_POST["comment"]?></textarea>
					</div>
					<button type="submit" class="btn btn-default send">Gönder</button>
				</form>
			</div>
			<?=$site->category();?>
		</div>
		<?=$site->footer();?>
	</body>
	<?=$site->scripts();?>
	<script type="text/javascript" src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-select/js/i18n/defaults-tr_TR.js"></script>
	<script type="text/javascript" src="assets/plugins/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		$('.selectpicker').selectpicker();
		
		<?php
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			userTrack();
			
			$category		=	ninja($_POST["category"]);
			$title			=	ninja($_POST["title"]);
			$seotitle		=	permalink(mb_substr(ninja($_POST["title"]), 0, 50));
			$comment		=	$_POST["comment"];
			$tarih			=	@date("Y-m-d H:i:s");
			
			if( empty($category) )
				edcAlert("En az 1 kategori belirtmelisin.");
			else if( empty($comment) || empty($title) )
				edcAlert("Lütfen boş alanları doldurunuz..");
			else if( strlen($title) < 10 )
				edcAlert("Başlık 10 karakterden az olamaz.");
			else {
				$count = count($category);
				foreach($category as $set)
				{
					$count--;
					
					if( $count != 0 )
						$nCategory .= $set . ",";
					else
						$nCategory .= $set;
					
					$addPoint = $db->prepare("CALL CategoryPointAdd({$set})");
					$addPoint->execute();
				}
				
				$seotitle .= "-" . rand(11111, 99999) . $_SESSION["user"]["id"];
				
				if( $_SESSION["securiy"] != "1" && veriEkle(array("user_id", "category", "seo_title", "title", "content", "tarih"), array($_SESSION["user"]["id"], $nCategory, $seotitle, $title, $comment, $tarih), "users_posts") )
				{
					$_SESSION["securiy"] = "1";
					
					echo '
						swal({
						  title: "Evet!!",
						  text: "Sorunuz başarıyla gönderilmiştir! \n Yönlendiriliyorsunuz..",
						  type: "success",
						  showLoaderOnConfirm: true,
						},function(){
						  document.location.href="/";
						});
						
						setInterval(function(){ location.href = "/"; }, 700);
					';
				} else {
					// echo 'swal("Oops...", "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..", "warning");';
					header("Location: /soru-sor");
					unset($_SESSION["securiy"]);
				}
			}
		} else {
			unset($_SESSION["securiy"]);
		}
		?>
	</script>
</html>