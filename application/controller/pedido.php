<?php
extract($_REQUEST);
require_once '../source/session/session.php';
require_once '../source/banco/conexao.php';
require_once '../source/php/geral.php';

$status = 'error';
if ($acao == 'cadastrar') {

    $inPedido = "INSERT INTO pedido SET IdCliente_Pedido = '$idCliente', IdFormaPagamento_Pedido = '$formaPagamento', Observacao_Pedido = '$observacaoPedido', Tipo_Pedido = '$tipoPedido'";

    if (mysqli_query($con, $inPedido)) {
        $idPedido = mysqli_insert_id($con);
        $status = 'success';
        $insertItens = "INSERT INTO itens_pedido (IdPedido_Itens_Pedido, IdProduto_Itens_Pedido, Quantidade_Itens_Pedido, Valor_Itens_Pedido) VALUE ";
        foreach ($idCategoria as $key => $itemPedido) {
            $insertItens .= "( '" . $idPedido . "', '" . $key . "', '" . $qtdCategoria[$key][$chave] . "', '" . $ValorCategoria[$key] . "'),";
        }
        $insertItens = substr_replace($insertItens, ';', -1);
        if (mysqli_query($con, $insertItens)) $status = 'success';
    }

    if ($tipoPedido == 'E') {
        $inPedidoFrete = "INSERT INTO pedido_frete SET IdPedido_pedido_frete = '$idPedido', Valor_pedido_frete = '$valorFrete'";
        mysqli_query($con, $inPedidoFrete);
    }
} else if($acao == 'excluir'){
    $excluirPedido = "UPDATE pedido SET Status_Pedido = 'C' WHERE Id_Pedido = '".retorna_somenteNumeros($idPedido)."'";
    if (mysqli_query($con, $excluirPedido)) $status = 'success';
}

echo json_encode(array("status" => $status), true);
exit;
