<?php

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

	//RECIBE:	String, String, String, Tag, Integer, Integer, Integer
	//RETORNA:	Array of String
	//NOTA:		Retorna un array con tres strings que contiene:
	//		La URL ($yabalaUrl+name+html) de la página HTML con los créditos del remix si $html!=0 sino retorna el string vacío
	//		La URL ($yabalaUrl+name+png) de la imagen QR con los créditos del remix si $qrfull!=0 sino retorna el string vacío
	//		La URL ($yabalaUrl+name+png) de la imagen QR con la licencia del remix si $qrmin!=0 sino retorna el string vacío 
	public function credits($name, $creditsPath, $yabalaUrl, $cc, $html, $qrfull, $qrmin){
			
			//Hacer el código de la licencia del remix
			$code = "<pre>\n";
			$code = $code."Obra bajo licencia Cretive Commons 4.0 Internacional $cc\n\n";
			$code = $code."Obra integrantes del remix:\n\n";
			foreach ($this->ocs as $oc) {
					$format = $oc->data->getFormat();
					$keywords = $oc->data->getKeywords();
					$author = $oc->data->getAuthor();
					$url = $oc->data->getUrl();
					$cct = $oc->data->getLicense();
					$code = $code."Licencia: $cct\nFormato: $format\nDescripción: $keywords\nAutor: $author\nUrl: $url\n\n";
			}
			$code = $code."</pre>";

			//Definir el nombre de los archivos
			//$name = uniqid().rand();
						
			//si $html es diferente de 0 crea el archivo html
			if($html!=0) {
				//Definir el nombre del archivo HTML
				$nameHtml = $name.".html";

				$fp = fopen($creditsPath.$nameHtml, "w");
				fwrite($fp, $code);
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

				//crea el nuevo archivo
				QRcode::png("CC 4.0: $cc", $creditsPath.$nameQrmin);
			}else{
				$nameQrmin="";
			}
			
			
			return array ($yabalaUrl.$nameHtml, $yabalaUrl.$nameQrfull, $yabalaUrl.$nameQrmin);
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