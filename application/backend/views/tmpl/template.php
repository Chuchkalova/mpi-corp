<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<title>CRM: система управления сайтом</title>
	
	<!--link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'-->
    <link href="/css/bootstrap.admin.css" rel="stylesheet">
	<link href="/css/jquery-ui.min.css" rel="stylesheet">
	<link href="/css/bootstrap-switch.css" rel="stylesheet">
	<link href="/css/init.css" rel="stylesheet">
	<link href="/css/admin.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script type="text/javascript" src="/js/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.admin.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap-switch.js"></script>
	<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="/js/ckfinder/ckfinder.js"></script>	
	<script type="text/javascript" src="/js/bootbox.min.js"></script>
	
	
	<script type="text/javascript" src="/js/jquery.ui.datepicker-ru.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
	
    
	<script type="text/javascript" src="/js/fileUpload/js/vendor/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="/js/fileUpload/js/jquery.iframe-transport.js"></script>
	<script type="text/javascript" src="/js/fileUpload/js/jquery.fileupload.js"></script>
	
	<script type="text/javascript" src="/js/admin.js"></script>
</head>
<body>
	<?
		if($this->session->userdata('super')){
	?>
			<div class="view_mode">
				<a href="<?= site_url("login/change_view_mode"); ?>"><img src="/img/view_mode_<?= ($this->session->userdata('super_mode'))?1:0; ?>.png"></a>
			</div>
	<?
		}
	?>
	
	<div class="adm-head">
		<div class="adm-head-body">
			<div class="adm-head-left">
				<a href="http://1pos.ru" target="blank"><img src="/images/logo-ipos.png" alt="iPOS - logo" /></a>
			</div>
			<div class="adm-head-nav">
				<div class="conf-table">
					<table>
						<tr>
							<td>
								<h2><a href="<?= site_url("/login/exit_admin"); ?>"><img src="/images/icons/icon_power.png" alt="Выход">Выход</a></h2>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="adm-side">		
		<?= $header; ?>
	</div>
	<div class="adm-ctn">
		<div class="adm-body">			
			<?= $content; ?>
		</div>
	</div>
</body>
</html>