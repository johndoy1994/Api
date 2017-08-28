<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('master-title')</title>
	  <!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @stack('header')
</head>
<body class="@yield('master-body-class') ">
	@yield('master-content')
     <div class="loader"></div>
    @stack('footer')
</body>
</html>
