<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<script src="{{Cdn::asset('kk-ass/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$( document ).ready(function() {
			var messages = '{!! $messages[0] !!}';
		    alert(messages);
		    window.location = "http://www.google.co.id";
		});
	</script>
</body>
</html>