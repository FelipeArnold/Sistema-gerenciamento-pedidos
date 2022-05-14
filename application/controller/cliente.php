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
        $where = "WHERE Id_Cliente = '".retorna_somenteNumeros($Id_Cliente)."' ";
    } 
    
    $inUpCliente =  $insertUpdate  ." cliente SET Nome_Cliente = '$nomeCliente',  CpfCnpj_Cliente = '".retorna_somenteNumeros($documentoCliente)."',  
                    Email_Cliente = '$emailCliente', DataNascimento_Cliente = '$dataAniverCliente', Telefone_Cliente = '".retorna_somenteNumeros($telefoneCliente)."',
                    Numero_Cliente = '".retorna_somenteNumeros($numero)."', IdLogradouro_Cliente = '".retorna_somenteNumeros($idLogradouro)."' 
                $where";

    
    if (mysqli_query($con, $inUpCliente)) $status = 'success';
} else if ($acao == 'excluir' && !empty((int)$idcliente)) {
    $dataExclusao = date('Y-d-m H:i');
    $excluirCliente = "UPDATE cliente SET DataExclusao_Cliente = '$dataExclusao' WHERE Id_Cliente = '".retorna_somenteNumeros($idcliente)."'";
    if (mysqli_query($con, $excluirCliente)) $status = 'success';
} 

echo json_encode(array("status" => $status), true);
