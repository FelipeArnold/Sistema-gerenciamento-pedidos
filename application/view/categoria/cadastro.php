<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$id = retorna_somenteNumeros($id);
$acao = $id == false ? 'cadastrar' : 'editar';
$status = 'C';
if ($id == true) {
    $status = 'E';
    $sql = "SELECT * FROM categoria WHERE ISNULL(DataExclusao_Categoria) AND Id_Categoria = '$id' ";

    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        }
    }
}
?>

<form id="cadastroCategoria" enctype="multipart/form-data">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="idCategoria" value="<?php echo $row->Id_Categoria; ?>">

    <div class="row">
        <div class="col-md-6 p-2">
            <label>Nome</label><br>
            <input type="text" name="nomeCategoria" required class="form-control" value="<?php echo $row->Nome_Categoria; ?>" placeholder="Digite o nome">
        </div>
        <div class="col-md-6 p-2">
            <label for="formFileSm" class="form-label">Icone</label>
            <input name="imagem" class="form-control form-control-sm" id="formFileSm" type="file">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-success">Salvar</button>
    </div>

</form>

<script>
    mascara_formularios();

    $('#cadastroCategoria').submit(function() {
        var form = new FormData(this);
        
        var valStatus = $('.status').val();
        $.ajax({
            url: 'application/controller/categoria.php',
            type: 'POST',
            data: form,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function(data) {
                exibe_alerta(data.status, valStatus);
                fechar_modal();
                consulta_categoria();
            }
        });

        return false;
    });
</script>