<?php

$arrayFiltro = array(
    "Titulo" => 'Mesas',
    "Icone" => 'mdi mdi-timetable',
    "Class" => 'usuario'
);

/**Busca */
echo widget_box_open($arrayFiltro); ?>

<div class="col-md-12 mb-2">
    <form id="cadastroMesas">
        <div class="row">
            <div class="col-md-2 p-2">
                <label>Número de Mesas</label><br>
                <input type="text" name="nomeEntregador" required class="form-control" value="<?php echo $row->Nome_Entregador; ?>" placeholder="Número de Mesas">
            </div>
            <div class="col-md-2 p-2">
                <button type="submit" class="btn btn-success mt-4">Salvar</button>
            </div>
        </div>
    </form>
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
</script>