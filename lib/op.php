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



	//RECIBE:	String, String, String, String, Tag, Boolean, Boolean
	//RETORNA:	Nada
	//NOTA:		Agrega el OC con datos $title, $format, $keywords, $author, $url, $cc, $modify, $exception a la colección $ocs 
	public function add($title, $format, $keywords, $author, $url, $cc, $modify, $exception){

		$oc = new OC($title, $format, $keywords, $author, $url, $cc, $modify, $exception);
		
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
			//Si el oc no tiene excepciones lo considera para el calculo
			$data = $oc->getData();
			if(!($data->getException())){
				//Se toman los valores del ELCC compatibles con la licencia del oc
				//Con los cuales se puede remixar y se guardan en $temp
				$temp = $oc->r();
				//Se intersecta el conjunto de soluciones actual $L con $temp
				$L = array_intersect($temp, $L);
			}
		}
		//Se retorna el conjunto resultado
		return $L;
	}

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el máximo valor del ELCC que podrían ser licencias para un remix de las obras
	//		representas por los oc contenidos en la colección $ocs
	public function calculatorMax(){
		return LICENCIA::max($this->calculator());
	}

	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el mínimo valor del ELCC que podrían ser licencias para un remix de las obras
	//		representas por los oc contenidos en la colección $ocs
	public function calculatorMin(){
		return LICENCIA::min($this->calculator());
	}

	//RECIBE:	String, String, String, String, String, String, Integer, Integer, Integer
	//RETORNA:	Array of String
	//NOTA:		Retorna un array con cinco strings que contiene:
	//		[0] String vacío que indica que se crearón los créditos
	//		[1] La URL ($yabalaUrl+name+html) de la página HTML con los créditos del remix si $html!=0 sino retorna el string vacío
	//		[2] La URL ($yabalaUrl+name+png) de la imagen QR con los créditos del remix si $qrfull!=0 sino retorna el string vacío
	//		[3] La URL ($yabalaUrl+name+png) de la imagen QR con la licencia del remix si $qrmin!=0 sino retorna el string vacío 
	//		[4] La URL ($yabalaUrl+name+png) de la imagen Creative Commons con la licencia del remix 
	public function credits($name, $cc, $title, $author, $creditsPath, $yabalaUrl, $html, $qrfull, $qrmin){
			
			//Hacer el código de la licencia del remix
			if ($title==""){
				$title = "Untitle";
			}
			$code = "<h3>$title</h3><hr />";
			$codeQR = "$title\n\n";
			//se define la leyenda según la licencia
			if ($cc=="CR"){
				$code = $code."T&eacute;rminos de uso: Obra con todos los derechos reservados. ";
				$codeQR = $codeQR."Términos de uso: Obra con todos los derechos reservados. ";
			}elseif($cc=="PD"){
				$code = $code."T&eacute;rminos de uso: Esta obra est&aacute; bajo <a href='".$yabalaUrl."pd.htm' target='_blank'>Dominio P&uacute;blico</a>. ";
				$codeQR = $codeQR."Términos de uso: Esta obra está bajo Dominio Público. ";
			}elseif($cc=="CC0"){
				$code = $code."T&eacute;rminos de uso: Esta obra est&aacute; licenciada bajo <a href='".$yabalaUrl."cc0.htm' target='_blank'>Cretive Commons $cc 1.0 Universal</a>. ";
				$codeQR = $codeQR."Términos de uso: Esta obra está licenciada bajo Cretive Commons $cc 1.0 Universal. ";
			}else{
				$code = $code."T&eacute;rminos de uso: Esta obra est&aacute; licenciada bajo <a href='$yabalaUrl".strtolower($cc).".htm' target='_blank'>Cretive Commons $cc Internacional licencia 4.0</a>. ";			
				$codeQR = $codeQR."Términos de uso: Esta obra está licenciada bajo una licencia Cretive Commons $cc Internacional 4.0. ";			
			}
			if ($author!=""){
				$code = $code."Se atribuye a $author. ";
				$codeQR = $codeQR."Se atribuye a $author. ";
			}
			if($this->ocs->count()>0){//si tiene ocs imprime el declaimer 	
				$code = $code."<hr />\nMateriales integrantes de la obra:\n\n";
				$codeQR = $codeQR."\n\nMateriales integrantes de la obra:\n\n";
			}else{//si no tiene ocs imprime el declaimer 	
				$code = $code."<hr />\n";
				$codeQR = $codeQR."";
			}
			foreach ($this->ocs as $oc) {
					$data = $oc->getData();
					$titlet = $data->getTitle();
					$authort = $data->getAuthor();
					$urlt = $data->getUrl();
					$cct = $data->getLicense();
					if ($titlet!=""){
						$code = $code."T&iacute;tulo: $titlet\n";
						$codeQR = $codeQR."Título: $titlet\n";
					}
					$code = $code."Licencia: <a href='$yabalaUrl".strtolower($cct).".htm' target='_blank'>$cct</a>\n";
					$codeQR = $codeQR."Licencia: $cct\n";
					if ($authort!=""){
						$code = $code."Autor: $authort\n";
						$codeQR = $codeQR."Autor: $authort\n";
					}
					if ($urlt!=""){
						$code = $code."Fuente: <a href='$urlt' target='_blank'>$urlt</a>\n";
						$codeQR = $codeQR."Fuente: $urlt\n";
					}
					if($data->getModify()){
						$code = $code."Modificado de su versi&oacute;n original\n\n";
						$codeQR = $codeQR."Modificado de su versión original\n\n";
					}
					if($data->getException()){
						$code = $code."Este material forma parte del conjunto como una exepci&oacute;n.\n\n";
						$codeQR = $codeQR."Este material forma parte del conjunto como una exepción.\n\n";
					}else{
						$code = $code."\n";
						$codeQR = $codeQR."\n";
					}
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
				QRcode::png($codeQR, $creditsPath.$nameQrfull);
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
					QRcode::png("CC $cc 4.0", $creditsPath.$nameQrmin);
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
			return array ("", $yabalaUrl.$nameHtml, $yabalaUrl.$nameQrfull, $yabalaUrl.$nameQrmin, $yabalaUrl.$nameCC);
	}
	

	//RECIBE:	Nada
	//RETORNA:	Array of Array of String
	//NOTA:		Retorna un array con los elementos de cada elemento de la coleccióm ocs como un array de strings 
	public function printOP(){
		$r = array();
		foreach ($this->ocs as $key => $item) {
			$r[$key] = $item->printOC();
		}
		return $r;
	}

}

?>