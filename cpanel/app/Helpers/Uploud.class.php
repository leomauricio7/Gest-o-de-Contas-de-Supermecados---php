<?php

class Uploud {

    private $Arquivo;
    private $Nome;
    private $Result;
    private $Msg;
    private static $Diretorio;
    private $Imagem;
    private $Folder;
    
    //Verifica se o diretorio existe
    function __construct($Diretorio = null) {
        self::$Diretorio = ( (string) $Diretorio ? $Diretorio : 'arquivos/');
        if (!file_exists(self::$Diretorio) && !is_dir(self::$Diretorio)):
            mkdir(self::$Diretorio, 0777);
        endif;
    }

    public function Imagem_in(array $Imagem) {
        $this->Arquivo = $Imagem;
        $this->Nome = $Imagem['name'];
        $this->UploudImagem();
    }

    //Uploud de NOva Imagems com caminho relativo
    public function Imagem(array $Imagem, $Folder) {
        $this->Arquivo = $Imagem;
        $this->Folder = ( (string) $Folder ? $Folder : $Folder . '/');
        if (!file_exists($this->Folder) && !is_dir($this->Folder)):
            mkdir(self::$Diretorio . $this->Folder,  0777);
            self::$Diretorio = self::$Diretorio . $this->Folder;
        endif;
        $this->Nome = $Imagem['name'];
        $this->UploudImagem();
    }

    //Uploud de NOva Imagems com caminho relativo
    public function ImagemEdit(array $Imagem, $Folder) {
        $this->Arquivo = $Imagem;
        $this->Folder = ( (string) $Folder ? $Folder : $Folder . '/');
        self::$Diretorio = self::$Diretorio . $this->Folder;
        $this->Nome = $Imagem['name'];
        $this->UploudImagem();
    }

    //Valida as extensões da imagem
    public function UploudImagem() {
        switch ($this->Arquivo['type']):
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->Imagem = imagecreatefromjpeg($this->Arquivo['tmp_name']);
                break;
            case 'image/png':
            case 'image/x-png':
                $this->Imagem = imagecreatefrompng($this->Arquivo['tmp_name']);
                break;
        endswitch;

        if ($this->Imagem):
            $this->MoveArquivo();
            imagedestroy($this->Imagem);
        else:
            $this->Result = false;
            $this->Msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro: </strong>Tipo de imagem não suportada. Envie imagem no formato PNG & JPG.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='cursor: pointer;'>&times;</span>
                    </button>
                </div>";
        endif;
    }

    //Uploud de qualquer tipo de arquivo
    public function Arquivo(array $Arquivo) {
        $this->Arquivo = $Arquivo;
        $this->Nome = $Arquivo['name'];
        $this->MoveArquivo();
    }

    //Move o arquivo para o diretorio
    public function MoveArquivo() {

        if (move_uploaded_file($this->Arquivo['tmp_name'], self::$Diretorio . $this->Nome)):
            $this->Result = $this->Nome;
            $this->Msg = "<div class='alert alert-success'><b>Sucesso: </b>Uploud realizado com sucesso!</div>";
        else:
            $this->Result = false;
            $this->Msg = "<div class='alert alert-danger'><b>Erro: </b>Uploud não foi realizado!</div>";
        endif;
    }

    function getResult() {
        return $this->Result;
    }

    function getMsg() {
        return $this->Msg;
    }

    //Uploud de arquivos PDF e DOCX
    public function File($File, $Folder=null, $MaxFileSize = null) {
        //verifica se a pasta existe
        $this->Folder = ( (string) $Folder ? $Folder : $Folder . '/');
        if (!file_exists($this->Folder) && !is_dir($this->Folder)):
            mkdir(self::$Diretorio . $this->Folder,  0777, true);
            self::$Diretorio = self::$Diretorio . $this->Folder;
        endif;
        
        $this->Arquivo = $File;
        $this->Nome = $File['name'];
        //Tamanho limite do arquivo 
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 2);
        //Tipo de arquivo aceitado pelo sistema WORD e PDF
        $FileAccept = [ 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'];

        //Verifica o tamanho da imagem
        if ($this->Arquivo['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Msg = "<div class='alert alert-danger'><b>Erro: </b>Arquivo muito grande, tamanho maximo permitido {$MaxFileSize}MB</div>";
        //Tipos de arquivos aceitos
        elseif (!in_array($this->Arquivo['type'], $FileAccept)):
            $this->Result = false;
            $this->Msg = "<div class='alert alert-danger'><b>Erro: </b>Tipo de arquivo não suportado. Envie .PDF ou .DOCX</div>";
        else:
            $this->MoveArquivo();
        endif;
    }
    
    public function editFile($File, $Folder=null, $MaxFileSize = null) {
        //verifica se a pasta existe
        $this->Folder = ( (string) $Folder ? $Folder : $Folder . '/');
        self::$Diretorio = self::$Diretorio . $this->Folder;
        
        $this->Arquivo = $File;
        $this->Nome = $File['name'];
        //Tamanho limite do arquivo 
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 2);
        //Tipo de arquivo aceitado pelo sistema WORD e PDF
        $FileAccept = [ 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf'];

        //Verifica o tamanho da imagem
        if ($this->Arquivo['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Msg = "<div class='alert alert-danger'><b>Erro: </b>Arquivo muito grande, tamanho maximo permitido {$MaxFileSize}MB</div>";
        //Tipos de arquivos aceitos
        elseif (!in_array($this->Arquivo['type'], $FileAccept)):
            $this->Result = false;
            $this->Msg = "<div class='alert alert-danger'><b>Erro: </b>Tipo de arquivo não suportado. Envie .PDF ou .DOCX</div>";
        else:
            $this->MoveArquivo();
        endif;
    }

}
