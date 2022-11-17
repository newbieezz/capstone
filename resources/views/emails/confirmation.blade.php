<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>P-Store Mart</title>
</head>
<body> <br><br>
    <tr><td>Dear {{ $name }} ,</td></tr> <br>
    <tr><td>&nbsp;</td></tr><br><br>
    <tr><td>Welcome to P-Store Mart! 
        <br>Click the link below to activate your Account : 
        <br>  </td></tr>
    <tr><td>&nbsp;</td></tr><br><br>
    <tr><td><a href="{{ url('/user/confirm/'.$code) }}">Confirm Account </a></td></tr> <br>
    <tr><td>&nbsp;</td></tr><br><br><br><br>
    <tr><td>Thanks & Regards,</td></tr><br>
    <tr><td>P-Store Mart</td></tr>
    <tr><td></td></tr>
</body>
</html>

