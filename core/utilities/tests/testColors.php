<?php
/**
 * @package harmoni.utilities.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: testColors.php,v 1.5 2007/09/04 20:25:56 adamfranco Exp $
 */

define("HARMONI","../../");
require_once(HARMONI."utilities/HTMLcolor.class.php");

print "Creating new HTML color:<br />";
$c = new HTMLcolor("#abc");
$c1 = new HTMLcolor("69b");
$c2 = new HTMLcolor("#036");

print $c->getHTMLcolor() . " " . $c1->getHTMLcolor() . " " . $c2->getHTMLcolor() . "<br />";
?>
<style type='text/css'>
td {font-size: 10px; font-family: "Verdana";}
</style>
<?php
print "lightening...<br />";
print "<table width=100%><tr>";
for ($i = 0; $i < 50; $i++) {
	$c->lighten(5);
	if ($i==25) print "</tr><tr>";
	$col = $c->getHTMLcolor();
	print "<td bgcolor=#$col>$col</td>";
}
print "</tr></table>";

print "darkening...<br />";
print "<table width=100%><tr>";
$c->HTMLcolor("abc");
for ($i = 0; $i < 50; $i++) {
	$c->darken(3);
	if ($i==25) print "</tr><tr>";
	$col = $c->getHTMLcolor();
	$c->invert();
	$tcol = $c->getHTMLcolor();
	$c->invert();
	print "<td bgcolor=#$col style='color: $tcol'>$col</td>";
}
print "</tr></table>";

print "shifting red...<br />";
print "<table width=100%><tr>";
$c->HTMLcolor("369");
for ($i = 0; $i < 50; $i++) {
	$c->shiftRed(5);
	if ($i==25) print "</tr><tr>";
	$col = $c->getHTMLcolor();
	$c->invert();
	$tcol = $c->getHTMLcolor();
	$c->invert();
	print "<td bgcolor=#$col style='color: $tcol'>$col</td>";
}
print "</tr></table>";

print "shifting green...<br />";
print "<table width=100%><tr>";
$c->HTMLcolor("369");
for ($i = 0; $i < 50; $i++) {
	$c->shiftGreen(5);
	if ($i==25) print "</tr><tr>";
	$col = $c->getHTMLcolor();
	$c->invert();
	$tcol = $c->getHTMLcolor();
	$c->invert();
	print "<td bgcolor=#$col style='color: $tcol'>$col</td>";
}
print "</tr></table>";

print "shifting blue...<br />";
print "<table width=100%><tr>";
$c->HTMLcolor("369");
for ($i = 0; $i < 50; $i++) {
	$c->shiftBlue(5);
	if ($i==25) print "</tr><tr>";
	$col = $c->getHTMLcolor();
	$c->invert();
	$tcol = $c->getHTMLcolor();
	$c->invert();
	print "<td bgcolor=#$col style='color: $tcol'>$col</td>";
}
print "</tr></table>";

?>