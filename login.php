<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/background/icone.png">
    <title>Sistema Administrativo - Pedi Food</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="dist/css/geral.css" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-C88N8QBSLK"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-C88N8QBSLK');
	</script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1496537241423254" crossorigin="anonymous"></script>
</head>

<body>
    <div class="main-wrapper">

        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark backgroud">
            <div class="auth-box bg-dark border-top border-secondary radius">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><img src="assets/images/background/soft_pedidos.png" alt="logo" class="img-fluid" /></span>
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-10" id="loginEmpresa">
                        <div class="row p-b-20">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="email" name="emailLogin" class="form-control form-control-lg" placeholder="Login" aria-label="E-mail" aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" name="passwordLogin" class="form-control form-control-lg" placeholder="Senha" aria-label="Password" aria-describedby="basic-addon1" required="">
                                </div>

                            </div>
                        </div>

                        <div class="row border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="">
                                        <!--button class="btn btn-info" id="to-recover" type="button"><i class="fa fa-lock m-r-5"></i> Esqueceu sua senha?</!--button-->
                                        <button class="btn btn-success btn-block float-right" type="submit">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="recoverform">
                    <div class="text-center">
                        <span class="text-white">Insira seu endereço de e-mail abaixo e enviaremos instruções sobre como recuperar uma senha.</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" action="index.html">
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                                </div>
                                <input type="email" class="form-control form-control-lg" placeholder="Digite seu e-mail" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="to-login" name="action">Voltar ao Login</a>
                                    <button class="btn btn-info float-right" type="button" name="action">Recuperar senha</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="application/source/js/geral.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
        $('#to-login').click(function() {
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });

        $('#loginEmpresa').submit(function() {
            var form = $("#loginEmpresa").serialize();

            $.ajax({
                url: 'application/view/login/index.php',
                type: 'POST',
                data: form,
                datatype: 'json',
                success: function(data) {

                    if (data == 1) {
                        exibe_alertaLogin('success');
                        window.location.href = 'home.php';
                    } else {
                        exibe_alertaLogin('error');
                        $("#loginEmpresa input").val('');
                    }
                }
            });
            return false;
        });
    </script>

</body>

</html>