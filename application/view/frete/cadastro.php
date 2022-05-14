<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$id = retorna_somenteNumeros($id);
$acao = $id == false ? 'cadastrar' : 'editar';
$status = 'C';

if ($id == true) {
    $status = 'E';
    $sql = "SELECT * FROM frete WHERE 1 AND Id_Frete = $id ";

    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        }
    }
}
?>
<form id="cadastroFrete">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="Id_Frete" value="<?php echo $row->Id_Frete; ?>">

    <div class="row">
        <div class="col-md-8 p-2">
            <label>Local</label><br>
            <input type="text" name="localFrete" class="form-control" value="<?php echo $row->Nome_Forma_Pagamento; ?>" placeholder="Local">
        </div>
        <div class="col-md-4 p-2">
            <label>Valor</label><br>
            <input type="text" name="valorFrete" class="form-control" value="<?php echo $row->Nome_Forma_Pagamento; ?>" placeholder="Valor do Frete">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-success">Salvar</button>
    </div>
</form>

<script>
    $('#cadastroFrete').submit(function() {
        var form = $("#cadastroFrete").serialize();
        var valStatus = $('.status').val();
        $.ajax({
            url: 'application/controller/frete.php',
            type: 'POST',
            data: form,
            dataType: "json",
            success: function(data) {
                exibe_alerta(data.status, valStatus);
                fechar_modal();
                consulta_frete();
            }
        });

        return false;
    });
</script>