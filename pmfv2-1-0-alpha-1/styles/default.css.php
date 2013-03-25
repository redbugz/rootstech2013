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
h4 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 100%;
}
h5 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 75%;
}
h6 {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 50%;
}
body, table   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #F5F5F5;
}
a   {
	color: #5f5f5f;
	text-decoration: none;
}
a:hover   {
	color: #0000a0;
	text-decoration: none;
}
a.hd_link {
	color: #5f5f5f;
	text-decoration: none;
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
	background-color: #FFFFFF;
}
table.header    {
    background-color: #D3DCE3;
	color: #000000;
}
th   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #D3DCE3;
}
td {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
}
td.tbl_even   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #DDDDDD;
}
td.tbl_odd   {
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: <?php echo $font_size; ?>;
	background-color: #CCCCCC;
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
.label {
font-style: oblique;
display: inline;
}
#useroptions ul {
margin: 1;
padding: 0;
}
#useroptions li {
float:left;
list-style-image:none;
list-style-position:outside;
list-style-type:none;
margin:5px;
padding:0px;
}
#options {
float: right;
position: relative;
}
#options ul {
margin: 0;
padding: 0;
}
#options li {
float:left;
list-style-image:none;
list-style-position:outside;
list-style-type:none;
margin:5px;
padding:0px;
}
#name {
text-align: center;
}
#name h2 {
margin: 0;
padding: 0;
}
div#bd {
padding: 5px 5px;
color:#000000;
font-family:verdana,Arial,Helvetica,sans-serif;
font-size: <?php echo $font_size; ?>;
position: relative;
left: 10%;
width: 80%;
display: block;
}
div.child {
display: block;
}
div.birth {
padding: 10px 10px;
width:40%;
top: 0;
float: left;
}
div.baptism {
width:40%;
float: left;
padding: 10px 10px;
}
div.death {
float: right;
top: 0;
padding: 10px 10px;
width:40%;
}
div.burial {
float: right;
width:40%;
padding: 10px 10px;
}
div#parents {
clear: both;
padding: 10px 10px;
margin-left: 15%;
float: none;
width: 70%;
display: block;
}
div.children {
padding: 10px 10px;
margin-left: 35%;
}
div#siblings {
padding: 10px 10px;
margin-left: 35%;
}
div.insert {
float: right;
}

#application span {
color: gray;
font-size: smaller;
font-variant: small-caps;
}