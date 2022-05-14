<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';
require_once '../source/php/geral.php';

$status = 'error';
if ($acao == 'cadastrar' || $acao == 'editar') {

    $where = '';
    if($acao == 'cadastrar') $insertUpdate = "INSERT INTO ";
    else if($acao == 'editar'){
        $insertUpdate = "UPDATE ";
        $where = "WHERE Id_Empresa = '".retorna_somenteNumeros($Id_Empresa)."' ";
    } 
    
    $inUpEmpresa =  $insertUpdate  ." empresa SET Nome_Empresa = '$nomeEmpresa',  Cnpj_Empresa = '".retorna_somenteNumeros($cnpjEmpresa)."',  
                    Email_Empresa = '$email', RazaoSocial_Empresa = '$razaoSocial', Telefone_Empresa = '".retorna_somenteNumeros($telefoneEmpresa)."',
                    Responsavel_Empresa = '".$responsavelEmpresa."', IdLogradouro_Empresa = '".retorna_somenteNumeros($idLogradouro)."' 
                $where";
    
    if (mysqli_query($con, $inUpEmpresa)) $status = 'success';
} 

echo json_encode(array("status" => $status), true);
