<?php

class TOCnode extends Node {
	var $parent = null;
	var $children = array(); // array
	var $next = null;
	var $prev = null;
	var $level = 0;
	
	var $number = 1;
	var $displayName;
	var $link;
	
	function TOCnode($name, $link) {
		$this->displayName = $name;
		$this->link = $link;
	}
	
	function addChild(&$child) {
		$num = $this->countChildren();
		if ($num) {
			$child->number = $this->children[$num-1]->number + 1;
			$child->level = $this->level + 1;
		}
		parent::addChild($child);
	}
	
	function buildFullNumber() {
		$str = '';
		if ($this->number == 0) return $str; //:: root node
		if ($this->parent) {
			$str .= $this->parent->buildFullNumber() . ".";
		}
		
		$str .= $this->number;
		$str = ereg_replace("^\.","",$str); // :: lob off leading '.'
		return $str;
	}
	
	function buildNextChildNumberString() {
		$str = $this->buildFullNumber();
		if ($str) $str.=".";
		
		$num = $this->countChildren();
		if ($num) {
			$str .= $num+1;
		} else $str .= "1";
		$str = ereg_replace("^\.","",$str); // :: lob off leading '.'
		return $str;
	}
	
	function getFile() {
		$link = ereg_replace("\#.+","",$this->link);
		return $link;
	}
	
	function txtTOC($level = 0) {
		// :: print me out
		for ($i=0; $i<$level; $i++) print "  ";
		print $this->buildFullNumber();
		print " ";
		print $this->displayName;
		print "\n";
		
		// :: print kids
		foreach ($this->children as $child) {
			$child->txtTOC($level+1);
		}
	}
	
	function mkLink($str) {
		return "<a href='".$this->link."'>$str</a> (".$this->displayName.")";
	}
	
	function toString() {
		return ($this->buildFullNumber() . " <a href='" . $this->link
		. "'>" . $this->displayName . "</a>");
	}
	
	function htmlTOC($level = 0) {
		// :: print me out
		$class = "toc";
		if (!$level) $class.="0";
		$str = "<div class='$class'>\n";
		$str .= $this->toString();
		$str .= "<br/>\n";
		
		// :: print kids
		foreach ($this->children as $child) {
			$str .= $child->htmlTOC($level + 1);
		}
		$str .= "</div>\n";
		return $str;
	}
	
	function &nextOverall($down=true) {
//		print "child ... ";
		if ($down && $this->countChildren()) return $this->getFirstChild();
//		print "next ... ";
		if ($this->next) return $this->next;
//		print "parent ... ";
		if ($this->parent) return $this->parent->nextOverall(false);
//		print "fail\n";
		return false;
	}
	
	function &prevOverall() {
		if ($this->prev) return $this->prev;
		if ($this->parent) return $this->parent->prevOverall();
		return false;
	}
	
	function &nextPageChange() {
		$next =& $this->nextOverall();
		if ($next) {
			if ($next->getFile() != $this->getFile()) return $next;
			return $next->nextPageChange();
		}
		return false;
	}
	
	function &prevPageChange() {
		$prev =& $this->prevOverall();
		if ($prev) {
			if ($prev->getFile() != $this->getFile()) return $prev;
			return $prev->prevPageChange();
		}
		return false;
	}
	
	function mkTplArray() {
		$a = array(
			"title"=>$this->displayName);
		if ($prev =& $this->prevPageChange())
			$a["prev"] = $prev->mkLink("prev");
		
		if ($next =& $this->nextPageChange())
			$a["next"] = $next->mkLink("next");
		
		if ($this->parent)
			$a["parent"] = $this->parent->mkLink("up");
		
		return $a;
	}
}
?>