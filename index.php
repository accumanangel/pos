<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | NetWorth</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!--Icon-->
    <link rel="shortcut icon" href="dist/img/networth.png">
    
</head>

<body class="hold-transition login-page accent-dark">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card rounded-0 shadow">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-lg-12">
                        <img src="dist/img/metipix.png" width="300">
                    </div>
                    

                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg" id="sign-in-progress">Sign in to start your session</p>

                <form action="networth/user.php" id="login-form" name="login-form" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="username" id="username" name="username" class="form-control rounded-0" placeholder="Username..." autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text rounded-0">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Password" required autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text rounded-0">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="icheck-success">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-4 col-md-6">
                            <button type="submit" name="loginBtn" id="loginBtn" class="btn btn-dark btn-block rounded-0"><i class="fa fa-sign-in-alt"></i> Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="form-group mt-3">
                </div>

                

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE App -->
    
    <script>
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        /**
         * user login
         * 
         * */
        $("#login-form").submit(function(e) {
            e.preventDefault();
            // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr("action");
            var username = $("#username").val();
            var password = $("#password").val();
            var action = "login";

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    username: username,
                    password: password,
                    action: action,
                }, // serializes the form's elements.
                beforeSend: function() {
                    $('#sign-in-progress').text("Authenticating...");
                },
                success: function(response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.status == 1) {
                            $('#sign-in-progress').text("Redirecting...");
                            window.location.href = "home/";
                        } else {
                            $('#sign-in-progress').text("Sign in to start your session");
                            Toast.fire({
                                icon: 'error',
                                title: data.message
                            });
                            document.getElementById('login-form').reset();
                        }
                    } catch (e) {
                        console.error("JSON parse error: ", e);
                        console.log("Response: ", response);
                        $('#sign-in-progress').text("Sign in to start your session");
                        Toast.fire({
                            icon: 'error',
                            title: "An error occurred. Please try again."
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: ", error);
                    console.log("Status: ", status);
                    console.log("Response: ", xhr.responseText);
                    $('#sign-in-progress').text("Sign in to start your session");
                    Toast.fire({
                        icon: 'error',
                        title: "An error occurred. Please try again."
                    });
                }
            });
        });
    });
</script>
</body>

</html>