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



include_once("collection/collection.php");

class DB5 {


	//RECIBE:	String
	//RETORNA:	Array of Array of String
	//NOTA:		Devuelve en $retorno un array con los nombres y url de los respostiros registrado en la base apuntada por $repositoryListUrl
	public static function getRepositoryList($repositoryListUrl){
		//Crear el array a devolver
		$retorno = Array();		
		//abrir el archivo de bases de datos
		$fp = fopen($repositoryListUrl, 'r');
		while (($fila = fgetcsv($fp)) !== FALSE) {//lee cada línea como un string
			//agregar $item a $retorno
			array_push($retorno, $fila);
		}
		//cierra el archivo
		fclose($fp);
		//Retorna el resultado
		return $retorno;
	}


	//RECIBE:	String, String, String, String, String, Tag
	//RETORNA:	Nada
	//NOTA:		Agrega el RECORD ($format, $keywords, $author, $url, $cc) a la base que está en la ruta $dbPath
	//		$dbPath hace referencia a un path local, por ejemplo: "../yabala/db/dv.csv"
	public static function insert($dbPath, $format, $keywords, $author, $url, $cc){
		//abrir el archivo de bases de datos
		$fp = fopen($dbPath, 'a');
		//agregar la linea a la base de datos
		fwrite($fp, $format."«".$keywords."«".$author."«".$url."«".$cc."\n");
		//cerrar el archivo de base de datos
		fclose($fp);
	}

	//RECIBE:	String, String, Integer, Integer
	//RETORNA:	Collection
	//NOTA:		Busca en la base de datos ubicada en la url $dbUrl, el string contenido en $key y retorna la colección de registros resultado
	//		Si $i<0 busca si aparece $key en forma exacta o como sub-string en cualquier campo
	//		Si $i>=0 y $mode=0 busca si aparece $key en forma exacta o como sub-string dentro del campo $i
	//		Si $i>=0 y $mode=1 busca si aparece $key en forma exacta  dentro del campo $i
	//		$dbUrl es una url donde está la base en la que se buscará, por ejemplo: "http://misitio.com/db.csv
	public static function select($dbUrl, $key, $i, $mode){
		//crea la colección $db
		$db = new Collection(array());
		if ($i>=0) {//quiere buscar en un campo específico
			DB5::selectSome($db, $dbUrl, $key, $i, $mode);
		}else{//quiere buscar en cualquier parte del registro
			DB5::selectAll($db, $dbUrl, $key);
		}
		return $db;
	}

	//RECIBE:	Collection, String, String
	//RETORNA:	Collection (por variable)
	//NOTA:		Busca en la base de datos ubicada en la url $dbUrl, el string contenido en $key y retorna la colección de registros resultado en $db
	//		$dbUrl es una url donde está la base en la que se buscará, por ejemplo: "http://misitio.com/db.csv
	private static function selectAll(&$db, $dbUrl, $key){
		if (($h = fopen($dbUrl, "r")) !== FALSE) {//abre el archivo
			while (($fila = fgetcsv($h)) !== FALSE) {//lee cada línea como un string
				if(stripos($fila[0], $key) !== false){//si la cadena clave se encuentra en la cadena fila
					//transforma el string en un array
					$fila = explode("«", $fila[0]); //string to array
					//agregar a search
					DB5::addrecord($db, $fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
				}
			}
			//cierra el archivo
			fclose($h);
		}
	}

	//RECIBE:	Collection, String, String, Integer, Integer
	//RETORNA:	Collection (por variable)
	//NOTA:		Busca en la base de datos ubicada en la url $dbUrl, el string contenido en $key y retorna la colección de registros resultado en $db
	//		Si $i<0 busca si aparece $key en forma exacta o como sub-string en cualquier campo
	//		Si $i>=0 y $mode=0 busca si aparece $key en forma exacta o como sub-string dentro del campo $i
	//		Si $i>=0 y $mode=1 busca si aparece $key en forma exacta  dentro del campo $i
	//		$dbUrl es una url donde está la base en la que se buscará, por ejemplo: "http://misitio.com/db.csv
	private static function selectSome(&$db, $dbUrl, $key, $i, $mode){
		if (($h = fopen($dbUrl, "r")) !== FALSE) {//abre el archivo
			while (($fila = fgets($h)) !== FALSE) {//lee cada línea como un string
				//transforma el string en un array
				$fila = explode("«", $fila);
				if ((($mode==0)&&(stripos($fila[$i], $key) !== false))||(($mode==1)&&(trim($fila[$i], "\n")==$key))){
					//agregar a search
					DB5::addrecord($db, $fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
				}
			}
			//cierra el archivo
			fclose($h);
		}
	}

	//RECIBE:	Collection, String, String, String, String, Tag
	//RETORNA:	Collection (por variable)
	//NOTA:		Agrega el registro ($format, $keywords, $author, $url, $cc) a la colección $db
	private static function addrecord(&$db, $format, $keywords, $author, $url, $cc){
		$db->add(rand(), array ($format, $keywords, $author, $url, $cc));
	}

	//Imprime el contenido de la base
	//SOLO PARA DEBUG
	//public static function printdbDB($db){
	//	foreach ($db as $key => $item) {
	//		echo "<b>$key:</b> ";
	//		print_r ($item);
	//		echo "<br>\n";
	//	}
	//}



}

?>