<?php

/**
 * this file tests the functionality of the FieldSet, RuleSet and FieldSetValidators
 *
 * @version $Id: FieldSetValidatorTest.php,v 1.1 2003/06/22 23:06:56 gabeschine Exp $
 * @copyright 2003 
 **/

require_once("utilities/FieldSetValidator/inc.php");
require_once("utilities/FieldSetValidator/rules/inc.php");
 
$a = array(	"string1"=>"this is string 1",
			"number1"=>60,
			"string2"=>"this is string 2, another string!",
			"name"=>"Gabe Schine",
			"email"=>"gschine@middlebury.edu",
			"boolean1"=>true,
			"blank1"=>"",
			"choice"=>"valid1",
			"array"=>"not an array"
			);
 
$f = & new FieldSet( $a );
//print_r($f->getKeys());
//print $f->get("string1");

//$e = & new Error;
$e = true; // for this test

$r = & new RuleSet;
$r->addRule("email", new EmailValidatorRule, $e);
$r->addRule("number1", new NumericValidatorRule, $e);
$r->addRule("blank1", new FieldRequiredValidatorRule, $e);
$r->addRule("boolean1", new BooleanValidatorRule, $e);
$r->addRule("choice", new ChoiceValidatorRule("valid1","valid2",50,20,array(5,10)), $e);
$r->addRule("array", new ArrayValidatorRuleWithRule(new NumericValidatorRule), $e);

$v = & new FieldSetValidator( $f, $r );

tryKey("number1");
$f->set("number1","not a number");
tryKey("number1");



tryKey("blank1");
//$f->set("blank1","not blank");
tryKey("blank1");



tryKey("email");
$f->set("email","bad!@email");
tryKey("email");

$f->set("choice",7);
$f->set("array",array(1,2,"not a number"));

$v->validateAll();

function tryKey($key) {
	return;
	global $v, $f;
	print "<br />$key = ".$f->get($key).": ";
    print ($v->validate($key)) ? "good" : "bad";
    print "<br />";
}
?>