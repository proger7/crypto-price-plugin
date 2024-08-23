<?php

function get_coin_id_by_symbol($symbol) {
    $json_file = plugin_dir_path(__FILE__) . 'assets/coins.json';
    $coins = json_decode(file_get_contents($json_file), true);
    foreach ($coins as $coin) {
        if ($coin['symbol'] === strtolower($symbol)) {
            return $coin['id'];
        }
    }

    return false;
}

function get_random_proxy() {
    $proxies = get_option('crypto_price_proxies', '');
    if (empty($proxies)) {
        return false;
    }

    $proxy_list = explode(',', $proxies);
    $random_proxy = trim($proxy_list[array_rand($proxy_list)]);

    list($proxy_host, $proxy_port, $proxy_user, $proxy_pass) = explode(':', $random_proxy);

    return [
        'host'     => $proxy_host,
        'port'     => $proxy_port,
        'username' => $proxy_user,
        'password' => $proxy_pass
    ];
}

function get_crypto_price($symbol) {
    $coin_id = get_coin_id_by_symbol($symbol);

    if (!$coin_id) {
        return 'Symbol not found';
    }

    $url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=' . $coin_id;

    $proxy = get_random_proxy();
    $args = [];

    if ($proxy) {
        $args['proxy'] = [
            'http' => $proxy['host'] . ':' . $proxy['port'],
            'https' => $proxy['host'] . ':' . $proxy['port'],
            'auth' => $proxy['username'] . ':' . $proxy['password']
        ];
    }

    $response = wp_remote_get($url, $args);

    if (is_wp_error($response)) {
        return 'Error fetching price';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!empty($data) && isset($data[0]['current_price'])) {
        return [
            'current_price' => $data[0]['current_price'],
            'price_change_percentage_24h' => $data[0]['price_change_percentage_24h']
        ];
    } else {
        return false;
    }
}

function get_crypto_price_cached() {
    $symbol = get_field('crypto_symbol');

    $cached_price = get_transient('crypto_price_' . $symbol);
    if ($cached_price !== false) {
        return $cached_price;
    }

    $price_data = get_crypto_price($symbol);
    if ($price_data) {
        set_transient('crypto_price_' . $symbol, $price_data, 5 * MINUTE_IN_SECONDS);
    }

    return $price_data;
}