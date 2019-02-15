<?php

class View {
   
    private static  $Data;
    private static $Keys;
    private static $Values;
    private static $Template;
    
    //Carrega template da view
    public static function Load($Template){
        self::$Template = (string) $Template;
        self::$Template = file_get_contents(self::$Template. '.tpl.html');
    }
    
    //Exibe o template da view
    public static function Show(array $Data){
        self::setKeys($Data);
        self::setValues();
        self::showView();
    }
    
    //Executa o tratamento dos campos para a substituição das chaves na View
    public static function setKeys($Data){
        self::$Data = $Data;
        self::$Keys = explode('&', '#' . implode("#&#", array_keys(self::$Data)) . '#');        
    }
    
    //Obtem os valores a serem inseridos nas chaves
    public static function setValues(){
        self::$Values = array_values(self::$Data);
    }
    
    //Substitui as chaves pelos os valores do template
    public static function showView(){
        echo str_replace(self::$Keys, self::$Values, self::$Template);
    }
}
