<?php

class Validation extends Conn {

    private $login;
    private $senha;
    private $email;
    private $cpf;
    private $Msg;

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setLogin($login) {
        $this->login = addslashes($login);
    }

    public function setSenha($senha) {
        $this->senha = addslashes($senha);
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function logar() {
            $pdo = parent::getConn();
            $logar = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $logar->bindValue(1, $this->getEmail());
            $logar->execute();
            if ($logar->rowCount() == 1) {
                $dados = $logar->fetch(PDO::FETCH_ASSOC);
                if (password_verify($this->getSenha(), $dados['senha'])) {
                    $_SESSION['user'] = $dados['nome'];
                    $_SESSION['email'] = $dados['email'];
                    $_SESSION['senha'] = $this->getSenha();
                    $_SESSION['idTipo'] = $dados['id_tipo'];
                    $_SESSION['idUser'] = $dados['id'];
                    $_SESSION['logado'] = true;
                    $_SESSION["sessiontime"] = time() + 60 * 20;
                    return true;
                } else {
                    $_SESSION['msg'] = '<div class="alert alert-danger"><h5 align="center"><i class="fa fa-warning"></i> Senha incorreta</h5></div>';
                    return false;
                }
            } else {
                $_SESSION['msg'] = '<div class="alert alert-danger"><h5 align="center"><i class="fa fa-warning"></i> Email não cadastrado no sistema</h5></div>';
                return false;
            }
    }

    /* Função de recuperar senha */

    public function recuperaSenha() {
        $pdo = parent::getConn();

        $rec = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $rec->bindValue(1, $this->getEmail());
        $rec->execute();
        if ($rec->rowCount() == 1):
            $_token = hash("sha256", md5(uniqid())); //gerando uma senha aletória para o usuário
            $dados = $rec->fetch(PDO::FETCH_ASSOC);
            $this->setEmail($dados['email']); //pegando o email do usuario
            //if ($this->enviaEmail($_token, $dados['nome'])) {//enviando o email com a nova senha
            $update = $pdo->prepare("UPDATE usuarios SET _token = :_token WHERE email = :email");
            $update->execute(array(
                ':email' => $this->getEmail(),
                ':_token' => $_token
            ));
            $this->Msg = '<div class="alert alert-success">'
                    . '<h5 align="center">'
                    . 'Foi enviado para o email: <strong>' . $this->getEmail() . '</strong> '
                    . 'um link para recuperação da senha.<br>'
                    . 'Verifique sua caixa de entrada.<br>Demo: Link temporario:<strong>'
                    . '<a href="localhost/lcte-v2/recupera-senha?_token=' . $_token . '">localhost/lcte-v2/recupera-senha?_token=' . $_token . '</a></strong>'
                    . '</h5>'
                    . '</div>';
            return true;
        //} else {
        //    $_SESSION['erro'] = '<div class="alert alert-danger"><h5 align="center"><i class="fa fa-warning"></i> Erro ao enviar o email.</h5></div>';
        //    return false;
        //}
        else:
            $this->Msg = '<div class="alert alert-danger"><h5 align="center"><i class="fa fa-warning"></i> Email ou CPF incorretos.</h5></div>';
            return false;
        endif;
    }

    /* Função de enviar Email */

    public function enviaEmail($_token, $user) {
        // emails para quem será enviado o formulário
        $from = "suporte@lcte.com.br";
        $assunto = "Solicitação de Recuperação de Senha";
        $destino = $this->getEmail();
        // É necessário indicar que o formato do e-mail é html
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "De: $from";
        $msg = '
            <!DOCTYPE html>
            <html>
            <head>
                    <meta charset="utf-8">
                    <title>Recuperação de Senha</title>
            </head>
            <body>
                    <table border="1" cellspacing="0" class="MsoTableGrid" style="margin:auto; border-collapse:collapse; border:solid #a5a5a5 1.0pt">
                            <tbody>
                                    <tr style="border-bottom: 15px solid #dbdbdb;background-image: linear-gradient(to top, #15a5d4 0%, #007eb0 100%);">
                                            <td style="width:424.7pt">
                                                    <p style="text-align:center"><img src="https://ltec.000webhostapp.com/demo/lcte/img/logo-branco.png" width="200px" /></p>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td style="width:424.7pt;padding:20px;">
                                            <p style="text-align:center"><strong><span style="font-size:25pt"><span style="font-family:&quot;Arial&quot;,sans-serif">Recupera&ccedil;&atilde;o de Senha</span></span></strong></p>
                                            <p style="text-align:left"><span style="font-size:15pt; font-weight:bold;"><span style="font-family:&quot;Arial&quot;,sans-serif">Prezado(a) <strong>' . $user . ',</strong></span></span></p>
                                            <p style="text-align:left; text-ident: 5px;"><span style="font-size:10.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif">Identificamos a solicita&ccedil;&atilde;o de recupera&ccedil;&atilde;o de senha no nosso sistema dia ' . date('d/m/Y H:i') . '.<br />
                                            Solicitamos que verifique os dados abaixo e caso tenha alguma altera&ccedil;&atilde;o acesse (<a href="https://ltec.000webhostapp.com/demo/lcte" target="_blank"><span style="color:blue">https://ltec.000webhostapp.com/demo/lcte</span></a>). </span></span></p>
                                            <p style="text-align:left; text-ident: 5px;"><span style="font-size:10.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif">Para  confirmar a solicitação de recuperação de senha, clique no link abaixo e siga o passo a passo para realizar a recuperação.</span></span></p>
                                            <a href="https://ltec.000webhostapp.com/demo/lcte/recupera-senha?_token=' . $_token . '">https://ltec.000webhostapp.com/demo/lcte/recupera-senha?_token=' . $_token . '</a>
                                            <p style="text-align:left; text-ident: 5px;"><span style="font-size:10.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif">Caso não tenha feito essa solicitação, desconsidere esse email, o link expirará em 2 horas.</span></span></p>
                                            <p style="text-align:center"><span style="font-size:10.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif">Atenciosamente,</span></span></p>
                                            <p style="text-align:center"><img src="https://ltec.000webhostapp.com/demo/lcte/img/logo-ltec.png" width="100px"></p>
                                            </td>
                                    </tr>
                                    <tr style="background-image: linear-gradient(to top, #15a5d4 0%, #007eb0 100%); color: #fff;">
                                            <td style="width:424.7pt">
                                            <p style="text-align:center"><br />
                                            <span style="font-size:10.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif">&copy;2018 LCT-e - Sistema de Processos Licitatórios<br />
                                            &nbsp;</p>
                                            </td>
                                    </tr>
                            </tbody>
                    </table>
            </body>
            </html>
          ';
        $enviaremail = mail($destino, $assunto, $msg, $headers);

        if ($enviaremail) {
            return true;
        } else {
            return false;
        }
    }

    public static function ForceHTTPS() {
        if (!isset($_SERVER['HTTPS'])) {
            $url = $_SERVER['SERVER_NAME'];
            $new_url = "https://" . $url . $_SERVER['REQUEST_URI'];
            header("Location: $new_url");
            exit;
        }
    }

    public static function deslogar() {
        if (isset($_SESSION['logado'])):
            unset($_SESSION['logado']);
            session_destroy();
            echo '<script>window.location.href="../cpanel-login";</script>';
        endif;
    }

    public static function validaSession() {
        if (!isset($_SESSION['logado'])):
            $_SESSION['erro'] = '<div class="alert alert-danger"><h5 align="center"><i class="fa fa-warning"></i> Area restrita para usuários cadastrados.</div>';
            echo '<script>window.location.href="../cpanel-login";</script>';
        else:
            $pdo = parent::getConn();
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $sql->bindValue(1, $_SESSION['email']);
            $sql->execute();
            if ($sql->rowCount() == 1):
                $dados = $sql->fetch(PDO::FETCH_ASSOC);
                if (!password_verify($_SESSION['senha'], $dados['senha'])) :
                    unset($_SESSION['email']);
                    unset($_SESSION['senha']);
                    unset($_SESSION['logado']);
                    unset($_SESSION['user']);
                    unset($_SESSION['idTipo']);
                    unset($_SESSION['idUser']);
                    $_SESSION['msg'] = '<div class="alert alert-danger"><i class="fa fa-warning"><h5 align="center"></i> Area restrita para usuários cadastrados</h5></div>';
                    echo '<script>window.location.href="../cpanel-login";</script>';
                endif;
            else:
                unset($_SESSION['email']);
                unset($_SESSION['senha']);
                unset($_SESSION['logado']);
                unset($_SESSION['user']);
                unset($_SESSION['idTipo']);
                unset($_SESSION['idUser']);
                $_SESSION['msg'] = '<div class="alert alert-danger"><i class="fa fa-warning"></i> Area restrita para usuários cadastrados</h5></div>';
                echo '<script>window.location.href="../cpanel-login";</script>';
            endif;
        endif;
    }

    public static function expiraSession() {
        if (isset($_SESSION["sessiontime"])) {
            if ($_SESSION["sessiontime"] < time()) {
                session_unset();
                unset($_SESSION['email']);
                unset($_SESSION['senha']);
                unset($_SESSION['logado']);
                unset($_SESSION['user']);
                unset($_SESSION['idTipo']);
                unset($_SESSION['idUser']);
                $_SESSION['msg'] = '<div class="alert alert-danger"><h5 align="center"><i class="fa fa-warning"></i> Sessão encerrada</h5></div>';
                echo '<script>window.location.href="../cpanel-login";</script>';
            } else {
                $_SESSION["sessiontime"] = time() + 60 * 10;
            }
        } else {
            session_unset();
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            unset($_SESSION['logado']);
            unset($_SESSION['user']);
            unset($_SESSION['idTipo']);
            unset($_SESSION['idUser']);
            $_SESSION['msg'] = '<div class="alert alert-danger"><h5 align="center"><i class="fa fa-warning"></i> Sessão encerrada</h5></div>';
            echo '<script>window.location.href="../cpanel-login";</script>';
        }
    }

    public function verificaRecaptcha($key) {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $respon = $key;

        $data = array('secret' => "6Lelv2oUAAAAAPko-GnVwLV9YdWke5QK9e01Kbkt", 'response' => $respon);

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsom = json_decode($result);

        if ($jsom->success) {
            return true;
        } else {
            return false;
        }
    }

    public static function getTipoUsario($idTipo) {
        $tipoUser = null;
        $read = new Read();
        $read->ExeRead("tipo_user", "WHERE id = $idTipo");
        foreach ($read->getResult() as $dados) {
            extract($dados);
            $tipoUser = $tipo;
        }
        return $tipoUser;
    }

    public static function getStatusCompra($id) {
        $statusCompra = null;
        $read = new Read();
        $read->ExeRead("status_compra", "WHERE id = $id");
        foreach ($read->getResult() as $dados) {
            extract($dados);
            $statusCompra = $status;
        }
        return $statusCompra;
    }

    public static function limpaDados(array $dados) {
        foreach ($dados as $indice => $value) {
            $dados[$indice] = addslashes($dados[$indice]);
        }
        return $dados;
    }

    public static function verificaToken($token){
        $read = new Read();
        $read->ExeRead('usuarios',"WHERE _token = '$token'");
        if($read->getResult()){
            return true;
        }else{
            return false;
        }
    }
    
    public static function updateSenha($token, $novaSenha){
        $pdo = parent::getConn();
        $update = $pdo->prepare("UPDATE usuarios SET _token = :token, senha = :novaSenha WHERE _token = :_token");
        $update->execute(array(
            ':novaSenha' => password_hash($novaSenha, PASSWORD_DEFAULT),
            ':_token' => $token,
            ':token' => NULL
        ));
        return true;
    }

    public static function getStatus($status){
        $class = '';
        switch($status){
            case 1:$class='info';break;
            case 2:$class='success';break;
            case 3:$class='danger';break;
            case 4:$class='warning';break;
        }
        return $class;
    }

    public static function getStatusDividas($status){
        $read = new Read();
        $read->ExeRead('contas', 'where id_status = '.$status);
        return $read->getRowCount();  
    }

    public static function getSTotaldados($table){
        $read = new Read();
        $read->ExeRead($table);
        return $read->getRowCount();  
    }
    
    function getMsg() {
        return $this->Msg;
    }

}
