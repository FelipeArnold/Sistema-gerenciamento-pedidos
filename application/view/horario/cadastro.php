<?php

$arrayFiltro = array(
    "Titulo" => 'Hor&aacute;rios de Atendimento',
    "Icone" => 'mdi mdi-calendar-clock',
    "Class" => 'horarios'
);


/**Busca */
echo widget_box_open($arrayFiltro); ?>

<form id="consultaProduto">
    <div class="row p-2">
        <div class="col-md-2">
            <label>Dia da Semana</label><br>
            <select name="tipo" id="tipo" class="form-control shadow-none" style="width: 100%; height: 36px">
                <option value="DO">Domingo</option>
                <option value="SG">Segunda-Feira</option>
                <option value="TE">Terça-Feira</option>
                <option value="QA">Quarta-Feira</option>
                <option value="QI">Quinta-Feira</option>
                <option value="SX">Sexta-Feira</option>
                <option value="SA">Sábado</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Turno</label><br>
            <select name="tipo" id="tipo" class="form-control shadow-none" style="width: 100%; height: 36px">
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>In&iacute;cio</label><br>
            <input type="time" name="inicio" value="" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Final</label><br>
            <input type="time" name="final" value="" class="form-control">
        </div>
        <div class="col-md-1 p-0 text-center">
            <label></label>
            <button type="submit" class="btn btn-success mt-4">Cadastrar</button>
        </div>
    </div>
</form>

<?php echo widget_box_close(); ?>
<script>
    
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