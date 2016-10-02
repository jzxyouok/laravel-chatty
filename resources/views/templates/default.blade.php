<html lang="en">
<head>
	<title>Chatty</title>
	<link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	@include('templates.partials.navigation')
	<div class="container">
		@include('templates.partials.alerts')

		@yield('content')
	</div>

</body>
</html>