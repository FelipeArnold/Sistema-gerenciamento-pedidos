<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$filtro = '';

if (!empty($codUsuario)) $filtro .= " AND Id_Usuario = '".retorna_somenteNumeros($codUsuario)."' ";
if (!empty($nomeUsuario)) $filtro .= " AND Nome_Usuario LIKE '%$nomeUsuario%' ";
if (!empty($dataInicio)) $filtro .= " AND DataCadastro_Usuario >= '$dataInicio'";
if (!empty($dataFinal)) $filtro .= " AND DataCadastro_Usuario <= '$dataFinal'";

$sql = "SELECT * FROM usuario u
        INNER JOIN logradouro l on u.IdLogradouro_Usuario = l.Id_Logradouro  
        INNER JOIN cidade ci on l.IdCidade_Logradouro = ci.Id_Cidade
        WHERE 1 $filtro AND ISNULL(DataExclusao_Usuario)";
echo $sql;
if ($query = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($query) > 0) {
        $sql = array();
        while ($row = mysqli_fetch_object($query)) {
            $sql[] = $row;
        }
    }
}

?>

<div class="table-responsive">
    <table id="zero_config" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Endere&ccedil;o</th>
                <th>Data Cadastro</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sql as $usuario) {

                $endereco = $usuario->Logradouro_Logradouro;
                if (!empty($usuario->Numero_Usuario)) $endereco .= ', ' . $usuario->Numero_Usuario;
                if (!empty($usuario->Bairro_Logradouro)) $endereco .= '<br>' . $usuario->Bairro_Logradouro;
                if (!empty($usuario->Cidade_Cidade)) $endereco .=  ' - ' . $usuario->Cidade_Cidade . '/' . $usuario->Estado_Cidade;
                if (!empty($usuario->Cep_Logradouro)) $endereco .= '<br>(' . $usuario->Cep_Logradouro . ')';
            ?>
                <tr id="usuario_<?php echo $usuario->Id_Usuario; ?>">
                    <td><?php echo formata_codigo($usuario->Id_Usuario); ?></td>
                    <td><?php echo $usuario->Nome_Usuario . '<br> (' . $usuario->Cpf_Usuario . ')'; ?></td>
                    <td><?php echo $usuario->Email_Usuario; ?></td>
                    <td><?php echo $usuario->Telefone_Usuario; ?></td>
                    <td><?php echo $endereco; ?></td>
                    <td> <i class="mdi mdi-clock text-success"></i><?php echo data_hora($usuario->DataCadastro_Usuario); ?></td>
                    <td>
                        <span data-toggle="tooltip" data-placement="bottom" title="Editar"><button type="button" class="btn btn-warning btn-sm rounded" onclick="modal_cadastro('Editar Usuário', 'usuario/cadastro', <?php echo $usuario->Id_Usuario; ?>)" data-toggle="modal" data-target="#modalConteudo"><i class="mdi mdi-table-edit"></i></button></span>
                        <button class="btn btn-danger btn-sm rounded" onclick="excluir_usuario(<?php echo $usuario->Id_Usuario; ?>)" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="mdi mdi-delete-variant"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $("#zero_config").DataTable();
</script>