<?php

function doPrint(&$e, $l) {
	if ($e->type == 1) {
		for($i=0;$i<$l;$i++) print "\t";
		print $e->tagname;
		if ($e->tagname == "p") {print domxml_dump_node($GLOBALS['dom'],$e);return;}
		print "\n";
	}
	if ($e->type == 3) {
		if (!ereg("^\s*$",$e->content)) {
			for($i=0;$i<$l;$i++) print "\t";
			print "Text: ".$e->content."\n";
		}
	}
	if ($e->has_child_nodes()) {
		$children = $e->child_nodes();
		for($i=0; $i<count($children); $i++) {
			doPrint($children[$i],$l+1);
		}
	}
}

print "Opening document...\n";
$dom =& domxml_open_file("manual/01-Introduction.xml");
//print $dom->dump_node();
//$dom->validate("dtds/chapter.dtd);
//print_r($dtd = $dom->dtd());

print "<pre>";
print XML_ELEMENT_NODE . "\n";
print XML_ATTRIBUTE_NODE . "\n";
$root =& $dom->get_root();
//doPrint($root,0);



print "<pre>";
$c=$root->children();
$c1 = $c[0];
$attr=$root->get_attribute_node("name");
print_r(get_class_methods(get_class($dom)));
print_r($dom->domdocument());

?>