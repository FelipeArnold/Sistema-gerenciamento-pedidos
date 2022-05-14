<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$sql = "SELECT Id_Entregador, Nome_Entregador, Situacao_Entregador, Telefone_Entregador, DataCadastro_Entregador
        FROM entregador 
        WHERE ISNULL(DataExclusao_Entregador)";

if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $sql[] = $row;
        }
    }
}

?>
<hr>
<div class="table-responsive">
    <table id="zero_config" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Data Cadastro</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sql as $entregador) {
                if( $entregador->Situacao_Entregador == 'A') {
                     $status = 'eye';
                     $situacaoInversa = 'I';
                     $cor = 'warning';
                } else{
                     $status = 'eye-off';
                     $situacaoInversa = 'A';
                     $cor = 'success';
                } 
            ?>
                <tr id="usuario_<?php echo $entregador->Id_Entregador; ?>">
                    <td><?php echo formata_codigo($entregador->Id_Entregador); ?></td>
                    <td><?php echo $entregador->Nome_Entregador; ?></td>
                    <td><?php echo $entregador->Telefone_Entregador; ?></td>
                    <td> <i class="mdi mdi-clock text-success"></i><?php echo data_hora($entregador->DataCadastro_Entregador); ?></td>
                    <td>
                        <span data-toggle="tooltip" data-placement="bottom" title="Editar"><button type="button" class="btn btn-warning btn-sm rounded" onclick="modal_cadastro('Editar Entregador', 'entregador/cadastro', <?php echo $entregador->Id_Entregador; ?>)" data-toggle="modal" data-target="#modalConteudo"><i class="mdi mdi-table-edit"></i></button></span>
                        <button class="btn btn-danger btn-sm rounded" onclick="excluir_entregador(<?php echo $entregador->Id_Entregador; ?>)" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="mdi mdi-delete-variant"></i></button>
                        <button class="btn btn-<?php echo $cor ?> btn-sm rounded" onclick="altera_statusEntregador(<?php echo $entregador->Id_Entregador. ', \''. $situacaoInversa.'\'' ; ?>)" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="mdi mdi-<?php echo $status?>"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $("#zero_config").DataTable();
</script>