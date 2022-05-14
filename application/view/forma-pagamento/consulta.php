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
    <button type="button" class="btn btn-success btn-sm text-white" onclick="modal_cadastro('Cadastro de Forma de Pagamento', 'forma-pagamento/cadastro')" data-toggle="modal" data-target="#modalConteudo">
        <i class="fa fa-plus"></i> Novo Pagamento
    </button>
</div>
<form id="consultaPagamento">
    <div class="row p-2">
        <div class="col-md-2">
            <label>Código Produto</label><br>
            <input type="text" name="codPagamento" value="" placeholder="Código do Pagamento" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Nome do Pagamento</label><br>
            <input type="text" name="nomePagamento" placeholder="Digite o nome do pagamento" id="nomePagamento" class="form-control">
        </div>
        <div class="col-md-1 p-0 text-center">
            <label></label>
            <button type="submit" class="btn btn-success mt-4">Pesquisar</button>
        </div>
    </div>
</form>

<?php
echo widget_box_close();

/**Resultado */
echo widget_box_open($arrayResultado);
?>
<div class="card conteudoRetorno"></div>
<?php echo widget_box_close(); ?>

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
    

    function consulta_forma_pagamento() {
        var form = $("#consultaPagamento").serialize();
        $.ajax({
            url: 'application/view/forma-pagamento/resultado.php',
            type: 'POST',
            data: form,
            success: function(data) {
                $('.conteudoRetorno').html(data);
            }
        });
    }

    consulta_forma_pagamento();

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