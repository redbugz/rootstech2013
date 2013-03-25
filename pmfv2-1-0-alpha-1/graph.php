<?php

include_once "modules/db/DAOFactory.php";

include_once "modules/graph/PmfGraphViz.php";
include_once "modules/graph/PmfJit.php";
include_once "modules/graph/PmfArbor.php";

@$use = $_REQUEST["use"];
$output = 'svg';

if (isset($use)) {
switch ($use) {
case "gv":
$g = new PmfGraphViz();
$output = $_REQUEST["output"];
break;
case "jit":
$g = new PmfJit();
break;
case "arbor":
default:
$g = new PmfArbor();
break;
}

$g->addRelationships();
$g->addPeople();
if ($output === 'dot') {
  $file = $g->save('');
  header("Content-Type: text/vnd.graphviz");
  header("Content-Length: " . filesize($file));
  header('Content-Disposition: inline; filename="phpmyfamily.gv"');
  $fp = fopen($file, 'rb');
  fpassthru($fp);
  fclose($fp);
  unlink($file);
} else {
$g->display($output);
}
} else {
?>
<dl>
<dt>GraphViz</dt>
<dd>
<ul>
<?php
if (is_exec_available()) {
?>
<li><a href="?use=gv&amp;output=svg">SVG</a></li>
<li><a href="?use=gv&amp;output=pdf">pdf</a></li>
<li><a href="?use=gv&amp;output=png">png</a></li>
<li><a href="?use=gv&amp;output=bmp">bmp</a></li>
<?php } ?>
<li><a href="?use=gv&amp;output=dot">dot</a></li>
</ul>
See <a href="http://www.graphviz.org/Resources.php">here</a> for resources to use dot files.
</dd>
<dt><a href="?use=jit">Jit</a></dt>
<dt><a href="?use=arbor">Arbor</a></dt>
</dl>
<?php
}

function is_exec_available() {
    static $available;

    if (!isset($available)) {
        $available = true;
        if (ini_get('safe_mode')) {
            $available = false;
        } else {
            $d = ini_get('disable_functions');
            $s = ini_get('suhosin.executor.func.blacklist');
            if ("$d$s") {
                $array = preg_split('/,\s*/', "$d,$s");
                if (in_array('exec', $array)) {
                    $available = false;
                }
            }
        }
    }

    return $available;
}
?>
