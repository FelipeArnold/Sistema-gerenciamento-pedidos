<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$id = retorna_somenteNumeros($id);
$acao = $id == false ? 'cadastrar' : 'editar';
$status = 'C';

if ($id == true) {
    $status = 'E';
    $sql = "SELECT * FROM forma_pagamento
        WHERE 1 AND Id_Forma_Pagamento = $id ";
    
    if ($query = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
        }
    }
    
}
?>
<form id="cadastroFormPagamento">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="status" class="status" value="<?php echo $status; ?>">
    <input type="hidden" name="Id_FormaPagamento" value="<?php echo $row->Id_Forma_Pagamento; ?>">
    <div class="accordion" id="accordionExample">
        <div class="card m-b-0 ">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-target="#formPagamento" aria-expanded="true" aria-controls="formPagamento">
                        <i class="m-r-5 mdi mdi-account" aria-hidden="true"></i>
                        <span>Forma de Pagamento</span>
                    </a>
                </h5>
            </div>
            <div id="formPagamento" class="collapse show borda" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 p-2">
                            <label>Nome</label><br>
                            <input type="text" name="nomePagamento" class="form-control" value="<?php echo $row->Nome_Forma_Pagamento; ?>" placeholder="Nome da forma de pagamento">
                        </div>
                        <div class="col-md-12 p-2">
                            <label>Descrição</label><br>
                            <textarea name="descricaoPagamento" class="form-control" rows="5" placeholder="Descrição da forma de pagamento"><?php echo $row->Descricao_Forma_Pagamento; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </div>
</form>

<script>

    $('#cadastroFormPagamento').submit(function() {
        var form = $("#cadastroFormPagamento").serialize();
        var valStatus = $('.status').val();
        $.ajax({
            url: 'application/controller/forma-pagamento.php',
            type: 'POST',
            data: form,
            dataType: "json",
            success: function(data) {
                exibe_alerta(data.status, valStatus);
                fechar_modal();
            }
        });

        return false;
    });

</script>