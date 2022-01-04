<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill email</title>
</head>
<body>
<p> Hello  </p>
<p> Please fill email to get new password </p>
@if($errors->any())
    <h4>{{$errors->first()}}</h4>
@endif

<form method="post" action="{{$url_post}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input name="email" type="email" required>
    <button type="submit"> Submit </button>
</form>
</body>
</html>
