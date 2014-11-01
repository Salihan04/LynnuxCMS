<?php

class PSIGrabber{
	private static $html;
	private static $DOM;
	private static $data;

	function __construct(){
		self::$DOM = new DOMDocument();
		self::$data = array();
		self::fetchWeb();
	}

    function fetchWeb(){//i did this so that it wont spam the website
    	if(file_exists('psi-data.html') and date('H') ==date('H', filemtime('psi-data.html'))) {
			self::$html = file_get_contents('psi-data.html');
			self::$DOM->loadHTML(self::$html);
		}else{
			self::refreshWeb();
		}
    }

    function refreshWeb(){
    	self::$html = file_get_contents("http://app2.nea.gov.sg/anti-pollution-radiation-protection/air-pollution-control/psi/psi-readings-over-the-last-24-hours");
		file_put_contents('psi-data.html', self::$html);
		self::$DOM->loadHTML(self::$html);
    }

    function getData(){
    	self::grabData();
    	return self::$data;
    }



	function grabData(){
		self::fetchWeb();
		///traverse through the nodes in this fashion
		///*[id = 'main']/div[0]/div[0]/div[2]/table[0]/
		$main = self::$DOM->getElementById('main');
		// self::printChilds($main);
		$div1 = self::findNodeByNamePos($main, 'div', 0);
		// self::printChilds($div1);
		$div2 = self::findNodeByNamePos($div1,'div', 0);
		// self::printChilds($div2);
		$div3 = self::findNodeByNamePos($div2, 'div', 2);
		// self::printChilds($div3);
		$table = self::findNodeByNamePos($div3, 'table', 0);///this table is the main table in the websites
		// self::printChilds($table);
		$north1 = self::findNodeByNamePos($table, 'tr', 1);
		// self::printChilds($north1);
		$south1 = self::findNodeByNamePos($table, 'tr', 2);
		// self::printChilds($south1);
		$east1 = self::findNodeByNamePos($table, 'tr', 3);
		// self::printChilds($east1);
		$west1 = self::findNodeByNamePos($table, 'tr', 4);
		// self::printChilds($west1);
		$central1 = self::findNodeByNamePos($table, 'tr', 5);
		// self::printChilds($central1);
		$overall1 = self::findNodeByNamePos($table,'tr', 6);
		// self::printChilds($overall1);
		$north2 = self::findNodeByNamePos($table, 'tr', 8);
		// self::printChilds($north2);
		$south2 = self::findNodeByNamePos($table, 'tr', 9);
		// self::printChilds($south2);
		$east2 = self::findNodeByNamePos($table, 'tr', 10);
		// self::printChilds($east2);
		$west2 =self::findNodeByNamePos($table, 'tr', 11);
		// self::printChilds($west2);
		$central2 = self::findNodeByNamePos($table, 'tr', 12);
		// self::printChilds($central2);
		$overall2 = self::findNodeByNamePos($table,'tr', 13);
		// self::printChilds($overall2);

		///get the latest of all rows
		// self::assignKeyValueToData('North', $north1);
		// self::assignKeyValueToData('South', $south1);
		// self::assignKeyValueToData('East', $east1);
		// self::assignKeyValueToData('West', $west1);
		// self::assignKeyValueToData('Central', $central1);
		// self::assignKeyValueToData('Overall', $overall1);
		self::assignKeyValueToData('North', $north2);
		self::assignKeyValueToData('South', $south2);
		self::assignKeyValueToData('East', $east2);
		self::assignKeyValueToData('West',$west2);
		self::assignKeyValueToData('Central', $central2);
		// self::assignKeyValueToData('Overall', $overall2);

		return (self::$data);
	}

	function assignKeyValueToData($key, $node){
		$value = self::getLatest($node);
		if($value == ''){
			return false;
		}else{
			self::$data[$key] = $value;
			return true;
		}
	}

	function getLatest($node){//traverse through all values in one row of a table to get the one with the 'strong' node
		$count = 0;//count is required as there is two strong nodes in each row. the latest one is the second
		if($node->nodeName== 'tr'){
			foreach($node->childNodes as $td){
				if(self::isStrong($td)){
					$count = $count+1;
					if($count == 2){//once reach second 'strong' node get the contents
						return $td -> textContent;
					}
				}
			}
		}
	}

	function isStrong($node){//check if node is strong
		if($node->nodeName=='td'){
			foreach($node->childNodes as $child){
				if($child->nodeName=='strong'){
					return true;
				}
			}
		}
		return false;
	}

	//////used for debugging///////
	function printChilds($node){	
		echo 'In node: ' . $node->nodeName . '<br>';
		foreach($node->childNodes as $child){
			echo $child->nodeName . ': '.  self::getNodeClass($child) . '<br>';
		}
		echo '<br>';
	}

	function is_iterable($var){//check if object is iterable
	    return $var !== null 
	        && (is_array($var) 
	            || $var instanceof Traversable 
	            || $var instanceof Iterator 
	            || $var instanceof IteratorAggregate
	            );
	}

	function hasClass($node){//check if node has class attribute
		if(self::is_iterable($node->attributes)){
			foreach($node->attributes as $attr){
				if($attr->nodeName=='class'){
					return true;
				}
			}
		}
		return false;
	}

	function getNodeClass($node){//get classname
		if(self::hasClass($node)){
			foreach($node->attributes as $attr){
				if($attr->nodeName=='class'){
					return $attr->value;
				}
			}
		}
		return " ";
	}


	function printAttributes($node){//print attributes in the node
		$array = false;
		echo 'Attr in node: ' . $node->nodeName . '<br>';
		foreach ($node->attributes as $attr) {
			$array[$attr->nodeName] = $attr->nodeValue;
		}
		foreach ($array as $key => $value) {
			echo $key . ': ' . $value;
		}
		echo '<br>';
	}

	function findNodeByNamePos($parent, $name, $pos){//get child by name and the position of occurence
		$curPos = 0;
		foreach($parent->childNodes as $key){
			if($key ->nodeName == $name){
				if ($curPos == $pos){
					return $key;
				}
				$curPos = $curPos + 1;
			}
		}
		return -1;
	}


}


//============================================
//    This is how you grab in your codes
//============================================
// $instance = new PSIGrabber();
// $data = PSIGrabber::grabData();
// foreach ($data as $key => $value) {
// 	echo $key . ': ' . $value . '<br>';
// }
?>