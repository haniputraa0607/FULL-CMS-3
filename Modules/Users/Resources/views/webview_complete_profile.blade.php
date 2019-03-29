<?php
    use App\Lib\MyHelper;
    $title = "User Profile";
?>
@extends('webview.main')

@section('page-style-plugin')

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{Cdn::asset('kk-ass/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{Cdn::asset('kk-ass/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 

    <!-- END PAGE LEVEL STYLES -->
@stop

@section('css')
    <style type="text/css">
        .text-brown{
            color: #6C5648;
        }
        .text-red{
          color: #e64343;
        }
        .text-error{
          margin-top: 5px;
        }
        .form-group.form-md-line-input{
          margin-bottom: 10px;
        }
        .form-group label{
          color: #666666;
          font-size: 13px;
          margin-bottom: 0px;
        }
        /* remove input number spinner */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
        input[type=number] {
          -moz-appearance:textfield; /* Firefox */
        }

        /* custom select */
        .select-wrapper,
        /*.birthday,*/
        .city {
          position: relative;
        }
        .custom-select {
          display: none; /*hide original SELECT element:*/
        }
        .select-selected {
          color: #000;
          padding: 8px 0px;
        }
        /* the arrow inside the select element: */
        .select-img{
          position: absolute;
          top: 55px;
          right: 3px;
          width: 17px;
          height: 17px;
          z-index: -1;
        }
        .city .select-img{
          top: 52px;
        }
        /*style the items (options), including the selected item:*/
        .select-selected {
          border-bottom: 1px solid #c2cad8;
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
          top: 98%;
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
        .select2-search__field{
            border: 1px solid #c2cad8;
        }
        span.select2-selection.select2-selection--single {
            outline: none;
        }
        .select2-container{
            padding-top: 1px;
        }
        .select2 .select2-container--default,
        .select2 .select2-selection--single,
        .select2 .select2-selection__rendered{
            line-height: 34px !important;
            padding-left: 0px !important;
            color: #000 !important;
            font-family: "Seravek";
            border-bottom: 1px solid #c2cad8;
        }
        .select2 .select2-selection--single{
            height: 34px;
            border: none;
        }
        .select2-results{
            height: 160px;
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
          animation: btn-click 0.5s;
        }
        @keyframes btn-click {
          0% {
            background-color: #fff;
            color: #6C5648;
          }
          50% {
            background-color: #6C5648;
            color: #fff;
          }
          100% {
            background-color: #fff;
            color: #6C5648;
          }
        }

        .birthday-wrapper input.form-control{
          height: 36px;
          padding-top: 8px;
          padding-bottom: 8px;
          border-bottom-color: #c2cad8;
          color: #000 !important;
          font-size: 15px;
        }
    </style>
@stop

@section('content')
    <div class="col-md-4 col-md-offset-4" style="position: unset;">
        <div class="text-brown" style="margin-top: 20px; margin-bottom: 20px; text-align: justify;">
            Silakan lengkapi data di bawah ini dan dapatkan Kenangan Points
        </div>

        @if(isset($errors))
          <div class="alert alert-danger text-red" role="alert" style="margin-top:20px; margin-bottom: 0px;">
           @foreach($errors as $e)
            <p>{{ $e }}</p>
           @endforeach
         </div>
        @endif

        @if($user != null)
            @if($user['birthday'] == null && $user['gender'] == null && $user['id_city'] == null)
            {{-- form --}}
            <form role="form" action="{{ url('webview/complete-profile/submit') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-body">
                    <div class="form-group form-md-line-input select-wrapper">
                        <label>Jenis Kelamin</label>
                        <select class="form-control custom-select gender-select" name="gender" required>
                            <option value="Male" selected>Laki-laki</option>
                            <option value="Female">Perempuan</option>
                        </select>
                        <img class="select-img" src="{{ asset('img/webview/arrow-down.png') }}" alt="">
                    </div>

                    <div class="form-group form-md-line-input birthday">
                        <label>Tanggal Lahir</label>

                        <div class="birthday-wrapper row">
                            <div class="form-md-line-input date-select col-xs-3">
                              <input id="date-input" class="form-control text-center" type="tel" name="date" maxlength="2" placeholder="Tanggal">
                            </div>
                            <div class="form-md-line-input col-xs-3">
                              <input id="month-input" class="form-control text-center" type="tel" name="month" maxlength="2" placeholder="Bulan">
                            </div>
                            <div class="form-md-line-input col-xs-4">
                              <input id="year-input" class="form-control text-center" type="tel" name="year" maxlength="4" placeholder="Tahun">
                            </div>
                        </div>
                        <div id="error-birthday" class="text-red text-error"></div>
                    </div>

                    <div class="form-group form-md-line-input city">
                        <label>Kota Domisili</label>
                        <select id="id_city" class="form-control select2 id_city" placeholder="Select City" name="id_city" required style="width: 100%;">
                            @foreach ($cities as $city)152
                                <option value="{{$city['id_city']}}" @if(old('id_city')==$city['id_city']) selected @elseif($city['id_city']=="152") selected @endif>{{ $city['city_type']. " " .$city['city_name'] }}</option>
                            @endforeach
                        </select>
                        <img class="select-img" src="{{ asset('img/webview/arrow-down.png') }}" alt="">
                        <div id="city-dropdown" style="position: relative;"></div>
                        <div id="error-city" class="text-red text-error"></div>
                    </div>

                    <div class="form-group form-md-line-input select-wrapper relationship">
                        <label>Relationship</label>
                        <select class="form-control custom-select" name="relationship">
                            <option value="" selected>-</option>
                            <option value="In a Relationship">In a Relationship</option>
                            <option value="Complicated">Complicated</option>
                            <option value="Jomblo">Jomblo</option>
                        </select>
                        <img class="select-img" src="{{ asset('img/webview/arrow-down.png') }}" alt="">
                    </div>

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
    <script src="{{Cdn::asset('kk-ass/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ url('assets/webview/scripts/select2-custom.js') }}" type="text/javascript"></script>
    {{-- <script src="{{Cdn::asset('kk-ass/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script> --}}
    <!-- END CORE PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{Cdn::asset('kk-ass/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
          // force select2 to open in below
          $('.select2').select2({
            positionDropdown: true,
            dropdownParent: $('#city-dropdown')
          });

          // change submit button's position from absolute to relative
          var body = $("body").height();
          body = body + 170;
          var win = $(window).height();

          if (body > win) {
              $(".button-wrapper").css({'position': 'relative', 'bottom': '0px'});
              $(".form-actions").css({'margin-top': '150px'});
          }
        });

        /* check screen when keyboard show */
        $('body').on('focus', 'input, .select2-search__field', function() {
          var body = $("body").height();
          body = body + 170;
          var win = $(window).height();

          $('.select2-container--open').css({'position': 'relative', 'top': '0'});
          $('.select2-dropdown').css('position', 'relative');

          // change submit button's position from absolute to relative
          if (body > win) {
              $(".button-wrapper").css({'position': 'relative', 'bottom': '0px'});
              $(".form-actions").css({'margin-top': '150px'});
          }
        });

        /* check screen when keyboard hide */
        $('body').on('blur', 'input, .select2-search__field', function() {
          var body = $("body").height();
          body = body + 170;
          var win = $(window).height();

          // change submit button's position from relative to absolute
          if (body < win) {
              $(".button-wrapper").attr('style', '');
              $(".form-actions").css({'margin-top': '70px'});
          }
        });

        /* check last date if month change */
        $('#month-input').on('change, keyup', function (e) {
          var month = $(this).val();
          var year = $('#year-input').val();
          if (year == "") {
            var today = new Date();
            var year = today.getFullYear();
          }
          var d = new Date(year, month, 0);
          var last_day = d.getDate();

          var date = $('#date-input').val();
          // reset selected date
          if (date > last_day) {
            date = 1;
            $('#date-input').val(date);
          }
        });
        // check february last day
        $('#year-input').on('change, keyup', function(e) {
          var year = $(this).val();
          var month = $('#month-input').val();
          if (month == 2) {
            var d = new Date(year, month, 0);
            var last_day = d.getDate();
            
            var date = $('#date-input').val();
            // reset selected date
            if (date > last_day) {
              date = 1;
              $('#date-input').val(date);
            }
          }
        });

        // validate date
        var date_input = document.getElementById('date-input');
        date_input.addEventListener('keydown', validateDate);
        date_input.addEventListener('keyup', validateDateRange);
        // validate month
        var month_input = document.getElementById('month-input');
        month_input.addEventListener('keydown', validateMonth);
        month_input.addEventListener('keyup', validateMonthRange);
        // validate year
        var year_input = document.getElementById('year-input');
        year_input.addEventListener('keydown', validateYear);

        function validateDate(e) {
          var date = date_input.value;
          var keycode = (typeof e.which == "number") ? e.which : e.keyCode;
          // max 2 digit
          // except backspace, delete, tab
          if (keycode != 8 && keycode != 46 && keycode != 9) {
            if (date.length == 2) {
              e.preventDefault();
            }
          }
          // accept only numeric in date
          if (keycode != 0 && keycode != 8 && keycode != 9 && (keycode < 48 || keycode > 57)) {
              e.preventDefault();
              if (keycode == 13) {
                // on enter, focus on month input
                month_input.focus();
              }
          }
        }
        // check date range
        function validateDateRange(e) {
          var date = date_input.value;
          var month = month_input.value;
          var year = year_input.value;
          if (year == "") {
            var today = new Date();
            var year = today.getFullYear();
          }
          var d = new Date(year, month, 0);
          var last_day = d.getDate();
          if (date == 0) {
            date_input.value = "";
          }
          else if (date > last_day) {
            date = date.slice(0, 1);
            date_input.value = date;
          }
        }

        function validateMonth(e) {
          var month = month_input.value;
          var keycode = (typeof e.which == "number") ? e.which : e.keyCode;
          // max 4 digit
          // except backspace, delete, tab
          if (keycode != 8 && keycode != 46 && keycode != 9) {
            if (month.length == 2) {
              e.preventDefault();
            }
          }
          // accept only numeric in month
          if (keycode != 0 && keycode != 8 && keycode != 9 && (keycode < 48 || keycode > 57)){
            e.preventDefault();
            if (keycode == 13) {
              // on enter, focus on month input
              year_input.focus();
            }
          }
        }
        // check month range
        function validateMonthRange(e) {
          var month = month_input.value;
          if (month == 0) {
            month_input.value = "";
          }
          else if (month > 12) {
            month = month.slice(0, 1);
            month_input.value = month;
          }
        }
        
        function validateYear(e) {
          var year = year_input.value;
          var keycode = (typeof e.which == "number") ? e.which : e.keyCode;
          // max 4 digit
          // except backspace, delete, tab
          if (keycode != 8 && keycode != 46 && keycode != 9) {
            if (year.length == 4) {
              e.preventDefault();
            }
          }
          // accept only numeric in year
          if (keycode != 0 && keycode != 8 && keycode != 9 && (keycode < 48 || keycode > 57)) {
            e.preventDefault();
            if (keycode == 13) {
              // on enter, remove cursor from field
              year_input.blur();
            }
          }
        }

        $('form').submit(function(e) {
          var gender = $('.gender-select').val();
          var birthday_d = $('#date-input').val();
          var birthday_m = $('#month-input').val();
          var birthday_y = $('#year-input').val();
          var id_city = $('.id_city').val();

          if (gender=="" || birthday_d=="" || birthday_m=="" || birthday_y=="" || id_city=="" ) {
            e.preventDefault();
            if (birthday_d=="" || birthday_m=="" || birthday_y=="") {
              $('#error-birthday').text('Tanggal Lahir tidak boleh kosong')
            }
            if (id_city=="") {
              $('#error-city').text('Kota tidak boleh kosong')
            }
          }

          if (birthday_y.length > 4) {
            e.preventDefault();
            $('#error-birthday').text('Tahun maksimal 4 digit')
          }
        });
        
    </script>

    <script>
        /* custom select */
        var x, i, j, selElmnt, a, b, c;
        /*look for any elements with the class "select-wrapper":*/
        x = document.getElementsByClassName("select-wrapper");
        for (i = 0; i < x.length; i++) {
          selElmnt = x[i].getElementsByClassName("custom-select")[0];
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
                s = this.parentNode.parentNode.getElementsByClassName("custom-select")[0];
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