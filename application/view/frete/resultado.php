<?php
extract($_REQUEST);

require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$arrayFiltro = array(
    "Titulo" => 'Relatório de Fretes',
    "Icone" => 'mdi mdi-credit-card',
    "Class" => 'relFretes'
);

echo widget_box_open($arrayFiltro);

$sql = "SELECT * FROM frete WHERE ISNULL(DataExclusao_Frete)";
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
                <th>Local</th>
                <th>Valor</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sql as $frete) { ?>
                <tr id="produto_<?php echo $frete->Id_Frete; ?>">
                    <td><?php echo formata_codigo($frete->Id_Frete); ?></td>
                    <td><?php echo $frete->Local_Frete ?></td>
                    <td><?php echo $frete->Valor_Frete ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm rounded" onclick="modal_cadastro('Editar Frete', 'frete/cadastro', <?php echo $frete->Id_Frete; ?>)" data-toggle="modal" data-target="#modalConteudo"><i class="mdi mdi-table-edit"></i></button>
                        <button class="btn btn-danger btn-sm rounded" onclick="excluir_frete(<?php echo $frete->Id_Frete; ?>)" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="mdi mdi-delete-variant"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    function excluir_frete(id) {
        $.ajax({
            url: 'application/controller/frete.php',
            type: 'POST',
            data: 'acao=excluir&Id_Frete=' + id,
            dataType: "json",
            success: function(data) {
                exibe_alerta(data.status, 'D');
                consulta_frete();
            }
        });
    }

    $("#zero_config").DataTable();
</script>

<?php echo widget_box_close();
