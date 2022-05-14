<?php
extract($_REQUEST);

session_start();
session_regenerate_id();

if ($_SESSION['chaveAcesso'] == false) {
    header("Location: login.php");
    session_unset();
    session_destroy();
    exit;
} else if ($_SESSION['chaveAcesso']) {
    require_once 'application/source/banco/conexaoLogin.php';
    require_once 'application/source/banco/conexao.php';

    if ($acao == 'sair') {
        header("Location: login.php");
        session_unset();
        session_destroy();
        exit;
    }

    require_once 'application/source/features/mkdir.php';
    /**Require de funcoes para o sistema */
    require_once 'application/source/php/geral.php';

    $pg = $pg ? 'application/view/' . $pg . '.php' : 'application/view/painel/index.php';

    /**Include do header */
    include 'application/source/features/head.php';

?>

    <body>

        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div id="main-wrapper" data-sidebartype="mini-sidebar" class="mini-sidebar">
            <!--HEADER -->
            <?php include 'application/source/features/header.php'; ?>
            <!--MENU LATERAL -->
            <?php include 'application/source/features/menu-lateral.php'; ?>
            <div class="page-wrapper">
                <div class="page-breadcrumb">
                    <div class="row">
                    </div>
                </div>
                <div class="container-fluid pt-0">
                    <?php include_once $pg; ?>
                </div>

                <div class="modal fade" id="modalConteudo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitulo"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true" class="mdi mdi-close-box text-danger"></span>
                                </button>
                            </div>
                            <div class="modal-body conteudo-modal"></div>
                        </div>
                    </div>
                </div>

                <!--FOOTER-->
                <footer class="footer text-center">
                    Todos os direitos reservados. Desenvolvido por Pedi Food <a href="https://wrappixel.com">Pedi Food</a>.
                </footer>
            </div>
        </div>

        <?php
        include 'application/source/features/scripts.php';
        ?>
        <script src="application/source/js/geral.js"></script>
    <?php
    //session_destroy();
    mysqli_close($con);
}


    ?>
    </body>

    </html>