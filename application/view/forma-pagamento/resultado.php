<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$filtro = '';


if ($codPagamento != '') $filtro .= " AND Id_Forma_Pagamento = '" . retorna_somenteNumeros($codPagamento) . "' ";
if ($nomePagamento != '') $filtro .= " AND Nome_Forma_Pagamento LIKE '%$nomePagamento%' ";


$sql = "SELECT * FROM forma_pagamento
        WHERE 1 AND ISNULL(DataExclusao_Forma_Pagamento)
        $filtro";

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
                <th>Descrição</th>
                <th>Data Cadastro</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sql as $forma_pagamento) { ?>
                <tr id="formaPag_<?php echo $forma_pagamento->Id_Forma_Pagamento; ?>">
                    <td><?php echo formata_codigo($forma_pagamento->Id_Forma_Pagamento); ?></td>
                    <td><?php echo $forma_pagamento->Nome_Forma_Pagamento; ?></td>
                    <td><?php echo $forma_pagamento->Descricao_Forma_Pagamento; ?></td>
                    <td> <i class="mdi mdi-clock text-success"></i><?php echo data_hora($forma_pagamento->DataCadastro_Forma_Pagamento); ?></td>
                    <td>
                        <span data-toggle="tooltip" data-placement="bottom" title="Editar"><button type="button" class="btn btn-warning btn-sm rounded" onclick="modal_cadastro('Cadastro de Forma de Pagamento', 'forma-pagamento/cadastro', <?php echo $forma_pagamento->Id_Forma_Pagamento; ?>)" data-toggle="modal" data-target="#modalConteudo"><i class="mdi mdi-table-edit"></i></button></span>
                        <button class="btn btn-danger btn-sm rounded" onclick="excluir_forma_pagamento(<?php echo $forma_pagamento->Id_Forma_Pagamento; ?>)" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="mdi mdi-delete-variant"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $("#zero_config").DataTable();
</script>