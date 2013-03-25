<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "../../..");
require_once 'Image/GraphViz.php';
require_once 'modules/graph/BaseGraph.php';

class PmfGraphViz extends BaseGraph {
	var $gv;
	
	function PmfGraphViz() {
		$config = Config::getInstance();
		$directed = true;
		$attributes = array();
		$name = $config->desc;
		$this->gv = new Image_GraphViz($directed,$attributes,$name);
	}


	function addNode($person, $group = '') {
		$this->gv->addNode(
		    $person->person_id,
		    array(
			'URL'   => '../'.$person->getURL(),
			'label' => $person->getDisplayName(). ' '. $person->getDates(),
			'shape' => 'box'
    			),
		    $group
		);
	}
	
	function addLink($person1, $person2, $label = '', $constraint = 'true') {
		$this->gv->addEdge(
		    array(
		      $person1->person_id => $person2->person_id
		    ),
		    array(
		      'label' => $label,
		      'constraint' => $constraint
		    )
		  );
	}
	
	
	function display($format = 'svg') {
		$this->gv->image($format);
	}
	
	function save($filename) {
		return($this->gv->saveParsedGraph($filename));
	}
}?>
