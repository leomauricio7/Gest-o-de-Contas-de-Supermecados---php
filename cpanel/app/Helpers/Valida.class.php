<?php
class Valida{
	
	private static $Data;
	private static $Format;
	
	public static function Email($Email){
		self::$Data = (string) $Email;
		self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';
		
		if(preg_match(self::$Format, self::$Data)):
			return true;
		else:
			return false;
		endif;
	}
        
        public static function Number($Campo){
		self::$Data = (string) $Campo;
		
		if(is_numeric(self::$Data)):
			return true;
		else:
			return false;
		endif;
	}
	
	public static function Nome($Nome){
		self::$Data = (string) $Nome;
		
		if(self::$Data):
			return true;
		else:
			return false;
		endif;
	}
	
}
