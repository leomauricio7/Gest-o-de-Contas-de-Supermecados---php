<?php

class Delete extends Conn{
   
    private $Delete;
    private $Places;
    private $Result;
    private $Del;
    
    private $Conn;
    
    public function ExeDelete($Tabela, $Termos = null, $ParseString = null) {
        
        if(!empty($ParseString)) {
            parse_str($ParseString, $this->Places);
        }
        $this->Delete = "DELETE FROM {$Tabela} {$Termos}";
        $this->Execute();
    }

    public function getResult() {
        return $this->Result;        
    }
    
    public function getRowCount(){
        return $this->Del->rowCount();
    }
    
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Del = $this->Conn->prepare($this->Delete);
        $this->Del->setFetchMode(PDO::FETCH_ASSOC);
    }
    
    private function getSyntax() {
       if($this->Places):
            foreach ($this->Places as $Vinculo => $Valor):
                if($Vinculo == 'limit' || $Vinculo == 'offset'):
                    $Valor = (int) $Valor;
                endif;
                $this->Del->bindValue(":{$Vinculo}", $Valor, (is_int($Valor)? PDO::PARAM_INT : PDO::PARAM_INT));
            endforeach;
        endif;
    }
    
    private function Execute() {
       $this->Connect();
        try {
            $this->Del->execute();
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            echo 'Message: ' .$e->getMessage();            
        }
    }

}
