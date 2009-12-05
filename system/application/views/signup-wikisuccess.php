<?php $this->load->view('default_header'); ?>

<div id="content">
<h1>Your new wiki is now active!</h1>

<p class="description">
Congratulations! <span class="highlight"><a href="<?php echo prep_url($wiki_url); ?>" style="font-size: 1.6em;"><?php echo $wiki_url; ?></a> is now yours</span>!
Welcome to the suppleText wiki community. Now click the link and go edit your wiki! 
</p>
<p class="description">
An email with your wiki url and other important links has 
been <span class="highlight">sent to your email address</span>.
We hope you enjoy suppleText!
</p>

</div>

<?php $this->load->view('default_footer'); ?>
