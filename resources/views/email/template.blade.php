<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<p>
Halo {{ $name }}, <br/><br/>

Silahkan klik <a href="http://localhost:8000/auth/verify/{{ $link }}">Aktivasi</a> untuk mengaktifkan akun anda.<br/>
Atau buka browser kemudian paste alamat : http://localhost:8000/auth/verify/{{ $link }}<br/><br/>

Hormat kami,<br/>
Admin Support
</p>
</body>
</html>