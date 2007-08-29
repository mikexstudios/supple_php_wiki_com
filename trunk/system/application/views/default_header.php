<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $page_title; ?> : suppleText</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<style type="text/css" media="screen">
	/* <![CDATA[ */
	@import url("<?php echo site_url('css/default.css'); ?>");
	<?php echo $page_css; ?>
	
	/* ]]> */
	</style>
	
	<script type="text/javascript" src="<?php echo site_url('js/niftycube.js'); ?>"></script>
	<script type="text/javascript">
		window.onload=function() {
			Nifty("div#content h1","tl bottom big");
			Nifty("div.error","tl bottom normal");
		}
	</script>
</head>

<body>
<div id="wrap">

<div id="header">
		<h1><a href="<?php echo base_url(); ?>">suppleText</a></h1>
		<p>your free elegant and flexible wiki</p>
</div>
