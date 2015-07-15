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



include_once("lib/yabala.php");


interface iyabala{

	const yabalaUrl = "http://localhost/yabala/yabala/www/";
	//const yabalaImg = "http://localhost/yabala/yabala/img/";
	const repositoryListUrl = "http://localhost/yabala/yabala/db/list.csv";
	const creditsPath = "../yabala/www/";
	const dbPath = "../yabala/db/db.csv";
	
	
	
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
	
	public function credits($name, $cc, $options);
	
	public function resetCredits($name, $options);

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
