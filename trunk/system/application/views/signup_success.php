<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>

<head>
	<title>suppleText - Signup Success!</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css" media="all">
	/* <![CDATA[ */
	@import url(<?php echo site_url('css/default.css'); ?>);
	@import url(<?php echo site_url('css/signup_success.css'); ?>);
	/* ]]> */
	</style>
</head>

<body>
<div id="wrap">


<div id="header">
	<h1><a href="<?php echo base_url(); ?>">suppleText</a></h1>
	<p>your free elegant and flexible wiki</p>
</div>	

<div id="content">
	<h2 class="center">Your account is now active!</h2>
	
	<p>
		An email with your username, password, url, and important 
		links has been sent to your email address.
	</p>
	
	<div class="center">
		What's next? Continue to your wiki and start editing!
	</div>
	
	<h3 class="center"><a href="<?php echo $user_url; ?>"><?php echo $user_url; ?></a></h3>
	
</div>

<div id="footer">
<small>Page rendered in {elapsed_time} seconds</small>
</div>

</div>
</body>

</html>
