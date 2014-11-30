<?php
/**
 * Settings > Form tab
 *
 * @package Strong_Testimonials
 * @since 1.13
 */
 
?>
<p>
	<em><?php printf( __( 'Customize the form fields <a href="%s">here</a>.', 'strong-testimonials' ), admin_url( 'edit.php?post_type=wpm-testimonial&page=fields' ) ); ?></em>
</p>

<h3><?php _e( 'Labels & Messages', 'strong-testimonials' ); ?></h3>

<table class="form-table multiple compact" cellpadding="0" cellspacing="0">
	<?php $messages = $form_options['messages']; ?>
	<?php foreach ( $messages as $key => $message ) : ?>
	<tr>
		<td>
			<?php echo $messages[$key]['description']; ?>
			<input type="hidden" name="wpmtst_form_options[messages][<?php echo $key; ?>][description]" value="<?php esc_attr_e( $messages[$key]['description'] ); ?>" />
		</td>
		<td>
			<input type="text" id="<?php echo $key; ?>" name="wpmtst_form_options[messages][<?php echo $key; ?>][text]" size="" value="<?php echo esc_attr( $messages[$key]['text'] ); ?>" required />
		</td>
		<td class="actions">
			<input type="button" class="button button-small secondary restore-default-message" value="<?php _ex( 'restore default', 'singular', 'strong-testimonials' ); ?>" />
		</td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan="3">
			<input type="button" value="<?php _ex( 'Restore Defaults', 'multiple', 'strong-testimonials' ); ?>" class="button" id="restore-default-messages" name="restore-default-messages">
		</td>
	</tr>
</table>


<h3><?php _ex( 'Actions', 'noun', 'strong-testimonials' );?></h3>

<table class="form-table multiple" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<?php _e( 'Post status', 'strong-testimonials' ); ?>
		</td>
		<td>
			<ul class="compact">
				<li>
					<label>
						<input type="radio" name="wpmtst_form_options[post_status]" <?php checked( 'pending', $form_options['post_status'] ); ?> value="pending" />
						<?php _e( 'Pending' ); ?>
					</label>
				</li>
				<li>
					<label>
						<input type="radio" name="wpmtst_form_options[post_status]" <?php checked( 'publish', $form_options['post_status'] ); ?> value="publish" />
						<?php _e( 'Published' ); ?>
					</label>
				</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<?php _e( 'Notification', 'strong-testimonials' ); ?>
		</td>
		<td>
			<label>
				<input id="wpmtst-options-admin-notify" type="checkbox" name="wpmtst_form_options[admin_notify]" <?php checked( $form_options['admin_notify'] ); ?> />
				<?php _e( 'Send email to', 'strong-testimonials' ); ?>
			</label>
			<input id="wpmtst-options-admin-email" type="email" size="30" placeholder="email address" name="wpmtst_form_options[admin_email]" value="<?php echo esc_attr( $form_options['admin_email'] ); ?>" />
		</td>
	</tr>
</table>


<h3><?php _e( 'Spam Control', 'strong-testimonials' );?></h3>

<table class="form-table multiple" cellpadding="0" cellspacing="0">
	<tr>
		<td class="align-top">
			<p><?php _ex( 'Honeypot', 'spam control techniques', 'strong-testimonials' ); ?></p>
		</td>
		<td>
			<p><?php _e( 'These methods are both time-tested and widely used. They can be used simultaneously for more protection.', 'strong-testimonials' ); ?></p>
			<ul>
				<li class="checkbox">
					<input type="checkbox" name="wpmtst_form_options[honeypot_before]" <?php checked( $form_options['honeypot_before'] ); ?> />
					<?php _e( 'Before', 'strong-testimonials' ); ?>
					<p class="description"><?php _e( 'Traps spambots by adding an extra empty field that is invisible to humans but not to spambots which tend to fill in every field they find in the form code. Empty field = human. Not empty = spambot.', 'strong-testimonials' ); ?></p>
				</li>
				<li class="checkbox">
					<input type="checkbox" name="wpmtst_form_options[honeypot_after]" <?php checked( $form_options['honeypot_after'] ); ?> />
					<?php _e( 'After', 'strong-testimonials' ); ?>
					<p class="description"><strong><?php _e( 'Recommended.', 'strong-testimonials' ); ?></strong> <?php _e( 'Traps spambots by using JavaScript to add a new field as soon as the form is submitted. Since spambots cannot run JavaScript, the new field never gets added. New field = human. Missing = spambot.', 'strong-testimonials' ); ?></p>
				</li>
			</ul>
		</td>
	</tr>
	<tr valign="top">
		<td class="align-top">
			<p><?php _e( 'Captcha', 'strong-testimonials' ); ?></strong>
		</td>
		<td class="stackem">
			<p><?php _e( 'Can be used alongside honeypot methods. Be sure to configure any plugins first, if necessary.', 'strong-testimonials' ); ?></p>
			<ul>
				<li>
					<label>
						<input type="radio" id="" name="wpmtst_form_options[captcha]" <?php checked( '', $form_options['captcha'] ); ?> value="" /> none
					</label>
				</li>
				
				<?php foreach ( $plugins as $key => $plugin ) : ?>
				<li>
					<label class="inline <?php if ( ! $plugin['active'] ) echo 'disabled'; ?>">
						<input type="radio" id="" name="wpmtst_form_options[captcha]" <?php disabled( ! $plugin['active'] ); ?><?php checked( $key, $form_options['captcha'] ); ?> value="<?php echo $key; ?>" />
						<?php echo $plugin['name']; ?>
					</label>	
					
					<?php if ( isset( $plugin['installed'] ) && $plugin['installed'] ) : ?>
					
						<?php if ( $plugin['active'] ) : ?>
						
							<?php if ( isset( $plugin['settings'] ) && $plugin['settings'] ) : ?>
								<span class="link"><a href="<?php echo $plugin['settings']; ?>"><?php _ex( 'settings', 'link', 'strong-testimonials' ); ?></a></span> |
							<?php else : ?>
								<span class="notice"><?php _e( 'no settings', 'strong-testimonials' ); ?></span> |
							<?php endif; ?>
							
						<?php else : ?>
							
							<span class="notice disabled"><?php _ex( 'inactive', 'adjective', 'strong-testimonials' ); ?></span> |
							
						<?php endif; ?>
						
					<?php else : ?>
					
						<span class="notice disabled">(<?php _e( 'not installed', 'strong-testimonials' ); ?>)</span> |
						<span class="link"><a href="<?php echo $plugin['search']; ?>"><?php _ex( 'install plugin', 'link', 'strong-testimonials' ); ?></a></span> |
						
					<?php endif; ?>
					
					<span class="link"><a href="<?php echo $plugin['url']; ?>" target="_blank"><?php _ex( 'plugin page', 'link', 'strong-testimonials' ); ?></a></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>
</table>
