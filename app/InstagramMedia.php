<?php
/**
 * User: Christian Augustine
 * Date: 1/4/17
 * Time: 5:07 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InstagramMedia
 *
 * @property int $id
 * @property int $instagram_id
 * @property string $media_id
 * @property string $tags
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereInstagramId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereMediaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereTags($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $low_res
 * @property string $high_res
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereHighRes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereLowRes($value)
 * @property int $likes
 * @property int $comment_count
 * @property string $caption_text
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereCaptionText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereCommentCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InstagramMedia whereLikes($value)
 */
class InstagramMedia extends Model
{
    /**
     * @var array
     */
    protected $guarded = [
        'updated_at',
    ];
}
