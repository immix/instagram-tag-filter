function initInstagramFeed() {
    var instagramFeed = $('#instagram-feed');

    if (instagramFeed.hasClass('is-init')) {
        return;
    }

    instagramFeed.html('<a class="next-feed-url" href="/demo/feed" style="display: none"></a>');

    instagramFeed.jscroll({
        nextSelector: '.next-feed-url:last'
    });

    instagramFeed.addClass('is-init');
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

