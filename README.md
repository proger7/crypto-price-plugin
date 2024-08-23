
# Coin Price WordPress Plugin

## Table of Contents
- [Description](#description)
- [Key Features](#key-features)
- [Installation and Setup](#installation-and-setup)
  - [Requirements](#requirements)
  - [Installation Steps](#installation-steps)
- [Plugin Settings](#plugin-settings)
  - [Select the post type](#select-the-post-type)
  - [Enter cryptocurrency symbol](#enter-cryptocurrency-symbol)
- [Usage](#usage)
  - [Add the shortcode to a page or post](#add-the-shortcode-to-a-page-or-post)
  - [How the plugin works](#how-the-plugin-works)
  - [Asynchronous price updates](#asynchronous-price-updates)
- [Updating the Local JSON File](#updating-the-local-json-file)
  - [File update](#file-update)
- [Example Workflow](#example-workflow)
- [Mechanism of Asynchronous Updates](#mechanism-of-asynchronous-updates)
- [License](#license)

## Description

This WordPress plugin adds an ACF field for a specified post type, allowing users to enter a cryptocurrency symbol. The plugin then looks up the cryptocurrency ID based on the symbol in a local JSON file. Once the ID is found, the plugin uses it to fetch the current price of the cryptocurrency from the CoinGecko public API. The price is displayed on the page using a `[coin_price]` shortcode and updates asynchronously every second without reloading the page.

## Key Features

- **ACF field for cryptocurrency symbol**: Automatically adds an ACF field to the selected post type(which is called as crypto_symbol).
- **Cryptocurrency ID lookup**: Finds the cryptocurrency ID based on the symbol in a local JSON file.
- **Fetch current price**: Queries the CoinGecko public API to get the current price of the cryptocurrency.
- **Asynchronous price updates**: The price is updated in real-time without refreshing the page(every 1 second).
- **Daily JSON file updates**: The local JSON file containing cryptocurrency data is automatically updated every day(for example, percentage price per 24 hours).

## Installation and Setup

### Requirements

- WordPress 5.6 or higher.
- Advanced Custom Fields (ACF) plugin installed and activated.
- Cron job support on the server for automatic daily updates of the local JSON file.

### Installation Steps

1. **Download or clone the repository**:
    ```bash
    git clone https://github.com/oleh96pp/coin-price-wp-plugin.git
    ```

2. **Upload the plugin to WordPress**:
    - Navigate to the `wp-content/plugins/` directory of your WordPress site.
    - Upload the plugin folder to this directory.

3. **Activate the plugin**:
    - In the WordPress admin panel, go to `Plugins` and activate the Coin Price plugin.

4. **Configure the ACF field**:
    - Once the plugin is activated, it automatically adds an ACF field for the cryptocurrency symbol to the selected post type.
    - You can configure the post type in the plugin settings.

## Plugin Settings

### Select the post type

1. **Go to the WordPress admin panel**: `Settings -> Coin Price`.
2. Choose the post type for which you want to add the ACF field.

### Enter cryptocurrency symbol

1. **When creating a new post** of the selected type, an ACF field will appear for entering the cryptocurrency symbol (e.g., `BTC` for Bitcoin or `ETH` for Ethereum).
2. The symbol must match one in the local JSON file for proper functionality.

## Usage

### Add the shortcode to a page or post

To display the current price of the selected cryptocurrency on a page or post, use the `[coin_price]` shortcode.

The shortcode will output the following HTML structure with the updated price:
```html
<div class="coin-price-container">
    123.45$
</div>
```

### How the plugin works

- The plugin looks up the cryptocurrency ID based on the symbol entered in the ACF field from the local JSON file, which has a structure like this:
```json
[
    {
        "id": "bitcoin",
        "symbol": "btc",
        "name": "Bitcoin"
    },
    {
        "id": "ethereum",
        "symbol": "eth",
        "name": "Ethereum"
    }
]
```
For example, for the symbol `btc`, the plugin will find the ID `bitcoin`.

- The plugin then sends a request to the CoinGecko API to get the cryptocurrency price by its ID:
```bash
GET https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=bitcoin
```

- After receiving the API response, the plugin displays the current price of the cryptocurrency on the page.

### Asynchronous price updates

On the page where the shortcode is placed, the cryptocurrency price is updated every second using JavaScript, so users always see the latest price.

## Updating the Local JSON File

### File update

The local JSON file contains a list of all cryptocurrencies with their IDs, symbols, and names.

The plugin is configured to automatically update this file daily at midnight. The update is handled by a Cron job that sends a request to the CoinGecko API and saves the new JSON file to the server.


## Example Workflow

1. You create a new post of the selected post type configured in the plugin settings.
2. Enter the cryptocurrency symbol, such as `btc`, into the ACF field.
3. Add the `[coin_price]` shortcode to the post.
4. On the published page, the shortcode will display the current price of Bitcoin, e.g., `45000.00$`.
5. The price is updated asynchronously every second, showing live data from CoinGecko.

## Mechanism of Asynchronous Updates

JavaScript is used to perform asynchronous price updates. Every second, a new request is sent to your site's REST API, which updates the price inside the container on the page.

The plugin adds a custom REST API route to retrieve the current cryptocurrency price.

## License

This plugin is licensed under the MIT License. See the LICENSE file for details.
