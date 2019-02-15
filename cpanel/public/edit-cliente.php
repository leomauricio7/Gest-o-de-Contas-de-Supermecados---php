
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Início</li>
        <li class="breadcrumb-item active" aria-current="page">Editar Cliente</li>
    </ol>
</nav>
<?php
$id = Url::getURL(1);
if ($_POST) {
    $dados = Validation::limpaDados(filter_input_array(INPUT_POST, FILTER_DEFAULT));
    $validaCpf = new ValidaCPFCNPJ($dados['cpf']);
    if ($validaCpf->valida()) {
        $dadosUpdate = ['nome'=>$dados['nome'],'cpf'=>$dados['cpf'],'endereco'=>$dados['endereco']];
        $update = new Update();
        $update->ExeUpdate('clientes', $dadosUpdate, 'WHERE id = :id', 'id=' . Url::getURL(1) . '');
        if ($update->getResult()):
            echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 align="center"><i class="fa fa-check-circle"></i> Alterações realizadas com sucesso.</h5>
                </div>';
        endif;
    }else {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                CPF inválido! Tente novamente.
            </div>';
    }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Cliente</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class=" btn btn-sm btn-dark" href="<?php echo Url::getBase() . 'clientes'; ?>"><i class="fa fa-list"></i> Lista Clientes</a>
        </div>
    </div>
</div>
<form method="post" action="" enctype="multipart/form-data">
    <?php
    $read = new Read();
    $read->ExeRead("clientes", " WHERE id = $id");
    foreach ($read->getResult() as $dados) {
        extract($dados);
        ?>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Nome</label>
                <input type="text" name="nome" value="<?php echo $nome; ?>" class="form-control" id="inputEmail4" placeholder="Nome" required autofocus />
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">CPF</label>
                <input type="text" name="cpf" class="form-control" value="<?php echo $cpf; ?>" id="inputPassword4" placeholder="CPF" minlength="11" maxlength="11" pattern="[0-9]+" required />
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Endereco</label>
                <input type="text" name="endereco" class="form-control" value="<?php echo $endereco; ?>" id="inputPassword4" placeholder="endereco" required />
            </div>
        </div>
    <?php 
    }
    ?>
    <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Salvar Alterações</button>
</form>
