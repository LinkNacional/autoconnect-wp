<?php

/**
 * Uninstall Lkn_Give_Cielo_Api
 *
 * @package     Give
 * @subpackage  Uninstall
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('lkn_autoconnect_wp_cli_website');
delete_option('lkn_autoconnect_wp_identifier');
