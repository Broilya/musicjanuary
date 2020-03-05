<?php
	function str_to_lower($s) {
                $s = iconv('UTF-8//IGNORE//TRANSLIT', 'WINDOWS-1251', $s);
		$s=strtolower($s);
		$trans=array( "À"=> "à","Á"=> "á","Â"=> "â","Ã"=> "ã","Ä"=> "ä","Å"=> "å","¨"=> "¸","Æ"=> "æ","Ç"=> "ç","È"=> "è","É"=> "é","Ê"=> "ê","Ë"=> "ë","Ì"=> "ì","Í"=> "í","Î"=> "î","Ï"=> "ï","Ð"=> "ð","Ñ"=> "ñ","Ò"=> "ò","Ó"=> "ó","Ô"=> "ô","Õ"=> "õ","Ö"=> "ö","×"=> "÷","Ø"=> "ø","Ù"=> "ù","Ü"=> "ü","Û"=> "û","Ú"=> "ú","Ý"=> "ý","Þ"=> "þ","ß"=> "ÿ");
		$s=strtr($s,$trans);
                $s = iconv('WINDOWS-1251', 'UTF-8//IGNORE//TRANSLIT', $s);
		return $s;
	}
	
	function an_to_ru($s) {
                $s = iconv('UTF-8//IGNORE//TRANSLIT', 'WINDOWS-1251', $s);
		$trans=array( "a"=> "à", "b"=> "â","e"=> "å", "k"=> "ê","o"=> "î","p"=> "ð","c"=> "ñ","x"=> "õ","b"=> "ü",
		              "A"=> "À", "B"=> "Â","E"=> "Å", "K"=> "Ê","M"=> "Ì","H"=> "Í","O"=> "Î","P"=> "Ð","C"=> "Ñ","T"=> "Ò","X"=> "Õ","b"=> "Ü");
		$s=strtr($s,$trans);
                $s = iconv('WINDOWS-1251', 'UTF-8//IGNORE//TRANSLIT', $s);
		return $s;
	}
	
	function str_to_upper($s) {
                $s = iconv('UTF-8//IGNORE//TRANSLIT', 'WINDOWS-1251', $s);
		$s=strtoupper($s);
		$trans=array( "à"=> "À","á"=> "Á","â"=> "Â","ã"=> "Ã","ä"=> "Ä","å"=> "Å","¸"=> "¨","æ"=> "Æ","ç"=> "Ç","è"=> "È","é"=> "É","ê"=> "Ê","ë"=> "Ë","ì"=> "Ì","í"=> "Í","î"=> "Î","ï"=> "Ï","ð"=> "Ð","ñ"=> "Ñ","ò"=> "Ò","ó"=> "Ó","ô"=> "Ô","õ"=> "Õ","ö"=> "Ö","÷"=> "×","ø"=> "Ø","ù"=> "Ù","ü"=> "Ü","û"=> "Û","ú"=> "Ú","ý"=> "Ý","þ"=> "Þ","ÿ"=> "ß");
		$s=strtr($s,$trans);
                $s = iconv('WINDOWS-1251', 'UTF-8//IGNORE//TRANSLIT', $s);
		return $s;
	}
	

?>