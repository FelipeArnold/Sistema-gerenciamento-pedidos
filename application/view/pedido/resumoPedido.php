<?php
extract($_REQUEST);

require_once '../../source/session/session.php';
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$sql = "SELECT * FROM pedido p
        INNER JOIN cliente c ON c.Id_Cliente = p.IdCliente_Pedido
        LEFT JOIN forma_pagamento fp ON fp.Id_Forma_Pagamento = p.IdFormaPagamento_Pedido
        INNER JOIN logradouro l ON l.Id_Logradouro = c.IdLogradouro_Cliente
        INNER JOIN cidade ci ON ci.Id_Cidade = l.IdCidade_Logradouro
        WHERE p.Id_Pedido = $idPedido
        GROUP BY p.Id_Pedido";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) $row = mysqli_fetch_object($query);
}

if ($row->Tipo_Pedido == 'E') $tipoPedido = 'Entrega';
else $tipoPedido = 'Retirada';

if ($row->Status_Pedido == 'C') $icon = 'error';
else if ($row->Status_Pedido == 'A') $icon = 'info';
else if ($row->Status_Pedido == 'F') $icon = 'success';
else if ($row->Status_Pedido == 'P') $icon = 'warning';

$conteudo = "<ul class='list-unstyled text-left'>
                <li class='p-0'>
                    <stromg>Nome:</stromg>
                    <small>" . $row->Nome_Cliente . " ( " . $row->Telefone_Cliente . " )</small>
                </li>
                <li class='p-0'>
                    <stromg>Endere&ccedil;o:</stromg>
                    <small>" . $row->Logradouro_Logradouro.', '. $row->Numero_Cliente .' - '.$row->Bairro_Logradouro. ' - ' .$row->Cidade_Logradouro . " ( " . $row->Cep_Logradouro . " )</small>
                </li>";
                if(!empty( $row->Complemento_Logradouro )){ 
                    $conteudo .= "<li class='p-0'>
                                    <stromg>Complemento:</stromg>
                                    <small>" . $row->Complemento_Logradouro ."</small>
                                </li>";
                }

                $conteudo .= "<div class='d-flex'>
                                <li class='p-2'>
                                    <stromg>Pedido:</stromg>
                                    <small>" . $tipoPedido . "</small>
                                </li>
                                <li class='p-2'>
                                    <stromg>Pagamento:</stromg>
                                    <small>" . $row->Nome_Forma_Pagamento . "</small>
                                </li>
                            </div>
                            <li>
                                <stromg>Observações:</stromg><br>
                                <small>" . $row->Observacao_Pedido . "</small>
                            </li>
                </ul>
            
            
";

$conteudo .= '<div class="col-md-12">
   
    <ul class="list-style-none">

        <li class="no-block card-body p-1 mt-4 ml-2 mr-2 mb-1 d-flex" style="border-bottom: 1px dotted rgb(204 204 204);">
            <div class="col-md-9 text-left ">
                <strong>Produto</strong>
            </div>
            <div class="col-md-3 text-right">
                <strong>Valor</strong>
            </div>
        </li>';

$produtos = "SELECT * FROM itens_pedido ip
            INNER JOIN categoria_item ci ON ci.Id_Categoria_Item = ip.IdProduto_Itens_Pedido
            WHERE ip.IdPedido_Itens_Pedido = $row->Id_Pedido";

if ($query = mysqli_query($con, $produtos)) {
    if (mysqli_num_rows($query) > 0) {
        $produtos = array();

        while ($produtos = mysqli_fetch_object($query)) {
            $soma += $produtos->Valor_Categoria_Item;
            $conteudo .= '<li class="no-block card-body p-1 ml-2 mr-2 mb-1 d-flex" style="border-bottom: 1px dotted rgb(204 204 204);">
                            <div class="col-md-9 text-left ">
                                <small>'.$produtos->Nome_Categoria_Item.'</small><br>
                                <small>Quantidade: '.$produtos->Quantidade_Itens_Pedido.'</small><br>
                            </div>
                            <div class="col-md-3 text-right">
                                <small>R$ ' . formata_ValorBancoReal($produtos->Valor_Categoria_Item) . '</small>
                            </div>
                        </li>';
        }

        $conteudo .= '<li class="no-block card-body p-1 mt-1 ml-2 mr-2 mb-2 d-flex">
                        <div class="col-md-6 text-left ">
                            <strong>Valor Total: </strong><br>
                        </div>
                        <div class="col-md-6 text-right ">
                            <strong class="resumo_ValorTotalPedido">'. $soma.'</strong>
                        </div>
                    </li>';
    }
}


$conteudo .= '
        </ul>
    </div>';

echo json_encode(array("icone" => $icon, "codigo" => formata_codigo($row->Id_Pedido), "conteudo" => $conteudo), true);
exit;