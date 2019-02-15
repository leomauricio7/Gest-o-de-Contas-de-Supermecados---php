<?php if($_SESSION['idTipo'] == 1){?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Início</li>
        <li class="breadcrumb-item active" aria-current="page">Usuários Cadastrados</li>
    </ol>
</nav>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Usuários Cadastrados</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class=" btn btn-sm btn-dark" href="<?php echo Url::getBase().'cadastra-usuario'; ?>"><i class="fa fa-plus-circle"></i> Cadastrar Usuário</a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Data do Cadastro</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $read= new Read();
            $read->ExeRead("usuarios");
            foreach($read->getResult() as $dados){
                extract($dados);
            ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $nome; ?></td>
                <td><?php echo Validation::getTipoUsario($id_tipo); ?></td>
                <td><?php echo date('d/m/Y', strtotime($created)); ?></td>
                <td>
                    <a href="<?php echo Url::getBase().'edit-usuario/'.$id;?>" class="btn btn-sm btn-warning"> <span class="fa fa-edit"></span> Editar</a>
                    <a href="<?php echo Url::getBase() . './app/delete.php?pag=usuarios&tb=usuarios&ch=id&value=' . $id; ?>" class="btn btn-sm btn-danger"> <span class="fa fa-trash"></span> Excluir</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php }else{
    require_once('404.php');
}