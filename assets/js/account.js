/*********************************/
		// İlker Şahin //
/*********************************/

$(document).ready(function() {
	var oneMoreTime = 1; // Console Filtre
	
	$(".new-register").click(function(){
		$(".register").css("display", "block");
		$(".login").css("display", "none");
		
		return false;
	});
	
	$(".new-login").click(function(){
		$(".login").css("display", "block");
		$(".register").css("display", "none");
		
		return false;
	});
	
	$(".e-send").click(function() {
		var form = $(".e-form").serialize();
		
		if( oneMoreTime == 1 ) // Console Filtre
		{
			oneMoreTime = 0;
			$.ajax({	
				type: "POST",
				url: "assets/form/log_account.php",
				data: form,
				dataType: "json",
				beforeSend: function()
				{
					swal({
					  title: "İşlem Yapılıyor",
					  text: "Lütfen bekleyiniz..",
					  type: "info",
					  showConfirmButton: false
					});
				},
				success: function(data) {
					if(data.noti == 1) {
						swal({
						  title: data.hood,
						  text: data.message,
						  type: data.type,
						  showConfirmButton: false
						});
						
						$(".e-form")[0].reset();
						setInterval(function(){ location.reload(); }, 1500);
					} else {
						swal({
						  title: data.hood,
						  text: data.message,
						  type: data.type,
						  showConfirmButton: true
						});
					}
					
					oneMoreTime = 1;
				},
				error: function(data)
				{
					swal("Oops...", "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..", "warning");
				}
			});
		}
		
		return false;
	});
	
	$(".y-send").click(function() {
		var form = $(".y-form").serialize();
		
		if( oneMoreTime == 1 ) // Console Filtre
		{
			oneMoreTime = 0;
			$.ajax({	
				type: "POST",
				url: "assets/form/reg_account.php",
				data: form,
				dataType: "json",
				beforeSend: function()
				{
					oneMoreTime = 0;
					swal({
					  title: "İşlem Yapılıyor",
					  text: "Lütfen bekleyiniz..",
					  type: "info",
					  showConfirmButton: false
					});
				},
				success: function(data) {
					swal(data.hood, data.message, data.type);
					
					if(data.noti == 1) {
						$(".y-form")[0].reset();
						setInterval(function(){ location.reload(); }, 1500);
					}
					
					oneMoreTime = 1;
				},
				error: function(data)
				{
					swal("Oops...", "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..", "warning");
					oneMoreTime = 1;
				}
			});
		}
		
		return false;
	});
	
	$(".da846c239291918242939a451a1e9da3").click(function() {
		$(this).remove();
		$(".cpass").fadeIn("fast");
		
		return false;
	});
	
	$(".social_add").click(function() {
		var social_type = $("select[name=social_type]").val();
		var social_user = $("input[name=social_username]").val();
		
		if( oneMoreTime == 1 ) // Console Filtre
		{
			oneMoreTime = 0;
			$.ajax({	
				type: "POST",
				url: "assets/form/social_add.php",
				data: {"type":"add", "social_type":social_type, "social_user":social_user},
				dataType: "json",
				beforeSend: function()
				{
					swal({
					  title: "İşlem Yapılıyor",
					  text: "Lütfen bekleyiniz..",
					  type: "info",
					  showConfirmButton: false
					});
				},
				success: function(data) {
					if(data.noti == 1) {
						$("input[name=social_username]").val("");
						$(".socials").append(' <a target="_blank" href="'+social_user+'"> <i class="fa fa-'+social_type+'" aria-hidden="true"></i> </a> ');
					}
					
					swal({
					  title: data.hood,
					  text: data.message,
					  type: data.type,
					  showConfirmButton: true
					});
					
					oneMoreTime = 1;
				},
				error: function(data)
				{
					swal("Oops...", "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..", "warning");
				}
			});
		}
		
		return false;
	});
	
	$(".social_del").click(function() {
		var social_id = $(this).attr("target");
		var social = $(this).parent();
		
		if( oneMoreTime == 1 ) // Console Filtre
		{
			oneMoreTime = 0;
			$.ajax({	
				type: "POST",
				url: "assets/form/social_add.php",
				data: {"type":"del", "social_id":social_id},
				dataType: "json",
				beforeSend: function()
				{
					swal({
					  title: "İşlem Yapılıyor",
					  text: "Lütfen bekleyiniz..",
					  type: "info",
					  showConfirmButton: false
					});
				},
				success: function(data) {
					if(data.noti == 1) {
						social.remove();
					}
					
					swal({
					  title: data.hood,
					  text: data.message,
					  type: data.type,
					  showConfirmButton: true
					});
					
					oneMoreTime = 1;
				},
				error: function(data)
				{
					swal("Oops...", "Belirlenemeyen bir hata oluştu. Lütfen daha tekrar deneyiniz..", "warning");
				}
			});
		}
		
		return false;
	});
	
});