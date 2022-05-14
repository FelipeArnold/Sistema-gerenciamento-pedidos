<?php

$arrayFiltro = array(
    "Titulo" => 'Pedido',
    "Icone" => 'mdi mdi-cart-outline',
    "Class" => 'pedido'
);

$arrayResultado = array(
    "Titulo" => 'Resultado',
    "Icone" => 'mdi mdi-cart-outline',
    "Class" => 'pedidoRetorno hide'
);

/**Busca */
echo widget_box_open($arrayFiltro); ?>

<div class="col-md-12 mb-2">
    <button type="button" class="btn btn-success btn-sm text-white" onclick="modal_cadastro('Cadastro de Pedido', 'pedido/cadastro')" data-toggle="modal" data-target="#modalConteudo">
        <i class="fa fa-plus"></i> Novo Pedido
    </button>
</div>
<form id="consultaProduto">
    <div class="row p-2">
        <div class="col-md-2">
            <label>Código Produto</label><br>
            <input type="text" name="codProduto" value="" placeholder="Digito do Produto" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Data Inicial</label><br>
            <input type="date" name="dataInicio" value="<?php echo date('Y-m-d'); ?>" id="dataInicio" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Data Final</label><br>
            <input type="date" name="dataFinal" value="<?php echo date('Y-m-d'); ?>" id="dataFinal" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Tipo</label><br>
            <select name="tipo" id="tipo" class="select2 form-select shadow-none" style="width: 100%; height: 36px">
                <option value="0">Todos</option>
                <option value="Cardapio">Cardapio</option>
                <option value="Produto">Produto</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Nome Produto</label><br>
            <input type="text" name="nomeProduto" placeholder="Digite o nome do produto" id="nomeProduto" class="form-control">
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
    function excluir_produto(idProduto) {
        $.ajax({
            url: 'application/controller/produto.php',
            type: 'POST',
            data: 'acao=excluir&idproduto=' + idProduto,
            dataType: "json",
            success: function(data) {
                $('#produto_' + idProduto).remove();
                exibe_alerta(data.status, 'D');
            }
        });
    }

    $('#consultaProduto').submit(function() {
        var form = $("#consultaProduto").serialize();
         $.ajax({
            url: 'application/view/produto/resultado.php',
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