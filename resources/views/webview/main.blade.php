<!DOCTYPE html>
<html>
	@include('webview.head')

	<body>
		@yield('content')

		@yield('page-script')

		<script src="{{ url('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
		<script type="text/javascript" src="{{ url('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	</body>
</html>