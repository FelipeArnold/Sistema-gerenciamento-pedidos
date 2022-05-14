
<?php
extract($_REQUEST);

include '../../source/session/session.php';

$banco = $_SESSION['banco'];
$con = $_SESSION['Empresa']['con'] = @mysqli_connect("$banco->Hosting_Acesso:$banco->Porta_Acesso", "$banco->User_Acesso", "$banco->Senha_Acesso", "$banco->Banco_Acesso");