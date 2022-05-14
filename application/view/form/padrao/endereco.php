<div class="card m-b-0 border-top">
    <div class="card-header border" id="headingTwo">
        <h5 class="mb-0">
            <a class="collapsed" data-toggle="collapse" data-target="#enderecoCollapse" aria-expanded="false" aria-controls="enderecoCollapse">
                <i class="m-r-5 mdi mdi-map-marker" aria-hidden="true"></i>
                <span>Endereço</span>
            </a>
        </h5>
    </div>
    <div id="enderecoCollapse" class="collapse borda" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
            <div class="row">
                <input type="hidden" name="idLogradouro" class="form-control idLogradouro" value="<?php echo $IdLogradouro?>">
                <div class="col-md-3 p-2">
                    <label>CEP</label><br>
                    <input type="text" name="cep" class="form-control cep" value="<?php echo $cep?>" onblur="consulta_endereco($('.cep').val())" placeholder="Digite o cep">
                </div>
                <div class="col-md-7 p-2">
                    <label>Logradouro</label><br>
                    <input type="text" name="logradouro" class="form-control logradouro" placeholder="Logradouro" value="<?php echo $logradouro?>" disabled>
                </div>
                <div class="col-md-2 p-2">
                    <label>Nº</label><br>
                    <input type="text" name="numero" class="form-control numero" value="<?php echo $num?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 p-2">
                    <label>Bairro</label><br>
                    <input type="text" name="bairro" class="form-control bairro" placeholder="Bairro" value="<?php echo $bairro?>" disabled>
                </div>
                <div class="col-md-5 p-2">
                    <label>Cidade</label><br>
                    <input type="text" name="cidade" class="form-control cidade" value="<?php echo $cidade?>" disabled>
                </div>
                <div class="col-md-2 p-2">
                    <label>UF</label><br>
                    <input type="text" name="uf" class="form-control uf" value="<?php echo $uf;?>" disabled>
                </div>
            </div>
        </div>
    </div>
</div>