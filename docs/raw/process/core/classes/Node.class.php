<?php

class Node {
	var $parent = null;
	var $next = null;
	var $prev = null;
	var $children = array();
	var $level = 0;
	
	function setParent(&$parent) {
		$this->parent =& $parent;
	}
	
	function addChild(&$child) {
		$num = $this->countChildren();
		$this->children[] =& $child;
		if ($num) {
			$child->prev =& $this->children[$num-1];
			$this->children[$num-1]->next =& $child;
		}
		$child->setParent($this);
		$child->level = $this->level + 1;
	}
	
	function countChildren() {
		return count($this->children);
	}
	
	function isRoot() {
		return($this->parent==null)? true : false;
	}
	
	function &getParent() {
		return $this->parent;
	}
	
	function &getFirstChild() {
		return $this->children[0];
	}
	
	function &getLastChild() {
		return $this->children[count($this->children)-1];
	}
}