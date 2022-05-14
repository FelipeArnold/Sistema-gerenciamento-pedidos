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
        $where = "WHERE Id_Forma_Pagamento = '".retorna_somenteNumeros($Id_FormaPagamento)."' ";
    } 
    
    $inUpPagamento =  $insertUpdate  ." forma_pagamento SET Nome_Forma_Pagamento = '$nomePagamento',  Descricao_Forma_Pagamento = '$descricaoPagamento' 
                    $where ";

    
    if (mysqli_query($con, $inUpPagamento)) $status = 'success';
} else if ($acao == 'excluir' && !empty(retorna_somenteNumeros($Id_FormaPagamento))) {
    $dataExclusao = date('Y-d-m H:i');
    $excluir = "UPDATE forma_pagamento SET DataExclusao_Forma_Pagamento = '$dataExclusao' WHERE Id_Forma_Pagamento = '".retorna_somenteNumeros($Id_FormaPagamento)."'";
    if (mysqli_query($con, $excluir)) $status = 'success';
} 

echo json_encode(array("status" => $status), true);
