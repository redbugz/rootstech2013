<?php
header("Content-Type: application/xml; charset=ISO-8859-1");  

include_once "modules/db/DAOFactory.php";

$search = new PersonDetail();
$search->queryType = Q_TYPE;
$search->person_id = 0;
$search->count = 20;
$search->order = " updated DESC";
$dao = getPeopleDAO();
$dao->getPersonDetails($search);


$now = date("D, d M Y H:i:s T");

$top = '<?xml version="1.0" encoding="utf-8"?>';
$top .= '<?xml-stylesheet title="XSL_formatting" type="text/xsl" href="rss/rss.xsl"?>';
$top .= '<?xml-stylesheet type="text/css" href="rss/identity.css"?>';

echo $top;

$config = Config::getInstance();

?>
<rss version="2.0">
  <channel>
    <title><?php echo $config->desc.' '.$strLast20; ?></title>
    <link><?php echo $config->absurl;?>rss.xml</link>
    <description>RSS feed <?php echo $config->desc.' '.$strLast20;?></description>
    <pubDate><?php echo $now;?></pubDate>
    <lastBuildDate><?php echo $now;?></lastBuildDate>

<?php
	foreach ($search->results AS $per) {
 ?>
<item xml:id="<?php echo $per->person_id; ?>" class="lotd">
      <title><?php echo htmlspecialchars(html_entity_decode($per->getDisplayName())); ?></title>
      <description><?php echo htmlspecialchars(html_entity_decode ($per->getFullLink())); ?></description>
      <link><?php echo htmlspecialchars(html_entity_decode ($per->getURL())); ?></link><?php
		list($date, $hours) = split(' ', $per->updated); 
		list($year,$month,$day) = split('-',$date); 
		list($hour,$min,$sec) = split(':',$hours); 
		//returns the date ready for the rss feed
		$date = date('r',mktime($hour, $min, $sec, $month, $day, $year)); 
?>
      <pubDate><?php echo $date; ?></pubDate>
      <guid><?php echo $per->getURL(); ?></guid>
    </item>
<?php } ?>
  </channel>
</rss>
