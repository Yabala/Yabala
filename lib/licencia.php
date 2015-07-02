<?php

include_once("elcc.php");

class LICENCIA {



	//Valor que representa el tipo de licencia, es un Tag integrate del ELCC
	var $cc;


	
	//Constructor de la clase
	function __construct($cc) {
		$this->cc = $cc;
	}



	//RECIBE:	Nada
	//RETORNA:	Tag
	//NOTA:		Retorna el valor del $cc del objeto
	public function getCC(){
		return $this->cc;
	}
	
	//RECIBE:	Nada
	//RETORNA:	Array de Tag
	//NOTA:		Implementa la tabla de compatibilidad para remix de obras, dado el valor del ELCC $value 
	//		retorna todos los valores del ELCC compatibles con $value para combinar en un remix de obras
	public function r(){
		return ELCC::r($this->cc);
	}

	//RECIBE:	Array de Tag
	//RETORNA:	Tag
	//NOTA:		Recibe un conjunto de valores del ELCC y retorna el mínimo valor de ese conjunto
	static function min($L){
		if(!empty($L)){
			$min = ELCC::getMax();
			foreach ($L as $value) {
				if(ELCC::order($value)<ELCC::order($min)) $min = $value;
			}
		}else{
			//conjunto vacío no hay mínimo
			return -1;
		}

		if($min!=ELCC::getMax()) return $min;
	}

	//RECIBE:	Array de Tag
	//RETORNA:	Tag
	//NOTA:		Recibe un conjunto de valores del ELCC y retorna el máximo valor de ese conjunto
	static function max($L){
		if(!empty($L)){
			$max = ELCC::getMin();
			foreach ($L as $value) {
				if(ELCC::order($value)>ELCC::order($max)) $max = $value;
			}
		}else{
			//conjunto vacío no hay máximo
			return -1;
		}

		if($max!=ELCC::getMin()) return $max;
	}



}
?>