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
        $where = "WHERE Id_Entregador = '".retorna_somenteNumeros($idEntregador)."' ";
    } 
    
    $inUpEntregador =  $insertUpdate  ." entregador SET Nome_Entregador = '$nomeEntregador',  Telefone_Entregador = '$telefoneEntregador'
                    $where ";
    
    if (mysqli_query($con, $inUpEntregador)) $status = 'success';
} else if ($acao == 'excluir' && !empty(retorna_somenteNumeros($idEntregador))) {
    $dataExclusao = date('Y-d-m H:i');
    $excluir = "UPDATE entregador SET DataExclusao_Entregador = '$dataExclusao' WHERE Id_Entregador = '".retorna_somenteNumeros($idEntregador)."'";
    if (mysqli_query($con, $excluir)) $status = 'success';
} else if ($acao == 'alteraStatus' && !empty(retorna_somenteNumeros($idEntregador))) {
    $dataExclusao = date('Y-d-m H:i');
    $excluir = "UPDATE entregador SET Situacao_Entregador = '$situacao' WHERE Id_Entregador = '".retorna_somenteNumeros($idEntregador)."'";
    if (mysqli_query($con, $excluir)) $status = 'success';
} 

echo json_encode(array("status" => $status), true);
