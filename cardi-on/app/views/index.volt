<!DOCTYPE html>
<html>
	<head>
            <meta charset="utf-8">
            <title>Phalcon PHP Framework</title>
            {{ stylesheet_link('css/bootstrap/bootstrap.css') }}
            {{ stylesheet_link('css/bootstrap/bootstrap-responsive.css') }}
	</head>
	<body>
            {{ content() }}
            {{ javascript_include('js/jquery.min.js') }}
            {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
	</body>
</html>