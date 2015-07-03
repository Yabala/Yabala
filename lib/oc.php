<?php


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
	//NOTA:		
	public function printOC(){
		return array ($this->data->getFormat(), $this->data->getKeywords(), $this->data->getAuthor(), $this->data->getUrl(), (string) $this->data->getLicense()); 
	}


}

?>


