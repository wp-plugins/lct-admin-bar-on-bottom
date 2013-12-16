<?php
/*
Plugin Name: LCT Admin Bar on Bottom
Plugin URI: http://lookclassy.com/wordpress-plugins/lct-admin-bar-on-bottom/
Description: This plugin sticks the Admin Bar to the bottom of your screen! You can choose to make this change on the front-end, back-end or both
Version: 1.0
Text Domain: lct-admin-bar-on-bottom
Author: Look Classy Technologies
Author URI: http://lookclassy.com/
License: GPLv3 (http://opensource.org/licenses/GPL-3.0)
Copyright 2013 Look Classy Technologies  (email : info@lookclassy.com)
*/

/*
Copyright (C) 2013 Look Classy Technologies

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


add_action('admin_init', 'lct_admin_bar_on_bottom_back_css');
function lct_admin_bar_on_bottom_back_css() {
	$user = wp_get_current_user();

	if(get_the_author_meta('lct_admin_bar_on_bottom_back', $user->ID))
		wp_enqueue_style('bottom-back', plugins_url('css/back.css', __FILE__));

	wp_enqueue_style('lct-admin-bar-on-bottom-profile', plugins_url('css/profile.css', __FILE__));
}


add_action('wp_enqueue_scripts', 'lct_admin_bar_on_bottom_front_css');
function lct_admin_bar_on_bottom_front_css() {
	$user = wp_get_current_user();

	if(get_the_author_meta('lct_admin_bar_on_bottom_front', $user->ID))
		wp_enqueue_style('lct_admin_bar_on_bottom_front', plugins_url('css/front.css', __FILE__));
}


/* add_action('wp_head', 'lct_admin_bar_on_bottom_front_css_style',99999);
function lct_admin_bar_on_bottom_front_css_style() {
	$user = wp_get_current_user();

	if(get_the_author_meta('lct_admin_bar_on_bottom_front', $user->ID)){ ?>
		<style>
		html{
			margin-top: 0px !important;
		}
		* html body{
			margin-top: 0px !important;
		}
		@media screen and (max-width: 782px) {
			html{
				margin-top: 0px !important;
			}
			* html body{
				margin-top: 0px !important;
			}
		}
		</style>
	<?php }
} */


add_action('show_user_profile', 'lct_admin_bar_on_bottom_extra_profile_fields');
add_action('edit_user_profile', 'lct_admin_bar_on_bottom_extra_profile_fields');
function lct_admin_bar_on_bottom_extra_profile_fields($user) { ?>
	<div id="lct-admin-bar-on-bottom">
		<h3>Admin Bar Settings (wpadminbar)</h3>
		<div class="setting-group">
			<h3>Put admin bar at the bottom of the browser window</h3>

			<table class="form-table">
				<tr>
					<th><label for="lct_admin_bar_on_bottom_front">Front-end</label></th>
					<td>
						<?php get_the_author_meta('lct_admin_bar_on_bottom_front', $user->ID) ? $checked = 'checked="checked"' : $checked = ''; ?>
						<input type="checkbox" name="lct_admin_bar_on_bottom_front" value="1" <?php echo $checked; ?> />
					</td>
				</tr>
				<tr>
					<th><label for="lct_admin_bar_on_bottom_back">Back-end</label></th>
					<td>
						<?php get_the_author_meta('lct_admin_bar_on_bottom_back', $user->ID) ? $checked = 'checked="checked"' : $checked = ''; ?>
						<input type="checkbox" name="lct_admin_bar_on_bottom_back" value="1" <?php echo $checked; ?> />
					</td>
				</tr>
			</table>
		</div>
	</div>
<?php }


add_action('personal_options_update', 'save_lct_admin_bar_on_bottom_extra_profile_fields');
add_action('edit_user_profile_update', 'save_lct_admin_bar_on_bottom_extra_profile_fields');
function save_lct_admin_bar_on_bottom_extra_profile_fields($user_id) {
	if(! current_user_can('edit_user', $user_id)) return false;
	update_usermeta($user_id, 'lct_admin_bar_on_bottom_front', $_POST['lct_admin_bar_on_bottom_front']);
	update_usermeta($user_id, 'lct_admin_bar_on_bottom_back', $_POST['lct_admin_bar_on_bottom_back']);
} ?>
