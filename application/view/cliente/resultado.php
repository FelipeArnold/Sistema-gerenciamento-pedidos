<?php
extract($_REQUEST);
require_once '../../source/banco/conexao.php';
require_once '../../source/php/geral.php';

$filtro = '';

if (!empty($codCliente)) $filtro .= " AND Id_Cliente = '".retorna_somenteNumeros($codCliente)."' ";
if (!empty($nomeCliente)) $filtro .= " AND Nome_Cliente LIKE '%$nomeCliente%' ";
if (!empty($telefone)) $filtro .= " AND Telefone_Cliente LIKE '%".retorna_somenteNumeros($telefone)."%' ";
if (!empty($dataInicio)) $filtro .= " AND DataCadastro_Cliente >= '$dataInicio'";
if (!empty($dataFinal)) $filtro .= " AND DataCadastro_Cliente <= '$dataFinal'";


$sql = "SELECT * FROM cliente c
        INNER JOIN logradouro l on c.IdLogradouro_Cliente = l.Id_Logradouro  
        INNER JOIN cidade ci on l.IdCidade_Logradouro = ci.Id_Cidade
        WHERE 1 AND ISNULL(DataExclusao_Cliente)
        $filtro";

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
            <?php foreach ($sql as $cliente) {

                $endereco = $cliente->Logradouro_Logradouro;
                if (!empty($cliente->Numero_Cliente)) $endereco .= ', ' . $cliente->Numero_Cliente;
                if (!empty($cliente->Bairro_Logradouro)) $endereco .= '<br>' . $cliente->Bairro_Logradouro;
                if (!empty($cliente->Cidade_Cidade)) $endereco .=  ' - ' . $cliente->Cidade_Cidade . '/' . $cliente->Estado_Cidade;
                if (!empty($cliente->Cep_Logradouro)) $endereco .= '<br>(' . $cliente->Cep_Logradouro . ')';
            ?>
                <tr id="produto_<?php echo $cliente->Id_Cliente; ?>">
                    <td><?php echo formata_codigo($cliente->Id_Cliente); ?></td>
                    <td><?php echo $cliente->Nome_Cliente . '<br> (' . $cliente->CpfCnpj_Cliente . ')'; ?></td>
                    <td><?php echo $cliente->Email_Cliente; ?></td>
                    <td><?php echo $cliente->Telefone_Cliente; ?></td>
                    <td><?php echo $endereco; ?></td>
                    <td> <i class="mdi mdi-clock text-success"></i><?php echo data_hora($cliente->DataCadastro_Cliente); ?></td>
                    <td>
                        <span data-toggle="tooltip" data-placement="bottom" title="Editar"><button type="button" class="btn btn-warning btn-sm rounded" onclick="modal_cadastro('Cadastro de Produto', 'cliente/cadastro', <?php echo $cliente->Id_Cliente; ?>)" data-toggle="modal" data-target="#modalConteudo"><i class="mdi mdi-table-edit"></i></button></span>
                        <button class="btn btn-danger btn-sm rounded" onclick="excluir_cliente(<?php echo $cliente->Id_Cliente; ?>)" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="mdi mdi-delete-variant"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $("#zero_config").DataTable();
</script>