<?php
extract($_REQUEST);

require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$acao = $Id_Categoria_Item == false ? 'cadastrar' : 'editar';
$status = 'C';
if ($id == true) {
    $status = 'E';
    $sql = "SELECT * FROM categoria_item WHERE ISNULL(DataExclusao_Categoria_Item) AND Id_Categoria_Item = '$id' ";
    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        }
    }
}

?>
<form id="cadastroCategoriaItem">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="idCategoriaItem" class="idCategoriaItem" value="<?php echo $id; ?>">
    <input type="hidden" name="Id_Categoria_Item" class="Id_Categoria_Item" value="<?php echo $row->Id_Categoria_Item; ?>">
    <div class="row">
        <div class="col-md-8 p-2">
            <label>Nome</label><br>
            <input type="text" name="nomeCategoria" required class="form-control" value="<?php echo $row->Nome_Categoria_Item; ?>" placeholder="Digite o nome">
        </div>
        <div class="col-md-4 p-2">
            <label class="form-label">Valor</label>
            <input name="valorCategoria" class="form-control money" type="text" value="<?php echo formata_ValorBancoReal($row->Valor_Categoria_Item); ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-success">Salvar</button>
    </div>
</form>

<script>
    mascara_formularios();
    $('#cadastroCategoriaItem').submit(function() {
        var form = $("#cadastroCategoriaItem").serialize();
        var valStatus = $('.status').val();
        var id = $('.idCategoriaItem').val();

        $.ajax({
            url: 'application/controller/categoria-item.php',
            type: 'POST',
            data: form,
            dataType: "json",
            success: function(data) {
                exibe_alerta(data.status, valStatus);
                consulta_categoria();
                fechar_modal();
                categoria_selecionada(id);
            }
        });

        return false;
    });
</script>