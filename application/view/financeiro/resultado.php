<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$filtro = '';

if (!empty($dataInicio)) $filtro .= " AND date(DataCadastro_Pedido) >= '$dataInicio'";
if (!empty($dataFinal)) $filtro .= " AND date(DataCadastro_Pedido) <= '$dataFinal'";


$sql = "SELECT p.Id_Pedido, p.DataCadastro_Pedido, p.Tipo_Pedido, p.Status_Pedido, fp.Nome_Forma_Pagamento, c.Nome_Cliente, c.Email_Cliente, c.Telefone_Cliente, fp.Nome_Forma_Pagamento, GROUP_CONCAT(ip.Valor_Itens_Pedido) valorPedidos 
        FROM pedido p
        INNER JOIN forma_pagamento fp ON fp.Id_Forma_Pagamento = p.IdFormaPagamento_Pedido
        LEFT JOIN cliente c on c.Id_Cliente = p.IdCliente_Pedido
        LEFT JOIN itens_pedido ip on ip.IdPedido_Itens_Pedido = p.Id_Pedido
        WHERE 1 $filtro
        GROUP By p.Id_Pedido";

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
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Data Cadastro</th>
                <th>Forma de Pagamento</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sql as $pedido) {  
                
                $valorPedidos = explode(',', $pedido->valorPedidos);
                $valorTotalPedidos = array_sum($valorPedidos);
                
                ?>
                <tr id="produto_<?php echo $pedido->Id_Pedido; ?>">
                    <td><?php echo formata_codigo($pedido->Id_Pedido); ?></td>
                    <td><?php echo $pedido->Nome_Cliente; ?></td>
                    <td><?php echo $pedido->Email_Cliente; ?></td>
                    <td><?php echo $pedido->Telefone_Cliente; ?></td>
                    <td><?php echo $pedido->Tipo_Pedido; ?></td>
                    <td><?php echo $pedido->Status_Pedido; ?></td>
                    <td> <i class="mdi mdi-clock text-success"></i><?php echo data_hora($pedido->DataCadastro_Pedido); ?></td>
                    <td><?php echo $pedido->Nome_Forma_Pagamento; ?></td>
                    <td>R$ <?php echo $valorTotalPedidos; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $("#zero_config").DataTable();
</script>