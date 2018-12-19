<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Technopartner Indonesia CRM System" name="description" />
	<title></title>
    <link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ url('assets/customer/css/spin-the-wheel.css') }}" rel="stylesheet" type="text/css" /> 

</head>
<body>
	@if($spin_items != null)
		<div class="spin">
			<div class="hidden-xs">
	            <div class="the_wheel" align="center" valign="center">
	                <canvas id="canvas" class="canvas" width="450" height="450">
	                    <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
	                </canvas>

	            	<div class="pointer"></div>

	            	<button type="button" class="spin-btn" class="btn" data-toggle="modal" data-target="#modal-spin">
	            		Spin
					</button>
	            </div>
            </div>

            <!-- mobile version -->
            <div class="visible-xs">
	            <div class="the_wheel" align="center" valign="center">
	                <canvas id="canvas-mobile" class="canvas" width="280" height="280">
	                    <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
	                </canvas>

	            	<div class="pointer"></div>

	            	<button type="button" class="spin-btn" class="btn" data-toggle="modal" data-target="#modal-spin">
	            		Spin
					</button>
	            </div>
            </div>
		</div>

		<div class="congratulation center-block text-center">
			<h3>Congratulation!</h3>
			<div>You won <b id="deals-title"></b></div>
			<br>
			<br>
			<br>
			<a href="" class="btn btn-primary btn-lg">Try Again</a>
		</div>
	@else
		<div>
			<h3 class="text-center">Sorry, spin the wheel is not available</h3>
		</div>
	@endif

	<!-- confirm modal -->
	<div class="modal fade" id="modal-spin" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        <p>You need use <b class="text-danger">{{ $spin_point }}</b> point to play</p>
	        <p>Are you sure?</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-primary" id="spin-confirm-btn">Yes</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- alert modal -->
	<div class="modal fade" id="modal-alert" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        <div class="text-danger">Something went wrong. Please try again later.</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="{{ url('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/customer/scripts/winwheel.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/customer/scripts/TweenMax.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
    	var screen = $(window).width();
    	
    	var spin_items = {!! $spin_items_id !!};
    	var segments   = {!! $spin_items !!};
    	var prize_id = {!! $spin_prize['id_deals'] !!};
    	var prize_title = "{!! $spin_prize['deals_title'] !!}";
    	var success = 0;

    	if (screen > 500) {
			var myWheel = new Winwheel({
				'canvasId'    : 'canvas',
		        'numSegments' : "{!! $spin_count !!}",
		        'outerRadius' : 180,
		        'lineWidth '  : 3,
		        'segments'    : segments,
		        'animation'	  :
		        {
		            'type'          : 'spinToStop',
		            'duration'      : 5,
		            'spins'         : 8,
		            'callbackFinished' : 'showPrize()'
		        }
		    });
		}
		else {	// mobile version
    		var myWheel = new Winwheel({
				'canvasId'    : 'canvas-mobile',
		        'numSegments' : "{!! $spin_count !!}",
		        'outerRadius' : 130,
		        'lineWidth '  : 3,
		        'segments'    : segments,
		        'animation'	  :
		        {
		            'type'          : 'spinToStop',
		            'duration'      : 5,
		            'spins'         : 8,
		            'callbackFinished' : 'showPrize()'
		        }
		    });
    	}

    	var spin_url = "{{ url('customer/spin-the-wheel/spin', $user_phone) }}"
        function ajax_spin() {
            $.ajax({
                type : "GET",
                url : spin_url,
                success : function(result) {
                    if (result != "") {
		                // flag for showPrize
		                success = 1;
                    }
                },
                fail: function(xhr, textStatus, errorThrown){
	       			$('#modal-alert').modal('show');
			    }
            });
        }

    	function searchPrize(id_deals) {
    		// get number segment by position in spin_items array
    		var position = jQuery.inArray( id_deals, spin_items );
			return (position + 1);
    	}

        $('#spin-confirm-btn').on('click', function() {
		    // flag for showPrize
        	success = 0;
            $('#modal-spin').modal('hide');
            var number_segment = searchPrize(prize_id);
            // Get random angle inside specified segment of the wheel.
            var stopAt = myWheel.getRandomForSegment(number_segment);

            // Important thing is to set the stopAngle of the animation before stating the spin.
            myWheel.animation.stopAngle = stopAt;
		    myWheel.startAnimation();
        	ajax_spin();
        })

	    // show prize after finish
	    function showPrize(){
	    	if(success == 1){
	    		$('.spin').hide();
	            $('#deals-title').text(prize_title);
	            $(".congratulation").show();
	    	}
	    	else {
	       		$('#modal-alert').modal('show');
	    	}
	    }

        $( document ).ajaxError(function() {
			$('#modal-alert').modal('show');
		});

    </script>

</body>
</html>