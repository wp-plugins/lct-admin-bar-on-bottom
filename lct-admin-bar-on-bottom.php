<?php /*
Plugin Name: LCT Admin Bar on Bottom
Plugin URI: http://lookclassy.com/wordpress-plugins/admin-bar-on-bottom/
Version: 1.2.1
Text Domain: lct-admin-bar-on-bottom
Author: Look Classy Technologies
Author URI: http://lookclassy.com/
License: GPLv3 (http://opensource.org/licenses/GPL-3.0)
Description: This plugin sticks the Admin Bar to the bottom of your screen! You can choose to make this change on the front-end, back-end or both
Copyright 2013 Look Classy Technologies  (email : info@lookclassy.com)
*/

/*
Copyright (C) 2013 Look Classy Technologies

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


//Globals
$lct_G = array();
$lct_G['editzz']					= 'editzz';
$lct_G['lct_text_domain']			= 'lct-admin-bar-on-bottom';
$lct_G['lct_plugin_base']			= 'lct_admin_bar_on_bottom';
$lct_G['plugin_file']				= __FILE__;
$lct_G['plugin_dir_url']			= plugin_dir_url( __FILE__ );
$lct_G['plugin_dir_path']			= plugin_dir_path( __FILE__ );


add_action( 'admin_init', $lct_G['lct_plugin_base'] . '_back_css' );
function lct_admin_bar_on_bottom_back_css() {
	global $lct_G;
	$user = wp_get_current_user();

	if( get_the_author_meta( $lct_G['lct_plugin_base'] . '_back', $user->ID ) )
		wp_enqueue_style( 'bottom-back', plugins_url( 'css/back.css', __FILE__ ) );

	wp_enqueue_style( 'lct-admin-bar-on-bottom-profile', plugins_url( 'css/profile.css', __FILE__ ) );
}


add_action( 'wp_enqueue_scripts', $lct_G['lct_plugin_base'] . '_front_css' );
function lct_admin_bar_on_bottom_front_css() {
	global $lct_G;
	$user = wp_get_current_user();

	if( get_the_author_meta( $lct_G['lct_plugin_base'] . '_front', $user->ID ) )
		wp_enqueue_style( $lct_G['lct_plugin_base'] . '_front', plugins_url( 'css/front.css', __FILE__ ) );
}


add_action( 'show_user_profile', $lct_G['lct_plugin_base'] . '_extra_profile_fields' );
add_action( 'edit_user_profile', $lct_G['lct_plugin_base'] . '_extra_profile_fields' );
function lct_admin_bar_on_bottom_extra_profile_fields( $user ) {
	global $lct_G; ?>

	<div id="lct-admin-bar-on-bottom">
		<h3>Admin Bar Settings (wpadminbar)</h3>

		<div class="setting-group">
			<h3>Put admin bar at the bottom of the browser window</h3>

			<table class="form-table">
				<tr>
					<th><label for="<?php echo $lct_G['lct_plugin_base']; ?>_front">Front-end</label></th>
					<td>
						<?php get_the_author_meta( $lct_G['lct_plugin_base'] . '_front', $user->ID ) ? $checked = 'checked="checked"' : $checked = ''; ?>
						<input type="checkbox" name="<?php echo $lct_G['lct_plugin_base']; ?>_front" value="1" <?php echo $checked; ?> />
					</td>
				</tr>
				<tr>
					<th><label for="<?php echo $lct_G['lct_plugin_base']; ?>_back">Back-end</label></th>
					<td>
						<?php get_the_author_meta( $lct_G['lct_plugin_base'] . '_back', $user->ID ) ? $checked = 'checked="checked"' : $checked = ''; ?>
						<input type="checkbox" name="<?php echo $lct_G['lct_plugin_base']; ?>_back" value="1" <?php echo $checked; ?> />
					</td>
				</tr>
			</table>
		</div>
	</div>
<?php }


add_action( 'personal_options_update', 'save_' . $lct_G['lct_plugin_base'] . '_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_' . $lct_G['lct_plugin_base'] . '_extra_profile_fields' );
function save_lct_admin_bar_on_bottom_extra_profile_fields( $user_id ) {
	global $lct_G;
	if( ! current_user_can( 'edit_user', $user_id ) ) return false;

	update_usermeta( $user_id, $lct_G['lct_plugin_base'] . '_front', $_POST[$lct_G['lct_plugin_base'] . '_front'] );
	update_usermeta( $user_id, $lct_G['lct_plugin_base'] . '_back', $_POST[$lct_G['lct_plugin_base'] . '_back'] );
} ?>
