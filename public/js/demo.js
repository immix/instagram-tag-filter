function initInstagramFeed() {
    var instagramFeed = $('#instagram-feed');

    if (instagramFeed.hasClass('is-init')) {
        return;
    }

    instagramFeed.html('<a class="next-feed-url" href="/demo/feed?tag=' + getUrlParameter('tag') + '" style="display: none"></a>');

    instagramFeed.jscroll({
        nextSelector: '.next-feed-url:last'
    });

    instagramFeed.addClass('is-init');
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

function toggleInstagramFeed() {
    var instagramFeedContainer = $('#instagram-feed-container');
    if (instagramFeedContainer.hasClass('collapsed')) {
        instagramFeedContainer.animate({
            'top': '0px'
        }).removeClass('collapsed');

        $('#show-instagram-feed-button').html('<img src="img/close.jpg">YOUR instagram FEED');
    } else {
        instagramFeedContainer.animate({
            'top': ($(window).height() - 60) + 'px'
        }, {
            complete: function () {
                // if initial page load then init feed
                if ($(this).is(':hidden')) {
                    $(this).show();
                    initInstagramFeed();
                }
            }
        }).addClass('collapsed');
        $('#show-instagram-feed-button').html('<img src="img/instagramFeed.jpg"> YOUR instagram FEED');
    }
}

function isMobileWidth() {
    return $(window).width() <= 642;
}

function windowResize() {
    var instagramFeed = $('#instagram-feed');
    var instagramFeedContainer = $('#instagram-feed-container');

    if (isMobileWidth()) {
        instagramFeed.height(($(window).height() - 60) + 'px');

        if (!instagramFeedContainer.hasClass('mobile')) {
            // Just switched from desktop mode
            if (instagramFeedContainer.hasClass('collapsed')) {
                // Collapse the feed
                instagramFeedContainer.removeClass('collapsed');
            }
            toggleInstagramFeed();
        }

        instagramFeedContainer.addClass('mobile');
    } else {
        instagramFeed.height($('.report-container').height() + 'px');
        instagramFeedContainer
            .removeClass('mobile')
            .css('top', '0px')
            .show();
    }
}

$(document).ready(function () {
    $(window).resize(windowResize);
    windowResize();

    if (isMobileWidth()) {
        toggleInstagramFeed();
    } else {
        initInstagramFeed();
    }

    $('#show-instagram-feed-button').click(function (event) {
        event.preventDefault();

        toggleInstagramFeed();
    });
});

