<div style="display:none;">
		<div id="order">
			<a class="fncy-custom-close"><img src="/site_img/x.png"></a>
			<form id="send_back" method="post" action="#">
				<h4 id="order_h4"><?= $parametrs->name; ?></h4>
				<p><input name="fio" type="text" placeholder="Имя" class="check" id="post_fio"></p>
				<p><input name="phone" type="text" placeholder="Телефон" class="check" id="post_phone"></p>
				<input type='hidden' value="" id="item_id">
				<p><a class="btn btn-success" id="submit_call" href="#">Отправить</a></p>
			</form>
		</div>
	</div>
	<div style="display:none;">
		<div id="success">
			<a class="fncy-custom-close"><img src="/site_img/x.png"></a>
			<h4>Отправлено!</h4>
			<p>В ближайшее время с вами свяжется наш специалист.</p>
		</div>
	</div>