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
	const repositoryListUrl = "http://localhost/yabala/yabala/db/list.csv";
	const creditsPath = "../yabala/www/";
	const dbPath = "../yabala/db/db.csv";
	

	
	//RECIBE:	Nada
	//RETORNA:	Collection
	//NOTA:		Devuelve el conjunto de materiales	
	public function getOP();



	//RECIBE:	Nada
	//RETORNA:	Array of String
	//NOTA:		Devuelve un array con los valores del dominio de FORMAT
	public function getFormats();



	//RECIBE:	Nada
	//RETORNA:	Array of String
	//NOTA:		Devuelve un array con los valores del dominio del ELCC
	public function getLicenses();
	
	//RECIBE:	Tag
	//RETORNA:	Array de Tag
	//NOTA:		Retorna todos los valores del ELCC que podrían ser licencias para la adaptación de un material con licencia $cc
	public function adaptation($cc);


	
	//RECIBE:	String, String, String, String, Tag
	//RETORNA:	Nada
	//NOTA:		Agrega el material con datos $format, $keywords, $author, $url, $cc al conjunto de materiales op
	public function add($format, $keywords, $author, $url, $cc);

	//RECIBE:	Integer
	//RETORNA:	Nada
	//NOTA:		Quita el material con identificador $id del conjunto de materiales op
	public function del($id);

	//RECIBE:	Nada
	//RETORNA:	Array de Tag
	//NOTA:		Retorna todos los valores del ELCC que podrían ser licencias para el conjunto de materiales op
	public function calculator();

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el máximo valor del ELCC que podrían ser licencias para el conjunto de materiales op
	public function calculatorMax();

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el mínimo valor del ELCC que podrían ser licencias para el conjunto de materiales op
	public function calculatorMin();
	
	//RECIBE:	String, String, Array of elements
	//RETORNA:	Array of String
	//NOTA:		EN ESTA VERSIÓN $options no se usa
	//		Retorna un array con cuatro strings que contiene:
	//		La URL de la página HTML con los créditos del conjunto de materiales op ($name es usado para identificar el archivo creado)
	//		La URL de la imagen QR con los créditos  del conjunto de materiales op ($name es usado para identificar el archivo creado)
	//		La URL de la imagen QR con la licencia  del conjunto de materiales op  ($name es usado para identificar el archivo creado)
	//		La URL de la imagen Creative Commons con la licencia  del conjunto de materiales op  ($name es usado para identificar el archivo creado)	
	public function credits($name, $cc, $options);
	
	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Retorna un array con los componentes de cada material del conjunto de materiales op como un array de strings 
	public function getWorks();



	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Devuelve un array con los nombres y url de los respostiros registrado en la base apuntada por $repositoryListUrl
	public function getRepositoryList();
	
	//RECIBE:	String, String, String, String, String, String
	//RETORNA:	Nada
	//NOTA:		Agrega el RECORD ($format, $keywords, $author, $url, $cc) a la base que está en la ruta $dbPath
	//		$dbPath hace referencia a un path local, por ejemplo: "../yabala/db/dv.csv"
	public function insert($format, $keywords, $author, $url, $cc);
	
	//RECIBE:	String, String, Integer, Integer
	//RETORNA:	Collection
	//NOTA:		Busca en la base de datos ubicada en la url $repositoryUrl, el string contenido en $key y retorna la colección de registros resultado
	//		Si $i<0 busca si aparece $key en forma exacta o como sub-string en cualquier campo
	//		Si $i>=0 y $mode=0 busca si aparece $key en forma exacta o como sub-string dentro del campo $i
	//		Si $i>=0 y $mode=1 busca si aparece $key en forma exacta  dentro del campo $i
	//		$repositoryUrl es una url donde está la base en la que se buscará, por ejemplo: "http://misitio.com/db.csv
	public function select($repositoryUrl, $key, $i, $mode);
	
		
	
	//RECIBE:	String, Array of elements
	//RETORNA:	Nada
	//NOTA:		EN ESTA VERSIÓN $options no se usa
	//		Borra:
	//		La URL de la página HTML con los créditos del conjunto de materiales de nombre $nombre
	//		La URL de la imagen QR con los créditos  del conjunto de materiales de nombre $nombre 
	//		La URL de la imagen QR con la licencia  del conjunto de materiales de nombre $nombre 
	//		La URL de la imagen Creative Commons con la licencia  del conjunto de materiales de nombre $nombre 
	public function resetCredits($name, $options);



}

?>
