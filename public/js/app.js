var instagramWindow = null;
var instagramAccessToken = null;

function closeInstagramWindow(accessToken) {
    instagramWindow.close();

    instagramAccessToken = accessToken;

    $("#instagramLinkButton").addClass('success').html('Instagram Account Linked');
}

$(document).ready(function () {
    $(document).foundation();
});
