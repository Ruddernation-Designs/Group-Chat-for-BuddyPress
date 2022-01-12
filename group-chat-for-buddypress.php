<?php
/*
* Plugin Name: Video Chat for BuddyPress Groups -Discontinued
* Plugin URI: https://wordpress.org/plugins/bp-group-chat/
* Author: ruddernationdesigns
* Author URI: https://profiles.wordpress.org/ruddernationdesigns
* Description: This plugin is used for BuddyPress to allow group creators to add TinyChat to the group using the same name as the group.
You now have to register to use the chat, you can do that at https://tinychat.com , This now includes a dark mode, YouTube is back!.
* Version: 1.2.4
* Requires at least: WordPress 4.0, BuddyPress 4.0
* Tested up to: 5.8.2
* Network: true
* Date: 12 January 2022
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
	require( dirname( __FILE__ ) . '/chat-core.php' );
}
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
			update_site_option( 'bp-tinychat-group-chat-db-version', bp_tinychat_group_chat_db_version );
}
	register_activation_hook( __FILE__, 'bp_tinychat_group_chat_activate' ); ?>
