<?php

$arrayFiltro = array(
    "Titulo" => 'Usuário',
    "Icone" => 'mdi mdi-cart-outline',
    "Class" => 'usuario'
);

$arrayResultado = array(
    "Titulo" => 'Resultado',
    "Icone" => 'mdi mdi-cart-outline',
    "Class" => 'usuarioRetorno hide'
);

/**Busca */
echo widget_box_open($arrayFiltro); ?>

<div class="col-md-12 mb-2">
    <button type="button" class="btn btn-success btn-sm text-white" onclick="modal_cadastro('Cadastro de Usuário', 'usuario/cadastro')" data-toggle="modal" data-target="#modalConteudo">
        <i class="fa fa-plus"></i> Novo Usuário
    </button>
</div>
<form id="consultaUsuario">
    <div class="row p-2">
        <div class="col-md-2">
            <label>Código Usuário</label><br>
            <input type="text" name="codUsuario" value="" placeholder="Código do Usuário" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Nome do Usuário</label><br>
            <input type="text" name="nomeUsuario" placeholder="Digite o nome do usuário" id="nomeUsuario" class="form-control">
        </div>
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
    function excluir_usuario(idUsuario) {
        $.ajax({
            url: 'application/controller/usuario.php',
            type: 'POST',
            data: 'acao=excluir&idusuario=' + idUsuario,
            dataType: "json",
            success: function(data) {
                $('#usuario_' + idUsuario).remove();
                exibe_alerta(data.status, 'D');
            }
        });
    }

    $('#consultaUsuario').submit(function() {
        var form = $("#consultaUsuario").serialize();
         $.ajax({
            url: 'application/view/usuario/resultado.php',
            type: 'POST',
            data: form,
            success: function(data) {
                $('.conteudoRetorno').html(data);
                $('.usuarioRetorno').show();
            }
        });
        return false;
    });
</script>