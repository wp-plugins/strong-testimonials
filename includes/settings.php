<?php
/**
 * Settings
 *
 * @package Strong_Testimonials
 */
 
 
/*
 * Menus
 */
function wpmtst_settings_menu() {
	add_submenu_page( 'edit.php?post_type=wpm-testimonial', // $parent_slug
										'Settings',                           // $page_title
										'Settings',                           // $menu_title
										'manage_options',                     // $capability
										'settings',                           // $menu_slug
										'wpmtst_settings_page' );             // $function

	add_submenu_page( 'edit.php?post_type=wpm-testimonial',
										'Fields',
										'Fields',
										'manage_options',
										'fields',
										'wpmtst_settings_custom_fields' );

	add_submenu_page( 'edit.php?post_type=wpm-testimonial',
										'Shortcodes',
										'Shortcodes',
										'manage_options',
										'shortcodes',
										'wpmtst_settings_shortcodes' );

	add_submenu_page( 'edit.php?post_type=wpm-testimonial',
										'Guide',
										'<div class="dashicons dashicons-info"></div> Guide',
										'manage_options',
										'guide',
										'wpmtst_guide' );
										
	add_action( 'admin_init', 'wpmtst_register_settings' );
}
add_action( 'admin_menu', 'wpmtst_settings_menu' );


/*
 * Make admin menu title unique if necessary.
 */
function wpmtst_unique_menu_title() {
	$need_unique = false;

	// GC Testimonials
	if ( is_plugin_active( 'gc-testimonials/testimonials.php' ) )
		$need_unique = true;

	// Testimonials by Aihrus
	if ( is_plugin_active( 'testimonials-widget/testimonials-widget.php' ) )
		$need_unique = true;

	// Clean Testimonials
	if ( is_plugin_active( 'clean-testimonials/clean-testimonials.php' ) )
		$need_unique = true;
		
	if ( ! $need_unique )
		return;

	global $menu;

	foreach ( $menu as $key => $menu_item ) {
		// set unique menu title
		if ( 'Testimonials' == $menu_item[0] && 'edit.php?post_type=wpm-testimonial' == $menu_item[2] ) {
			$menu[$key][0] = 'Strong Testimonials';
		}
	}
}
add_action( 'admin_menu', 'wpmtst_unique_menu_title', 100 );


/*
 * Register settings
 */
function wpmtst_register_settings() {
	register_setting( 'wpmtst-settings-group', 'wpmtst_options', 'wpmtst_sanitize_options' );
	register_setting( 'wpmtst-cycle-group', 'wpmtst_cycle', 'wpmtst_sanitize_cycle' );
}


/*
 * Sanitize general settings
 */
function wpmtst_sanitize_options( $input ) {
	$input['per_page']          = (int) sanitize_text_field( $input['per_page'] );
	$input['admin_notify']      = isset( $input['admin_notify'] ) ? 1 : 0;
	$input['admin_email']       = sanitize_email( $input['admin_email'] );
	$input['honeypot_before']   = isset( $input['honeypot_before'] ) ? 1 : 0;
	$input['honeypot_after']    = isset( $input['honeypot_after'] ) ? 1 : 0;
	$input['load_page_style']   = isset( $input['load_page_style'] ) ? 1 : 0;
	$input['load_widget_style'] = isset( $input['load_widget_style'] ) ? 1 : 0;
	$input['load_form_style']   = isset( $input['load_form_style'] ) ? 1 : 0;
	return $input;
}


/*
 * Sanitize cycle settings
 */
