$(document).ready(function(){
	$(".date-pick").datepicker({ dateFormat: "dd.mm.yy", changeYear: true, changeMonth: true });
	
	$('.confirm').click(function(){
		$ref=$(this);
		bootbox.confirm("Вы уверены?", function(result) {
			if(result){
				document.location.href=$ref.attr('href');
			}
		});
		return false;
	});
	
	if(window.location.href.indexOf("/add") > -1){
		$("input[name=is_show]").each(function() {
			$(this).attr('checked', true);
		});
		$("input[name=region_rewrite]").each(function() {
			$(this).attr('checked', true);
		});
	}
	$(".regions input[type=checkbox]").each(function() {
		$(this).attr('checked', true);
	});
	
	$("[name='is_show']").bootstrapSwitch();
	
	$(document).on("click", ".delete_image", function(){
		$this=$(this);
		bootbox.confirm("Вы уверены?", function(result) {	
			if(result){
				$.ajax({
					url: $this.attr("href"),
					success: function(result){
						$this.parent().parent().remove();
					},
				});
			}
		});
		return false;
	});
	
	$('.fileupload').fileupload({
		url: '/js/fileUpload/server/php/',
		dataType: 'json',
		done: function (e, data) {	
			var gallery_id=e.target.getAttribute('data-id');
			$.each(data.result.files, function (index, file) {
				$.ajax({
					url: "/admin/gallerys/save_to_gallery",
					type:   'POST',
					data: {
						gallery_id: gallery_id,
						file_name: file.name,
					},
					success: function(result){
						if(result!=-1){
							$(result).appendTo(".item_table[data-id="+gallery_id+"]");
						}
					},
				});
			});
		},
		progressall: function (e, data) {
			var gallery_id=e.target.getAttribute('data-id');
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('.progress_'+gallery_id+' .progress-bar').css('width', progress + '%');
		}
	}).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
	
	
	$(".invert").click(function() {
        $(".regions input[type=checkbox]").each(function() {
			$(this).attr('checked', !$(this).attr('checked'));
		});
		return false;
    });
});