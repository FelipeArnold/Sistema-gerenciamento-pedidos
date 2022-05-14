<?php
extract($_REQUEST);

$arrayFiltro = array(
    "Titulo" => 'Relatório de Pedido',
    "Icone" => 'mdi mdi-credit-card',
    "Class" => 'relPedidos'
);

echo widget_box_open($arrayFiltro);

$sql = "SELECT p.Id_Pedido, p.Observacao_Pedido, p.Observacao_Pedido, p.Tipo_Pedido, p.DataCadastro_Pedido, c.Nome_Cliente, c.Telefone_Cliente, c.Numero_Cliente,
               l.Cep_Logradouro, l.Logradouro_Logradouro, l.Bairro_Logradouro, ci.Cidade_Cidade, ci.Estado_Cidade,  f.Nome_Forma_Pagamento, p.Status_Pedido
        FROM pedido p
        INNER JOIN cliente c ON c.Id_Cliente = p.IdCliente_Pedido
        INNER JOIN logradouro l ON c.IdLogradouro_Cliente = l.Id_Logradouro
        INNER JOIN cidade ci ON ci.Id_Cidade = l.IdCidade_Logradouro
        INNER JOIN forma_pagamento f ON f.Id_Forma_Pagamento = p.IdFormaPagamento_Pedido
        ORDER BY Id_Pedido DESC";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $sql[] = $row;
        }
    }
}

?>


<div class="table-responsive">
    <table id="zero_config" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Endere&ccedil;o</th>
                <th>Forma Pagamento</th>
                <th>Tipo</th>
                <th>Data Pedido</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sql as $pedido) {

                $endereco = $pedido->Logradouro_Logradouro;
                if (!empty($pedido->Numero_Cliente)) $endereco .= ', ' . $pedido->Numero_Cliente;
                if (!empty($pedido->Bairro_Logradouro)) $endereco .= '<br>' . $pedido->Bairro_Logradouro;
                if (!empty($pedido->Cidade_Cidade)) $endereco .=  ' - ' . $pedido->Cidade_Cidade . '/' . $pedido->Estado_Cidade;
                if (!empty($pedido->Cep_Logradouro)) $endereco .= '<br>(' . $pedido->Cep_Logradouro . ')';

                if ($pedido->Tipo_Pedido == 'E') $tipoPedido = 'Entrega';
                else $tipoPedido = 'Retirada';

                if ($pedido->Status_Pedido == 'P') {
                    $status = 'Pendente';
                    $cor = 'warning';
                } else if ($pedido->Status_Pedido == 'A') {
                    $status = 'Andamento';
                    $cor = 'info';
                } else if ($pedido->Status_Pedido == 'C') {
                    $status = 'Cancelado';
                    $cor = 'danger';
                } else if ($pedido->Status_Pedido == 'F') {
                    $status = 'Finalizado';
                    $cor = 'success';
                }

            ?>
                <tr id="produto_<?php echo $pedido->Id_Pedido; ?>">
                    <td><?php echo formata_codigo($pedido->Id_Pedido); ?></td>
                    <td><?php echo $pedido->Nome_Cliente . '<br> (' . $pedido->Telefone_Cliente . ')'; ?></td>
                    <td><?php echo $endereco; ?></td>
                    <td><?php echo $pedido->Nome_Forma_Pagamento; ?></td>
                    <td><?php echo $tipoPedido; ?></td>
                    <td> <i class="mdi mdi-clock text-success"></i><?php echo data_hora($pedido->DataCadastro_Pedido); ?></td>
                    <td> <span class="label label-<?php echo $cor; ?>"><?php echo $status; ?></span></td>
                    <td>
                        <?php if ($pedido->Status_Pedido != 'C') { ?>
                            <button class="btn btn-danger btn-sm rounded" onclick="excluir_pedido(<?php echo $pedido->Id_Pedido; ?>)" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="mdi mdi-delete-variant"></i></button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>

    function excluir_pedido(id) {
        $.ajax({
            url: 'application/controller/pedido.php',
            type: 'POST',
            data: 'acao=excluir&idPedido=' + id,
            dataType: "json",
            success: function(data) {
                window.location.href = 'home.php?pg=pedido/relatorio';
                exibe_alerta(data.status, 'D');
            }
        });
    }

    $("#zero_config").DataTable();
    
</script>

<?php echo widget_box_close();
