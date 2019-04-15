<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Questrial" rel="stylesheet">
    <link href="{{ env('AWS_ASSET_URL') }}{{('css/slide.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <style type="text/css">
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
        .kotak {
            margin : 10px;
            padding: 10px;
            /*margin-right: 15px;*/
            -webkit-box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            -moz-box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            box-shadow: 0px 0px 21px 0px rgba(168,168,168,1);
            border-radius: 3px;
            background: #fff;
            font-family: 'Seravek Light';
        }

        .kotak-full {
            padding: 10px;
            background: #fff;
            font-family: 'Seravek Light';
        }

        .kotak-biasa {
            margin-left: 5px;
            font-family: 'Seravek Light';
        }

        .kotak-inside {
        	padding-left: 25px;
        	padding-right: 25px
        }

        body {
            background: #fafafa;
        }

        .seravek-font {
            font-family: 'Seravek';
        }

        .seravek-light-font {
            font-family: 'Seravek Light';
        }
        .open-sans-font {
            font-family: 'Open Sans', sans-serif;
        }

        .questrial-font {
            font-family: 'Questrial', sans-serif;
        }

        .text-21-7px {
            font-size: 21.7px;
        }

        .text-16-7px {
            font-size: 16.7px;
        }

        .text-15px {
            font-size: 15px;
        }

        .text-14-3px {
            font-size: 14.3px;
        }

        .text-14px {
            font-size: 14px;
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

    </style>
  </head>
  <body>

    <div class="kotak-full">
        <div class="container">
            <div class="row">
                <div class="col-12 text-13-3px seravek-light-font text-grey-white"><?php echo $value; ?></div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
    
  </body>
</html>