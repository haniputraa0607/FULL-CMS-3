<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Questrial" rel="stylesheet">
    <style type="text/css">
    	.kotak1 {
    		padding-top: 10px;
    		padding-bottom: 10px;
    		padding-left: 26.3px;
    		padding-right: 26.3px;
			background: #fff;
			font-family: 'Open Sans', sans-serif;
    	}

    	.kotak2 {
    		padding-top: 10px;
    		padding-bottom: 10px;
    		padding-left: 26.3px;
    		padding-right: 26.3px;
			background: #fff;
			font-family: 'Open Sans', sans-serif;
      height: 100%
    	}

    	.completed {
    		color: green;
    	}

    	.bold {
    		font-weight: bold;
    	}

    	.space-bottom {
    		padding-bottom: 15px;
    	}

        .space-top {
            padding-top: 15px;
        }

    	.space-text {
    		padding-bottom: 10px;
    	}

    	.line-bottom {
    		border-bottom: 1px solid #eee;
    		margin-bottom: 15px;
    	}

    	.text-grey {
    		color: #aaaaaa;
    	}

    	.text-much-grey {
    		color: #bfbfbf;
    	}

    	.text-black {
    		color: #000000;
    	}

    	.text-medium-grey {
    		color: #806e6e6e;
    	}

    	.text-grey-white {
    		color: #666;
    	}

    	.text-grey-black {
    		color: #4c4c4c;
    	}

    	.text-grey-red {
    		color: #9a0404;
    	}

        .text-grey-red-cancel {
            color: rgba(154,4,4,1);
        }

        .text-grey-blue {
            color: rgba(0,140,203,1);
        }

        .text-grey-yellow {
            color: rgba(227,159,0,1);
        }

    	.text-grey-green {
    		color: rgba(4,154,74,1);
    	}

    	.open-sans-font {
    		font-family: 'Open Sans', sans-serif;
    	}

    	.questrial-font {
    		font-family: 'Questrial', sans-serif;
    	}

    	.text-14-3px {
    		font-size: 14.3px;
    	}

    	.text-14px {
    		font-size: 14px;
    	}

      .text-15px {
        font-size: 15px;
      }

    	.text-13-3px {
    		font-size: 13.3px;
    	}

    	.text-12-7px {
    		font-size: 12.7px;
    	}

    	.text-12px {
    		font-size: 12px;
    	}

    	.text-11-7px {
    		font-size: 11.7px;
    	}

    	.logo-img {
    		width: 16.7px;
    		height: 16.7px;
        margin-top: -7px;
        margin-right: 5px;
    	}

      .text-bot {
        margin-left: -15px;
      }

      .owl-dots {
        margin-top: -37px !important;
        position: absolute;
        width: 100%;
        margin-left: 1px;
        height: 37px;
        opacity: 0.5;
      }

      .image-caption-outlet {
       
      }

      .owl-carousel {
        overflow: hidden;
      }

      .owl-theme .owl-dots .owl-dot span {
        width: 5px !important;
        height: 4px !important;
        margin: 5px 1px !important;
        margin-top: 28px !important;
      }

      .image-caption-all {
            position: absolute;
            z-index: 99999;
            bottom: 0;
            color: white;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
      }

      .image-caption-you {
            position: absolute;
            z-index: 99999;
            top: 0;
            color: white;
            width: 100%;
            padding: 8%;
      }

      .cf_videoshare_referral {
   display: none !important;
}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  </head>
  <body>
    @php
      // print_r($news[0]);die();
    @endphp

    @if (isset($news[0]['news_event_date_start']) || isset($news[0]['news_event_location_name']) || isset($news[0]['news_event_location_address']) || isset($news[0]['news_event_location_phone']) || isset($news[0]['news_event_location_map']))
  	<div class="kotak1">
  		<div class="container line-bottom">
        @if (isset($news[0]['news_event_date_start']))
  	   		<div class="row space-bottom">
  	   			<div class="col-12 text-grey-black text-13-3px open-sans-font"><img class="logo-img" src="{{ url('img/webview/calendar.png') }}"> <span> {{ date('d F', strtotime($news[0]['news_event_date_start'])) }} - {{ date('d F Y', strtotime($news[0]['news_event_date_end'])) }} </span></div>
  	   		</div>
        @endif
        @if (isset($news[0]['news_event_location_name']))
  	   		<div class="row space-bottom">
  	   			<div class="col-12 text-grey-black text-13-3px open-sans-font"><img class="logo-img" src="{{ url('img/webview/outlet.png') }}"> <span> {{ $news[0]['news_event_location_name'] }} </span></div>
  	   		</div>
        @endif

        @if (isset($news[0]['news_event_location_address']))
  	   		<div class="row space-bottom">
  	   			<div class="col-12 text-grey-black text-13-3px open-sans-font"><img class="logo-img" src="{{ url('img/webview/marker.png') }}"> <span>{{ $news[0]['news_event_location_address'] }} </span></div>
  	   		</div>
        @endif

        @if (isset($news[0]['news_event_location_phone']))
  	   		<div class="row space-bottom">
  	   			<div class="col-12 text-grey-black text-13-3px open-sans-font"><img class="logo-img" src="{{ url('img/webview/marker.png') }}"> <span> {{ $news[0]['news_event_location_phone'] }} </span></div>
  	   		</div>
        @endif

        @if (isset($news[0]['news_event_location_map']))
  	   		<div class="row space-bottom">
  	   			<div class="col-12 text-grey-black text-13-3px open-sans-font"><div id="map-canvas" style="width:500;height:180px;"></div></div>
  	   		</div>
        @endif

	   	</div>
  	</div>
    @endif

  	<div class="kotak2">
  		<div class="container">
	   		<div class="row space-bottom">{!! $news[0]['news_content_long'] !!}
	   		</div>
	   	</div>
  	</div>

    @if (isset($news[0]['news_video_text']))
      <div class="kotak2">
        <div class="container">
          @if (isset($news[0]['news_video_text']))
            <div class="row space-bottom">
              <div class="col-12 text-bot text-grey-black text-15px open-sans-font"> <span> {{ $news[0]['news_video_text'] }} :  </span></div>
            </div>
          @endif

          @if (isset($news[0]['news_video']))
            <div class="row space-bottom">
              <div class="embed-responsive embed-responsive-16by9" style="height: 60vw !important;">
    <iframe id="frame1" class="embed-responsive-item" src="https://www.youtube.com/embed/{{ substr($news[0]['news_video'], strpos($news[0]['news_video'], "=") + 1) }}?rel=0" allowfullscreen></iframe><div class="questrial-font image-caption-you text-13-3px"></div>
  </div>

            </div>
          @endif

        </div>
        </div>
      @endif

      @if (isset($news[0]['news_outlet_text']))
        <div class="kotak2">
        <div class="container">
          @if (isset($news[0]['news_outlet_text']))
            <div class="row space-bottom">
              <div class="col-12 text-bot text-grey-black text-15px open-sans-font"> <span> {{ $news[0]['news_outlet_text'] }} :  </span></div>

            </div>
          @endif

          @if (isset($news[0]['news_outlet']))
            <div class="row">
              <div class="owl-carousel owl-theme">
                @foreach ($news[0]['news_outlet'] as $key => $value)
                  <div class="item"> <img style="height: 60vw;" src="{{ $value['outlet']['photos'][0]['url_outlet_photo'] }}"> <div class="questrial-font image-caption-all text-13-3px">{{ $value['outlet']['outlet_name'] }}</div> </div>

                @endforeach
              </div>
              
            </div>
          @endif

        </div>
        </div>
      @endif

      @if (isset($news[0]['news_product_text']))
        <div class="kotak2">
        <div class="container">
          @if (isset($news[0]['news_product_text']))
            <div class="row space-bottom">
              <div class="col-12 text-bot text-grey-black text-15px open-sans-font"> <span> {{ $news[0]['news_product_text'] }} :  </span></div>

            </div>
          @endif

          @if (isset($news[0]['news_product']))
            <div class="row space-bottom">
              <div class="owl-carousel owl-theme">
                  @foreach ($news[0]['news_product'] as $key => $value)
                    <div class="item"> <img style="height: 60vw !important;" src="{{ $value['product']['photos'][0]['url_product_photo'] }}"> <div class="questrial-font image-caption-all text-13-3px">{{ $value['product']['product_name'] }}</div> </div>
                  @endforeach
              </div>
              
            </div>
          @endif

        </div>
        </div>
      @endif
   
   	

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOHBNv3Td9_zb_7uW-AJDU6DHFYk-8e9Y&v=3.exp&signed_in=true&libraries=places"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
      $(document).ready(function(){
        $("#frame1").contents().find(".ytp-chrome-top-buttons").attr("style","display:none");
      });

      $(document).on('click', '.ampas', function() {
        console.log('testing');
      });

        $(".owl-carousel").owlCarousel({
          margin: 1,
          items : 1,
          loop:true,
        });

      owl = $('.owl-carousel').owlCarousel();

      owl.on('translated.owl.carousel', function(event) {
        // var title = $(this).find('.active').find('#image-outlet').attr('title');
        // if(title) $('.image-caption-outlet').html(title);

        var title2 = $(this).find('.active').find('#image-product').attr('title');
        if(title2) $('.image-caption-product').html(title2);
      });

        var map;

          var lat = "{!! $news[0]['news_event_latitude'] !!}";
          var long = "{!! $news[0]['news_event_longitude'] !!}";

        var markers = [];

        function initialize() {
          var haightAshbury = new google.maps.LatLng(lat,long);
          var marker        = new google.maps.Marker({
              position:new google.maps.LatLng(lat,long),
              map: map,
              anchorPoint: new google.maps.Point(0, -29)
          });

          var mapOptions = {
              zoom: 12,
              center: haightAshbury,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          var infowindow = new google.maps.InfoWindow({
              content: '<p>Marker Location:</p>'
          });

          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions); 
            
          
          // Adds a marker at the center of the map.
          addMarker(haightAshbury);
        }

        function placeMarker(location) {
          marker = new google.maps.Marker({
            position: location,
            map: map,
          });

          markers.push(marker);

          infowindow = new google.maps.InfoWindow({
             content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
          });
          infowindow.open(map,marker);
        }

        // Add a marker to the map and push to the array.

        function addMarker(location) {
          var marker = new google.maps.Marker({
            position: location,
            map: map
          });
          
          $('#lat').val(location.lat());
          $('#lng').val(location.lng());
          markers.push(marker);
        }

        // Sets the map on all markers in the array.

        function setAllMap(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
          setAllMap(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
          setAllMap(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
          clearMarkers();
          markers = [];
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </body>
</html>