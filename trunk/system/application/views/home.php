<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>suppleText - get your own wiki! Free wiki hosting.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<style type="text/css" media="screen">
	/* <![CDATA[ */
	@import url("<?php echo site_url('css/default.css'); ?>");
	@import url("<?php echo site_url('css/home.css'); ?>");
	/* ]]> */
	</style>
	
	<script type="text/javascript" src="<?php echo site_url('js/niftycube.js'); ?>"></script>
	<script type="text/javascript">
		window.onload=function() {
			Nifty("div#signup","tl bottom big fixed-height");
			Nifty("div#login","tl bottom big fixed-height");
		}
	</script>
</head>

<body>
<div id="wrap">

	

<table cellpadding="0" cellspacing="0">
<tr>
	<td class="left">
	<div id="header">
		<h1><a href="<?php echo base_url(); ?>">suppleText</a></h1>
		<p>your free elegant and flexible wiki</p>
	</div>	
	</td>
	<td>
	</td>
</tr>
<tr>
	<td class="left">
	<div id="content">
		<p>a very <span class="highlight">elegant and flexible</span> <em>collaborative</em> web authoring and publishing solution 
		focusing on <span class="highlight">semantics, clean aesthetics, web standards, usability</span>, and giving 
		users the power to <span class="highlight">customize the presentation of their <strong>wiki</strong></span>.</p>
	</div>
	
	<!--
	<div id="features">
		<p><a href="<?php echo site_url('features'); ?>">Check out our features &raquo;</a></p>
	</div>
	-->

	</td>

	<td class="right">
	<div id="interact">
		<?php if($this->authorization->is_logged_in()): ?>
			<?php
				//Check if the user has created any wikis 
				$user_wikis = get('user_wikis');
				if(count($user_wikis) > 0 && !empty($user_wikis[0])): 
			?>
		<div id="signup">
			<p>Welcome back, <?php out('logged_in_username'); ?>!</p>
			<p class="signup_link"><a href="<?php echo site_url('signup'); ?>">Create another wiki!</a></p>
		</div>
		<div id="login">
			<p><strong>Visit your wiki<?php echo (count($user_wikis) > 1) ? 's' : ''; ?>:</strong></p>
			<ul class="wiki_list">
				<?php foreach($user_wikis as $each_wiki): ?>
				<li><a href="<?php echo site_url('users/'.$each_wiki); ?>"><?php echo $each_wiki; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
			<?php else: ?>
		<div id="signup">
			<p>Welcome back, <?php out('logged_in_username'); ?>!</p>
			<p class="signup_link"><a href="<?php echo site_url('signup'); ?>">Create your own wiki!</a></p>
		</div>
		<div id="login">
			<p>You are currently associated with no wikis.</p>
		</div>
			<?php endif; ?>
		<?php else: ?>
		<div id="signup">
			<p>Get your own free wiki in seconds:</p>
			<p class="signup_link"><a href="<?php echo site_url('signup'); ?>">Sign up now!</a></p>
		</div>
		<div id="login">
			<p>Already have an account?</p>
			
			<form action="<?php site_url('users/login'); ?>">
			<table class="login_box">
			<tr valign="top"> 
			<th scope="row">Username:</th> 
			<td>
				<input id="username" type="text"  name="username" size="16" value="" />
			</td>
			</tr> 
			
			<tr valign="top"> 
			<th scope="row">Password:</th> 
			<td>
				<input id="password"  type="text" name="password" size="16" value="" />
			</td>
			</tr> 
			</table>
			<p class="submit"><input id="login_button" type="submit" value="Login &raquo;" size="40" /></p>	
			</form>
			
		</div>
		<?php endif; ?>
		
	</div>
	</td>
	

</tr>
</table>

</div>

<div id="footer">
<small>Page rendered in {elapsed_time} seconds</small>
</div>

</div>
</body>

</html>