function wpmtst_sanitize_cycle( $input ) {
	// an unchecked checkbox is not posted
	// radio buttons always return a value, no need to sanitize
	
	$input['category']   = strip_tags( $input['category'] );
	// $input['order']
	// $input['all']
	$input['limit']      = (int) strip_tags( $input['limit'] );
	$input['title']      = isset( $input['title'] ) ? 1 : 0;
	// $input['content']
	$input['char_limit'] = (int) sanitize_text_field( $input['char_limit'] );
	$input['images']     = isset( $input['images'] ) ? 1 : 0;
	$input['client']     = isset( $input['client'] ) ? 1 : 0;
	// $input['more']
	$input['more_page']  = strip_tags( $input['more_page'] );
	$input['timeout']    = (float) sanitize_text_field( $input['timeout'] );
	$input['effect']     = strip_tags( $input['effect'] );
	$input['speed']      = (float) sanitize_text_field( $input['speed'] );
	$input['pause']      = isset( $input['pause'] ) ? 1 : 0;
	
	return $input;
}


/*
 * Settings page
 */
function wpmtst_settings_page() {
	if ( ! current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	?>
	<div class="wrap wpmtst">

		<h2><?php _e( 'Testimonial Settings', 'strong-testimonials' ); ?></h2>

		<?php if( isset( $_GET['settings-updated'] ) ) : ?>
			<div id="message" class="updated">
				<p><strong><?php _e( 'Settings saved.' ) ?></strong></p>
			</div>
		<?php endif; ?>

		<?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general'; ?>
		<h2 class="nav-tab-wrapper">
			<a href="?post_type=wpm-testimonial&page=settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General', 'strong-testimonials' ); ?></a>
			<a href="?post_type=wpm-testimonial&page=settings&tab=cycle" class="nav-tab <?php echo $active_tab == 'cycle' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Cycle Shortcode', 'strong-testimonials' ); ?></a>
			<a href="?post_type=wpm-testimonial&page=settings&tab=client" class="nav-tab <?php echo $active_tab == 'client' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Client Section', 'strong-testimonials' ); ?></a>
		</h2>

		<form method="post" action="options.php">
			<?php
			if( $active_tab == 'cycle' ) {
				settings_fields( 'wpmtst-cycle-group' );
				wpmtst_cycle_section();
			}
			elseif( $active_tab == 'client' ) {
				settings_fields( 'wpmtst-settings-group' );
				wpmtst_client_section();
			}
			else {  // general tab
				settings_fields( 'wpmtst-settings-group' );
				wpmtst_settings_section();
			} 
			?>
			<p class="submit">
				<input id="submit" class="button button-primary" type="submit" value="Save Changes" name="submit">
				<span class="reminder"><?php _e( 'Remember to save changes before switching tabs.', 'strong-testimonials' ); ?></span>
			</p>
		</form>

	</div><!-- wrap -->

	<?php
}


/*
 * General settings
 */
function wpmtst_settings_section() {
	$options = get_option( 'wpmtst_options' );

	// ----------------------------------------
	// Build list of supported Captcha plugins.
	// ----------------------------------------
	// @TODO - Move this to options array
	$plugins = array(
			'bwsmath' => array(
					'name' => 'Captcha by BestWebSoft',
					'file' => 'captcha/captcha.php',
					'settings' => 'admin.php?page=captcha.php',
					'search' => 'plugin-install.php?tab=search&s=Captcha',
					'url'  => 'http://wordpress.org/plugins/captcha/',
					'installed' => false,
					'active' => false
			),
			'miyoshi' => array(
					'name' => 'Really Simple Captcha by Takayuki Miyoshi',
					'file' => 'really-simple-captcha/really-simple-captcha.php',
					'search' => 'plugin-install.php?tab=search&s=Really+Simple+Captcha',
					'url'  => 'http://wordpress.org/plugins/really-simple-captcha/',
					'installed' => false,
					'active' => false
			),
			'wpmsrc'  => array(
					'name' => 'Simple reCAPTCHA by WP Mission',
					'file' => 'simple-recaptcha/simple-recaptcha.php',
					'settings' => 'options-general.php?page=simple-recaptcha.php',
					'search' => 'plugin-install.php?tab=search&s=Simple+reCAPTCHA',
					'url'  => 'http://wordpress.org/plugins/simple-recaptcha',
					'installed' => false,
					'active' => false
			),
	);

	foreach ( $plugins as $key => $plugin ) {
	
		if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin['file'] ) ) 
			$plugins[$key]['installed'] = true;
			
		$plugins[$key]['active'] = is_plugin_active( $plugin['file'] );
		
		// If current Captcha plugin has been deactivated, disable Captcha
		// so corresponding div does not appear on front-end form.
		if ( $key == $options['captcha'] && ! $plugins[$key]['active'] ) {
			$options['captcha'] = '';
			update_option( 'wpmtst_options', $options );
		}
		
	}
	
	include( WPMTST_INC . 'form-general-settings.php' );
}


