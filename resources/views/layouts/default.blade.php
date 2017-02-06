<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Instagram Demo</title>
    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/app.css" />
    <link rel="stylesheet" href="css/modal.css" />
  </head>
  <body id="home">
    <div id="heading" class="row">
      <div class="small-6 columns">
      </div>
      <div class="small-6 columns">
        <ul></ul>
      </div>
    </div>
    @yield('content')
    
    <script src="js/lib/modernizr/modernizr.js"></script>
    
    <script src="js/lib/jquery/dist/jquery.min.js"></script>
    
    <script src="js/lib/foundation/js.js"></script>
    <script src="js/lib/foundation/foundation.js"></script>
    <script src="js/lib/foundation/foundation.reveal.js"></script>

    <script src="js/app.js"></script>
    
    @yield('scripts')
  </body>
</html>
