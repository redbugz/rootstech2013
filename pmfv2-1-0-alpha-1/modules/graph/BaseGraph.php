<?php

class BaseGraph {

	
	function addRelationships() {
	
		$search = new Relationship();
		$dao = getRelationsDAO();
		$dao->getMarriages($search);
		$i = 0;

		foreach ($search->results AS $rel) {
			$this->addNode($rel->person, $rel->event->event_id);
			$this->addNode($rel->relation, $rel->event->event_id);
			$this->addLink($rel->person, $rel->relation, 'Marriage '.$rel->dom); 	
		
		}
	}

	function addPersonToGraph($param, $per) {
		$this->addNode($per);
	
		if ($per->mother->person_id != "0000") {
			$this->addLink($per->mother, $per);
		}
			
		
		if ($per->father->person_id != "0000") {
			$this->addLink($per->father, $per);	
		}

	}

	function addPeople () {
		$callback = array($this, 'addPersonToGraph');

		$search = new PersonDetail();
		$search->queryType = Q_TYPE;
		$search->order = "p_year_of_birth";
		$dao = getPeopleDAO();
	
		$dao->getPersonDetails($search, $callback);
	
		
	}
	
}?>
