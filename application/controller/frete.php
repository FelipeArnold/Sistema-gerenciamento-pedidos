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
        $where = "WHERE Id_Frete = '".retorna_somenteNumeros($Id_Frete)."' ";
    } 
    
    $inUpFrete =  $insertUpdate  ." frete SET Local_Frete = '$localFrete',  Valor_Frete = '$valorFrete'
                    $where ";
    
    if (mysqli_query($con, $inUpFrete)) $status = 'success';
} else if ($acao == 'excluir' && !empty(retorna_somenteNumeros($Id_Frete))) {
    $dataExclusao = date('Y-d-m H:i');
    $excluir = "UPDATE frete SET DataExclusao_Frete = '$dataExclusao' WHERE Id_Frete = '".retorna_somenteNumeros($Id_Frete)."'";
    if (mysqli_query($con, $excluir)) $status = 'success';
} 

echo json_encode(array("status" => $status), true);
