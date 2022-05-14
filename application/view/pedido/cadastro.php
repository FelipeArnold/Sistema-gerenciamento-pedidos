<?php
extract($_REQUEST);

$arrayFiltro = array(
    "Titulo" => 'Novo Pedido',
    "Icone" => 'mdi mdi-credit-card',
    "Class" => 'fundoPedidos'
);

?>
<style>
    .fundoPedidos {
        background-color: rgb(239 239 239) !important
    }

    .d-flex {
        display: flex;
    }
</style>

<form id="cadastroPedido">
    <input type="hidden" name="acao" value="cadastrar">
    <div class="row">
        <div class="col-md-8">
            <div class="accordion" id="accordionExample">
                <div class="card mb-0">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <a class="d-flex align-items-center" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span>Produto</span>
                            </a>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="col-md-12 d-flex">
                            <div class="col-md-6 divCategorias">
                                <div class="card shadow p-3 mb-5 bg-white rounded">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-0">Categoria</h4>
                                    </div>
                                    <ul class="list-style-none">
                                        <div class="retornoCategoria"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="retornoCategoriaItem"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0 border-top">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <a class="collapsed d-flex align-items-center" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span>Cliente / Endereço </span>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-8">
                                    <label>Consulta Cliente</label><br>
                                    <input type="hidden" name="idCliente" class="idCliente" value="">
                                    <input type="search" name="consultaCliente" id="consultaCliente" class="form-control nomeCliente" value="" onkeyup="lista_consulta(this, 'cliente')" autocomplete="off">
                                    <div class="col-md-12 p-1 consulta_lista_cliente">
                                        <div class="retorno_lista_consulta"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label></label><br>
                                    <button type="button" class="btn btn-success btn-sm text-white mt-2" onclick="modal_cadastro('Cadastro de Cliente', 'cliente/cadastro')" data-toggle="modal" data-target="#modalConteudo">
                                        <i class="fa fa-plus"></i> Novo Cliente
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex mt-2">
                                <div class="col-md-4">
                                    <label>Forma de Pagamento</label><br>
                                    <select name="formaPagamento" class="form-control formaPagamento" onchange="atualiza_pedido_resumo('.formaPagamento', '.resumo_FormPagemento')">
                                        <?php echo forma_pagamento(); ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Tipo pedido</label><br>
                                    <select name="tipoPedido" class="form-control tipoPedido" onchange="valida_tipoPedido(); atualiza_pedido_resumo('.tipoPedido', '.resumo_TipoPedido')">
                                        <option value="">Selecione</option>
                                        <option value="E">Entrega </option>
                                        <option value="R">Retirada </option>
                                    </select>
                                </div>
                                <div class="col-md-4 frete" style="display: none;">
                                    <label>Frete</label><br>
                                    <select name="valorFrete" class="form-control valorFrete" onchange="atualiza_pedido_resumo('.valorFrete', '.resumo_valorFrete'); atualizar_valorPedido($('.valorFrete :selected').val());">
                                        <option value="">Selecione</option>
                                        <?php echo retornarValoresFretes(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label>Observações do Pedido</label><br>
                                <textarea name="observacaoPedido" class="observacaoPedido form-control" onblur="$('.resumo_observacaoPedido').html( $('.observacaoPedido').val() )" rows="5" placeholder="Digite aqui as observações do pedido e detalhes da entrega"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 divResumoPedido">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body text-center">
                    <h4 class="card-title mb-0">Resumo Pedido</h4>
                    <div class="p-2 border-bottom"></div>
                </div>
                <ul class="list-style-none">

                    <div class="retornoResumoPedido"></div>
                    <li class="no-block card-body d-flex p-1 ml-2 mr-2">
                        <div class="col-md-12 text-left ">
                            <strong class="resumo_TipoPedido"></strong>
                        </div>
                    </li>
                    <li class="no-block card-body d-flex p-1 ml-2 mr-2">
                        <div class="col-md-12 text-left ">
                            <strong class="resumo_nomeCliente"></strong>
                            <span class="resumo_telefoneCliente"></span>
                        </div>
                    </li>
                    <li class="no-block card-body d-flex p-1 ml-2 mr-2">
                        <div class="col-md-12 text-left">
                            <strong>Endereço: </strong><br>
                            <span class="resumo_enderecoCliente"></span>
                        </div>
                    </li>
                    <li class="no-block card-body d-flex p-1 ml-2 mr-2">
                        <div class="col-md-12 text-left ">
                            <strong>Observação: </strong><br><span class="resumo_observacaoPedido"> </span>
                        </div>
                    </li>

                    <li class="no-block card-body p-1 mt-4 ml-2 mr-2 mb-1 d-flex" style="border-bottom: 1px dotted rgb(204 204 204);">
                        <div class="col-md-9 text-left ">
                            <strong>Produto</strong>
                        </div>
                        <div class="col-md-3 text-right">
                            <strong>Valor</strong>
                        </div>
                    </li>

                    <div class="retornoProduto">
                        <div class="col-md-12 divAlertaProduto">
                            <div class="swal2-validation-message" id="swal2-validation-message" style="display: table-cell;">Selecione um produto para seu pedido.</div>
                        </div>
                    </div>

                    <li class="no-block card-body p-1 mt-2 ml-2 mr-2 mb-1 d-flex" style="border-bottom: 1px dotted rgb(204 204 204);"></li>

                    <li class="no-block card-body p-1 mt-1 ml-2 mr-2 d-flex">
                        <div class="col-md-6 text-left ">
                            <strong>Forma de Pagamento:</strong><br>
                        </div>
                        <div class="col-md-6 text-right ">
                            <strong class="resumo_FormPagemento"></strong>
                        </div>
                    </li>

                    <li class="no-block card-body p-1 mt-1 ml-2 mr-2 mb-1 d-flex" style="border-bottom: 1px dotted rgb(204 204 204);"></li>
                    <li class="no-block card-body p-1 mt-3 ml-2 mr-2 mb-2 d-flex">
                        <div class="col-md-3 text-left ">
                            <strong>Frete:</strong><br>
                        </div>
                        <div class="col-md-9 text-right ">
                            <strong class="resumo_valorFrete"></strong>
                        </div>
                    </li>

                    <li class="no-block card-body p-1 mt-1 ml-2 mr-2 mb-2 d-flex">
                        <div class="col-md-6 text-left ">
                            <strong>Valor total do pedido: </strong><br>
                        </div>
                        <div class="col-md-6 text-right ">
                            <input type="hidden" name="valorTotalPedido" id="valorTotalPedido" value="0">
                            <strong class="resumo_ValorTotalPedido"></strong>
                        </div>
                    </li>
                    <li class="no-block card-body p-3 text-center">
                        <button type="submit" class="btn btn-success bt-small btn-block"><i class="mdi mdi-check"></i> Finalizar Pedido</button>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</form>


<script src="application/source/js/geral.js"></script>
<script>
    pedido_consulta_categoria();

    $('#cadastroPedido').submit(function() {
        var form = $("#cadastroPedido").serialize();
        $.ajax({
            url: 'application/controller/pedido.php',
            type: 'POST',
            data: form,
            dataType: "json",
            success: function(data) {
                exibe_alerta(data.status, 'C');
                window.location.href = 'home.php?pg=pedido/cadastro';
            }
        });

        return false;
    });

    function valida_tipoPedido() {
        var tipo = $('.tipoPedido :selected').val();
        if (tipo == 'E') $('.frete').show();
        else $('.frete').hide();
    }

    function atualiza_pedido_resumo(origem, destino) {
        var conteudo = $(origem + ' :selected').text();
        var origem = $(origem + ' :selected').val();

        if (origem != '') $(destino).html(conteudo);
        else $(destino).html('');
    }

    function atualizar_valorPedido(valorSomar) {
        var valor = parseFloat($('#valorTotalPedido').val()) || 0;
        var valorSomar = parseFloat(valorSomar);

        var valorTotal = valor + valorSomar;
        $('#valorTotalPedido').val(valorTotal);
        $('.resumo_ValorTotalPedido').html('R$ ' + valorTotal);
    }

    function adiciona_itemPedido(id, categoria, produto, valor) {
        console.log(categoria)
        var conteudo = '<li class="no-block card-body d-flex p-1 ml-2 mr-2">' +
            '<input type="hidden" name="idCategoria[' + id + ']" value="' + id + '">' +
            '<input type="hidden" name="qtdCategoria[' + id + ']" value="1">' +
            '<input type="hidden" name="ValorCategoria[' + id + ']" value="' + valor + '">' +
            '<div class="col-md-9 text-left ">' +
            '<strong>' + categoria + ': </strong>' +
            '<span>' + produto + '</span>' +
            '</div>' +
            '<div class="col-md-3 text-right">' +
            '<strong>R$ </strong>' +
            '<span>' + valor + '</span>' +
            '</div>' +
            '</li>';

        $('.divAlertaProduto').hide();
        $('.retornoProduto').append(conteudo);
    }
    
</script>