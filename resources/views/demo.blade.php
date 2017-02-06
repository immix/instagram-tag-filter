@extends('layouts.default')
@section('scripts')
    <script src="js/lib/jquery.jscroll.min.js"></script>
    <script src="js/demo.js"></script>
@stop
@section('content')
    <div class="row container">
        <div id="instagram-feed-container" class="column medium-5">
            <a id="show-instagram-feed-button"><img src="img/instagramFeed.jpg">YOUR instagram FEED</a>
            <section id="instagram-feed">
            </section>
        </div>
    </div>
@endsection
