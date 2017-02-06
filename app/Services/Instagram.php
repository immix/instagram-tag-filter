<?php
/**
 * User: Christian Augustine
 * Date: 12/30/16
 * Time: 11:33 AM
 */

namespace App\Services;

use App\Exceptions\Instagram\InvalidAuthenticationCodeException;
use App\Helpers\Env;
use App\InstagramMedia as Media;
use Illuminate\Support\Facades\URL;

class Instagram
{
    /**
     * @var array|string[]
     */
    public static $scope = ['basic', 'public_content'];

    /**
     * @var string
     */
    private $clientID;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $accessTokenURL;

    /**
     * @var string
     */
    private $apiURL;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var object
     */
    private $user;

    /**
     * Instagram constructor.
     */
    public function __construct()
    {
        $this->clientID = Env::required('INSTAGRAM_CLIENT_ID');
        $this->clientSecret = Env::required('INSTAGRAM_CLIENT_SECRET');
        $this->redirectURL = URL::to('/instagram/redirect');
        $this->accessTokenURL = "https://api.instagram.com/oauth/access_token";
        $this->apiURL = "https://api.instagram.com/v1";
    }

    /**
     * Redirect to the Instagram login page to request an authentication code
     * @param string $redirectURL URL to redirect to once Instagram has authenticated the user
     * @return \Illuminate\Http\RedirectResponse|\Laravel\Lumen\Http\Redirector
     */
    public function authenticate($redirectURL)
    {
        $scope = implode("+", self::$scope);
        $authURL = "https://api.instagram.com/oauth/authorize/?client_id={$this->clientID}&redirect_uri=$redirectURL&scope=$scope&response_type=code";

        return redirect($authURL);
    }

    /**
     * Request an access token from Instagram using the provided authentication code
     * @param string $code the authentication code from Instagram
     * @param string $redirectURL URL which was used to receive the authentication code
     * @throws InvalidAuthenticationCodeException
     */
    public function requestAuthToken($code, $redirectURL)
    {
        // Use the code to request an access token
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->accessTokenURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id={$this->clientID}&client_secret={$this->clientSecret}&grant_type=authorization_code&redirect_uri=$redirectURL&code=$code");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        if (isset($result->code)) {
            switch ($result->code) {
                case 400:
                    throw new InvalidAuthenticationCodeException(new \Exception($result->error_message, $result->code));
                    break;
            }
        }

        $this->accessToken = $result->access_token;
        $this->user = $result->user;
    }
    
    /**
     * @param $endpoint
     * @param array $parameters
     * @return mixed
     * @throws InvalidAuthenticationCodeException
     */
    public function apiCall($endpoint, array $parameters = [])
    {
        $urlParameters = '';
        if (count($parameters) > 0) {
            foreach ($parameters as $parameter => $value) {
                $urlParameters .= "&$parameter=$value";
            }
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "{$this->apiURL}$endpoint?access_token={$this->accessToken}$urlParameters");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        if (isset($result->code)) {
            switch ($result->code) {
                case 400:
                    var_dump($result);
                    throw new InvalidAuthenticationCodeException(new \Exception($result->error_message, $result->code));
                    break;
                default:
                    die('code:' . $result->code);
            }
        }
        return $result;
    }

    public function getMediaByTag($tag, $limit = 5)
    {
        return Media::where('tags', 'LIKE', '%"' . $tag . '"%')->take($limit)->get();
    }

    public function storeLatestMedia()
    {
        if (Media::whereInstagramId($this->getUser()->id)->count() === 0) {
            // Do an initial import
            $totalCount = 0;
            $attemptCount = 0;
            $maxId = "0";
            $mediaIds = [];
            while ($attemptCount < 3) {
                // todo: error handling response code 429 (rate limit exceeded), or 400 (spam detected)
                $response = $this->apiCall("/users/self/media/recent", ['count' => -1, 'max_id' => $maxId]);
                
                if (!isset($response->data)) {
                    break;
                }

                foreach ($response->data as $media) {
                    if (in_array($media->id, $mediaIds)) {
                        continue;
                    }
                    
                    $mediaIds[] = $media->id;
                    
                    $captionText = "";
                    if(!is_null($media->caption)) {
                        $captionText = $media->caption->text;
                    }
                    
                    $createdTime = $media->created_time;
                    if(!is_null($media->caption)) {
                        $createdTime = $media->caption->created_time;
                    }

                    Media::create([
                        'instagram_id' => $this->getUser()->id,
                        'media_id' => $media->id,
                        'tags' => json_encode($media->tags),
                        'likes' => $media->likes->count,
                        'comment_count' => $media->comments->count,
                        'caption_text' => $captionText,
                        'low_res' => $media->images->low_resolution->url,
                        'high_res' => $media->images->standard_resolution->url,
                        'created_at' => $createdTime,
                    ])->save();

                    $totalCount++;
                    $maxId = $media->id;
                }

                $attemptCount++;
            }
        }

        // Get latest media id
        $minId = Media::whereInstagramId($this->getUser()->id)->orderBy('media_id', 'desc')->take(1)->get()->first();
        if(!is_null($minId)) {
            $minId = $minId->media_id;
        }
        
        $response = $this->apiCall("/users/self/media/recent", ['count' => -1, 'min_id' => $minId]);
        
        foreach ($response->data as $media) {
            if ($media->id == $minId) {
                break;
            }

            Media::create([
                'instagram_id' => $this->getUser()->id,
                'media_id' => $media->id,
                'tags' => json_encode($media->tags)
            ])->save();
        }
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @codeCoverageIgnore
     * @param string $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return object
     */
    public function getUser()
    {
        if (is_null($this->user)) {
            $this->user = $this->apiCall('/users/self/')->data;
        }

        return $this->user;
    }
}
