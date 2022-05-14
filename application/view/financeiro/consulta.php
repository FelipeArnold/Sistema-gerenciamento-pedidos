<?php

$arrayFiltro = array(
    "Titulo" => 'Relat&oacute;rio Financeiro',
    "Icone" => 'mdi mdi-account',
    "Class" => 'financeiro'
);

$arrayResultado = array(
    "Titulo" => 'Resultado',
    "Icone" => 'mdi mdi-account',
    "Class" => 'clienteResultado hide'
);

echo widget_box_open($arrayFiltro); ?>

<form id="consultaFinanceira">
    <div class="row p-2">
        <div class="col-md-2">
            <label>Data Inicial</label><br>
            <input type="date" name="dataInicio" value="<?php echo date('Y-m-d'); ?>" id="dataInicio" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Data Final</label><br>
            <input type="date" name="dataFinal" value="<?php echo date('Y-m-d'); ?>" id="dataFinal" class="form-control">
        </div>
        <div class="col-md-1 p-0 text-center">
            <label></label>
            <button class="btn btn-success mt-4">Pesquisar</button>
        </div>
    </div>
</form>

<?php
echo widget_box_close();
echo widget_box_open($arrayResultado);
?>
<div class="card conteudoRetorno"></div>
<?php echo widget_box_close(); ?>

<script>
    $('#consultaFinanceira').submit(function() {
        var form = $("#consultaFinanceira").serialize();
        $.ajax({
            url: 'application/view/financeiro/resultado.php',
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