require_once("/path/to/harmoni.inc.php");

// :: get all the services we need ::
$authHandler =& Services::getService("Authentication");
$dbHandler =& Services::getService("DBHandler");

// :: set up the database connection ::
$dbIndex = $dbHandler->addDatabase( 
			new MySQLDatabase(  "my.host.com", 
								"myAppDB", 
								"username", 
								"password") 
			);

// :: set up the DBAuthenticationMethod options ::
$options =& new DBMethodOptions;
$options->set("databaseIndex",$dbIndex);
$options->set("tableName", "users");
$options->set("usernameField", "users_username");
$options->set("passwordField", "users_password");

// :: the following options are not required, but suggested ::
$options->set("passwordFieldEncrypted", true); // default = false
$options->set("passwordFieldEncryptionType", "databaseMD5"); // options: databaseMD5, databaseSHA1, crypt

// :: create the DBAuthenticationMethod with the above options ::
$dbAuthMethod =& new DBAuthenticationMethod($options);

// :: add it to the handler ::
$authHandler->addMethod("someName",0,$dbAuthMethod);