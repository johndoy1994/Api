<!DOCTYPE html>
<html>
<head>
	<title>Correct Belt</title>
</head>
<body>
	<div style="background-color:#fcf9f9;border:1px solid #ede3e3;padding:10px;">
		<p>Hello {{$data['name']}},</p>
		<br>Your request for new password has been generated. Find you new Password bolow:
		<br><p>Your new Password is : <b>{{$data['newPassword']}}</b></p>
		<br><p>Thank you.<br><strong>{{env("PROJECT_TITLE")}}</strong></p>
	</div>
</body>
</html>
