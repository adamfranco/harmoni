<?

require_once("authHandler/inc.php");

$a = & new authHandler();

$a->addModule("local","db");
$a->modCfg("databaseType","mysql");
$a->modCfg("host","localhost");
$a->modCfg("username","root");
$a->modCfg("password","");
$a->modCfg("database","auth");
$a->modCfg("table","user");

$a->modCfg("usernameField","user_username");
$a->modCfg("passwordField","user_password");
$a->modCfg("otherFields",array("fullname"=>"user_fname","email"=>"user_email"));
$a->modCfg("passwordFieldEncrypted",false);
$a->modCfg("passwordEncryptionType","des"); // not implemented yet!



$a->authUser("gabe","x33dm1m");

if ($a->isValid()) {
	print "You are valid: ".$a->getAgent()."<BR>";
	print "full name: ".$a->getSingleExtra("fullname")."<BR>";
	print "email: ".$a->getSingleExtra("email")."<BR>";
	
} else print "You are not valid!";

print "<pre>";
print_r($a);