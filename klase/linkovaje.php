	<?php
	/**
	* Ova klasa je namenjen za stvaranja svih dinamickih linkova
	*/
	class linkovanje {
		var $Href;
		var $Klasa;
		var $Naziv;
		var $slika;
		function setA($Href,$Klasa,$Naziv) {
			$this->href = $Href;
			$this->Klasa = $Klasa;
			$this->Naziv = $Naziv; 
		}
		function getA($Href,$Klasa,$Naziv) {
			$mali_font = mb_strtolower($Href, "UTF-8");
			$nazaiv_preradjen = mb_strtoupper ($Naziv, "UTF-8");
			$naziv_cist = $nazaiv_preradjen;
			$search = array('ž','š','đ','ć','č',' ',',');
			$replace = array('z','s','dj','c','c','-','');
			$promena_karaktera = str_replace($search ,$replace , $mali_font);
			$Href_cist = $promena_karaktera;
			if(!empty($Klasa)){
				return '<a href="'.$Href_cist.'" class="'.$Klasa.'">'.$naziv_cist.'</a>';
			}elseif (empty($Klasa)) {
				return '<a href="'.$Href_cist.'">'.$naziv_cist.'</a>';
			}
		}
		function setIMG($Klasa,$Href,$Slika,$Naziv){
			$this->href = $Href;
			$this->Klasa = $Klasa;
			$this->Naziv = $Naziv; 
			$this->Slika = $Slika;
		}
		function getIMG($Klasa,$Href,$Slika,$Naziv){
			$mali_font = mb_strtolower($Href, "UTF-8");
			$nazaiv_preradjen = mb_strtoupper ($Naziv, "UTF-8");
			$naziv_cist = $nazaiv_preradjen;
			$search = array('ž','š','đ','ć','č',' ',',');
			$replace = array('z','s','dj','c','c','-','');
			$promena_karaktera = str_replace($search ,$replace , $mali_font);
			$Href_cist = $promena_karaktera;
			if(!empty($Klasa)){
				return '<a href="'.$Href_cist.'"><img class="'.$Klasa.'" src="'.$Slika.'" alt="'.$Naziv.'"></a>';
			}elseif (empty($Klasa)) {
				return '<a href="'.$Href_cist.'"><img src="'.$Slika.'" alt="'.$Naziv.'"></a>';
			}
		}
		function setLink($Href){
			$this->href = $Href;
		}
		function getLink($Href){
			$mali_font = mb_strtolower($Href, "UTF-8");
			$search = array('ž','š','đ','ć','č',' ');
			$replace = array('z','s','dj','c','c','-');
			$promena_karaktera = str_replace($search ,$replace , $mali_font);
			$Href_cist = $promena_karaktera;
			return $Href_cist;
		}
	}