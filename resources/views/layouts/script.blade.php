<!-- BEGIN CORE PLUGINS -->
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
@yield('page-plugin')
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
@yield('page-script')
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<script src="{{ env('AWS_ASSET_URL') }}{{ ('assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<!-- <script>
	$(document).ready(function()
	{
		$('#clickmewow').click(function()
		{
			$('#radio1003').attr('checked', 'checked');
		});
	})
</script> -->