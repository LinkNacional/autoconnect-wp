<?php

// Exit, if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generates custom menu section and setting page
 *
 * @return void
 */
function lkn_autoconnect_wp_add_config_section() {
    add_menu_page(
        __('Autoconnect WP', 'lkn-autoconnect-wp-plugin'),
        __('Autoconnect WP', 'lkn-autoconnect-wp-plugin'),
        'manage_options',
        'lkn-autoconnect-wp-config',
        false,
        'dashicons-admin-network',
        50
    );

    $hookname = add_submenu_page(
        'lkn-autoconnect-wp-config',
        __('Configurações', 'lkn-autoconnect-wp-plugin'),
        __('Configurações', 'lkn-autoconnect-wp-plugin'),
        'manage_options',
        'lkn-autoconnect-wp-config',
        'lkn_autoconnect_wp_render_config_page',
        1
    );

    add_action('load-' . $hookname, 'lkn_autoconnect_wp_configuration_form_handle');
}

add_action('admin_menu', 'lkn_autoconnect_wp_add_config_section');

/**
 * Adds new invoice submenu page and edit invoice submenu page
 *
 * @return void
 */
function lkn_autoconnect_wp_add_login_submenu_section() {
    $hookname = add_submenu_page(
        'lkn-autoconnect-wp-config',
        __('Login', 'lkn-autoconnect-wp-plugin'),
        __('Login Cliente', 'lkn-autoconnect-wp-plugin'),
        'manage_options',
        'lkn-autoconnect-wp-admin',
        'lkn_autoconnect_wp_render_login_page',
        2
    );

    add_action('load-' . $hookname, 'lkn_autoconnect_wp_login_form_handle');
}

add_action('admin_menu', 'lkn_autoconnect_wp_add_login_submenu_section');

function lkn_autoconnect_wp_render_config_page() {
    $website = get_option('lkn_autoconnect_wp_cli_website', ''); ?>

    <div class="wrap">
        <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
        <?php settings_errors(); ?>
        <form action="<?php menu_page_url('lkn-autoconnect-wp-config') ?>" method="post" class="lkn-autoconnect-wp-form-wrap">
        <?php wp_nonce_field('lkn_autoconnect_wp_save_config'); ?>
        <div class="lkn-autoconnect-wp-config-data">    
            <div class="lkn-autoconnect-wp-pl-row-wrap">
                <div class="lkn-autoconnect-wp-pl-column-wrap">
                    <div class="input-row-wrap">
                        <label for="lkn_autoconnect_wp_cli_website_input"><?php _e('Site URL', 'lkn-autoconnect-wp-plugin')?></label>
                        <input name="lkn_autoconnect_wp_cli_website" type="text" id="lkn_autoconnect_wp_cli_website_input" class="regular-text" value="<?php echo $website; ?>" required>
                    </div>

                    <div class="lkn-autoconnect-wp-pl-action-btn">
                        <?php submit_button(__('Save')) ?>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <style>
    .lkn-autoconnect-wp-pl-action-btn {
        display: flex;
        flex-direction: row;
        justify-content: end;
    }
    .lkn-autoconnect-wp-pl-row-wrap {
        display: flex;
        flex-direction: row;
    }
    .lkn-autoconnect-wp-pl-column-wrap {
        display: flex;
        background-color: white;
        flex-direction: column;
        padding: 15px;
        border: 1px solid #c3c4c7;
    }
    .input-row-wrap {
        display: flex;
        flex-direction: column;
        padding: 6px 0px;
    }
    .lkn-autoconnect-wp-notice-positive {
        background-color: green;
        display: flex;
        justify-content: center;
        color: white;
        padding: 8px;
        font-size: 1.1em;
        animation: hideAnimation 0s ease-in 5s;
        animation-fill-mode: forwards;
    }
    .lkn-autoconnect-wp-notice-negative {
        background-color: rgb(175, 2, 2);
        display: flex;
        justify-content: center;
        color: white;
        padding: 8px;
        font-size: 1.1em;
        animation: hideAnimation 0s ease-in 5s;
        animation-fill-mode: forwards;
    }
    @keyframes hideAnimation {
        to {
        visibility: hidden;
        width: 0;
        height: 0;
        }
    }
    </style>
    <script>
        console.log('HELLO WORDLD ADMIN CONFIG!');
    </script>
    <?php
}

