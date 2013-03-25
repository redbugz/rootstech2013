<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "../../..");
require_once 'modules/graph/BaseGraph.php';

class PmfJit extends BaseGraph {
	
	function PmfJit() {
		$config = Config::getInstance();
		$directed = true;
		$attributes = array();
		$name = $config->desc;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Spacetree - Tree Animation</title>

<!-- CSS Files -->
<link type="text/css" href="styles/Jit/base.css" rel="stylesheet" />
<link type="text/css" href="styles/Jit/Spacetree.css" rel="stylesheet" />

<!--[if IE]><script language="javascript" type="text/javascript" src="../../Extras/excanvas.js"></script><![endif]-->

<!-- JIT Library File -->
<script language="javascript" type="text/javascript" src="inc/Jit/jit.js"></script>

<!-- Example File -->
<script language="javascript" type="text/javascript">
var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
  }
};


function init(){
		var json = [
<?php
	}


	function addNode($person, $group = '') {
?>{
                   "data": {
                               "$color": "#c74243"
                                },
                   "id": "<?php echo $person->person_id;?>",
                   "name": "<?php echo $person->getDisplayName().' '.$person->getDates();?>"
                },<?php
	}
	
	function addLink($person1, $person2, $label = '', $constraint = 'true') {
?>
              { "adjacencies": [
                                     {
                "nodeTo": "<?php echo $person2->person_id;?>",
                "nodeFrom": "<?php echo $person1->person_id;?>",
                "data": {
                        "$color": "#557EAA"
                         }
                             }
                                      ],
                "id": "<?php echo $person1->person_id;?>",
               },
<?php		
	}
	
	function display($format = 'svg') {
?>
];
    //end
    //init Spacetree
    //Create a new ST instance
    var st = new $jit.ST({
        //id of viz container element
        injectInto: 'infovis',
        //set duration for the animation
        duration: 800,
        //set animation transition type
        transition: $jit.Trans.Quart.easeInOut,
        //set distance between node and its children
        levelDistance: 50,
        levelsToShow: 5,
        //enable panning
        Navigation: {
          enable:true,
          panning:true
        },
        //set node and edge styles
        //set overridable=true for styling individual
        //nodes or edges
        Node: {
            height: 50,
            width: 160,
            type: 'rectangle',
            color: '#aaa',
            overridable: true
        },
        
        Edge: {
            type: 'bezier',
            overridable: true
        },
        
        onBeforeCompute: function(node){
            Log.write("loading " + node.name);
        },
        
        onAfterCompute: function(){
            Log.write("done");
        },
        
        //This method is called on DOM label creation.
        //Use this method to add event handlers and styles to
        //your node.
        onCreateLabel: function(label, node){
            label.id = node.id;            
            label.innerHTML = node.name;
            label.onclick = function(){
            	if(normal.checked) {
            	  st.onClick(node.id);
            	} else {
                st.setRoot(node.id, 'animate');
            	}
            };
            //set label styles
            var style = label.style;
            style.width = 150 + 'px';
            style.height = 17 + 'px';            
            style.cursor = 'pointer';
            style.color = '#333';
            style.fontSize = '0.8em';
            style.textAlign= 'center';
            style.paddingTop = '3px';
        },
        
        //This method is called right before plotting
        //a node. It's useful for changing an individual node
        //style properties before plotting it.
        //The data properties prefixed with a dollar
        //sign will override the global node style properties.
        onBeforePlotNode: function(node){
            //add some color to the nodes in the path between the
            //root node and the selected node.
            if (node.selected) {
                node.data.$color = "#ff7";
            }
            else {
                delete node.data.$color;
                //if the node belongs to the last plotted level
                if(!node.anySubnode("exist")) {
                    //count children number
                    var count = 0;
                    node.eachSubnode(function(n) { count++; });
                    //assign a node color based on
                    //how many children it has
                    if (count > 5) { count = 5; };
                    node.data.$color = ['#aaa', '#baa', '#caa', '#daa', '#eaa', '#faa'][count];                    
                }
            }
        },
        
        //This method is called right before plotting
        //an edge. It's useful for changing an individual edge
        //style properties before plotting it.
        //Edge data proprties prefixed with a dollar sign will
        //override the Edge global style properties.
        onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#eed";
                adj.data.$lineWidth = 3;
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        }
    });
    //load json data
    st.loadJSON(json);
    //compute node positions and layout
    st.compute();
    //optional: make a translation of the tree
    st.geom.translate(new $jit.Complex(-200, 0), "current");
    //emulate a click on the root node.
    st.onClick(st.root);
    //end
    //Add event handlers to switch spacetree orientation.
    var top = $jit.id('r-top'), 
        left = $jit.id('r-left'), 
        bottom = $jit.id('r-bottom'), 
        right = $jit.id('r-right'),
        normal = $jit.id('s-normal');
        
    
    function changeHandler() {
        if(this.checked) {
            top.disabled = bottom.disabled = right.disabled = left.disabled = true;
            st.switchPosition(this.value, "animate", {
                onComplete: function(){
                    top.disabled = bottom.disabled = right.disabled = left.disabled = false;
                }
            });
        }
    };
    
    top.onchange = left.onchange = bottom.onchange = right.onchange = changeHandler;
    //end

}
</script>
</head>

<body onload="init();">
<?php include_once("inc/analyticstracking.php"); ?>
<div id="container">

<div id="left-container">



<div class="text">
<h4>
Tree Animation    
</h4> 

            A static JSON Tree structure is used as input for this animation.<br /><br />
            <b>Click</b> on a node to select it.<br /><br />
            You can <b>select the tree orientation</b> by changing the select box in the right column.<br /><br />
            You can <b>change the selection mode</b> from <em>Normal</em> selection (i.e. center the selected node) to 
            <em>Set as Root</em>.<br /><br />
            <b>Drag and Drop the canvas</b> to do some panning.<br /><br />
            Leaves color depend on the number of children they actually have.
            
</div>

<div id="id-list"></div>


</div>

<div id="center-container">
    <div id="infovis"></div>    
</div>

<div id="right-container">

<h4>Tree Orientation</h4>
<table>
    <tr>
        <td>
            <label for="r-left">Left </label>
        </td>
        <td>
            <input type="radio" id="r-left" name="orientation" checked="checked" value="left" />
        </td>
    </tr>
    <tr>
         <td>
            <label for="r-top">Top </label>
         </td>
         <td>
            <input type="radio" id="r-top" name="orientation" value="top" />
         </td>
    </tr>
    <tr>
         <td>
            <label for="r-bottom">Bottom </label>
          </td>
          <td>
            <input type="radio" id="r-bottom" name="orientation" value="bottom" />
          </td>
    </tr>
    <tr>
          <td>
            <label for="r-right">Right </label>
          </td> 
          <td> 
           <input type="radio" id="r-right" name="orientation" value="right" />
          </td>
    </tr>
</table>

<h4>Selection Mode</h4>
<table>
    <tr>
        <td>
            <label for="s-normal">Normal </label>
        </td>
        <td>
            <input type="radio" id="s-normal" name="selection" checked="checked" value="normal" />
        </td>
    </tr>
    <tr>
         <td>
            <label for="s-root">Set as Root </label>
         </td>
         <td>
            <input type="radio" id="s-root" name="selection" value="root" />
         </td>
    </tr>
</table>

</div>

<div id="log"></div>
</div>
</body>
</html>
<?php
	}
	
	function save($filename) {
	}
}?>
