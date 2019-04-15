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

    	.brown div {
    		color: #6c5648;
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

    	.space-sch {
    		padding-bottom: 5px;
    	}

    	.min-left {
    		margin-left: -15px;
    		margin-right: 10px;
    	}

    	.line-bottom {
    		border-bottom: 0.3px solid #dbdbdb;
    		margin-bottom: 5px;
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

		.text-grey-2{
			color: #a9a9a9;
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

		@font-face {
            font-family: 'Seravek';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("AWS_ASSET_URL") }}{{("assets/fonts/Seravek.ttf")}}') format('truetype'); 
        }

        @font-face {
            font-family: 'Seravek Light';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("AWS_ASSET_URL") }}{{("assets/fonts/Seravek-Light.ttf")}}') format('truetype'); 
        }

        @font-face {
            font-family: 'Seravek Medium';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("AWS_ASSET_URL") }}{{("assets/fonts/Seravek-Medium.ttf")}}') format('truetype'); 
        }

        @font-face {
            font-family: 'Seravek Italic';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("AWS_ASSET_URL") }}{{("assets/fonts/Seravek-Italic.ttf")}}') format('truetype'); 
        }

        @font-face {
            font-family: 'Roboto Regular';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("AWS_ASSET_URL") }}{{("assets/fonts/Roboto-Regular.ttf")}}') format('truetype'); 
        }

    	.open-sans-font {
    		font-family: 'Open Sans', sans-serif;
    	}

    	.questrial-font {
    		font-family: 'Questrial', sans-serif;
    	}
		.seravek-font {
            font-family: 'Seravek';
        }

        .seravek-light-font {
            font-family: 'Seravek Light';
        }

        .seravek-medium-font {
            font-family: 'Seravek Medium';
        }

        .seravek-italic-font {
            font-family: 'Seravek Italic';
        }

        .roboto-regular-font {
            font-family: 'Roboto Regular';
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

	.day-alphabet{
		margin: 0 10px;
		border-radius: 50%;
		width: 20px;
		height: 20px;
		text-align: center;
		background: #d9d6d6;
		color: white !important;
		padding-top: 1px;
	}

	.day-alphabet-today{
		background: #6c5648;
	}

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  </head>
  <body>

  	<div class="kotak1">
  		<div class="container">
	   		<div class="row">
	   			<div class="col-12 text-black text-15px seravek-font space-bottom">{{ $data[0]['outlet_name'] }}</div>
	   			<div class="col-1 text-grey-black text-13-3px seravek-light-font space-text"><img class="logo-img" src="{{ env('AWS_ASSET_URL') }}{{('img/webview/location.png') }}"></div>
	   			<div class="col-10 text-grey-black text-13-3px seravek-light-font space-text"><span> {{ $data[0]['outlet_address'] }} </span></div>
	   		</div>
	   		<div class="row space-bottom line-bottom">
	   			<div class="col-1 text-grey-black text-13-3px seravek-light-font space-text"><img class="logo-img" src="{{ env('AWS_ASSET_URL') }}{{('img/webview/phone.png') }}"></div>
	   			<div class="col-10 text-grey-black text-13-3px seravek-light-font space-text"><span> {{ $data[0]['call'] }} </span></div>
	   		</div>
	   	</div>
  	</div>

    <div class="kotak1">
  		<div class="container">
  			@php
  				$hari = date ("D");
 
			switch($hari){
				case 'Sun':
					$hari_ini = "Minggu";
				break;
		 
				case 'Mon':			
					$hari_ini = "Senin";
				break;
		 
				case 'Tue':
					$hari_ini = "Selasa";
				break;
		 
				case 'Wed':
					$hari_ini = "Rabu";
				break;
		 
				case 'Thu':
					$hari_ini = "Kamis";
				break;
		 
				case 'Fri':
					$hari_ini = "Jumat";
				break;
		 
				default:
					$hari_ini = "Sabtu";
				break;
			}

  			@endphp
  			@foreach ($data[0]['outlet_schedules'] as $key => $val)
		   		<div class="row space-sch @if ($val['day'] == $hari_ini) brown @endif">
		   			<div class="text-grey-2 text-13-3px seravek-light-font day-alphabet @if ($val['day'] == $hari_ini) day-alphabet-today @endif">{{ substr($val['day'], 0,1) }}</div>
		   			<div class="col-2 text-grey-2 text-13-3px  @if ($val['day'] == $hari_ini) seravek-font @else seravek-light-font @endif min-left "> {{ $val['day'] }} </div>
		   			<div class="col-5 text-grey-2 text-13-3px  @if ($val['day'] == $hari_ini) seravek-font @else seravek-light-font @endif"> 
    		   			@if($val['is_closed'] == '1')
					   		TUTUP
						@else
							{{date('H:i', strtotime($val['open']))}} - {{date('H:i', strtotime($val['close']))}} 
						@endif
		   			</div>
		   		</div>
		   	@endforeach
	   	</div>
  	</div>
   
   	

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOHBNv3Td9_zb_7uW-AJDU6DHFYk-8e9Y&v=3.exp&signed_in=true&libraries=places"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  </body>
</html>