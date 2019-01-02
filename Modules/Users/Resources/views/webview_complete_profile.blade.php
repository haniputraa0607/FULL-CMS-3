<?php
    use App\Lib\MyHelper;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>User Profile</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Kopi Kenangan" name="description" />
        <meta content="" name="author" />
        
        <link href="{{ url('assets/webview/css/pace-flash.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ url('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ url('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ url('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" /><link href="{{ url('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ url('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ url('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        <style type="text/css">
            body{
                background-color: #fff;
                font-size: 15px;
            }
            .text-brown{
                color: #7A361A;
            }
            .birthday input,
            .birthday input::placeholder{
                color: #000 !important;
                font-size: 15px;
            }
            .birthday-img{
              position: absolute;
              top: 30px;
              right: 3px;
              width: 17px;
              height: 17px;
            }

            /* custom select */
            .gender-wrapper,
            .birthday,
            .city {
              position: relative;
            }

            .gender-select {
              display: none; /*hide original SELECT element:*/
            }

            .select-selected {
              color: #000;
              border-bottom: 1px solid #D9D6D6;
              padding: 6px 0px;
            }

            /* the arrow inside the select element: */
            .select-img{
              position: absolute;
              top: 34px;
              right: 3px;
              width: 17px;
              height: 17px;
            }

            /*style the items (options), including the selected item:*/
            .select-items div,
            .select-selected {
              border: 1px solid transparent;
              border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
              cursor: pointer;
              user-select: none;
            }
            .select-items div{
              color: #333;
              padding: 6px 8px;
            }

            /*style items (options):*/
            .select-items {
              position: absolute;
              background-color: #fafafa;
              top: 100%;
              left: 0;
              right: 0;
              z-index: 99;
            }

            /*hide the items when the select box is closed:*/
            .select-hide {
              display: none;
            }

            .select-items div:hover, .same-as-selected {
              background-color: #f0f0f0;
            }
            /* end of custom select */

            /* select 2 */
            .select2 .select2-container--default,
            .select2 .select2-selection--single,
            .select2 .select2-selection__rendered{
                line-height: 34px !important;
                padding-left: 0px !important;
                color: #000 !important;
            }
            .select2 .select2-selection--single{
                height: 34px;
                border-top: none;
                border-left: none;
                border-right: none;
                border-bottom-color: #D9D6D6;
            }
            .select2-container--default,
            .select2-results__option--highlighted[aria-selected] {
                background-color: #7A361A !important;
            }
            .select2-selection__arrow{
                display: none;
            }
            .city .select-img{
                top: 30px;
            }

            .button-wrapper .btn{
                width: 230px;
                font-size: 16px;
            }
            .btn-round{
                border-radius: 25px !important;
            }
            .btn-outline.brown{
                border-color: #7A361A;
                color: #7A361A;
                background-color: #fff;
            }
            .button-wrapper .btn-default{
                border-color: #000;
                color: #000;
            }
        </style>

    </head>
    <!-- END HEAD -->

    <body>
        <div class="col-md-4 col-md-offset-4">
            @include('layouts.notifications')
            
            <div class="text-brown" style="margin-top: 50px; margin-bottom: 20px; text-align: justify;">
                Silahkan lengkapi data dibawah ini dan dapatkan Kopi Points
            </div>

            @if($user != null)
                @if($user['birthday'] == null || $user['gender'] == null || $user['id_city'] == null)
                {{-- form --}}
                <form role="form" action="{{ url('webview/complete-profile', $user['phone']) }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-body">
                        @if($user['gender'] == null)
                        <div class="form-group form-md-line-input gender-wrapper">
                            <select class="form-control gender-select" name="gender" required>
                                <option value="">Jenis Kelamin</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <img class="select-img" src="{{ asset('img/webview/arrow-down-brown.png') }}" alt="">
                        </div>
                        @endif

                        @if($user['birthday'] == null)
                        <div class="form-group form-md-line-input birthday">
                            <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="birthday" value="{{ old('birthday') }}" required>
                            <img class="birthday-img" src="{{ asset('img/webview/calendar-brown.png') }}" alt="">
                        </div>
                        @endif


                        @if($user['id_city'] == null)
                        <div class="form-group form-md-line-input city">
                            <select class="form-control select2" placeholder="Select City" name="id_city" required style="width: 100%;">
                                <option value="">Kota</option>
                                @foreach ($cities as $city)
                                    <option value="{{$city['id_city']}}" {{ (old('id_city')==$city['id_city'] ? "selected" : "") }}>{{ $city['city_type']. " " .$city['city_name'] }}</option>
                                @endforeach
                            </select>
                            <img class="select-img" src="{{ asset('img/webview/arrow-down-brown.png') }}" alt="">
                        </div>
                        @endif

                        <div class="form-actions noborder" style="margin-top: 70px; margin-bottom: 30px;">
                            <div class="button-wrapper text-center">
                                <input type="submit" value="SIMPAN" class="btn btn-round btn-outline brown">
                            </div>

                            <div class="button-wrapper text-center" style="margin-top: 20px;">
                                <a href="{{ url('webview/complete-profile/later', $user['phone']) }}" class="btn btn-round btn-outline btn-default">LEWATI</a>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- end form --}}
                @else
                    <div class="alert alert-warning">Data is completed</div>
                @endif
            @else
                <div class="alert alert-warning">Data not found</div>
            @endif
        </div>
                            
        <!-- END CONTAINER -->
        <!--[if lt IE 9] -->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ url('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ url('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        {{-- <script src="{{ url('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script> --}}
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $('.datepicker').datepicker({
                'format' : 'd-M-yyyy',
                'autoclose' : true
            });
            $('.select2').select2();
        </script>

        <script>
            var x, i, j, selElmnt, a, b, c;
            /*look for any elements with the class "gender-wrapper":*/
            x = document.getElementsByClassName("gender-wrapper");
            for (i = 0; i < x.length; i++) {
              selElmnt = x[i].getElementsByClassName("gender-select")[0];
              /*for each element, create a new DIV that will act as the selected item:*/
              a = document.createElement("DIV");
              a.setAttribute("class", "select-selected");
              a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
              x[i].appendChild(a);
              /*for each element, create a new DIV that will contain the option list:*/
              b = document.createElement("DIV");
              b.setAttribute("class", "select-items select-hide");
              for (j = 0; j < selElmnt.length; j++) {
                /*for each option in the original select element,
                create a new DIV that will act as an option item:*/
                c = document.createElement("DIV");
                c.innerHTML = selElmnt.options[j].innerHTML;
                c.addEventListener("click", function(e) {
                    /*when an item is clicked, update the original select box,
                    and the selected item:*/
                    var y, i, k, s, h;
                    s = this.parentNode.parentNode.getElementsByClassName("gender-select")[0];
                    h = this.parentNode.previousSibling;
                    for (i = 0; i < s.length; i++) {
                      if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                          y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                      }
                    }
                    h.click();
                });
                b.appendChild(c);
              }
              x[i].appendChild(b);
              a.addEventListener("click", function(e) {
                  /*when the select box is clicked, close any other select boxes,
                  and open/close the current select box:*/
                  e.stopPropagation();
                  closeAllSelect(this);
                  this.nextSibling.classList.toggle("select-hide");
                  this.classList.toggle("select-arrow-active");
                });
            }
            function closeAllSelect(elmnt) {
              /*a function that will close all select boxes in the document,
              except the current select box:*/
              var x, y, i, arrNo = [];
              x = document.getElementsByClassName("select-items");
              y = document.getElementsByClassName("select-selected");
              for (i = 0; i < y.length; i++) {
                if (elmnt == y[i]) {
                  arrNo.push(i)
                } else {
                  y[i].classList.remove("select-arrow-active");
                }
              }
              for (i = 0; i < x.length; i++) {
                if (arrNo.indexOf(i)) {
                  x[i].classList.add("select-hide");
                }
              }
            }
            /*if the user clicks anywhere outside the select box,
            then close all select boxes:*/
            document.addEventListener("click", closeAllSelect);
            </script>
</body>

</html>