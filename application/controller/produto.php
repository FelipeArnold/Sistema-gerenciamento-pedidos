<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';

$status = 'error';
if ($acao == 'cadastrar') {
    $insertProduto = "INSERT INTO produto SET Nome_Produto = '$nomeProduto',  Descricao_Produto = '$descricao', 
                Valor_Produto = '$valor', ValorPromocao_Produto = '$valorPromocao', Quantidade_Produto = '$quantidade', Tipo_Produto = '$tipoProduto' ";

    if (mysqli_query($con, $insertProduto)) $status = 'success';
} else if ($acao == 'excluir' && !empty((int)$idproduto)) {
    $dataExclusao = date('Y-d-m H:i');
    $excluirProduto = "UPDATE produto SET DataExclusao_Produto = '$dataExclusao' WHERE Id_Produto = '$idproduto'";
    if (mysqli_query($con, $excluirProduto)) $status = 'success';
} else if ($acao == 'editar') {
    $updateProduto = "UPDATE produto SET Nome_Produto = '$nomeProduto', Descricao_Produto = '$descricao', Valor_Produto = '$valor', 
                        ValorPromocao_Produto = '$valorPromocao', Quantidade_Produto = '$quantidade', Tipo_Produto = '$tipoProduto' 
                    WHERE Id_Produto = '$Id_Produto' ";

    if (mysqli_query($con, $updateProduto)) $status = 'success';
}

echo json_encode(array("status" => $status), true);
