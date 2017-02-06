<?php

namespace App\Http\Controllers;

use App\Services\Instagram;
use App\Exceptions\Instagram as InstagramExceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class InstagramController extends Controller
{
    public function authenticate(Instagram $instagram)
    {
        return $instagram->authenticate(URL::to('/instagram/requestAuthToken'));
    }

    public function requestAuthToken(Request $request, Instagram $instagram)
    {
        if (!$request->exists('code')) {
            throw new InstagramExceptions\MissingAuthenticationCodeException();
        }

        $instagram->requestAuthToken($request->get('code'), URL::to('/instagram/requestAuthToken'));
        $_SESSION['instagram_access_token'] = $instagram->getAccessToken();

        return '
        <h2 id="instagramLinked" style="font-family: sans-serif">Instagram Successfully Linked</h2>
        <script type="text/javascript">
            // Check if this is a popup or not
            if(typeof opener !== "undefined" && opener !== null) {
                // Close the popup
                opener.closeInstagramWindow("' . $instagram->getAccessToken() . '");
            } else {
                // Redirect to the profile page
                window.location = "' . URL::to('/demo') . '";
            }
        </script>
    ';
    }
}
