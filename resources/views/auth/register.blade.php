
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
   <title>Electronic Mail Administration System - Login</title>
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
   <!-- Fontawesome CSS -->
   <link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css">
   <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">
   <!-- Main CSS -->
   <link rel="stylesheet" href="/assets/css/style.css">
   <!--[if lt IE 9]>
      <script src="/assets/js/html5shiv.min.js"></script>
      <script src="/assets/js/respond.min.js"></script>
   <![endif]-->
</head>
<body>
   <!-- Main Wrapper -->
   <div class="main-wrapper login-body">
      <div id="login" class="login-wrapper">
         <div class="container">
            <div class="loginbox">
               <div class="login-right">
                  <div class="login-right-wrap">
                     <h1>Daftar Akun</h1>
                     <p class="account-subtitle">Untuk Mengakses Dashboard</p>
                     <form action="{{ route('auth.submitRegister') }}" method="POST" autocomplete="off">
                        @csrf
                        @if ($message = Session::get('error'))
                          <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @endif
                        <div class="form-group">
                           <label class="form-control-label">Nama Lengkap</label>
                           <input name="name" type="name" class="form-control" required />
                        </div>
                        <div class="form-group">
                           <label class="form-control-label">Alamat Email</label>
                           <input name="email" type="email" class="form-control" required />
                        </div>
                        <div class="form-group">
                           <label class="form-control-label">Kata Sandi</label>
                           <div class="pass-group">
                              <input name="password" type="password" class="form-control pass-input" required />
                              <span class="fas fa-eye toggle-password"></span>
                           </div>
                        </div>
                        <button class="btn btn-lg btn-block btn-primary" type="submit">Submit</button>
                        <a class="btn btn-lg btn-block btn-outline-primary" href="{{ route('auth.login') }}">Kembali Login</a>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /Main Wrapper -->
   <!-- jQuery -->
   <script src="/assets/js/jquery-3.5.1.min.js"></script>
   <!-- Bootstrap Core JS -->
   <script src="/assets/js/popper.min.js"></script>
   <script src="/assets/js/bootstrap.min.js"></script>
   <!-- Feather Icon JS -->
   <script src="/assets/js/feather.min.js"></script>
   <!-- Custom JS -->
   <script src="/assets/js/script.js"></script>
</body>
</html>