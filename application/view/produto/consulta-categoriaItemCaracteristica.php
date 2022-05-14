<?php
extract($_REQUEST);

require_once '../../source/session/session.php';
require_once '../../source/banco/conexao.php';

$sql = "SELECT * FROM categoria_item_caracteristica WHERE 1 AND Id_Categoria_Item_Caracteristica = '$id' ";

$acao = 'cadastrar';
if ($query = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_object($query);
    if (mysqli_num_rows($query) > 0) $acao = 'editar';
}


$conteudo = '<div class="card shadow p-3 mb-5 bg-white rounded">
            <div class="card-body text-center">
                <h4 class="card-title mb-0">Caracteristica</h4>
            </div>
            <ul class="list-style-none ">
                <form id="form_caracteristica">
                    <div class="col-md-12">
                        <input type="hidden" value="' . $acao . '" name="acao" class="acao">
                        <input type="hidden" value="' . $id . '" name="idCaracteristicas">
                        <textarea class="form-control" row="5" name="descricaoCaracteristicas" required>' . $row->Descricao_Categoria_Item_Caracteristica . '</textarea>
                    </div>
                    <li class="no-block card-body p-3 border-top text-center">
                        <button type="submit" class="btn btn-outline-success btn-small text-center btn-block"><span><i class="mdi mdi-plus"></i> SALVAR </span> </button>
                    </li>
                </form>
            </ul>
        </div>
        <script>
        $("#form_caracteristica").submit(function() {
            var form = $("#form_caracteristica").serialize();
            var Status = $(".retornoCategoriaItemCaracteristica .acao").val();
            var valStatus = Status == "cadastrar" ? "C" : "E";
    
            console.log(form);
            $.ajax({
                url: "application/controller/categoria-item-categoria.php",
                type: "POST",
                data: form,
                dataType: "json",
                success: function(data) {
                    exibe_alerta(data.status, valStatus);
                    window.location.href = "home.php?pg=produto/cadastro";   
                }
            });
    
            return false;
        });
        </script>';

echo json_encode(array("conteudo" => $conteudo), true);
