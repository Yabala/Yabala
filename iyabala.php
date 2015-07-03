<?php


include_once("lib/yabala.php");


interface iyabala{

	const yabalaUrl = "http://localhost/yabala/yabala/www/";
	const creditsPath = "../yabala/www/";
	const dbPath = "../yabala/db/db.csv";
	const repositoryListUrl = "http://localhost/yabala/yabala/db/list.csv";
	//const dbPath = "http://164.73.2.138/db.csv";

	//Colección de objetos contenedores
	//var $op;

	//function __construct() {
	//       $this->op = new OP();
   	//}

	public function getOP();

	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Devuelve un array con los nombres y url de los respostiros registrado en la base apuntada por $repositoryListUrl
	public function getRepositoryList();

	//RECIBE:	Nada
	//RETORNA:	Array of String
	//NOTA:		Devuelve un array con los valores del dominio de FORMAT
	public function getFormats();

	//RECIBE:	Nada
	//RETORNA:	Array of String
	//NOTA:		Devuelve un array con los valores del dominio del ELCC
	public function getLicenses();
	
	//RECIBE:	un op y los datos para un oc
	//RETORNA:	un op con un oc agregado
	//NOTA:		sin comentarios
	public function add($format, $keywords, $author, $url, $cc);

	//Quita un oc(id) del OP(collection)
	public function del($id);

	//retorna la licencia combinada del OP
	public function calculator();

	//retorna la máxima licencia combinada del OP
	public function calculatorMax();

	//retorna la mínima licencia combinada del OP
	public function calculatorMin();
	
	//retorna la mínima licencia de la adaptacion cc
	public function adaptation($cc);
	
	public function credits($name, $cc);

	//Agrega a la base de datos del sistema los datos un registro
	public function insert($format, $keywords, $author, $url, $cc);

	//realiza una consulta en la base de datos y la recibe en una colección de datos
	public function select($repositoryUrl, $key, $i, $mode);

	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Retorna un array con los elementos de cada OC como un array de strings 
	public function getWorks();

	}

?>
