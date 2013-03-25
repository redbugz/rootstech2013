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
	background-color: #C6F9FF;
}
td.tbl_odd   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #ddddff;
}
table.header    {
    background-color: #45347b;
	color: #FFFFFF;
}
a.hd_link {
	color: #00ff00;
}
a.hd_link:hover {
	color: #00ff00;
}
a.copyright:hover {
	text-decoration: underline;
}
a.delete:hover {
	color: red;
}
input,select,textarea     {
	background-color: #bbffbb;
}
th   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #7a5ada;
}
body   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #FFFFFF;
}
a:hover   {
	color: #0000a0;
	text-decoration: none;
}
a   {
	color: #7a5ada;
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
