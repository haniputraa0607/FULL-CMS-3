<form class="form-horizontal form-row-separated" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
  <div class="form-body">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Bottom Image <span class="required" aria-required="true"> * </span> </label>
            <div class="col-md-9">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 300px; height: 100px;">
                      <img src="http://www.placehold.it/300x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                    <br>
                        <span class="required" aria-required="true"> width (1080) x height (360) </span>
                    <br>
                    <div>
                        <span class="btn default btn-file">
                            <span class="fileinput-new"> Select image </span>
                            <span class="fileinput-exists"> Change </span>
                            {{ csrf_field() }}
                            <input type="hidden" name="page" value="{{ $page }}">
                            <input type="hidden" name="add" value="1">
                            <input type="hidden" name="type" value="img_bottom">
                            <input type="hidden" name="current" value="piconbottom">
                            <input type="file" accept="image/*" name="img_bottom" onChange="this.form.submit();">
                        </span>
                      <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
              </div>
            </div>
        </div>
  </div>
</form>
@if (!empty($advert['img_bottom']))
    <div class="portlet-title m-heading-1 border-green m-bordered">
    	<div class="caption">
    		Sort
    	</div>
    </div>
    <div class="portlet-body">
    	<form action="{{ url()->current() }}" method="POST">
    	  	<div class="form-body">
	    	    	<div class="col-md-12 sortable form-group"> 
	    	    	   @foreach($advert['img_bottom'] as $knc=>$nilai)
	    	    	     <div class="portlet portlet-sortable light bordered col-md-4">
	    	    	       	<div class="portlet-title">
	    	    	         <span class="caption-subject bold" style="font-size: 12px !important;">{{ $knc + 1 }}</span>
	    	    	       	</div>
	    	    	       	<div class="portlet-body">
	    	    	        	<input type="hidden" name="id_advert[]" value="{{ $nilai['id_advert'] }}">
	    	    	        	<center>
	    	    	        		<img src="{{ $nilai['value'] }}" alt="{{ $knc + 1 }}" width="150">
    	    	         			<a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $nilai['id_advert'] }}"><i class="fa fa-trash-o"></i></a>
    	    	        		</center>
	    	    	       	</div>
	    	    	    </div>
	    	    	   @endforeach
	    	    	</div> 
    	  	</div>
	  		<div class="form-actions">
    	    	    <div class="col-md-5"></div>
    	    	    <div class="col-md-7">
                        <input type="hidden" name="current" value="piconbottom">
    	    	    	<input type="hidden" name="rearange" value="yes">
    	    	      	<button type="submit" class="btn green">Submit</button>
    	    	      {{ csrf_field() }}
    	    	    </div>
    	    	</div>
    	</form>  
    </div>
@endif