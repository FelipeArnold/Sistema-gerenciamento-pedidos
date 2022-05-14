 <header class="topbar" data-navbarbg="skin5">
     <nav class="navbar top-navbar navbar-expand-md navbar-dark">
         <div class="navbar-header" data-logobg="skin5">
             <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
             <a class="navbar-brand" href="./home.php">
                 <b class="">
                     <img src="assets/images/background/icone.png" alt="homepage" class="light-logo " style="max-width: 100%;"/>
                 </b>
                 <span class="logo-text">
                     <img src="assets/images/background/textoLogo.png" alt="homepage" class="light-logo img-fluid" />
                 </span>
             </a>
             <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
         </div>
         <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
             <ul class="navbar-nav float-left mr-auto">
                 <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <span class="d-none d-md-block"> <i class="fa fa-plus"></i> Novo <i class="fa fa-angle-down"></i></span>
                         <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>
                     </a>
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                         <a class="dropdown-item" href="?pg=pedido/cadastro">Pedido</a>
                         <button class="dropdown-item" onclick="modal_cadastro('Cadastro Cliente', 'cliente/cadastro')">Cliente</button>
                     </div>
                 </li>
             </ul>
             <ul class="navbar-nav float-right">
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                     <div class="dropdown-menu dropdown-menu-right user-dd animated">
                         <a class="dropdown-item" href="?pg=empresa/consulta"><i class="ti-user m-r-5 m-l-5"></i> Perfil </a>
                         <a class="dropdown-item" href="?pg=financeiro/consulta"><i class="ti-wallet m-r-5 m-l-5"></i> Financeiro </a>
                     </div>
                 </li>
             </ul>
         </div>
     </nav>
 </header>