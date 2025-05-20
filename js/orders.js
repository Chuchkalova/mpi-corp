$(document).ready(function(){	
	$(document).on('click', ".add-cart", function(e) {
		$.post("/orders/add_cart_ajax/"+$(this).attr("data-id")+"/1/", {
			
		},
		function (result) {
			obj = JSON.parse(result);
			if(obj.count){
				if(obj.count!="0"){
					$('.cart-empty').addClass("hidden");
					$('.cart-full').removeClass("hidden");
				}
				else{
					$('.cart-empty').removeClass("hidden");
					$('.cart-full').addClass("hidden");
				}
				$('.cart-count').html(obj.count);
			}
			if(obj.summa){
				$('.cart-summa').html(obj.summa);
			}
			$.fancybox.open('#cart-success',{
			});
		});

		return false;
	});
	
	function calculate_cart(){
		var cart_positions = {};
		$.each($(".cart-position-count"), function() {
			cart_positions[$(this).attr("data-id")]=$(this).val();
		});
		
		$.post("/orders/update_cart_ajax/", {
			items:cart_positions,
		},
		function (result) {
			obj = JSON.parse(result);
			if(obj.count){
				if(obj.count!="0"){
					$('.cart-empty').addClass("hidden");
					$('.cart-full').removeClass("hidden");
				}
				else{
					$('.cart-empty').removeClass("hidden");
					$('.cart-full').addClass("hidden");
				}
				$('.cart-count').html(obj.count);
			}
			if(obj.summa){
				$('.cart-summa').html(obj.summa);
			}
			
			$.each($("table.cart-table tr"), function() {
				count=parseInt($(this).find(".cart-position-count").val());
				price=$(this).find(".price span.s1").text();
				$(this).find(".summa span.s1").text(price*count);
			});
		});
	}
	
	$(".cart-position-count").keyup(function (e) {
		if(!isNaN($(this).val())&&$(this).val()>=0){
			$(this).css('background','');
			calculate_cart()
		}
		else{
			$(this).css('background','red');
		}
	});
	
	$(".cart-position-count").change(function(){
		if(!isNaN($(this).val())&&$(this).val()>=0){
			calculate_cart();
		}
	});
	
	$(document).on('click', ".delete-cart", function(e) {
		$this=$(this);
		$.post("/orders/delete_cart_ajax/"+$(this).attr("data-id"), {
			
		},
		function (result) {
			obj = JSON.parse(result);
			if(obj.count){
				if(obj.count!="0"){
					$('.cart-empty').addClass("hidden");
					$('.cart-full').removeClass("hidden");
				}
				else{
					$('.cart-empty').removeClass("hidden");
					$('.cart-full').addClass("hidden");
				}
				$('.cart-count').html(obj.count);
			}
			if(obj.summa){
				$('.cart-summa').html(obj.summa);
			}
			$this.parent().parent().remove();
		});
		return false;
	});
});