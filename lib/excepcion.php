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



class EXCEPCION{



	//Valores del dominio de EXCEPCION
	//const _DOMAIN_ = array ("");
	//_DOMAIN_ deber�a declararse como una constante pero PHP no admite constantes que sean arreglos

	//Valor que representa el tipo de licencia, es un Tag integrate del ELCC
	var $excepcion;


	
	//Constructor de la clase
	function __construct($excepcion) {
		$this->excepcion = $excepcion;
	}

	public function getExcepcion(){
		return $this->excepcion;
	}

	//RECIBE:	Nada
	//RETORNA:	Array de String
	//NOTA:		Retorna todos los valores del dominio de EXCEPCION
	public function getDomain(){
		//_DOMAIN_ deber�a declararse como una constante pero PHP no admite constantes que sean arreglos
		//este m�todo deber�a retornar: self::_DOMAIN_
		return array ("�tem de una colecci�n","Obra propia","Autorizaci�n manifiesta","Derecho a cita","Licencia est�ndar de Youtube","Otro");
	}

	//RECIBE:	String
	//RETORNA:	String
	//NOTA:		Retorna la URL de la excepcion pasada como String
	public function getUrl($excepcion){
		if ($excepcion=="�tem de una colecci�n") return "itemCollection.html";
		if ($excepcion=="Obra propia") return "ownerWork.html";
		if ($excepcion=="Autorizaci�n manifiesta") return "authorizationStates.html";
		if ($excepcion=="Derecho a cita") return "rightQuote.html";
		if ($excepcion=="Licencia est�ndar de Youtube") return "standarYoutube.html";
		if ($excepcion=="Otro") return "other.html";
		return NULL;
	}



	//RECIBE:	String
	//RETORNA:	Boolean
	//NOTA:		Retorna TRUE si $value pertenece al dominio de EXEPCION y FALSE en caso contrario
	public function is($value){
		if (in_array($value, self::getDomain(), TRUE)) {
		    return TRUE;   
		}
		return FALSE;
	}

}

?>

