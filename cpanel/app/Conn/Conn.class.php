<?php

abstract class Conn {

    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Bd = BD;
    private static $Connect = null;

    private static function Conectar() {
        try {
            if (self::$Connect == null):
                self::$Connect = new PDO('mysql:host=' . self::$Host . ';dbname=' . self::$Bd, self::$User, self::$Pass);
            endif;
        } catch (PDOException $e) {
            echo 'Message: ' . $e->getMessage();
            die;
        }
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }

    protected static function getConn() {
        return self::Conectar();
    }

}
