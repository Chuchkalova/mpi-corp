$(document).ready(function(){

	$('.slider4').bxSlider({

		slideWidth: 243,

		minSlides: 1,

		maxSlides: 4,

		moveSlides: 1,

		slideMargin: 30,

		pager: false

	});

	let head = $("#head");
let leftEye = $("#eye");
let headOffset = head.offset();
let headWidth = head.width();
let headHeight = head.height();
let headX = headOffset.left + headWidth / 2;
let headY = headOffset.top + headHeight / 2;
let currentAngle = 0;
let targetAngle = 0;
function lerp(start, end, t) {
    return start * (1 - t) + end * t;
}
function normalizeAngle(angle) {
    while (angle > 180) angle -= 360;
    while (angle < -180) angle += 360;
    return angle;
}
$(document).on("mousemove", function (event) {
    let mouseX = event.pageX;
    let mouseY = event.pageY;
    let radians = Math.atan2(mouseY - headY, mouseX - headX);
    let rawTargetAngle = radians * (180 / Math.PI) + 160;
    targetAngle = normalizeAngle(rawTargetAngle - currentAngle) + currentAngle;
});

function animate() {
    currentAngle = lerp(currentAngle, targetAngle, 0.1);
    leftEye.css("transform", "rotate(" + currentAngle + "deg)");
    requestAnimationFrame(animate);
}
animate();

	

	$(".zoom").fancybox({

		'titlePosition'	: 'inside'

	});

	

	$('.fancybox').click(function(e){

		if($(this).attr("rel")){

			$("#popup_description").val($(this).attr("rel"));

		}

		$.fancybox.open({

			href:$(this).attr('href')

		});

		return false;

	});

	

	// $("input[name=phone]").mask("+7(999)999-99-99");

	

	$('form.ajax').submit(function(e){

		$.ajax({

			url: "/mains/submit_form",

			type:   'POST',

			data: $(this).serialize(),

			success: function(result){

				$.fancybox.open({

					href:"#success",

				});

			}

		});

		return false;

	});




	$('a.fncy-custom-close').click(function(e){

		e.preventDefault();

		$.fancybox.close();

	});

});
$(document).on('submit', 'form.ajax-form', function(e) {
	e.preventDefault(); // предотвращаем стандартное поведение формы

	$.ajax({
		url: "/mains/submit_form",
		type: 'POST',
		data: $(this).serialize(),
		success: function(result) {
			$.fancybox.open({
				href: "#success",
			});
		}
	});

	return false;
});