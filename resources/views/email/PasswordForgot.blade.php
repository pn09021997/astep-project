<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bala Test XX</title>
</head>
<body>
<p>Hello . This is email from {{config('app.name')}} </p>
<p>This is Email for Reset password </p>
<p>Please Click link below to setup new password </p>
<p><a href="{{$detail['verify_code']}}">Click here</a></p>
</body>
</html>
