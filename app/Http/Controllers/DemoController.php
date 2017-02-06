<?php

namespace App\Http\Controllers;

use App\InstagramMedia;
use App\Services\Instagram;
use App\Exceptions\Instagram as InstagramExceptions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class DemoController extends Controller
{
    public function index(Instagram $instagram)
    {
        if (!isset($_SESSION['instagram_access_token'])) {
            return redirect('/instagram/authenticate');
        }
        $instagram->setAccessToken($_SESSION['instagram_access_token']);

        $instagram->storeLatestMedia();

        $user = User::whereInstagramId($instagram->getUser()->id)->orderBy('id', 'desc')->first();
        
        return view('demo', ['user' => $user, 'userJSON' => json_encode($user), 'instagramAccessToken' => $instagram->getAccessToken()]);
    }

    public function feed(Request $request, Instagram $instagram)
    {
        if (!isset($_SESSION['instagram_access_token'])) {
            throw new InstagramExceptions\InvalidAuthenticationCodeException();
        }

        $instagram->setAccessToken($_SESSION['instagram_access_token']);
        if (is_null($instagram->getUser())) {
            throw new InstagramExceptions\InvalidAuthenticationCodeException();
        }

        $limit = 5;
        $offset = $request->get('offset', 0);
        $tag = $request->get('tag', '');

        $media = DB::select(
            "
              SELECT * FROM(
                    SELECT
                        'instagram' as `type`,
                        likes,
                        comment_count,
                        caption_text,
                        high_res,
                        created_at
                    FROM instagram_media
                    WHERE instagram_id=?         
                    AND tags LIKE '%\"" . $tag . "\"%'
                ) feed
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?
            ",
            [
                $instagram->getUser()->id,
                $limit,
                $offset
            ]
        );

        return view('demoFeed', [
            'media' => $media,
            'nextUrl' => URL::to('/demo/feed?tag=' . $tag . 'offset=' . ($offset + $limit)),
        ]);
    }
}
