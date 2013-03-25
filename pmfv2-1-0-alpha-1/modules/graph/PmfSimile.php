<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "../../..");
require_once 'modules/graph/BaseGraph.php';

class PmfSimile extends BaseGraph {
	
	function PmfSimile() {
		$config = Config::getInstance();
		$directed = true;
		$attributes = array();
		$name = $config->desc;
?>

var timeline_data = {  // save as a global variable
'dateTimeFormat': 'iso8601',

'events' : [

<?php
	}


	function addNode($person, $group = '') {
		if ($person->date_of_birth == '0000-00-00' || $person->date_of_death == '0000-00-00') {
			return;
		}
?>{'start': '<?php echo substr($person->date_of_birth,0,10);?>',
        'end': '<?php echo substr($person->date_of_death,0,10);?>',
        'title': '<?php echo $person->getDisplayName();?>',
        'link': 'people.php?person=<?php echo $person->person_id;?>',
        'isDuration' : true,
        'color' : '<?php if ($person->gender == "M") echo "blue"; else echo "pink";?>',
        'textColor' : 'green'},
<?php
	}
	
	function addLink($person1, $person2, $label = '', $constraint = 'true') {
	}
	
	function display($format = 'svg') {
?>
]};
    //end
<?php
	}
	
	function save($filename) {
	}
}?>
