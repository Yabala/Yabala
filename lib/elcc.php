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
	//const _DOMAIN_ = array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
	//_DOMAIN_ debería declararse como una constante pero PHP no admite constantes que sean arreglos

	//Valores del dominio del ELCC que exigen tener autor definido
	//const _AUTHOR_ = array ("BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
	//_AUTHOR_ debería declararse como una constante pero PHP no admite constantes que sean arreglos

	//Valores del dominio del ELCC que no permiten ser adaptados o modificados
	//const _MODIFY_ = array ("BY-ND","BY-NC-ND","CR");
	//_MODIFY_ debería declararse como una constante pero PHP no admite constantes que sean arreglos

	//Valores del dominio del ELCC que no permiten ser agregados a un conjunto si no es de forma exepcional
	//const _EXCEPTION_ = array ("BY-ND","BY-NC-ND","CR");
	//_EXCEPTION_ debería declararse como una constante pero PHP no admite constantes que sean arreglos
	
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
		//_DOMAIN_ debería declararse como una constante pero PHP no admite constantes que sean arreglos
		//este método debería retornar: self::_DOMAIN_
		return array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
	}

	//RECIBE:	Tag
	//RETORNA:	Array de Tag
	//NOTA:		Implementa la tabla de compatibilidad para remix de obras, dado el valor del ELCC $value 
	//		retorna todos los valores del ELCC compatibles con $value para combinar en un remix de obras
	public static function r($value){
		if ($value=="PD") return array ("PD","CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
		if ($value=="CC0") return array ("CC0","BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
		if ($value=="BY") return array ("BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
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
		if ($value=="BY") return array ("BY","BY-SA","BY-NC","BY-ND","BY-NC-SA","BY-NC-ND","CR");
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
	//RETORNA:	Bool
	//NOTA:		Retorna TRUE si $value pertenece al dominio del ELCC y FALSE en caso contrario
	public static function is($value){
		//este método se debería implementar buscando en la constante de clase _DOMAIN_ pero
		//no puede ser declaradas constantes en PHP que sean arrays
		if ($value=="PD") return TRUE;
		if ($value=="CC0") return TRUE;
		if ($value=="BY") return TRUE;
		if ($value=="BY-NC") return TRUE;
		if ($value=="BY-SA") return TRUE;
		if ($value=="BY-NC-SA") return TRUE;
		if ($value=="BY-ND") return TRUE;
		if ($value=="BY-NC-ND") return TRUE;
		if ($value=="CR") return TRUE;
		return FALSE;
	}

	//RECIBE:	Tag
	//RETORNA:	String
	//NOTA:		Retorna si $value pertenece al dominio del ELCC la info de dicho elemento (por ejemplo la definición de la licencia) sino retorna null
	//REFERENCIAS: La mayoría de los textos devueltos son tomados de "https://creativecommons.org/licenses/", los que están bajo una licencia BY que es compatible con la licencia en que es liberado este código (GPL 3)
	public static function info($value){
		//este método se debería implementar buscando en la constante de clase _DOMAIN_ pero
		//no puede ser declaradas constantes en PHP que sean arrays
		if ($value=="PD") return "Cualquier explotación de la obra es permitida.";
		if ($value=="CC0") return "Esta licencia permite a otros distribuir, mezclar, ajustar y construir a partir de su obra, incluso con fines comerciales y sin necesidad que le sea reconocida la autoría de la creación original.";
		if ($value=="BY") return "Esta licencia permite a otros distribuir, mezclar, ajustar y construir a partir de su obra, incluso con fines comerciales, siempre que le sea reconocida la autoría de la creación original.";
		if ($value=="BY-NC") return "Esta licencia permite a otros entremezclar, ajustar y construir a partir de su obra con fines no comerciales, y aunque en sus nuevas creaciones deban reconocerle su autoría y no puedan ser utilizadas de manera comercial, no tienen que estar bajo una licencia con los mismos términos.";
		if ($value=="BY-SA") return "Esta licencia permite a otros re-mezclar, modificar y desarrollar sobre tu obra incluso para propósitos comerciales, siempre que te atribuyan el crédito y licencien sus nuevas obras bajo idénticos términos.";
		if ($value=="BY-NC-SA") return "Esta licencia permite a otros entremezclar, ajustar y construir a partir de su obra con fines no comerciales, siempre y cuando le reconozcan la autoría y sus nuevas creaciones estén bajo una licencia con los mismos términos.";
		if ($value=="BY-ND") return "Esta licencia permite la redistribución, comercial y no comercial, siempre y cuando la obra no se modifique y se transmita en su totalidad, reconociendo su autoría.";
		if ($value=="BY-NC-ND") return "Esta licencia sólo permite que otros puedan descargar las obras y compartirlas con otros, siempre que se reconozca su autoría, pero no se pueden cambiar de ninguna manera ni se pueden utilizar comercialmente.";
		if ($value=="CR") return "Ninguna explotación de la obra es permitida.";
		return  null;
	}

	//RECIBE:	Tag
	//RETORNA:	Bool
	//NOTA:		Retorna TRUE si $value obliga a tener un autor definido
	public static function author($value){
		//este método se debería implementar buscando en la constante de clase _AUTHOR_ pero
		//no puede ser declaradas constantes en PHP que sean arrays
		if ($value=="BY") return TRUE;
		if ($value=="BY-NC") return TRUE;
		if ($value=="BY-SA") return TRUE;
		if ($value=="BY-NC-SA") return TRUE;
		if ($value=="BY-ND") return TRUE;
		if ($value=="BY-NC-ND") return TRUE;
		if ($value=="CR") return TRUE;
		return FALSE;
	}

	//RECIBE:	Tag
	//RETORNA:	Bool
	//NOTA:		Retorna TRUE si $value no permite modificaciones o adpataciones
	public static function modify($value){
		//este método se debería implementar buscando en la constante de clase _MODIFY_ pero
		//no puede ser declaradas constantes en PHP que sean arrays
		if ($value=="BY-ND") return TRUE;
		if ($value=="BY-NC-ND") return TRUE;
		if ($value=="CR") return TRUE;
		return FALSE;
	}

	//RECIBE:	Tag
	//RETORNA:	Bool
	//NOTA:		Retorna TRUE si $value exige una excepción
	public static function exception($value){
		//este método se debería implementar buscando en la constante de clase _EXCEPTION_ pero
		//no puede ser declaradas constantes en PHP que sean arrays
		if ($value=="BY-ND") return TRUE;
		if ($value=="BY-NC-ND") return TRUE;
		if ($value=="CR") return TRUE;
		return FALSE;
	}

}

?>

