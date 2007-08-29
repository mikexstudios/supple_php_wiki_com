<?php $this->load->view('default_header'); ?>

<div id="content">
<h1>Get your free suppleText wiki in seconds!</h1>

<div id="message">
	<?php if(!empty($this->validation->error_string)): ?>
		<?php echo $this->validation->error_string; ?>
	<?php endif; ?>
</div>

<p class="description">
	Hi, <?php out('logged_in_username'); ?>! Fill out the form below to add a wiki to your account. You currently have
	unlimited number of wikis you can create! However, please only create wikis
	that you will use!
</p>

<form action="<?php echo site_url('signup/newwiki'); ?>" method="post">
  <table class="signup">
  <tr>
  	<th>Wiki Domain:</th>
    <td>
    	<input id="domain" name="domain" size="16" type="text" value="<?php echo $this->validation->domain; ?>" /><span style="font-size: 2.1em">.suppletext.com</span>
    	<p><span class="highlight">No spaces or special characters (besides the underscore: _) allowed and at least four characters in wiki domain.</span></p>
    </td>
  </tr>
  <tr>
  	<th>Wiki Title:</th>
    <td>
    	<input id="title" name="title" size="20" type="text" value="<?php echo $this->validation->title; ?>" />
    	<p><span class="highlight">The wiki title can be changed at any time on your Options page.</span></p>
    </td>
  </tr>
  <tr>
  	<th></th>
  	<td>
  		<p class="submit"><input type="submit" value="Create Wiki &raquo;"></p>
  	</td>
  </tr>
	</table>
  
</form>

</div>

<?php $this->load->view('default_footer'); ?>
