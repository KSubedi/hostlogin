<?php
class Core{
	public static function sterm($string){
		if(strlen($string)>25){
			$string = substr($string, 0, 25);
			$string .= '...';
		}
		return $string;
	}

	public static function getSalt(){
		return '467d2c88cc7ca3b9c7c4515abf925d5f5ae05ea18bb2a6ea7630e59ed7487e3a492a09a905b098370a9a32811d0ed7c97b21dae3cad965dcf3';
	}

	public static function getLegacy(){
		if($_SERVER['HTTP_HOST'] == 'hostlog.in'){
			return 11;
		}else{
			return 1;
		}
	}

	public static function showScript($script){
		return '<script src="'. URL::route('assets', $script). '"></script>';
	}
}