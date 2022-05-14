<?php

$arrayFiltro = array(
    "Titulo" => 'Entregador',
    "Icone" => 'mdi mdi-car',
    "Class" => 'usuario'
);

/**Busca */
echo widget_box_open($arrayFiltro); ?>

<form id="cadastroEntregador">
    <input type="hidden" name="id" value="<?php echo $acao; ?>">
<div class="col-md-12 mb-2">
    <button type="button" class="btn btn-success btn-sm text-white" onclick="modal_cadastro('Cadastro de Entregador', 'entregador/cadastro')" data-toggle="modal" data-target="#modalConteudo">
        <i class="fa fa-plus"></i> Novo Entregador
    </button>
</div>


<div class="card conteudoRetorno"></div>
<?php
echo widget_box_close();
?>

<script>
    function excluir_entregador(id) {
        $.ajax({
            url: 'application/controller/entregador.php',
            type: 'POST',
            data: 'acao=excluir&idEntregador=' + id,
            dataType: "json",
            success: function(data) {
                $('#usuario_' + id).remove();
                exibe_alerta(data.status, 'D');
                busca_entregador();
            }
        });
    }

    function altera_statusEntregador(id, status){
         $.ajax({
            url: 'application/controller/entregador.php',
            type: 'POST',
            data: 'acao=alteraStatus&idEntregador=' + id + '&situacao=' + status,
            dataType: "json",
            success: function(data) {
                $('#usuario_' + id).remove();
                exibe_alerta(data.status, 'D');
                busca_entregador();
            }
        });
    }

    function busca_entregador() {
        $.ajax({
            url: 'application/view/entregador/resultado.php',
            type: 'POST',
            success: function(data) {
                $('.conteudoRetorno').html(data);
            }
        });
    }
    busca_entregador();

</script>