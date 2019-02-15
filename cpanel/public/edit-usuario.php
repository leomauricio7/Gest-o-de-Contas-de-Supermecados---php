
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Início</li>
        <li class="breadcrumb-item active" aria-current="page">Editar Usuário</li>
    </ol>
</nav>
<?php
$id = Url::getURL(1);
if ($_POST) {
        $dados = Validation::limpaDados(filter_input_array(INPUT_POST, FILTER_DEFAULT));

        $dadosUpdate = ['nome'=>$dados['nome'],'email'=>$dados['email'],'id_tipo'=>$dados['id_tipo']];
        
        $update = new Update();
        $update->ExeUpdate('usuarios', $dadosUpdate, 'WHERE id = :id', 'id=' . Url::getURL(1) . '');
        if ($update->getResult()):
            echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 align="center"><i class="fa fa-check-circle"></i> Alterações realizadas com sucesso.</h5>
                </div>';
        endif;

}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Usuário</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class=" btn btn-sm btn-dark" href="<?php echo Url::getBase() . 'usuarios'; ?>"><i class="fa fa-list"></i> Lista Usuários</a>
        </div>
    </div>
</div>
<form method="post" action="" enctype="multipart/form-data">
    <?php
    $read = new Read();
    $read->ExeRead("usuarios", " WHERE id = $id");
    foreach ($read->getResult() as $dados) {
        extract($dados);
        ?>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Nome</label>
                <input type="text" name="nome" value="<?php echo $nome; ?>" class="form-control" id="inputEmail4" placeholder="Nome" required autofocus />
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">E-mail</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" id="inputPassword4" placeholder="Email" required />
            </div>
            <div class="form-group col-md-4">
                <label for="inputCity">Tipo</label>
                <select class="form-control" name="id_tipo" required>
                    <option value="">Selecione</option>
                    <?php
                    $read = new Read();
                    $read->ExeRead("tipo_user");
                    foreach ($read->getResult() as $dados) {
                        extract($dados);
                        ?>
                        <option <?php if($id_tipo == $id){echo 'selected';}?> value="<?php echo $id; ?>"><?php echo $tipo; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    <?php 
    }
    ?>
    <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Salvar Alterações</button>
</form>