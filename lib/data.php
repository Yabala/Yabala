<?php

include_once("licencia.php");


class DATA{



	//Valores que representa los datos que contiene cada OC
	var $format;
	var $keywords;
	var $author;
	var $url;
	var $license;



	//Constructor de la clase
	function __construct($format, $keywords, $author, $url, $cc) {
		$this->type = $format;
		$this->keywords = $keywords;
		$this->author = $author;
		$this->url = $url;
		$this->license = new LICENCIA ($cc);
	}

	//RECIBE:	Nada
	//RETORNA:	String
	//NOTA:		Retorna el valor del $format del objeto
	public function getFormat(){
			return $this->format;
	}

	//RECIBE:	Nada
	//RETORNA:	String
	//NOTA:		Retorna el valor del $keywords del objeto
	public function getKeywords(){
			return $this->keywords;
	}

	//RECIBE:	Nada
	//RETORNA:	String
	//NOTA:		Retorna el valor del $author del objeto
	public function getAuthor(){
			return $this->author;
	}

	//RECIBE:	Nada
	//RETORNA:	String
	//NOTA:		Retorna el valor del $url del objeto
	public function getUrl(){
			return $this->url;
	}

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el valor del $license del objeto
	public function getLicense(){
			return $this->license->getCC();
	}

	//RECIBE:	Nada
	//RETORNA:	Array de Tag
	//NOTA:		Implementa la tabla de compatibilidad para remix de obras, dado el valor del ELCC $value 
	//		retorna todos los valores del ELCC compatibles con $value para combinar en un remix de obras
	public function r(){
		return $this->license->r();
	}



}

?>