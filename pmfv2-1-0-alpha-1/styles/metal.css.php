<?php
	header("Content-type: text/css");
	$font_size = "small";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
		$font_size = "x-small";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
		$font_size = "small";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mac'))
		$font_size = "medium";
?>
td.tbl_even   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #EEEEFF;
}
td.tbl_odd   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #E0E0E0;
}
table.header    {
    background-color: #D0D1D3;
	color: #000000;
}
a.hd_link {
	color: #5f5f5f;
}
a.hd_link:hover {
	color: #5f5f5f;
}
a.copyright:hover {
	text-decoration: underline;
}
a.delete:hover {
	color: red;
}
input,select,textarea     {
	background-color: #DDDDDD;
}
th   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #a0a0a0;
}
body   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #C0C6D3;
}
a:hover   {
	color: #0000a0;
	text-decoration: none;
}
a   {
	color: #5f5f5f;
	text-decoration: none;
}
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
