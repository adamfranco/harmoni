<?php

class DisplayNode extends Node {
	var $text;
	var $domNode;
	var $tocNode;
	var $domDoc;
	var $filePath;
	
	function init( &$domDoc, &$node, &$toc, $filePath ) {
		$this->domDoc = $domDoc;
		$this->domNode =& $node;
		$this->tocNode =& $toc;
		$this->filePath = $filePath;
	}
	
	function processChildren() {
		global $handlerClasses;
		$node =& $this->domNode;
		$toc =& $this->tocNode;
		$children =& $node->children();
		for ($i=0; $i<count($children); $i++) {
			$elementName = $children[$i]->node_name();
//			if ($elementName == "name") continue; // ignore the "name" element
			$handler = $handlerClasses[$elementName];
			if (!$handler) doError("Unknown element: '$elementName'.");
			//	print "Found: $handler\n";
			$class =& new $handler;
			$this->addChild($class);
			$class->init($this->domDoc, $children[$i], $toc, $this->filePath);
			$class->process();
		}
	}
	
	function outputChildren() { 
		$child =& $this->getFirstChild();
		while ($child) {
			$child->output();
			$child =& $child->next;
		}
	}
}