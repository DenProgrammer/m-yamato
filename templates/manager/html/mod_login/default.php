<?php // @version $Id: default.php 11796 2009-05-06 02:03:15Z ian $
defined('_JEXEC') or die('Restricted access');
?>
<div class="loginform">
<?php
$return = base64_encode(base64_decode($return).'#content');

if ($type == 'logout') : ?>
<form action="index.php" method="post" name="login" class="log">
	<?php if ($params->get('name')) : {
		echo JText::sprintf( 'HINAME', $user->get('name') );
	} else : {
		echo JText::sprintf( 'HINAME', $user->get('username') );
	} endif; ?>
	<p>
		<input type="submit" name="Submit" class="button" value="<?php echo JText::_('BUTTON_LOGOUT'); ?>" />
	</p>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<?php else : ?>
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" class="form-login">
	<input name="username" id="mod_login_username" value="<?php echo JText::_('Username'); ?>" type="text" class="inputbox" alt="<?php echo JText::_('Username'); ?>" />
	<input type="password" id="mod_login_password" value="<?php echo JText::_('Password'); ?>" name="passwd" class="inputbox"  alt="<?php echo JText::_('Password'); ?>" />
	<label for="mod_login_remember" class="remember">
		<?php echo JText::_('Remember me'); ?>
	</label>
	<input type="checkbox" name="remember" id="mod_login_remember" class="checkbox" value="yes" alt="<?php echo JText::_('Remember me'); ?>" />
	<input type="submit" name="Submit" class="button" value="<?php echo JText::_('BUTTON_LOGIN'); ?>" />
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php endif; ?>
</div>
<script>

	jQuery('document').ready(function($){
	
		var mod_login_username = '<?php echo JText::_('Username'); ?>';
		var mod_login_password = '<?php echo JText::_('Password'); ?>';
		
		$('#mod_login_username').focus(function(){
			if ($(this).val() === mod_login_username){
				$(this).val('');
			}
		}).blur(function(){
			if ($(this).val() === ''){
				$(this).val(mod_login_username);
			}
		});
		
		$('#mod_login_password').focus(function(){
			if ($(this).val() === mod_login_password){
				$(this).val('');
			}
		}).blur(function(){
			if ($(this).val() === ''){
				$(this).val(mod_login_password);
			}
		});
	
	});
</script>
