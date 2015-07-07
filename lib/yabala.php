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


include_once("op.php");
include_once("db5.php");
include_once("formats.php");
include_once("elcc.php");


class yabala implements iyabala{

	//const yabalaUrl = "http://localhost/yabala/yabala/www/";
	//const creditsPath = "../yabala/www/";
	//const dbPath = "../yabala/db/db.csv";
	//const repositoryListUrl = "http://localhost/yabala/yabala/db/list.csv";
	//const dbPath = "http://164.73.2.138/db.csv";

	//Colección de objetos contenedores
	var $op;

	function __construct() {
	       $this->op = new OP();
   	}

	public function getOP(){
		//Retorna el resultado
		return $this->op;
	}

	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Devuelve un array con los nombres y url de los respostiros registrado en la base apuntada por $repositoryListUrl
	public function getRepositoryList(){
		//Retorna el resultado
		return DB5::getRepositoryList(self::repositoryListUrl);
	}

	//RECIBE:	Nada
	//RETORNA:	Array of String
	//NOTA:		Devuelve un array con los valores del dominio de FORMAT
	public function getFormats(){
		//Retorna el resultado
		return FORMATS::getDomain();
	}

	//RECIBE:	Nada
	//RETORNA:	Array of String
	//NOTA:		Devuelve un array con los valores del dominio del ELCC
	public function getLicenses(){
		//Retorna el resultado
		return ELCC::getDomain();
	}
	
	//RECIBE:	un op y los datos para un oc
	//RETORNA:	Nada
	//NOTA:		sin comentarios
	public function add($format, $keywords, $author, $url, $cc){
		$this->op->add($format, $keywords, $author, $url, $cc);
	}


	//Quita un oc(id) del OP(collection)
	public function del($id){
		$this->op->del($id);
	}


	//retorna la licencia combinada del OP
	public function calculator(){
		return $this->op->calculator();
	}


	//retorna la máxima licencia combinada del OP
	public function calculatorMax(){
		return $this->op->calculatorMax();
	}


	//retorna la mínima licencia combinada del OP
	public function calculatorMin(){
		return $this->op->calculatorMin();
	}

	//retorna la mínima licencia de la adaptacion cc
	public function adaptation($cc){
		return ELCC::a($cc);
	}

	public function credits($name, $cc, $options){
		return $this->op->credits($name, self::creditsPath, self::yabalaUrl, self::yabalaImg, $cc, 1, 1, 1);
	}

	public function resetCredits($name, $options){
		//definir nombres de archvios de créditos
		$nameHtml = $name.".html";
		$nameQrfull = $name."_full.png";
		$nameQrmin = $name."_min.png";
		
		//si el archivo ya existe lo borra
		if (file_exists(self::creditsPath.$nameHtml)){
			unlink(self::creditsPath.$nameHtml);
		}

		//si el archivo ya existe lo borra	
		if (file_exists(self::creditsPath.$nameQrfull)){
			unlink(self::creditsPath.$nameQrfull);
		}

		//si el archivo ya existe lo borra
		if (file_exists(self::creditsPath.$nameQrmin)){
			unlink(self::creditsPath.$nameQrmin);
		}
	}

	//Agrega a la base de datos del sistema los datos un registro
	public function insert($format, $keywords, $author, $url, $cc){
		//$db5 = new db5();
		DB5::insert(self::dbPath, $format, $keywords, $author, $url, $cc);
	}



	//RECIBE:	String, String, Integer, Integer
	//RETORNA:	Collection
	//NOTA:		Busca en la base de datos ubicada en la url $repositoryUrl, el string contenido en $key y retorna la colección de registros resultado
	//		Si $i<0 busca si aparece $key en forma exacta o como sub-string en cualquier campo
	//		Si $i>=0 y $mode=0 busca si aparece $key en forma exacta o como sub-string dentro del campo $i
	//		Si $i>=0 y $mode=1 busca si aparece $key en forma exacta  dentro del campo $i
	//		$repositoryUrl es una url donde está la base en la que se buscará, por ejemplo: "http://misitio.com/db.csv
	public function select($repositoryUrl, $key, $i, $mode){
		return (DB5::select($repositoryUrl, $key, $i, $mode));
	}


	//Imprime el contenido de todos los oc de la OP
	//SOLO PARA DEBUG
	//function printdb($db){
	//	DB5::printdbDB($db);
	//}


	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Retorna un array con los elementos de cada OC como un array de strings 
	public function getWorks(){
			return $this->op->printOP();
	}

	}

?>
