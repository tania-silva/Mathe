<?php
use Flarum\Extend;
use Flarum\Frontend\Document;
use Flarum\Event\ConfigureClientView;
use Illuminate\Contracts\Events\Dispatcher;

 

return [
  (new Extend\Frontend('forum'))
      ->content(function (Document $document) {
          $document->head[] = '
          <link rel="stylesheet" href="http://localhost/mathe/teacher-forum/public/css/jquery-ui.min.css">
          <link rel="stylesheet" href="http://localhost/mathe/teacher-forum/public/css/hamburgers.min.css">
          <link rel="stylesheet" href="http://localhost/mathe/teacher-forum/public/css/media-queries.css">
          <link href="http://localhost/mathe/teacher-forum/public/css/style.css" rel="stylesheet">
          <script type="text/javascript" src="http://localhost/mathe/teacher-forum/public/js/jquery-2.1.3.min.js"></script>
          <script type="text/javascript" src="http://localhost/mathe/teacher-forum/public/js/main.js"></script>
          <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
          <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
          <div class="background">
            <div class="container">
              <img src="http://localhost/mathe/teacher-forum/public/img/erasmus.jpg" alt="Erasmus" style="float:left;padding:15px;">
              <p>This project has been funded with support from the European Commission. This web site reflects the views only of the author, and the Commission cannot be held responsible for any use which may be made of the information contained therein.</p>
            </div>
          </div>
          ';
      }),

      (new Extend\Frontend('forum'))
              ->content(function (Document $document) {
                  $document->foot[] = "
      <script type='text/javascript'>
       $(window).scroll(function() {
         var header = $('.Flagrow-Ads-under-header');
         if ($(window).scrollTop() > 79) {
           header.addClass('sticky');
         } else {
           header.removeClass('sticky');
         }
       });
      </script>
      ";
      })
];
