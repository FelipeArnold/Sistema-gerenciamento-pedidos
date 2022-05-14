<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$id = retorna_somenteNumeros($id);
$acao = $id == false ? 'cadastrar' : 'editar';
$status = 'C';
if ($id == true) {
    $status = 'E';
    $sql = "SELECT Id_Entregador, Nome_Entregador, Situacao_Entregador, Telefone_Entregador, DataCadastro_Entregador
        FROM entregador 
        WHERE ISNULL(DataExclusao_Entregador) AND Id_Entregador = '$id' ";

    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        }
    }
}
?>
<form id="cadastroEntregador">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="idEntregador" value="<?php echo $row->Id_Entregador; ?>">

    <div class="row">
        <div class="col-md-9 p-2">
            <label>Nome</label><br>
            <input type="text" name="nomeEntregador" required class="form-control" value="<?php echo $row->Nome_Entregador; ?>" placeholder="Digite o nome">
        </div>
         <div class="col-md-3 p-2">
            <label>Telefone</label><br>
            <input type="text" name="telefoneEntregador" class="form-control telefone" value="<?php echo $row->Telefone_Entregador; ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-success">Salvar</button>
    </div>

</form>

<script>
    mascara_formularios();

    $('#cadastroEntregador').submit(function() {
        var form = $("#cadastroEntregador").serialize();
        var valStatus = $('.status').val();
        $.ajax({
            url: 'application/controller/entregador.php',
            type: 'POST',
            data: form,
            dataType: "json",
            success: function(data) {
                exibe_alerta(data.status, valStatus);
                fechar_modal();
                busca_entregador();
            }
        });

        return false;
    });
</script>