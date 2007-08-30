<?php $this->load->view('default_header'); ?>

<div id="content">
<h1>Your account is now active!</h1>

<p class="description">
Congratulations! <span class="highlight">You are now logged in as <?php out('logged_in_username'); ?></span>.
By having a suppleText account, you have the ability to participate in the suppleText
wiki community. You are now able to <span class="highlight">edit other wikis</span> 
and <span class="highlight">even <a href="<?php echo site_url('signup/newwiki'); ?>">create your own wiki</a></span>!
</p>
<p class="description">
An email with your username, password, and important links has 
been <span class="highlight">sent to your email address</span>.
We hope you enjoy suppleText!
</p>

</div>

<?php $this->load->view('default_footer'); ?>
