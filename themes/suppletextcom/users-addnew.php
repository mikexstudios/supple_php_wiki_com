<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php theme_include('header'); ?>

<!--starting page content-->
<div class="wrap">

<?php if(!empty($this->validation->error_string)): ?>
		<?php echo $this->validation->error_string; ?>
<?php endif; ?>

<?php out('message'); ?>

<h2 id="add-new-user">Add User to Wiki</h2>

<div class="narrow">

<p>You can use this page to <span class="highlight">give other <a href="<?php echo $this->config->item('mu_base_url'); ?>">suppleText</a> 
users special privileges (ie. Editor or Administrator) on this wiki</span>. For instance, 
by making a user an Editor, that user can modify page permissions. If you make a user
an administrator, they will have full control over your wiki (so be careful about
who you add)! <em>Users must already be <a href="<?php echo $this->config->item('mu_base_url').'signup/';?>">registered</a></em>.</p>

<form action="<?php out('admin_url', 'users/addnew'); ?>" method="post" name="adduser" id="adduser">
<table class="editform" width="100%" cellspacing="2" cellpadding="5">
	<tr>
		<th scope="row" width="33%">Username:</th>
		<td width="66%"><input name="user_login" type="text" id="user_login" value="<?php echo $this->validation->user_login; ?>" /></td>
	</tr>
	<tr>
		<th scope="row">Role:</th>
		<td>
			<select name="role" id="role">
				<option value='Editor' <?php echo $this->validation->set_select('role', 'Editor'); ?>>Editor</option>
				<option value='Administrator' <?php echo $this->validation->set_select('role', 'Administrator'); ?>>Administrator</option>
			</select>
		</td>
	</tr>
</table>
<p class="submit">
	<input name="adduser" type="submit" id="addusersub" value="Add User &raquo;" />
</p>

</form>

</div> <!--End div narrow-->
</div>
<!--closing page content-->

<?php theme_include('footer'); ?>
