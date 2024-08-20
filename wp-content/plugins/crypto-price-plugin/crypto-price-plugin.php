<?php
/**
 * Plugin Name: Crypto Price Plugin
 * Description: Get and display cryptocurrency prices via CoinGecko API with data updates every second.
 * Version: 1.0
 * Author: Andrii Sliusar
 */

require_once plugin_dir_path(__FILE__) . 'includes/api-handler.php';

register_activation_hook(__FILE__, 'crypto_price_activate');
register_deactivation_hook(__FILE__, 'crypto_price_deactivate');

function crypto_price_activate() {}

function crypto_price_deactivate() {}

add_shortcode('coin_price', 'crypto_price_shortcode');

function crypto_price_shortcode($atts) {
    $symbol = get_field('crypto_symbol');
    $coin_price = get_crypto_price_cached();

    ob_start();
    ?>
    <div id="crypto-progress-bar-container" class="progress-bar-container">
        <div id="crypto-progress-bar" class="progress-bar"></div>
    </div>

    <div id="crypto-price-container" class="coin-price-container" style="display: none;"></div>
    <input type="hidden" id="crypto-symbol" value="<?= esc_attr($symbol); ?>">
    <?php
    return ob_get_clean();
}

function crypto_price_enqueue_styles() {
    wp_enqueue_style('crypto-price-css', plugin_dir_url(__FILE__) . 'includes/assets/css/crypto-price.css');
}
add_action('wp_enqueue_scripts', 'crypto_price_enqueue_styles');


function crypto_price_enqueue_scripts() {
    wp_enqueue_script('crypto-price-js', plugin_dir_url(__FILE__) . 'includes/assets/js/crypto-price.js', array('jquery'), null, true);
    wp_localize_script('crypto-price-js', 'cryptoPriceAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'crypto_price_enqueue_scripts');

add_action('wp_ajax_nopriv_get_crypto_price', 'crypto_price_ajax_handler');
add_action('wp_ajax_get_crypto_price', 'crypto_price_ajax_handler');

function crypto_price_ajax_handler() {
    $symbol = isset($_POST['symbol']) ? sanitize_text_field($_POST['symbol']) : '';

    if (empty($symbol)) {
        echo 'Symbol not found';
        wp_die();
    }

    $coin_price = get_crypto_price($symbol);

    echo esc_html($coin_price);
    wp_die();
}

/**
 * Proxy
 */
function crypto_price_add_admin_menu() {
    add_menu_page(
        'Crypto Price Settings',
        'Crypto Price Settings',
        'manage_options',
        'crypto-price-settings',
        'crypto_price_settings_page'
    );
}
add_action('admin_menu', 'crypto_price_add_admin_menu');

function crypto_price_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Crypto Price Proxy Settings', 'crypto-price'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('crypto_price_settings');
            do_settings_sections('crypto_price_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function crypto_price_settings_init() {
    register_setting('crypto_price_settings', 'crypto_price_proxies');

    add_settings_section(
        'crypto_price_section',
        __('Proxy Settings', 'crypto-price'),
        null,
        'crypto_price_settings'
    );

    add_settings_field(
        'crypto_price_proxies',
        __('Proxy List (comma-separated)', 'crypto-price'),
        'crypto_price_proxies_render',
        'crypto_price_settings',
        'crypto_price_section'
    );
}
add_action('admin_init', 'crypto_price_settings_init');

function crypto_price_proxies_render() {
    $proxies = get_option('crypto_price_proxies', '');
    ?>
    <textarea name="crypto_price_proxies" rows="5" cols="50"><?php echo esc_textarea($proxies); ?></textarea>
    <p><?php esc_html_e('Enter proxy addresses in the format: host:port:user:password, separated by commas.', 'crypto-price'); ?></p>
    <?php
}
