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
$a->modCfg("passwordFieldEncrypted",false);
$a->modCfg("passwordEncryptionType","des");



$a->authUser("joe","test");

if ($a->isValid()) {
	print "You are valid: ".$a->getAgent();
	
} else print "You are not valid!";

print "<pre>";
print_r($a);