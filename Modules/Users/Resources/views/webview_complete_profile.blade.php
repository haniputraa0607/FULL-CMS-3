<?php
    use App\Lib\MyHelper;
    $title = "User Profile";
?>
@extends('webview.main')

@section('page-style-plugin')
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ url('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ url('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ url('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <!-- END PAGE LEVEL STYLES -->
@stop

@section('css')
    <style type="text/css">
        .text-brown{
            color: #6C5648;
        }
        .form-group label{
          color: #666666;
          font-size: 13px;
        }
        .birthday input{
            color: #000 !important;
            font-size: 15px;
        }
        .birthday-img{
          position: absolute;
          top: 50px;
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
          /*border-bottom: 1px solid #D9D6D6;*/
          padding: 8px 0px;
        }
        /* the arrow inside the select element: */
        .select-img{
          position: absolute;
          top: 55px;
          right: 3px;
          width: 17px;
          height: 17px;
        }
        /*style the items (options), including the selected item:*/
        .select-selected {
          border: 1px solid #c2cad8;
          border: 1px solid transparent;
          border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
          cursor: pointer;
          user-select: none;
        }
        .select-items div{
          color: #333;
          padding: 8px;
        }
        /*style items (options):*/
        .select-items {
          border: 1px solid #c2cad8;
          position: absolute;
          background-color: #fff;
          top: 99%;
          left: 0;
          right: 0;
          z-index: 99;
        }
        /*hide the items when the select box is closed:*/
        .select-hide {
          display: none;
        }
        .select-items div:hover, .same-as-selected {
          color: #fff !important;
          background-color: #6C5648;
        }
        /* end of custom select */

        .form-group.form-md-line-input .form-control[readonly]{
          border-style: solid !important;
        }

        /* select 2 */
        .select2 .select2-container--default,
        .select2 .select2-selection--single,
        .select2 .select2-selection__rendered{
            line-height: 34px !important;
            padding-left: 0px !important;
            color: #000 !important;
            font-family: "Seravek";
        }
        .select2 .select2-selection--single{
            height: 34px;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom-color: #D9D6D6;
        }
        .select2-results{
            height: 200px;
            overflow: auto;
        }
        .select2-results__option{
            color: #000;
        }
        .select2-container--default,
        .select2-results__option--highlighted[aria-selected] {
            background-color: #6C5648 !important;
            color: #fff;
        }
        .select2-selection__arrow{
            display: none;
        }

        .button-wrapper {
          position: absolute;
          bottom: 30px;
          left: 0;
          right: 0;
        }
        .button-wrapper .btn{
            width: 75%;
            max-width: 400px;
            font-size: 16px;
        }
        .btn-round{
            border-radius: 25px !important;
        }
        .btn-outline.brown{
            border-color: #6C5648;
            color: #6C5648;
            background-color: #fff;
        }
        .btn-outline.brown:focus{
          background-color: #6C5648;
          color: #fff;
        }

        .datepicker table td, .datepicker table th, .datetimepicker table td, .datetimepicker table th{
            font-family: "Seravek", sans-serif !important;
        }
        .datepicker .active {
            background-color: #6C5648 !important;
        }
        .datepicker .active:hover{
            background-color: #907462 !important;
        }
    </style>
@stop

@section('content')
    <div class="col-md-4 col-md-offset-4" style="position: unset;">
        @include('layouts.notifications')
        
        <div class="text-brown" style="margin-top: 50px; margin-bottom: 20px; text-align: justify;">
            Silahkan lengkapi data di bawah ini dan dapatkan Kopi Points
        </div>

        @if($user != null)
            @if($user['birthday'] == null || $user['gender'] == null || $user['id_city'] == null)
            {{-- form --}}
            <form role="form" action="{{ url('webview/complete-profile') }}" method="post">
                {{ csrf_field() }}

                <div class="form-body">
                    @if($user['gender'] == null)
                    <div class="form-group form-md-line-input gender-wrapper">
                        <label>Jenis Kelamin</label>
                        <select class="form-control gender-select" name="gender" required>
                            <option value="Male" selected>Laki-laki</option>
                            <option value="Female">Perempuan</option>
                        </select>
                        <img class="select-img" src="{{ asset('img/webview/arrow-down.png') }}" alt="">
                    </div>
                    @endif

                    @if($user['birthday'] == null)
                    <div class="form-group form-md-line-input birthday">
                        <label>Tanggal Lahir</label>
                        <input type="text" class="form-control datepicker" name="birthday" value="{{ old('birthday') }}" required readonly>
                        <img class="birthday-img" src="{{ asset('img/webview/calendar-o.png') }}" alt="">
                    </div>
                    @endif

                    @if($user['id_city'] == null)
                    <div class="form-group form-md-line-input city">
                        <label>Kota</label>
                        <select class="form-control select2" placeholder="Select City" name="id_city" required style="width: 100%;">
                            @foreach ($cities as $city)152
                                <option value="{{$city['id_city']}}" @if(old('id_city')==$city['id_city']) selected @elseif($city['id_city']=="152") selected @endif>{{ $city['city_type']. " " .$city['city_name'] }}</option>
                            @endforeach
                        </select>
                        <img class="select-img" src="{{ asset('img/webview/arrow-down.png') }}" alt="">
                    </div>
                    @endif

                    <div class="form-actions noborder" style="margin-top: 70px; margin-bottom: 30px;">
                        <input type="hidden" name="bearer" value="{{ $bearer }}">

                        <div class="button-wrapper text-center">
                            <input type="submit" value="SIMPAN" class="btn btn-round btn-outline brown">
                        </div>
                    </div>
                </div>
            </form>
            {{-- end form --}}
            @else
                <div class="alert alert-warning text-brown">Data is completed</div>
            @endif
        @else
            <div class="alert alert-warning text-brown">Data not found</div>
        @endif
    </div>
@stop
                            
@section('page-script')
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
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        /* set default date */
        var date = new Date();
        var year = date.getFullYear();
        var default_year = year - 17;
        var month = date.getMonth();
        var day = date.getDate();
        
        $(document).ready(function() {
          $('.datepicker').datepicker({
              'format' : 'd-M-yyyy',
              'autoclose' : true,
              'defaultViewDate' : {
                'year' : default_year,
                'month': month,
                'day': day
              }
          });
          $('.select2').select2();
        });
        
    </script>

    <script>
        /* custom select */
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
@stop