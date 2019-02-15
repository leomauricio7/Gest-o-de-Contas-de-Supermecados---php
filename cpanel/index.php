<?php
require_once('./app/Conf.inc');
require_once('./vendor/autoload.php');
Validation::validaSession();
Validation::validaSession();
if (isset($_GET['logout'])):
    if ($_GET['logout'] == 'true'):
        Validation::deslogar();
    endif;
endif;
$url = Url::getURL(0);
$tipoUser = $_SESSION['idTipo'];
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo Url::getBase() . '../img/logo.png'; ?>">

        <title>NT-SISTEMAS - <?php echo $_SESSION['user']; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo Url::getBase() . '../css/bootstrap.min.css'; ?>" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo Url::getBase() . '../css/dashboard.css'; ?>" rel="stylesheet">
        <link href="<?php echo Url::getBase() . '../css/estilo-back.css'; ?>" rel="stylesheet">

        <!-- Font Weasome -->
        <link href="<?php echo Url::getBase() . '../css/font-awesome.css'; ?>" rel="stylesheet">

        <!-- Bootstrap 4 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet"/>
        
    </head>

    <body>
        <?php require_once './public/menu-superior.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <?php require_once './public/menu-lateral.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <?php
                    $pagina = Url::getURL(0);
                    if ($pagina == null):
                        $pagina = "home";
                    endif;
                    if (file_exists("public/" . $pagina . ".php")):
                        require "public/" . $pagina . ".php";
                    else:
                        require "public/404.php";
                    endif;
                    ?>
                </main>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo Url::getBase() . '../js/jquery.min.js'; ?>" ></script>
        <script src="<?php echo Url::getBase() . '../js/popper.min.js'; ?>"></script>
        <script src="<?php echo Url::getBase() . '../js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo Url::getBase() . '../js/jquery-3.3.1.min.js'; ?>"></script>
        <!-- Icons -->
        <script src="<?php echo Url::getBase() . '../js/feather.min.js'; ?>"></script>
        <script>
            feather.replace();
        </script>
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
            $(document).ready(function () {
                //$('#example').DataTable();
                $("#on").click(function(){;
                    st = $("#doc").is(":visible");
                    //console.log(st);
                    if(st === false){
                        $("#icon").addClass("fa fa-arrow-down");
                    }else{
                        $("#icon").removeClass("fa fa-arrow-down");
                        $("#icon").addClass("fa fa-arrow-up");
                    }
                   $("#doc").toggle(); 
                });

            });
        </script>
        <script>
            $(function () {
             $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <script>

         function CriaRequest() {
            try{
                request = new XMLHttpRequest();        
            }catch (IEAtual){
                try{
                    request = new ActiveXObject("Msxml2.XMLHTTP");       
                }catch(IEAntigo){
                    try{
                        request = new ActiveXObject("Microsoft.XMLHTTP");          
                    }catch(falha){
                        request = false;
                    }
                }
            }
            if (!request) 
                alert("Seu Navegador não suporta Ajax!");
            else
                return request;
            }

            $('.pagar-parcialmente').click(function(e){
                e.preventDefault();
                var id = $(this).attr('alt');
                var valor = prompt('Valor a ser pago?');
                var xmlreq = CriaRequest();
                if(valor){
                xmlreq.open("GET", "../app/Class/pagarDivida.php?id="+id+"&valor="+valor, true);
                xmlreq.onreadystatechange = function(){
                    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
                    if (xmlreq.readyState == 4) {
                        // Verifica se o arquivo foi encontrado com sucesso
                        if (xmlreq.status == 200) {
                            location.reload();
                            $('#success').show('fast');
                            $('#error').hide('fast');
                        }else{
                            location.reload();
                            $('#success').hide('fast');
                            $('#error').show('fast');
                        }
                    }
                }
                }
                xmlreq.send(null);
            });
        </script>
        <script>
            function printtag(tagid) {
                    var hashid = "#"+ tagid;
                    var tagname =  $(hashid).prop("tagName").toLowerCase() ;
                    var attributes = ""; 
                    var attrs = document.getElementById(tagid).attributes;
                    $.each(attrs,function(i,elem){
                        attributes +=  " "+  elem.name+" ='"+elem.value+"' " ;
                    })
                    var divToPrint= $(hashid).html() ;
                    var head = "<html><head>"+ $("head").html() + "</head>" ;
                    var allcontent = head + "<body  onload='window.print()' >"+ "<" + tagname + attributes + ">" +  divToPrint + "</" + tagname + ">" +  "</body></html>"  ;
                    var newWin=window.open('','Print-Window');
                    newWin.document.open();
                    newWin.document.write(allcontent);
                    newWin.document.close();
                // setTimeout(function(){newWin.close();},10);
                }
        </script>
    </body>
</html>
