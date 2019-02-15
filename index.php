<?php
require_once('./cpanel/app/Conf.inc');
require_once('./cpanel/vendor/autoload.php');
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Sistema de Licitação para entidades publicas">
        <meta name="author" content="Leonardo Mauricio - Ltec">
        <link rel="icon" href="<?php echo Url::getBase()?>img/logo.png">
        <title>Controle Financeiro - NTSISTEMAS </title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo Url::getBase()?>css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo Url::getBase()?>css/floating-labels.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </head>

    <body>
        <?php
        $pagina = Url::getURL(0);
        if ($pagina == null):
            $pagina = "cpanel-login";
        endif;
        if (file_exists("public/" . $pagina . ".php")):
            require "public/" . $pagina . ".php";
        else:
            require "public/404.php";
        endif;
        ?>
        <script src="<?php echo Url::getBase() . 'js/jquery.min.js'; ?>" ></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <!-- função para validas as senhas -->
        <script>
            var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");
            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Senhas não coincidem!");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        </script>
        <script>
            $(function(){
                var senha = $('#senha');
                var olho= $("#olho");

                olho.mousedown(function() {
                senha.attr("type", "text");
                });

                olho.mouseup(function() {
                senha.attr("type", "password");
                });
                // para evitar o problema de arrastar a imagem e a senha continuar exposta, 
                //citada pelo nosso amigo nos comentários
                $( "#olho" ).mouseout(function() { 
                $("#senha").attr("type", "password");
                });
            })
        </script>
    </body>
</html>
