<?php

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set new password</title>
</head>
<body>
<form method="post" action="{{config('app.url')."/password-reset"}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" value="{{app('request')->input('code')}}" name="token">
    <div>
    <p>Email</p>
    <input name="email" type="email" required >
    </div>
    <div>
        <p> New Password</p>
        <input name="new_password" type="password" required>
    </div>
    <button type="submit"> Submit </button>
</form>

</body>
</html>
