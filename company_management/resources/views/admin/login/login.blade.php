<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ asset('') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>VT LUXURY - Foot, brain & difference</title>

    <!-- Bootstrap -->
    <link href="backend/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="backend/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="backend/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="backend/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="backend/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <img src="img-logo/VT_luxury.png" alt="Logo" class="w-50">
                <div id="alert" style="opacity: 1; transition: opacity 2s;">
                    @include('Layout.messenger')
                </div>
                <form action="{{ route('admin_authentication.login') }}" method="POST">
                    @csrf
                    <h1>Login Form</h1>
                    <div>
                        <input type="email" name="email" class="form-control" placeholder="Username" required="" />
                    </div>
                    <div>
                        <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                    </div>
                    <div>
                        <button class="btn btn-default submit">Login</button>
                        <a class="reset_pass" href="#">Lost your password?</a>
                    </div>
                    <div class="separator">
                        <p class="change_link">VT LUXURY</p>
                        <p>Foot, brain & difference</p>
                    </div>
                </form>
            </section>
        </div>
    </div>
</body>

<script>
    setTimeout(function() {
        var alertDiv = document.getElementById('alert');
        alertDiv.style.opacity = 0;
        setTimeout(function() {
            alertDiv.style.display = 'none';
        }, 2000);
    }, 5000);

</script>

</html>
