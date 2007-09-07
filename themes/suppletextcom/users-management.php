<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php theme_include('header'); ?>

<!--starting page content-->
<div class="wrap">

<?php if(!empty($this->validation->error_string)): ?>
		<?php echo $this->validation->error_string; ?>
<?php endif; ?>

<?php out('message'); ?>

<h2>User List by Role</h2>

<p>Note: <span class="highlight">You cannot modify yourself</span>. You must have another Administrator on 
this wiki do it for you.</p>

<form action="<?php out('admin_url', 'users/management'); ?>" method="post" name="updateusers" id="updateusers">
<table class="widefat">

<tbody>
<tr class="thead">
	<th>Username</th>
	<th>Role</th>
</tr>
</tbody>

<tbody>
<?php 
	$all_users_info = get('all_users_info'); 
	//print_r($all_users_info);
	foreach($all_users_info as $each_username => $each_user_info): 
?>
	<tr id='user-<?php echo $each_username; ?>' <?php echo alternator('class="alternate"', ''); ?>>
		<td><?php if($each_username != get('logged_in_username')): ?><input type='checkbox' name='users[]' id='user_<?php echo $each_username; ?>' value='<?php echo $each_username; ?>' /><?php endif; ?> <label for='user_<?php echo $each_username; ?>'><strong><?php echo $each_username; ?></strong></label></td>
		<td><?php echo $each_user_info['role']; ?></td>
	</tr>
<?php
	endforeach;	
?>
</tbody>
</table>

<h3>Update Selected</h3>
<ul style="list-style:none;">
	<li><input type="radio" name="action" id="action0" value="delete" <?php echo $this->validation->set_radio('action', 'delete'); ?>/> <label for="action0">Delete checked users.</label></li>
	<li>
		<input type="radio" name="action" id="action1" value="promote" <?php echo $this->validation->set_radio('action', 'promote'); ?>/> <label for="action1">Set the Role of checked users to:</label>
		<select name="new_role" onchange="getElementById('action1').checked = 'true'">
			<option value='Editor' <?php echo $this->validation->set_select('new_role', 'Editor'); ?>>Editor</option>
			<option value='Administrator' <?php echo $this->validation->set_select('new_role', 'Administrator'); ?>>Administrator</option>
		</select>
	</li>
</ul>
<p class="submit"><input name="bulkupdate" type="submit" value="Bulk Update &raquo;" /></p>
</form>

</div>
<!--closing page content-->

<?php theme_include('footer'); ?>