/*
 * Client section settings
 */
function wpmtst_client_section() {
	$options = get_option( 'wpmtst_options' );

	// ----------------------------
	// Build list of custom fields.
	// ----------------------------
	$field_options = get_option( 'wpmtst_fields' );
	$field_groups = $field_options['field_groups'];
	$current_field_group = $field_options['current_field_group'];  // "custom", only one for now
	$fields = $field_groups[$current_field_group]['fields'];
	$fields_array = array();
	foreach ( $fields as $field ) {
		$field_name = $field['name'];
		if ( ! in_array( $field['name'], array( 'post_title', 'post_content', 'featured_image' ) ) )
			$fields_array[] = '<span class="code wide">' . $field['name'] . '</span>';
	}
	
	include( WPMTST_INC . 'form-client-settings.php' );
}


/*
 * Cycle shortcode settings
 */
function wpmtst_cycle_section() {
	$cycle = get_option( 'wpmtst_cycle' );
	
	// @TODO: de-duplicate (in widget too)
	$order_list = array(
			'rand'   => __( 'Random', 'strong-testimonials' ),
			'recent' => __( 'Newest first', 'strong-testimonials' ),
			'oldest' => __( 'Oldest first', 'strong-testimonials' ),
	);

	$category_list = get_terms( 'wpm-testimonial-category', array(
			'hide_empty' 	=> false,
			'order_by'		=> 'name',
			'pad_counts'	=> true
	) );

	$pages_list = get_pages( array(
			'sort_order'  => 'ASC',
			'sort_column' => 'post_title',
			'post_type'   => 'page',
			'post_status' => 'publish'
	) );
	
	include( WPMTST_INC . 'form-cycle-settings.php' );
}


/*
 * Shortcodes page
 */
function wpmtst_settings_shortcodes() {
	?>
	<div class="wrap wpmtst">

		<h2><?php _e( 'Shortcodes', 'strong-testimonials' ); ?></h2>

		<?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'strong'; ?>
		<h2 class="nav-tab-wrapper">
			<a href="?post_type=wpm-testimonial&page=shortcodes" class="nav-tab <?php echo $active_tab == 'strong' ? 'nav-tab-active' : ''; ?>"><span class="strong-tab-label">strong</span></a>
			<a href="?post_type=wpm-testimonial&page=shortcodes&tab=original" class="nav-tab <?php echo $active_tab == 'original' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Original', 'strong-testimonials' ); ?></a>
		</h2>

		<?php
		if( $active_tab == 'original' ) {
			include( WPMTST_INC . 'settings-shortcodes.php' );
		}
		else {
			include( WPMTST_INC . 'settings-shortcodes-strong.php' );
		} 
		?>
		

	</div><!-- wrap -->
	<?php
}


/*
 * [Restore Default Template] event handler
 */
function wpmtst_restore_default_template_script() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#restore-default-template").click(function(e){
			var data = {
				'action' : 'wpmtst_restore_default_template',
			};
			$.get( ajaxurl, data, function( response ) {
				$("#client-section").val(response);
			});
		});
	});
	</script>
	<?php
}
add_action( 'admin_footer', 'wpmtst_restore_default_template_script' );


/*
 * [Restore Default Template] Ajax receiver
 */
function wpmtst_restore_default_template_function() {
	$options = get_option( 'wpmtst_options' );
	$template = $options['default_template'];
	echo $template;
	die();
}
add_action( 'wp_ajax_wpmtst_restore_default_template', 'wpmtst_restore_default_template_function' );
