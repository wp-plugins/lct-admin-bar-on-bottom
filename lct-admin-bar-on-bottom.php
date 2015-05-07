<?php /*
Plugin Name: LCT Admin Bar on Bottom
Plugin URI: http://lookclassy.com/wordpress-plugins/admin-bar-on-bottom/
Version: 4.2.2
Text Domain: lct-admin-bar-on-bottom
Author: Look Classy Technologies
Author URI: http://lookclassy.com/
License: GPLv3 (http://opensource.org/licenses/GPL-3.0)
Description: This plugin sticks the Admin Bar to the bottom of your screen! You can choose to make this change on the front-end, back-end or both
Also Available in lct-useful-shortcodes-functions
Copyright 2014 Look Classy Technologies  (email : info@lookclassy.com)
*/

/*
Copyright (C) 2014 Look Classy Technologies

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


//PLUGIN PREFIX: labob


if( ! class_exists( 'g_labob' ) ) {
	class g_labob {
	 	public $editzz						= 'editzz';
		public $pre							= 'labob_';
		public $dash						= 'lct-admin-bar-on-bottom';
		public $us							= 'lct_admin_bar_on_bottom';

		public function __construct() {
			$this->plugin_file				= __FILE__;
			$this->plugin_dir_url			= plugin_dir_url( __FILE__ );
			$this->plugin_dir_path			= plugin_dir_path( __FILE__ );
		}
	}
}

if( ! function_exists( 'is_plugin_active' ) ) { include_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
if( ! is_plugin_active( 'lct-useful-shortcodes-functions/lct-useful-shortcodes-functions.php' ) ) {
	//Globals
	$g_labob = new g_labob;


	add_action( 'admin_init', 'lct_admin_bar_on_bottom_back_css' );
	function lct_admin_bar_on_bottom_back_css() {
		global $g_labob;
		$user = wp_get_current_user();

		if( get_the_author_meta( $g_labob->us . '_back', $user->ID ) )
			wp_enqueue_style( $g_labob->pre . 'back', $g_labob->plugin_dir_url . 'assets/css/' . $g_labob->pre . 'back.css' );

		wp_enqueue_style( $g_labob->pre . 'profile', $g_labob->plugin_dir_url . 'assets/css/' . $g_labob->pre . 'profile.css' );
	}


	add_action( 'wp_enqueue_scripts', 'lct_admin_bar_on_bottom_front_css' );
	function lct_admin_bar_on_bottom_front_css() {
		global $g_labob;
		$user = wp_get_current_user();

		if( get_the_author_meta( $g_labob->us . '_front', $user->ID ) )
			wp_enqueue_style( $g_labob->pre . 'front', $g_labob->plugin_dir_url . 'assets/css/' . $g_labob->pre . 'front.css' );
	}


	add_action( 'show_user_profile', $g_labob->us . '_extra_profile_fields' );
	add_action( 'edit_user_profile', $g_labob->us . '_extra_profile_fields' );
	function lct_admin_bar_on_bottom_extra_profile_fields( $user ) {
		global $g_labob; ?>

		<div id="lct-admin-bar-on-bottom">
			<h3>Admin Bar Settings (wpadminbar)</h3>

			<div class="setting-group">
				<h3>Put admin bar at the bottom of the browser window</h3>

				<table class="form-table">
					<tr>
						<th><label for="<?php echo $g_labob->us; ?>_front">Front-end</label></th>
						<td>
							<?php get_the_author_meta( $g_labob->us . '_front', $user->ID ) ? $checked = 'checked="checked"' : $checked = ''; ?>
							<input type="checkbox" name="<?php echo $g_labob->us; ?>_front" value="1" <?php echo $checked; ?> />
						</td>
					</tr>
					<tr>
						<th><label for="<?php echo $g_labob->us; ?>_back">Back-end</label></th>
						<td>
							<?php get_the_author_meta( $g_labob->us . '_back', $user->ID ) ? $checked = 'checked="checked"' : $checked = ''; ?>
							<input type="checkbox" name="<?php echo $g_labob->us; ?>_back" value="1" <?php echo $checked; ?> />
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php }


	add_action( 'personal_options_update', 'save_' . $g_labob->us . '_extra_profile_fields' );
	add_action( 'edit_user_profile_update', 'save_' . $g_labob->us . '_extra_profile_fields' );
	function save_lct_admin_bar_on_bottom_extra_profile_fields( $user_id ) {
		global $g_labob;
		if( ! current_user_can( 'edit_user', $user_id ) ) return false;

		update_usermeta( $user_id, $g_labob->us . '_front', $_POST[$g_labob->us . '_front'] );
		update_usermeta( $user_id, $g_labob->us . '_back', $_POST[$g_labob->us . '_back'] );
	}
}
