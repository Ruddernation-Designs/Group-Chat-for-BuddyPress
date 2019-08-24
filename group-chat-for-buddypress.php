<?php
/*
* Plugin Name: Group Chat for BuddyPress
* Plugin URI: https://github.com/Ruddernation-Designs/group-chat-for-buddypress/
* Author: Ruddernation Designs
* Author URI: https://profiles.wordpress.org/ruddernationdesigns
* Description: This plugin is used for BuddyPress to allow group creators to add TinyChat to the group using the same name as the group.
* Version: 1.0.1
* Requires at least: WordPress 5.0.0, BuddyPress 4.0.0
* Tested up to: WordPress 5.2.2, BuddyPress 4.4.0
* Network: true
* Date: 22nd August 2019
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/
function bp_tinychat_group_chat_init() {
	    global $wpdb;
    if ( is_multisite() && BP_ROOT_BLOG != $wpdb->blogid ) {
	return;
    }
    if ( ! bp_is_active( 'groups' ) ) {
	return;
    }
	require( dirname( __FILE__ ) . '/chat-core.php' );}
add_action( 'bp_include', 'bp_tinychat_group_chat_init' , 96);
function bp_tinychat_group_chat_activate() {
	global $wpdb;
	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
$sql[] = "CREATE TABLE {$wpdb->base_prefix}bp_tinychat_group_chat (
id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
group_id bigint(20) NOT NULL,
user_id bigint(20) NOT NULL,
message_content text) {$charset_collate};";
	$sql[] = "CREATE TABLE {$wpdb->base_prefix}bp_tinychat_group_chat_online (
id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
group_id bigint(20) NOT NULL,
user_id bigint(20) NOT NULL,
timestamp int(11) NOT NULL) {$charset_collate};";
	require_once( ABSPATH . 'wp-admin/upgrade-functions.php' );
	dbDelta($sql);
	update_site_option( 'bp-tinychat-group-chat-db-version', BP_TINYCHAT_GROUP_CHAT_DB_VERSION );
}
register_activation_hook( __FILE__, 'bp_tinychat_group_chat_activate' ); ?>
