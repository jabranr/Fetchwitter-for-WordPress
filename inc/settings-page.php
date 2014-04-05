<?php

/**
 * Settings page document
 *
 * @author: hello@jabran.me
 * @package: Fetchwitter for WordPress
 *
 */

if ( isset($_POST['jr_fetchwitter_wp_nonce']) && $_POST['jr_fetchwitter_wp_nonce'] ) {
	if ( wp_verify_nonce( $_POST['jr_fetchwitter_wp_nonce'], 'update-api-info' ) ) {
		if (isset($_POST['jr_fetchwitter_api_key']) && isset($_POST['jr_fetchwitter_api_secret']) ) {
			if ( $_POST['jr_fetchwitter_api_key'] && $_POST['jr_fetchwitter_api_secret'] ) {
				$config = array( 'api_key'=> $_POST['jr_fetchwitter_api_key'], 'api_secret' => $_POST['jr_fetchwitter_api_secret']);
				$fetchwitter = new Fetchwitter( $config );
				if ( $jr_fetchwitter_access_key = $fetchwitter->get_new_access_token() ) {
					update_option( JR_FW_OPTIONS, array(
						'jr_fetchwitter_api_key' => $_POST['jr_fetchwitter_api_key'],
						'jr_fetchwitter_api_secret' => $_POST['jr_fetchwitter_api_secret'],
						'jr_fetchwitter_api_access_key' => $jr_fetchwitter_access_key
						) 
					);
					$jr_fetchwitter_info['type'] = 'updated';
					$jr_fetchwitter_info['message'] = 'Information saved successfully. An access token has been generated from this information.';
				}
				else {
					$jr_fetchwitter_info['type'] = 'error';
					$jr_fetchwitter_info['message'] = 'There was an error while producing an access token from Twitter API. Check API key and secret.';
				}
			}
			else {
				update_option( JR_FW_OPTIONS, array(
					'jr_fetchwitter_api_key' => '',
					'jr_fetchwitter_api_secret' => '',
					'jr_fetchwitter_api_access_key' => ''
					) 
				);
				$jr_fetchwitter_info['type'] = 'updated';
				$jr_fetchwitter_info['message'] = 'Information updated successfully.';
			}
		}
	}
}

$jr_fetchwitter_options = get_option( JR_FW_OPTIONS );
$jr_fetchwitter_api_key = ($jr_fetchwitter_options && $jr_fetchwitter_options['jr_fetchwitter_api_key']) ? $jr_fetchwitter_options['jr_fetchwitter_api_key'] : (isset($_POST['jr_fetchwitter_api_key']) ? $_POST['jr_fetchwitter_api_key'] : '') ;
$jr_fetchwitter_api_secret = ($jr_fetchwitter_options && $jr_fetchwitter_options['jr_fetchwitter_api_secret']) ? $jr_fetchwitter_options['jr_fetchwitter_api_secret'] : (isset($_POST['jr_fetchwitter_api_secret']) ? $_POST['jr_fetchwitter_api_secret'] : '') ;
$jr_fetchwitter_api_access_key = ($jr_fetchwitter_options && $jr_fetchwitter_options['jr_fetchwitter_api_access_key']) ? $jr_fetchwitter_options['jr_fetchwitter_api_access_key'] : '' ;

$form_action_target = admin_url( htmlentities( basename($_SERVER['PHP_SELF']) . '?' . $_SERVER['QUERY_STRING'] ) );

?>
<div class="wrap">
	<h2><?php echo __('Fetchwitter for WordPress'); ?></h2>
	<form name="form" id="form" method="post" action="<?php echo $form_action_target; ?>">
		<p>Fetchwitter requires Twitter App <strong>Key</strong> and <strong>Secret</strong> in order to work properly. Start with creating an app at <strong>Twitter Application Manager</strong> (https://apps.twitter.com) and retrieve the API Key and API Secret from app settings. Enter the both keys in following fields and press “Save Changes” to update the information.</p>

		<?php if ( isset($jr_fetchwitter_info['message']) && $jr_fetchwitter_info['message'] ) : ?>
			<div class="<?php echo $jr_fetchwitter_info['type']; ?>">
				<p><?php echo $jr_fetchwitter_info['message']; ?></p>
			</div>
		<?php endif; ?>
		
		<table class="form-table">
			<tr>
				<th>
					<label for="jr_fetchwitter_api_key">API Key:</label>
				</th>
				<td>
					<input type="text" class="regular-text code" name="jr_fetchwitter_api_key" id="jr_fetchwitter_api_key" value="<?php echo $jr_fetchwitter_api_key; ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="jr_fetchwitter_api_secret">API Secret:</label>
				</th>
				<td>
					<input type="text" class="regular-text code" name="jr_fetchwitter_api_secret" id="jr_fetchwitter_api_secret" value="<?php echo $jr_fetchwitter_api_secret; ?>">
				</td>
			</tr>
			<?php if ( $jr_fetchwitter_api_access_key ) : ?>
			<tr>
				<th>API Access Token:</th>
				<td>
					<code><?php echo $jr_fetchwitter_api_access_key; ?></code>
					<br>
					<p class="description">
						<small>Consider API Access Token as a password. Keep it safe and never share it.</small>
					</p>
					<p>You can now use the <a href="<?php echo admin_url(); ?>widgets.php">Fetchwitter Widget</a> to place the Tweets anywhere in your WordPress Theme.</p>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th>&nbsp;</th>
				<td class="submit">
					<input type="submit" class="button button-primary" name="jr_fetchwitter_submit" id="jr_fetchwitter_submit" value="Save Changes">
				</td>
			</tr>
		</table>
		<input type="hidden" name="jr_fetchwitter_api_access_key" id="jr_fetchwitter_api_access_key" value="<?php echo $jr_fetchwitter_api_access_key; ?>">
		<?php wp_nonce_field( 'update-api-info', 'jr_fetchwitter_wp_nonce', '', true  ); ?>
	</form>

<p>&nbsp;</p>

<hr>
<div>
	<p>
		“Fetchwitter for WordPress” by Jabran Rafique is based on “Fetchwitter”. Code for both of these projects is open-sourced and available at Github for contribution and public use.
		<br>
		<a href="http://j.mp/fetchwitter-for-wordpress" target="_blank">Fetchwitter for WordPress at Github</a> | <a title="Report an issue/bug" href="http://j.mp/fetchwitter-wp-issues" target="_blank">Report an issue / bug</a>
		<br>
		<a href="http://j.mp/fetchwitter" target="_blank">Fetchwitter at Github</a>
	</p>
	<p>
		&copy; <?php echo date('Y'); ?> &ndash; <a href="http://jabran.me" target="_blank">Jabran Rafique</a> &ndash; MIT License
	</p>
</div>

</div>