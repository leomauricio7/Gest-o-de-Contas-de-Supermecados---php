
<form class="form-signin" method="post" action="">
    <?php
    if (isset($_SESSION['logado'])):
        echo '<script>window.location.href="cpanel/";</script>';
    else:
        unset($_SESSION['logado']);
    endif;
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    if ($_POST) {
        $valida = new Validation();
        if ($valida->verificaRecaptcha($_POST['g-recaptcha-response'])):
            $valida->setEmail(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
            $valida->setSenha(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
            if ($valida->logar()) {
                echo '<script>window.location.href="cpanel/";</script>';
            } else {
                echo '<script>window.history.go(-1);</script>';
            }
        else:
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Atenção:</strong> Recaptcha Inválido
                 </div>';
        endif;
    }
    ?>
    <div class="text-center mb-4">
        <a href="<?php echo Url::getBase(); ?>"><img class="mb-4" id="img-logo" src="<?php echo Url::getBase() ?>img/logo.png" alt="NT-SITEMAS"></a>
        <h1 class="h3 mb-3 font-weight-normal">Acesso restrito</h1>
    </div>

    <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
    </div>

    <div class="form-group">
      <div class="input-group mb-2">
      <input type="password" class="form-control" id="senha" name="password" placeholder="Senha" required>
        <div class="input-group-prepend">
          <div class="input-group-text" id="olho"><i class="fa fa-eye"></i></div>
        </div>
        <label class="sr-only" for="senha">Senha</label>
      </div>
    </div>

    <div class="checkbox mb-3">
        <div class="g-recaptcha" data-sitekey="6Lelv2oUAAAAAKqDbwRpG6W79ppJB1Fs1Int7ca2"></div>
    </div>
    <button class="btn btn-success btn-block" type="submit"><i class="fa fa-sigin-out"></i> Entrar</button>
    <a class="btn btn-primary btn-block" href="<?php echo Url::getBase() . 'recupera-senha'; ?>">Esqueceu sua senha?</a>
    <p class="mt-2 text-muted text-center">&copy Todos os direitos reservados<br><a href="http://ltec.000webhostapp.com/"><img src="./img/logo-ltec.png" width="50px"/></a></p>
</form>