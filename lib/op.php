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



include_once ("collection/collection.php");
include_once ("phpqrcode/qrlib.php");
include_once ("oc.php");

class OP {



	//Colección de objetos contenedores OC
	var $ocs;



	//Constructor de la clase
	function __construct() {
		$this->ocs = new Collection(array());
	}



	//RECIBE:	String, String, String, String, Tag
	//RETORNA:	Nada
	//NOTA:		Agrega el OC con datos $format, $keywords, $author, $url, $cc a la colección $ocs 
	public function add($format, $keywords, $author, $url, $cc){

		//crear el oc
		$oc = new OC($format, $keywords, $author, $url, $cc);
		
		//agregar el oc al ocs
		$this->ocs->add(uniqid().rand(), $oc);
	}

	//RECIBE:	Integer
	//RETORNA:	Nada
	//NOTA:		Quita el OC de identificador $id de la colección $ocs
	public function del($id){

		//si existe un objeto con id $id lo quita de la colección $ocs
		if ($this->ocs->__isset($id)){
			$this->ocs->delete($id);
		}
	}

	//RECIBE:	Nada
	//RETORNA:	Array de Tag
	//NOTA:		Retorna todos los valores del ELCC que podrían ser licencias para un remix de las obras
	//		representas por los oc contenidos en la colección $ocs
	public function calculator(){

		//Conjunto inicial L igual a todo el dominio del ELCC
		$L= ELCC::getDomain();

		//Por cada oc en $ocs del op hacer
		foreach ($this->ocs as  $oc) {
			//Se toman los valores del ELCC compatibles con la licencia del oc
			//Con los cuales se puede remixar y se guardan en $temp
			$temp = $oc->r();
			//Se intersecta el conjunto de soluciones actual $L con $temp
			$L = array_intersect($temp, $L);
		}
		//Se retorna el conjunto resultado
		return $L;
	}

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el máximo valores del ELCC que podrían ser licencias para un remix de las obras
	//		representas por los oc contenidos en la colección $ocs
	public function calculatorMax(){
		return LICENCIA::max($this->calculator());
	}

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el mínimo valores del ELCC que podrían ser licencias para un remix de las obras
	//		representas por los oc contenidos en la colección $ocs
	public function calculatorMin(){
		return LICENCIA::min($this->calculator());
	}

	//RECIBE:	String, Tag, String, String, Integer, Integer, Integer
	//RETORNA:	Array of String
	//NOTA:		Retorna un array con cuatro strings que contiene:
	//		La URL ($yabalaUrl+name+html) de la página HTML con los créditos del remix si $html!=0 sino retorna el string vacío
	//		La URL ($yabalaUrl+name+png) de la imagen QR con los créditos del remix si $qrfull!=0 sino retorna el string vacío
	//		La URL ($yabalaUrl+name+png) de la imagen QR con la licencia del remix si $qrmin!=0 sino retorna el string vacío 
	//		La URL ($yabalaUrl+name+png) de la imagen Creative Commons con la licencia del remix 
	public function credits($name, $cc, $creditsPath, $yabalaUrl, $html, $qrfull, $qrmin){
			
			//Hacer el código de la licencia del remix
			$code = "";
			//se define la leyenda según la licencia
			if ($cc=="CR"){
				$code = $code."Obra con todos los derechos reservados \n\n";
			}else{
				$code = $code."Obra bajo licencia Cretive Commons 4.0 Internacional $cc\n\n";
			}
			$code = $code."Obra integrantes del remix:\n\n";
			foreach ($this->ocs as $oc) {
					$author = $oc->data->getAuthor();
					$url = $oc->data->getUrl();
					$cct = $oc->data->getLicense();
					$code = $code."Licencia: $cct\nAutor: $author\nUrl: $url\n\n";
			}

			//Definir el nombre de los archivos
						
			//si $html es diferente de 0 crea el archivo html
			if($html!=0) {
				//Definir el nombre del archivo HTML
				$nameHtml = $name.".html";

				$fp = fopen($creditsPath.$nameHtml, "w");
				fwrite($fp, "<pre>\n".$code."</pre>\n");
				fclose($fp);
			}else{
				$nameHtml="";
			}
			
			//si $qrfull es diferente de 0 crea el archivo QR full
			if($qrfull!=0) {
				
				//Definir el nombre del archivo QR Full
				$nameQrfull = $name."_full.png";
				
				//si el archivo ya existe lo borra
				if (file_exists($creditsPath.$nameQrfull)){
					unlink($creditsPath.$nameQrfull);
				}
				
				//Crea el nuevo archivo
				QRcode::png($code, $creditsPath.$nameQrfull);
			}else{
				$nameQrfull="";
			}

			//si $qrmin es diferente de 0 crea el archivo QR min
			if($qrmin!=0) {
				//Definir el nombre del archivo QR Min
				$nameQrmin = $name."_min.png";
				
				//si el archivo ya existe lo borra
				if (file_exists($creditsPath.$nameQrmin)){
					unlink($creditsPath.$nameQrmin);
				}

				//crea el nuevo archivo según la licencia
				if($cc=="CR"){
					QRcode::png("$cc", $creditsPath.$nameQrmin);
				}else{
					QRcode::png("CC 4.0: $cc", $creditsPath.$nameQrmin);
				}
			}else{
				$nameQrmin="";
			}
			
			//crea el archivo de licencia tradicional CC
			//Definir el nombre del archivo CC
				$nameCC = $name."_cc.png";
				
				//si el archivo ya existe lo borra
				if (file_exists($creditsPath.$nameCC)){
					unlink($creditsPath.$nameCC);
				}
				//crea el nuevo archivo
				copy($creditsPath.strtolower($cc).".png", $creditsPath.$nameCC);
			
			//$nameCC = strtolower($cc).".png";
			//return array ($yabalaUrl.$nameHtml, $yabalaUrl.$nameQrfull, $yabalaUrl.$nameQrmin, $yabalaImg.$nameCC);
			return array ($yabalaUrl.$nameHtml, $yabalaUrl.$nameQrfull, $yabalaUrl.$nameQrmin, $yabalaUrl.$nameCC);
	}
	

	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Retorna un array con los elementos de cada OC como un array de strings 
	public function printOP(){
		$r = array();
		foreach ($this->ocs as $key => $item) {
			$r[$key] = $item->printOC();
		}
		return $r;
	}

}

?>