<?php

$arrayFiltro = array(
    "Titulo" => 'Forma de Pagamento',
    "Icone" => 'mdi mdi-cart-outline',
    "Class" => 'forma_pagamento'
);

$arrayResultado = array(
    "Titulo" => 'Resultado',
    "Icone" => 'mdi mdi-cart-outline',
    "Class" => 'formaPagamentoRetorno'
);

/**Busca */
echo widget_box_open($arrayFiltro); ?>

<div class="col-md-12 mb-2">
    <button type="button" class="btn btn-success btn-sm text-white" onclick="modal_cadastro('Cadastro de Fretes', 'frete/cadastro')" data-toggle="modal" data-target="#modalConteudo">
        <i class="fa fa-plus"></i> Novo Frete
    </button>
</div>

<div class="retornoFretes"></div>

<?php echo widget_box_close();?>

<script>
    
    function excluir_forma_pagamento(idFormaPagamento) {
        $.ajax({
            url: 'application/controller/forma-pagamento.php',
            type: 'POST',
            data: 'acao=excluir&Id_FormaPagamento=' + idFormaPagamento,
            dataType: "json",
            success: function(data) {
                $('#formaPag_' + idFormaPagamento).remove();
                exibe_alerta(data.status, 'D');
            }
        });
    }

    function consulta_frete(){
        $.ajax({
            url: 'application/view/frete/resultado.php',
            type: 'POST',
            success: function(data) {
                $('.retornoFretes').html(data);
            }
        });
    }
    consulta_frete();

    $('#consultaPagamento').submit(function() {
        var form = $("#consultaPagamento").serialize();
        $.ajax({
            url: 'application/view/forma-pagamento/resultado.php',
            type: 'POST',
            data: form,
            success: function(data) {
                $('.conteudoRetorno').html(data);
                $('.produtoRetorno').show();
            }
        });
        return false;
    });
</script>