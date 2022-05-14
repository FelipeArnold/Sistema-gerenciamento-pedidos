<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';
require_once '../source/php/geral.php';

$status = 'error';
if ($acao == 'cadastrar' || $acao == 'editar') {

    $where = '';
    if ($acao == 'cadastrar') $insertUpdate = "INSERT INTO ";
    else if ($acao == 'editar') {
        $insertUpdate = "UPDATE ";
        $where = "WHERE Id_Categoria_Item = '" . retorna_somenteNumeros($Id_Categoria_Item) . "' ";
    }

    $inUpCliente =  $insertUpdate  . " categoria_item SET IdCategoria_Categoria_Item = '$idCategoriaItem', Nome_Categoria_Item = '$nomeCategoria', Valor_Categoria_Item = '".formata_ValorBanco($valorCategoria)."'
                $where";

    if (mysqli_query($con, $inUpCliente)) $status = 'success';
} else if ($acao == 'excluir' && !empty((int)$idcliente)) {
    $dataExclusao = date('Y-d-m H:i');
    $excluirCliente = "UPDATE cliente SET DataExclusao_Cliente = '$dataExclusao' WHERE Id_Cliente = '" . retorna_somenteNumeros($idcliente) . "'";
    if (mysqli_query($con, $excluirCliente)) $status = 'success';
}

echo json_encode(array("status" => $status), true);
