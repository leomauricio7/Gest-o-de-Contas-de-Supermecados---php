<?php 
$_token = addslashes(filter_input(INPUT_GET, "_token", FILTER_DEFAULT));
if(isset($_token) && !empty($_token)){
    if(Validation::verificaToken($_token)){ 
?>
<form class="form-signin" method="post" action="">
    <?php                    
        /*###########################################################################*/
        if ($_POST):
            $valida = new Validation();
            //pegando os valores do formulario
            $novaSenha = addslashes(filter_input(INPUT_POST, "novaSenha", FILTER_SANITIZE_MAGIC_QUOTES));
            //fazendo a validação
            if($valida->updateSenha($_token, $novaSenha)){
                $_SESSION['msg'] = '<div class="alert alert-success"><h5 align="center"><i class="fa fa-warning"></i> Senha alterada com sucesso.</h5></div>';
                echo '<script>window.location.href="'.Url::getBase().'"</script>';
            }
        endif;               
    ?>
    <div class="text-center mb-4">
        <a href="<?php echo Url::getBase();?>"><img class="mb-4" id="img-logo" src="<?php echo Url::getBase()?>img/logo.png" alt="Lct-e v2"></a>
        <h1 class="h3 mb-3 font-weight-normal">Recuperação de Senha</h1>
    </div>
    <div class="form-label-group">
        <input type="password" id="password" name="novaSenha" class="form-control" placeholder="Nova Senha" minlength="6" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required autofocus>
        <label for="inputEmail">Nova Senha</label>
    </div>
    <div class="form-label-group">
        <input type="password" id="confirm_password" class="form-control" placeholder="" required>
        <label for="inputEmail">Confirma Senha</label>
    </div>
    <button class="btn btn-success btn-block" type="submit">Alterar Senha</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018<br>Desenvolvimento: <a href="http://ltec.000webhostapp.com/"><img src="./img/logo-ltec.png" width="50px"/></a></p>
</form>       
<?php  }else{
    $_SESSION['msg'] =
        '<div class="alert alert-danger">'
            . '<h5 align="center">'
            . '<i class="fa fa-warning"></i>'
            . ' o link de recuperação de senha expirou ou não existe. mais informações entre em contato com o administrador do sistema.'
            . '</h5>'
            . '</div>';
    echo '<script>window.location.href="'.Url::getBase().'"</script>';
    }
}else{
?>
<form class="form-signin" method="post" action="">
    <?php                    
        /*###########################################################################*/
        if ($_POST):
            $valida = new Validation();
            //pegando os valores do formulario
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_MAGIC_QUOTES);
            //setando os valores nos metodos
            $valida->setEmail($email);

            //fazendo a validação
            $valida->recuperaSenha();
            echo $valida->getMsg();
        endif;               
    ?>
    <div class="text-center mb-4">
        <a href="<?php echo Url::getBase();?>"><img class="mb-4" id="img-logo" src="<?php echo Url::getBase()?>img/logo.png" alt="Lct-e v2"></a>
        <h1 class="h3 mb-3 font-weight-normal">Recuperar Senha</h1>
    </div>
    <div class="form-group">
        <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required>
    </div>
    <button class="btn btn-primary btn-block" type="submit">Recuperar</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy;Todos os direitos reservados<br><a href="http://ltec.000webhostapp.com/"><img src="./img/logo-ltec.png" width="50px"/></a></p>
</form>
<?php }