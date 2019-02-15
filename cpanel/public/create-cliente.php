
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Início</li>
        <li class="breadcrumb-item active" aria-current="page">Cadastrar Cliente</li>
    </ol>
</nav>
<?php
if ($_POST) {
    $dados = Validation::limpaDados(filter_input_array(INPUT_POST, FILTER_DEFAULT));
    $validaCpf = new ValidaCPFCNPJ($dados['cpf']);
    if ($validaCpf->valida()) {
        $user = new Cliente();
        $user->createCliente($dados);
        if (!$user->getResult()):
            echo $user->getMsg();
        else:
            echo $user->getMsg();
            unset($dados);
        endif;
    }else{
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                CPF inválido! Tente novamente.
            </div>';
    }    
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cadastrar Cliente</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class=" btn btn-sm btn-dark" href="<?php echo Url::getBase() . 'clientes'; ?>"><i class="fa fa-list"></i> Lista Clientes</a>
        </div>
    </div>
</div>
<form method="post" action="" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputEmail4">Nome</label>
            <input type="text" name="nome"class="form-control" id="inputEmail4" placeholder="Nome" required autofocus />
        </div>
        <div class="form-group col-md-4">
            <label for="inputPassword4">CPF</label>
            <input type="text" name="cpf" class="form-control" id="inputPassword4" placeholder="CPF" minlength="11" maxlength="11" pattern="[0-9]+" required />
        </div>
        <div class="form-group col-md-4">
            <label for="inputPassword4">Endereço</label>
            <input type="text" name="endereco" class="form-control" id="inputPassword4" placeholder="Endereço" required />
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cadastrar</button>
</form>