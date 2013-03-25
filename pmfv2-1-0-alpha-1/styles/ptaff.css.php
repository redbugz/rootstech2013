<?php
	header("Content-type: text/css");
	$font_size = "small";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
		$font_size = "x-small";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
		$font_size = "small";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mac'))
		$font_size = "medium";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Gecko'))
		$gecko = true;
?>

td.tbl_even   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
    color: #fff;
	background-color: #207080;
}
td.tbl_odd   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
    color: #fff;
	background-color: #308090;
}
table.header { 
    border-spacing: 0px; 
    <?php if (!$gecko) { echo "background-color: #308090;"; }; ?>
}
table.header td {
    background-color: #308090;
	color: #fff;
}
table.header tr td:first-child {
    <?php if ($gecko) { echo "-moz-border-radius: 16px 0px 0px 0px;"; }; ?>
}
a.hd_link, a.hd_link:link, a.hd_link:visited {
	color: #000;
    background: #ccc;
    padding: 1px;
    border: 2px outset #ccc;
    line-height: 2em;
}
a.hd_link:hover {
	color: #000;
    background: #fff;
    text-decoration: none;
}
a.copyright:hover {
	text-decoration: underline;
}
a.delete:hover {
	color: red;
}
th   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
    color: #ffaf5e;
	background-color: #002730;
<?php if ($gecko) { echo "-moz-border-radius: 8px 0px 0px 0px;"; }; ?>
}
body   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
        color: #ff7;
	background-color: #005060;
}
a:hover   {
	color: #9ff;
    background: transparent;
	text-decoration: underline;
}
a   {
	color: #fff;
	text-decoration: none;
}
a:link { color: #fff; }
a:visited { color: #cff; }
h5 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 75%;
}
td {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
}
h4 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 100%;
}
h1 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 175%;
}
h2 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 150%;
}
h3 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 125%;
}
h6 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 50%;
}
.restrict {
	color: red;
}
.vert {
	background: url('../images/vert.png') no-repeat center;
}
.outer {
	background: url('../images/outer.png') no-repeat center;
}
.br {
	background: url('../images/br.png') no-repeat center;
}
.tr	{
	background: url('../images/tr.png') no-repeat center;
}
.rb {
	background: url('../images/rb.png') no-repeat center;
}
.rt	{
	background: url('../images/rt.png') no-repeat center;
}
