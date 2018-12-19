<form class="form-horizontal form-row-separated" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Top Text <span class="required" aria-required="true"> * </span> </label>
            <div class="col-md-9">
                <textarea name="value" class="form-control summernote">@if (isset($advert['text_top'][0])){{ $advert['text_top'][0]['value'] }}@endif</textarea>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <div class="col-md-5"></div>
        <div class="col-md-7">
            <input type="hidden" name="page" value="{{ $page }}">
            <input type="hidden" name="type" value="text_top">
            <input type="hidden" name="current" value="textontop">
            <button type="submit" class="btn green">Submit</button>
          {{ csrf_field() }}
        </div>
    </div>
</form>