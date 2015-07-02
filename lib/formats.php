<?php

class FORMATS{



	//Valores del dominio de FORMATS
	//const domaine = array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
	//domain debería declararse como una constante pero PHP no admite constantes que sean arreglos
	

	
	//RECIBE:	Nada
	//RETORNA:	Array de FORMATS
	//NOTA:		Retorna todos los valores del dominio de FORMATS
	public static function getDomain(){
		//domain debería declararse como una constante pero PHP no admite constantes que sean arreglos
		//este método debería retornar: self::domain
		return array ("APPLICATION", "AUDIO", "EXAMPLE", "IMAGE", "MESSAGE", "MODEL", "MULTIPART", "TEXT", "VIDEO");
	}

	//RECIBE:	Tag
	//RETORNA:	Boolean
	//NOTA:		Retorna true si $value pertenece al dominio de FORMATS y false en caso contrario
	public static function is($value){
		if (in_array($value, getDomaine(), true)) {
		    return true;
		}
		return false;
	}



}

?>


