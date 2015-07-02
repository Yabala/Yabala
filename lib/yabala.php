<?php


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
	//RETORNA:	un op con un oc agregado
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

	public function credits($name, $cc){
		return $this->op->credits($name, self::creditsPath, self::yabalaUrl, $cc, 1, 1, 1);
	}

	//Agrega a la base de datos del sistema los datos un registro
	public function insert($format, $keywords, $author, $url, $cc){
		//$db5 = new db5();
		DB5::insert(self::dbPath, $format, $keywords, $author, $url, $cc);
	}



	//realiza una consulta en la base de datos y la recibe en una colección de datos
	public function select($repositoryUrl, $key, $i, $mode){
		//$db5 = new db5();
		return (DB5::select($repositoryUrl, $key, $i, $mode));
	}


	//Imprime el contenido de todos los oc de la OP
	//SOLO PARA DEBUG
	function printdb($db){
		DB5::printdbDB($db);
	}


	public function printYABALA(){
		return $this->op->printOP();
	}




	}

?>
