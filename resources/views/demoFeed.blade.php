@foreach($media as $item)
    @if($item->type == 'weight')
        <div class="progress-feed-item progress-feed-item-weight">
            <div class="progress-feed-weight-title">{{ (new \Carbon\Carbon($item->created_at))->format('D, M j, Y') }}</div>
            <div class="progress-feed-weight-pounds">{{ $item->weight }} lbs</div>
        </div>
    @else    
        <div class="progress-feed-item progress-feed-item-instagram">
            <div class="progress-feed-item-top">
                <span>{{ (new \Carbon\Carbon($item->created_at))->toDayDateTimeString() }}</span>
            </div>
            <img src="{{ $item->high_res }}" />
            <div class="progress-feed-item-bottom">
                <span>
                    <span>{{ $item->likes }}</span>
                    @if($item->likes == 1)
                        <span> like</span>
                    @else
                        <span> likes</span>
                    @endif    
                </span>
            </div>
        </div>
    @endif    
@endforeach    
<a class="next-feed-url" href="{{ $nextUrl }}">Next</a>
