<?

require_once("configHandler/inc.php");

$c = & new configHandler();

$c->addAttr("testString:s:test1,test2,shit");
$c->addAttr("number1:n","nArray:n:array","number2:n:0,5,10");
$c->addAttr("anObject:o");

// the following line should throw an error
#$c->addAttr("nArray2:n:4,5,string");

print "Setting testString to 'test2': ";
$c->set("testString","test2");
print $c->get("testString");
print "<br>";

// the following line should throw an error
#$c->set("testString","aaaaah!");

print "Setting number1 to 56: ";
$c->set("number1",56);
print $c->get("number1");
print "<br>";
// the following line should throw an error
#$c->set("number1","a string");

print "Setting nArray to array(1,2,3,4): ";
$c->set("nArray",array(1,2,3,4));
print_r($c->get("nArray"));
print "<br>";
// the following line should throw an error
#$c->set("nArray","non-array value");

print "Creating new configHandler and passing it to 'anObject': ";
$t = & new configHandler();
$c->set("anObject",&$t);
$t->addAttr("string:s");
print_r($c->get("anObject"));
print "<br>";
// the following line should throw an error
#$c->set("anObject",array("bla"));

$num1 = 5;
$c->set("number1", & $num1);
$num2 = & $c->get("number1");
$num1 = 7;
print "$num1 - $num2<BR>";

print "<pre>";
print_r($c);

