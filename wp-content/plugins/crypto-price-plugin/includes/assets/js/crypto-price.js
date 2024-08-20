jQuery(document).ready(function($) {
    let lastPrice = null;
    let progressBarDuration = 2000;

    function startProgressBar() {
        $('#crypto-progress-bar').css({
            'width': '0%',
            'transition': 'none'
        }).show();

        setTimeout(function() {
            $('#crypto-progress-bar').css({
                'width': '90%',
                'transition': 'width ' + (progressBarDuration / 1000) + 's linear'
            });
        }, 100);
    }

    function finishProgressBar() {
        $('#crypto-progress-bar').css({
            'width': '100%',
            'transition': 'width 0.5s ease-in-out'
        });

        setTimeout(function() {
            $('#crypto-progress-bar-container').fadeOut();
        }, 500);
    }

    function updateCryptoPrice() {
        startProgressBar();

        var cryptoSymbol = $('#crypto-symbol').val();

        $.ajax({
            url: cryptoPriceAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_crypto_price',
                symbol: cryptoSymbol
            },
            success: function(response) {
                if ($.isNumeric(response)) {
                    let price = parseFloat(response);

                    let formattedPrice = price % 1 === 0 ? price.toString() : price.toFixed(6);

                    if (formattedPrice != lastPrice) {
                        $('#crypto-price-container').text(formattedPrice + '$').fadeIn();
                        lastPrice = formattedPrice;
                        finishProgressBar();
                    }
                }
            },
            error: function() {
                finishProgressBar(); 
            }
        });
    }

    updateCryptoPrice();

    setInterval(updateCryptoPrice, 1000);
});