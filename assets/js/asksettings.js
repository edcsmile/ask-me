/*********************************/
		// İlker Şahin //
/*********************************/

$(document).ready(function() {
	var oneMoreTime = 1; // Console Filtre
	
	$(".5e6a96cc7bf9108cd89ufd3c44aedk8c").click(function() {
		var answer_id = $(this).attr("data-target");
		
		if( oneMoreTime == 1 ) // Console Filtre
		{
			oneMoreTime = 0;
			$.ajax({	
				type: "POST",
				url: "assets/form/ask_settings.php",
				data: {"stat":"rightly", "answer_id":answer_id},
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
	
	$(".e119ca50b0c39ff197a982d013bac7a8").click(function() {
		var answer_id = $(this).attr("data-target");
		
		if( oneMoreTime == 1 ) // Console Filtre
		{
			oneMoreTime = 0;
			$.ajax({	
				type: "POST",
				url: "assets/form/ask_settings.php",
				data: {"stat":"addLike", "answer_id":answer_id},
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
});