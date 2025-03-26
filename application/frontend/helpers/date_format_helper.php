<?php

function format_date_all($format, $date){
	$date_eng=date($format, strtotime($date));
	$days_of_week=array(
		'Mon'=>'Понедельник',
		'Tue'=>'Вторник',
		'Wed'=>'Среда',
		'Thu'=>'Четверг',
		'Fri'=>'Пятница',
		'Sat'=>'Суббота',
		'Sun'=>'Восвресенье',
	);

	$months=array(
		'January'=>'Января',
		'February'=>'Февраля',
		'March'=>'Марта',
		'April'=>'Апреля',
		'May'=>'Мая',
		'June'=>'Июня',
		'July'=>'Июля',
		'August'=>'Августа',
		'September'=>'Сентября',
		'October'=>'Октября',
		'November'=>'Ноября',
		'December'=>'Декабря',
	);
	
	$date = strtr($date_eng, $days_of_week);
	$date = strtr($date, $months);
	return $date;
}

function format_date($date){
	$months=array(
		'',
		'января',
		'февраля',
		'марта',
		'апреля',
		'мая',
		'июня',
		'июля',
		'августа',
		'сентября',
		'октября',
		'ноября',
		'декабря',
	);
	return date('d',strtotime($date))." ".$months[(int)date('m',strtotime($date))]." ".date('Y',strtotime($date));
}

?>