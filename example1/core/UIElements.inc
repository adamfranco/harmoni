<?php

# this file contains classes for displaying different UIs

class HorizontalMenu {

	var $items;
	
	function HorizontalMenu (& $items) {
		$thie->items = array();
		foreach ($items as $item) {
			$this->items.push ($item);
		}
	}
	
	function addItem (& $item) {
		$this->items.push ($item);
	}
	
	function addItems (& $items) {
		foreach ($items as $item) {
			$this->items.push ($item);
		}
	}
	
	function render ($itemSelected) {
		
	}
}

class VerticalTreeMenu {
	
	function VerticalTreeMenu () {
		
	}
	
	function setTree (& $tree) {
		
	}
	
	function render ($itemSelected) {
		
	}
	
}

class MenuTree {
	
	function MenuTree () {
		
	}
	
	function setData () {
		
	}
	
	function addChild () {
		
	}
	
	function getData () {
	
	}
	
	function getChildren () {
	
	}
}

class DisplayBox {

	var $content;
	
	function DisplayBox () {
		
	}
	
	function setContent ($content) {
		$this->content = $content;
	}
	
	function appendContent () {
		$this->content .= $content;
	}
	
	function render () {
		ob_start();
		?>
			<table class="border" width="100%">
				<tr>
					<td>
						<?= $this->content; ?>
					</td>
				</tr>
			</table>
		<?php
		$s = ob_get_contents();
		ob_end_clean();		
		return $s;
	}
}

class MenuItem {

	var $name;
	var $url;
	
	function MenuItem ($name, $link) {
		$this->name = $name;
		$this->url = $link;
	}
	
	function setName ($name) {
		$this->name = $name;
	}
	
	function setLink ($url) {
		$this->url = $url;
	}
	
	function getName () {
		return $this->name;
	}
	
	function getLink () {
		return $this->url;
	}
}

class UIElements {
	
	function importStyleSheet ($file) {
		?>
			<link rel="stylesheet" href="<?= $file; ?>" type="text/css">
		<?php
	}
		
}