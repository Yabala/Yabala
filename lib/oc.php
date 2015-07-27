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



include_once("data.php");

class OC {



	//Datos de cada OC
	var $data;



	//Constructor de la clase
	function __construct($format, $keywords, $author, $url, $cc) {
		$this->data = new DATA($format, $keywords, $author, $url, $cc);
	}

	//RECIBE:	Nada
	//RETORNA:	Data
	//NOTA:		Retorna el valor del $data del objeto
	public function getData(){
			return $this->data;
	}



	//RECIBE:	Nada
	//RETORNA:	Array de Tag
	//NOTA:		Implementa la tabla de compatibilidad para remix de obras, dado el valor del ELCC $value 
	//		retorna todos los valores del ELCC compatibles con $value para combinar en un remix de obras
	public function r(){
		return $this->data->r();
	}

	//RECIBE:	Nada
	//RETORNA:	Array de String
	//NOTA:		Retorna los componentes de un OC para ser manipulados desde el invocante
	public function printOC(){
		return array ($this->data->getFormat(), $this->data->getKeywords(), $this->data->getAuthor(), $this->data->getUrl(), (string) $this->data->getLicense()); 
	}


}

?>


