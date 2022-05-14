<?php extract($_REQUEST); ?>

<div class="row">
    <div class="col-md-4 divCategorias">
        <div class="card shadow p-3 mb-5 bg-white rounded">
            <div class="card-body text-center">
                <h4 class="card-title mb-0">Categoria</h4>
            </div>
            <ul class="list-style-none">
                <div class="retornoCategoria"></div>
                <li class="no-block card-body p-3 border-top text-center">
                    <button class="btn btn-outline-success btn-small text-center btn-block" onclick="modal_cadastro('Cadastro de Categoria', 'categoria/cadastro')" data-toggle="modal" data-target="#modalConteudo"><span><i class="mdi mdi-plus"></i> ADICIONAR CATEGORIA</span> </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="retornoCategoriaItem"></div>
    </div>
    <div class="col-md-4">
        <div class="retornoCategoriaItemCaracteristica"></div>
    </div>
</div>

<script src="application/source/js/geral.js"></script>
<script>
    consulta_categoria();

    function consulta_caracteristicas_item(id) {
        $.ajax({
            url: 'application/view/produto/consulta-categoriaItemCaracteristica.php',
            type: 'POST',
            data: 'id='+id,
            dataType: "json",
            success: function(data) {
                $('.retornoCategoriaItemCaracteristica').html(data.conteudo);
            }
        });
    }

    
</script>