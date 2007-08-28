<?php $this->load->view('default_header'); ?>

<div id="content">
<h1>Get your free suppleText account in seconds!</h1>

<div id="message">
	<?php if(!empty($this->validation->error_string)): ?>
		<?php echo $this->validation->error_string; ?>
	<?php endif; ?>
</div>

<form action="<?php echo site_url('signup/newuser'); ?>" method="post">
  <table class="signup">
  <tr>
  	<th>Choose a username:</th>
    <td>
    	<input id="username" name="username" size="20" type="text" value="<?php echo $this->validation->username; ?>" />
    	<p><span class="highlight">No spaces or special characters allowed and at least four characters in username.</span></p>
    </td>
  </tr>
  <tr>
  	<th>And your email address:</th>
    <td>
    	<input id="email" name="email" size="30" type="text" value="<?php echo $this->validation->email; ?>" />
    </td>
  </tr>
  <tr>
  	<th>Enter your email address <strong>again</strong>:</th>
    <td>
    	<input id="email_again" name="email_again" size="30" type="text" value="<?php echo $this->validation->email_again; ?>" />
			<p><span class="highlight">We'll never share, sell, or use your email address in irresponsible ways.</span></p>
		</td>
  </tr>
  <tr>
  	<th>Pick a password:</th>
		<td>
			<input id="password" name="password" size="20" type="password" />
    </td>
  </tr>
  <tr>
  	<th>Type that password <strong>again</strong>:</th>
    <td>
    	<input id="password_again" name="password_again" size="20" type="password" />
		</td>
  </tr>
  <tr>
  	<th>What would you like:</th>
  	<td>
			<input id="signup_for_wiki" type="radio" name="signup_for" value="wiki" <?php if(empty($this->validation->signup_for)){echo 'checked';} else {echo $this->validation->set_radio('signup_for', 'wiki');} ?> />
			<label for="signup_for_wiki">Gimme a wiki! (Like username.suppletext.com)</label>
			<br />
			<input id="signup_for_user" type="radio" name="signup_for" value="user" <?php echo $this->validation->set_radio('signup_for', 'user'); ?> />
			<label for="signup_for_user">Just a username, please.</label>
  	</td>
  </tr>
  <tr>
  	<th></th>
  	<td>
  		<p class="submit"><input type="submit" value="Create my account &raquo;"></p>
  	</td>
  </tr>
	</table>
  
</form>

</div>

<?php $this->load->view('default_footer'); ?>
