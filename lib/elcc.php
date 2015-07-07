<?php



// This file is part of Yabala https://github.com/Yabala/yabala
//
// Yabala is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Yabala is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Yabala.  If not, see <http://www.gnu.org/licenses/>.



class ELCC{



	//Valor que representa el mínimo valor del ELCC 
	const _MIN_ = "MIN"; 
	
	//Valor que representa el mínimo valor del ELCC
	const _MAX_ = "MAX"; 
	
	//Valores del dominio del ELCC
	//const domaine = array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
	//domain debería declararse como una constante pero PHP no admite constantes que sean arreglos
	

	
	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna un valor que representa al mínimo valor del ELCC
	public static function getMin(){
		return self::_MIN_;
	}

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna un valor que representa al máximo valor del ELCC
	public static function getMax(){
		return self::_MAX_;
	}

	//RECIBE:	Nada
	//RETORNA:	Array de Tag
	//NOTA:		Retorna todos los valores del dominio del ELCC
	public static function getDomain(){
		////domain debería declararse como una constante pero PHP no admite constantes que sean arreglos
		//este método debería retornar: self::domain
		return array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
	}

	//RECIBE:	Tag
	//RETORNA:	Array de Tag
	//NOTA:		Implementa la tabla de compatibilidad para remix de obras, dado el valor del ELCC $value 
	//		retorna todos los valores del ELCC compatibles con $value para combinar en un remix de obras
	public static function r($value){
		if ($value=="PD") return array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
		if ($value=="CC0") return array ("CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
		if ($value=="BY") return array ("BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND");
		if ($value=="BY-SA") return array ("BY-SA");
		if ($value=="BY-NC") return array ("BY-NC", "BY-NC-SA","BY-NC-ND");
		if ($value=="BY-ND") return array ();
		if ($value=="BY-NC-SA") return array ("BY-NC-SA");
		if ($value=="BY-NC-ND") return array ();
		if ($value=="CR") return array ();
		return -1;
	}

	//RECIBE:	Tag
	//RETORNA:	Array de Tag
	//NOTA:		Implementa la tabla de obras adaptadas, dado el valor del ELCC $value 
	//		retorna todos los valores del ELCC que pueden ser posibles licencias de una obra adaptada con licencia $value
	public static function a($value){
		if ($value=="PD") return array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
		if ($value=="CC0") return array ("CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
		if ($value=="BY") return array ("BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND");
		if ($value=="BY-SA") return array ("BY-SA");
		if ($value=="BY-NC") return array ("BY-NC", "BY-NC-SA","BY-NC-ND");
		if ($value=="BY-ND") return array ();
		if ($value=="BY-NC-SA") return array ("BY-NC-SA");
		if ($value=="BY-NC-ND") return array ();
		if ($value=="CR") return array ();
		return -1;
	}

	//RECIBE:	Tag
	//RETORNA:	Integer
	//NOTA:		Retorna el ordinal de $value en el ELCC
	//		En esta función es que se define la relación de orden entre los elementos del ELCC
	public static function order($value){
		if($value=="MIN") return ~PHP_INT_MAX;
		elseif ($value=="PD") return 0;
		elseif ($value=="CC0") return 1;
		elseif ($value=="BY") return 2;
		elseif ($value=="BY-NC") return 3;
		elseif ($value=="BY-SA") return 4;
		elseif ($value=="BY-NC-SA") return 5;
		elseif ($value=="BY-ND") return 6;
		elseif ($value=="BY-NC-ND") return 7;
		elseif ($value=="CR") return 8;
		elseif ($value=="MAX") return PHP_INT_MAX;
		return -1;
	}

	//RECIBE:	Tag
	//RETORNA:	Boolean
	//NOTA:		Retorna true si $value pertenece al dominio del ELCC y false en caso contrario
	public static function is($value){
		//este método se debería implementar buscando en la constante de clase $domain pero
		//no puede ser declaradas constantes en PHP que sean arrays
		if ($value=="PD") return true;
		if ($value=="CC0") return  true;
		if ($value=="BY") return  true;
		if ($value=="BY-NC") return  true;
		if ($value=="BY-SA") return  true;
		if ($value=="BY-NC-SA") return  true;
		if ($value=="BY-ND") return  true;
		if ($value=="BY-NC-ND") return  true;
		if ($value=="CR") return  true;
		return false;
	}



}

?>

