<?php

$arrayFiltro = array(
    "Titulo" => 'Cliente',
    "Icone" => 'mdi mdi-account',
    "Class" => 'pedidos'
);

$arrayResultado = array(
    "Titulo" => 'Resultado',
    "Icone" => 'mdi mdi-account',
    "Class" => 'clienteResultado hide'
);

/**Busca */
echo widget_box_open($arrayFiltro); ?>

<div class="col-md-12 mb-2">
    <button type="button" class="btn btn-success btn-sm text-white" onclick="modal_cadastro('Cadastro de Cliente', 'cliente/cadastro')" data-toggle="modal" data-target="#modalConteudo">
        <i class="fa fa-plus"></i> Novo Cliente
    </button>
</div>
<form id="consultaCliente">
    <div class="row p-2">
        <div class="col-md-2">
           
            <label>Código Cliente</label><br>
            <input type="text" name="codCliente" value="" placeholder="Digito o código" id="codCliente" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Data Inicial</label><br>
            <input type="date" name="dataInicio" value="<?php echo date('Y-m-d'); ?>" id="dataInicio" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Data Final</label><br>
            <input type="date" name="dataFinal" value="<?php echo date('Y-m-d'); ?>" id="dataFinal" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Nome Cliente</label><br>
            <input type="text" name="nomeCliente" placeholder="Digite o nome" id="nomeCliente" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Telefone</label><br>
            <input type="text" name="telefone" placeholder="Digite o número do telefone" id="telefone" class="form-control telefone">
        </div>
        <div class="col-md-1 p-0 text-center">
            <label></label>
            <button class="btn btn-success mt-4">Pesquisar</button>
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
    function excluir_cliente(idCliente) {
        $.ajax({
            url: 'application/controller/cliente.php',
            type: 'POST',
            data: 'acao=excluir&idcliente=' + idCliente,
            dataType: "json",
            success: function(data) {
                $('#produto_' + idCliente).remove();
                exibe_alerta(data.status, 'D');
            }
        });
    }

    $('#consultaCliente').submit(function() {
        var form = $("#consultaCliente").serialize();
        $.ajax({
            url: 'application/view/cliente/resultado.php',
            type: 'POST',
            data: form,
            success: function(data) {
                $('.conteudoRetorno').html(data);
                $('.clienteResultado').show();
            }
        });
        return false;
    });
</script>