function lkn_autoconnect_wp_render_login_page() {
    $website = get_option('lkn_autoconnect_wp_cli_website', ''); ?>
    <div class="wrap">
        <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
        <?php settings_errors(); ?>
        <form action="<?php menu_page_url('lkn-autoconnect-wp-login') ?>" method="post" class="lkn-autoconnect-wp-form-wrap">
        <?php wp_nonce_field('lkn_autoconnect_wp_redirect_login'); ?>
        <div class="lkn-autoconnect-wp-login-data">
            <div class="lkn-autoconnect-wp-pl-row-wrap">
                <div class="lkn-autoconnect-wp-col">
                    <?php echo $website; ?>
                </div>
                <div class="lkn-autoconnect-wp-btn-login">
                    <?php submit_button(__('Login')); ?>
                </div>
            </div>
        </div>
        </form>
    </div>
    <style>
    .lkn-autoconnect-wp-col {
        display: flex;
        flex-direction: row;
        justify-content: start;
        padding-right: 20px;
        font-size: 1.2em;
    }
    .lkn-autoconnect-wp-pl-row-wrap {
        display: flex;
        background-color: white;
        padding: 15px;
        border: 1px solid #c3c4c7;
        align-items: center;
    }
    #lkn-autoconnect-wp-button-redirect {
        background-color: #2271b1;
        color: #f6f7f7;
        border-color: #2271b1;
        border: solid 1px;
        padding: 0px 30px;
        min-height: 30px;
        border-radius: 3px;
        font-size: 13px;
        cursor: pointer;
    }
    #lkn-autoconnect-wp-button-redirect:hover {
        background: #0a4b78;
        border-color: #f0f0f1;
    }
    </style>
    <script>
    </script>
    <?php
}

function lkn_autoconnect_wp_configuration_form_handle() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'lkn_autoconnect_wp_save_config')) {
            if (isset($_POST['lkn_autoconnect_wp_cli_website']) && !empty($_POST['lkn_autoconnect_wp_cli_website'])) {
                $authkey = get_option('lkn_autoconnect_wp_identifier', wp_generate_password(32, true));
                $website = $_POST['lkn_autoconnect_wp_cli_website'];

                if ($authkey !== false) {
                    $args['body'] = [
                        'data' => base64_encode(json_encode(['auth' => $authkey, 'origin' => get_site_url()])),
                        'action' => 'generatesso',
                    ];

                    $response = wp_remote_post($website, $args);

                    update_option('lkn_autoconnect_wp_identifier', $authkey);

                    if (get_option('lkn_autoconnect_wp_cli_website') === false) {
                        add_option('lkn_autoconnect_wp_cli_website', $website);
                    } else {
                        update_option('lkn_autoconnect_wp_cli_website', $website);
                    }

                    echo '<div class="lkn-autoconnect-wp-notice-positive">' . __('Configurações salvas com sucesso', 'lkn-autoconnect-wp-plugin') . '</div>';
                }
            } else {
                echo '<div class="lkn-autoconnect-wp-notice-negative">' . __('Erro ao salvar configurações', 'lkn-autoconnect-wp-plugin') . '</div>';
            }
        } else {
            echo '<div class="lkn-autoconnect-wp-notice-negative">' . __('Erro ao salvar configurações', 'lkn-autoconnect-wp-plugin') . '</div>';
        }
    }
}

function lkn_autoconnect_wp_login_form_handle() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'lkn_autoconnect_wp_redirect_login')) {
            $authkey = get_option('lkn_autoconnect_wp_identifier', '');
            $website = get_option('lkn_autoconnect_wp_cli_website', '');

            $encodedInfo = base64_encode(json_encode(['auth' => $authkey, 'origin' => get_site_url()]));
            $url = add_query_arg([
                'action' => 'validatesso',
                'i' => $encodedInfo,
            ], $website);

            wp_redirect($url);
            exit;
        } else {
            echo '<div class="lkn-autoconnect-wp-notice-negative">' . __('Erro ao gerar nova sessão', 'lkn-autoconnect-wp-plugin') . '</div>';
        }
    }
}
