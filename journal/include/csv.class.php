<?php
/**
* @package phpCSV
* @author Mike Leigh
* @copyright (C) 2006 Mike Leigh. All Rights Reserved.
* @version 0.1
* @license http://www.gnu.org/licenses/gpl.txt GNU General Public License
*/
class phpCSV {


/*
	file	[] 		csv file
	mode	[r]		read/write
	delimiter [,]
	length
	null	[true] false	attribute not exist



*/
	var $attributes = array('status' => true, 'null' => true);
	var $rows = -1;
	var $row = -1;

	function phpCSV($attributes = array()) {
		if(count($attributes) >= 1) {
			foreach($attributes as $key => $value) {
				$this->setAttribute($key, $value);
			}
		}
	}

	function getAttribute($attribute) {
		if($this->getStatus() == true) {
			if(array_key_exists($attribute, $this->attributes)) {
				return $this->attributes[$attribute];
			} else {
			        if ($this->getAttribute('null')) return false;
				$this->setStatus(false);
				$this->setMessage("Attribute: '".$attribute."' does not exist");
				return $this->getStatus();
			}
		}
	}

	function setAttribute($attribute, $value) {
		if($this->getStatus() == true) {
			$this->attributes[$attribute] = $value;
		}
	}

	function getStatus() {
		return $this->attributes['status'];
	}

	function setStatus($value) {
		$this->attributes['status'] = $value;
	}

	function getMessage() {
		return $this->attributes['message'];
	}

	function setMessage($value) {
		$this->attributes['message'] = $value;
	}


	function openFile() {
	        if (!$this->getAttribute('handle')) {
		        if ($this->getAttribute('mode') == 'w')
				@unlink($this->getAttribute('file'));
			$this->setAttribute('handle', fopen($this->getAttribute('file'), $this->getAttribute('mode')));
			$this->setAttribute('result', array());
		}
	}

	function closeFile() {
		if ($this->getAttribute('handle')) {
			fclose($this->getAttribute('handle'));
  			chmod($this->getAttribute('file'), 0666);
  		}
		$this->setAttribute('handle', '');
	}

	function readCSV($win=false) {
	        if (!$this->getAttribute('handle'))
			$this->openFile();
/*
		while(($data = fgetcsv($this->getAttribute('handle'), $this->getAttribute('length'), $this->getAttribute('delimiter'))) !== false) {
			$this->addResult($data);
		}
*/
                $datas = file($this->getAttribute('file'));
		for($i=0, $im=count($datas); $i < $im; $i++) {
		        if (empty($win))
			        $datas[$i] = iconv('WINDOWS-1251', 'UTF-8//IGNORE//TRANSLIT', $datas[$i]);
			$data = explode ($this->getAttribute('delimiter'), trim($datas[$i]));
			$this->addResult($data);
		}
		$this->countResult();
		$this->closeFile();
	}

	function addResult(&$array) {
		$this->attributes['result'][] = $array;
	}

	function countResult() {
		$this->setAttribute('rows', count($this->attributes['result']));
		$this->row = -1;
		return $this->getAttribute('rows');
	}

	function fetch_array() {
	        if ($this->getAttribute('rows') == -1) $this->countResult();
	        $row = $this->row;
		if ($this->row++ == $this->getAttribute('rows')-1) return false;
		return $this->attributes['result'][$this->row];
	}

	function writeCSV($win=true) {
	        if (!$this->getAttribute('handle'))
			$this->openFile();

		$this->countResult();
		while(($data = $this->fetch_array()) !== false) {
		        if (!empty($win))
			        $data = iconv('UTF-8//IGNORE//TRANSLIT', 'WINDOWS-1251', $data);
			fwrite($this->getAttribute('handle'), implode($this->getAttribute('delimiter'), $data)."\r\n");
		}
		$this->closeFile();
	}

}
?>