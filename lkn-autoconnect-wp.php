<?php
/**
 * Plugin Name: Autoconnect WP
 * Plugin URI:  https://www.linknacional.com.br/wordpress/
 * Description: WordPress website admin page login.
 * Version:     1.0.0
 * Author:      Link Nacional
 * Author URI:  https://www.linknacional.com.br
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lkn-admin-plugin
 */

// Exit if accessed directly. ABSPATH is attribute in wp-admin - plugin.php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Lkn_Autoconnect_WP
 */
final class Lkn_Autoconnect_WP {
    /**
     * Instance.
     *
     * @since
     * @access private
     * @var Lkn_Autoconnect_WP
     */
    private static $instance;

    /**
     * Singleton pattern.
     *
     * @since
     * @access private
     */
    private function __construct() {
    }

    /**
     * Get instance.
     *
     * @return Lkn_Autoconnect_WP
     * @since
     * @access public
     *
     */
    public static function get_instance() {
        if (!isset(self::$instance) && !(self::$instance instanceof Lkn_Autoconnect_WP)) {
            self::$instance = new Lkn_Autoconnect_WP();
            self::$instance->setup();
        }

        return self::$instance;
    }

    /**
     * Setup
     *
     * @since
     * @access private
     */
    private function setup() {
        self::$instance->setup_constants();

        register_activation_hook(LKN_AUTOCONNECT_WP_FILE, [$this, 'install']);
        // add_action('woocommerce_init', [$this, 'init'], 10, 1);
        add_action('plugins_loaded', [$this, 'init'], 999);
    }

    /**
     * Setup constants
     *
     * Defines useful constants to use throughout the add-on.
     *
     * @since
     * @access private
     */
    private function setup_constants() {
        // Defines addon version number for easy reference.
        if (!defined('LKN_AUTOCONNECT_WP_VERSION')) {
            define('LKN_AUTOCONNECT_WP_VERSION', '1.0.0');
        }

        if (!defined('LKN_AUTOCONNECT_WP_FILE')) {
            define('LKN_AUTOCONNECT_WP_FILE', __FILE__);
        }

        if (!defined('LKN_AUTOCONNECT_WP_DIR')) {
            define('LKN_AUTOCONNECT_WP_DIR', plugin_dir_path(LKN_AUTOCONNECT_WP_FILE));
        }

        if (!defined('LKN_AUTOCONNECT_WP_URL')) {
            define('LKN_AUTOCONNECT_WP_URL', plugin_dir_url(LKN_AUTOCONNECT_WP_FILE));
        }

        if (!defined('LKN_AUTOCONNECT_WP_BASENAME')) {
            define('LKN_AUTOCONNECT_WP_BASENAME', plugin_basename(LKN_AUTOCONNECT_WP_FILE));
        }
    }

    /**
     * Plugin installation
     *
     * @since
     * @access public
     */
    public function install() {
        // Bailout.
        if (!self::$instance->check_environment()) {
            return;
        }
    }

    /**
     * Plugin installation
     *
     * @return void
     * @since
     * @access public
     *
     */
    public function init() {
        //echo "init";
        if (!self::$instance->check_environment()) {
            //se não esta logado entra daqui
            self::$instance->load_files();
            self::$instance->setup_hooks();

            return;
        }

        self::$instance->load_files();
        self::$instance->setup_hooks();
    }

    /**
     * Check plugin environment
     *
     * @return bool|null
     * @since
     * @access public
     *
     */
    public function check_environment() {
        // Is not admin
        if (!is_admin() || !current_user_can('activate_plugins')) {
            require_once LKN_AUTOCONNECT_WP_DIR . 'includes/actions.php';

            return null;
        }

        // Load plugin helper functions.
        if (!function_exists('deactivate_plugins') || !function_exists('is_plugin_active')) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        // Load helper functions.
        require_once LKN_AUTOCONNECT_WP_DIR . 'includes/misc-functions.php';

        return true;
    }

    /**
     * Load plugin files.
     *
     * @since
     * @access private
     */
    private function load_files() {
        require_once LKN_AUTOCONNECT_WP_DIR . 'includes/misc-functions.php';
        require_once LKN_AUTOCONNECT_WP_DIR . 'includes/actions.php';

        if (is_admin()) {
            require_once LKN_AUTOCONNECT_WP_DIR . 'includes/admin/setting-admin.php';
        }
    }

    /**
     * Setup hooks
     *
     * @since
     * @access private
     */
    private function setup_hooks() {
        // Filters
        add_filter('plugin_action_links_' . LKN_AUTOCONNECT_WP_BASENAME, '__lkn_autoconnect_wp_plugin_row_meta', 10, 2);
    }
}

/**
 * The main function responsible for returning the one true Lkn_Autoconnect_WP instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $recurring = Lkn_Autoconnect_WP(); ?>
 *
 * @return Lkn_Autoconnect_WP|bool
 * @since 1.0.0
 *
 */
function lkn_autoconnect_wp() {
    return Lkn_Autoconnect_WP::get_instance();
}

lkn_autoconnect_wp();
