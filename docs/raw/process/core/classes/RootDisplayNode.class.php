<?php

class RootDisplayNode extends DisplayNode {
	function RootDisplayNode( &$domDoc, &$rootNode, $filePath ) {
		$this->domNode =& $rootNode;
		$this->domDoc =& $domDoc;
		$this->filePath = $filePath;
		
		$attr =& $rootNode->get_attribute_node("name");
		$manualName = $attr->get_content();
		
		print "Creating new Root Node for: $manualName\n";
		
		$toc =& new TOCnode($manualName, "index.html");
		$toc->number=0;
		$this->tocNode =& $toc;
	}
	
	function process() {
		$this->processChildren();
	}
	
	function output() {
		global $templates;
		$fp = files::openNode($this);
		$cssFp = files::open("common.css");
		
		$page =& $templates->newTemplate("page");
		$css =& $templates->newTemplate("css");
		$toc =& $templates->newTemplate("toc");
		// :: output the TOC
		
		$vars = $this->tocNode->mkTplArray();
		$vars["body"] = $toc->catchOutput(array(
		"toc"=>$this->tocNode->htmlTOC()));
		
		$content = $page->catchOutput($vars);
		
		fputs($cssFp,$css->catchOutput(array()));
		fputs($fp,$content);
		files::close($fp);
		files::close($cssFp);
		
		$this->outputChildren();
	}
}

class Chapter extends DisplayNode {
	var $version;
	
	function process() {
		// :: ok, let's now process
		$chldrn =& $this->domNode->children();
		for($i=0; $i<count($chldrn); $i++) {
			if ($chldrn[$i]->node_name() == "name") {
				$name = $chldrn[$i]->get_content();
				$chldrn[$i]->unlink_node();
			}
			if ($chldrn[$i]->node_name() == "version") {
				$this->version = $chldrn[$i]->get_content();
				$chldrn[$i]->unlink_node();
			}
		}
		if (!$name) doError("No <name> tag found in chapter!");
		
		print "New ".get_class($this).": $name\n";
		
		$toc =& new TOCnode($name,$this->tocNode->buildNextChildNumberString().".html");
		$this->tocNode->addChild($toc);
		$this->tocNode =& $toc;
		
		$this->processChildren();
	}
	
	function output() {
		global $templates;
		$fp = files::openNode($this);
		// :: output some chapter heading or something
		$page = $templates->newTemplate("page");
		$toc = $templates->newTemplate("toc");
		
		$vars = $this->tocNode->mkTplArray();
		$body = $toc->catchOutput(array("toc"=>$this->tocNode->htmlTOC()));
		
		$body .= "<div class='title'>Chapter ".$this->tocNode->number.": ".$this->tocNode->displayName."</div>\n";
		$body .= "<div class='content'>\n";
		
		ob_start();
		// :: do the children
		$this->outputChildren();
		$body .= ob_get_contents();
		ob_end_clean();
		
		$body .= "</div>\n";
		if ($this->version) {
			$body .= "<div class='version'>Version: ".$this->version."</div>";
		}
		
		$vars["body"] = $body;
		fputs($fp, $page->catchOutput($vars));
	}
}

class ChapterFile extends Chapter {
	function process() {
		$node =& $this->domNode;
		$toc =& $this->tocNode;
		
		$fileNode =& $node->get_attribute_node("file");
		
		$filename = $fileNode->get_content();
		$file = mkFile($this,$filename);
		if (!file_exists($file) || !is_file($file)) {
			doError("File '$filename' is not a valid file!");
		}
		
		$newDOM =& domxml_open_file($file);
		if (!$newDOM) doError("File '$filename' does not appear to be a valid XML file!");
		
		$rootNode =& $newDOM->root();
		if ($rootNode->name() != "chapter") {
			doError("<chapterfile> must specify a chapter XML file!");
		}
		
		//print "New chapter from file: $filename\n";
		
		$this->domNode =& $rootNode;
		$this->domDoc =& $newDOM;
		$this->filePath = $file;
		parent::process();
	}
	
	function output() {
		parent::output();
	}
}

class SubChapter extends Chapter {
	function output() {
		global $templates;
		$fp = files::openNode($this);
		// :: output some chapter heading or something
		$page = $templates->newTemplate("page");
		$toc = $templates->newTemplate("toc");
		
		$vars = $this->tocNode->mkTplArray();
		$body = $toc->catchOutput(array("toc"=>$this->tocNode->htmlTOC()));
		
		$body .= "<div class='title'>Subchapter ".$this->tocNode->buildFullNumber().": ".$this->tocNode->displayName."</div>\n";
		$body .= "<div class='content'>\n";
		
		ob_start();
		// :: do the children
		$this->outputChildren();
		$body .= ob_get_contents();
		ob_end_clean();
		
		$body .= "</div>";
		
		$vars["body"] = $body;
		fputs($fp, $page->catchOutput($vars));
		
		// :: now print something to appear in the parent chapter
		print "<div class='inlinetitle'>".$this->tocNode->buildFullNumber()." Subchapter: ".$this->tocNode->displayName."</div>\n";
		print "<p>This section is a subchapter. Below is its table of contents:</p>";
		print $this->tocNode->htmlTOC();
	}
}

class SubChapterFile extends SubChapter {
	function process() {
		$node =& $this->domNode;
		$toc =& $this->tocNode;
		
		$fileNode =& $node->get_attribute_node("src");
		
		$filename = $fileNode->get_content();
		$file = mkFile($this,$filename);
		if (!file_exists($file) || !is_file($file)) {
			doError("File '$filename' is not a valid file!");
		}
		
		$newDOM =& domxml_open_file($file);
		if (!$newDOM) doError("File '$filename' does not appear to be a valid XML file!");
		
		$rootNode =& $newDOM->root();
		if ($rootNode->name() != "subchapter") {
			doError("<subchapterfile> must specify a subchapter XML file!");
		}
		
		//print "New subchapter from file: $filename\n";
		
		$this->domNode =& $rootNode;
		$this->domDoc =& $newDOM;
		$this->filePath = $file;
		parent::process();
	}
}

class Section extends DisplayNode {
	function process() {
		// :: ok, let's now process
		$chldrn =& $this->domNode->children();
		for($i=0; $i<count($chldrn); $i++) {
			if ($chldrn[$i]->node_name() == "name") {
				$name = $chldrn[$i]->get_content();
				$chldrn[$i]->unlink_node();
			}
		}
		if (!$name) doError("No <name> tag found in section!");
		
		//print "New section: $name\n";
		
		$toc =& new TOCnode($name,$this->tocNode->link."#".ereg_replace("[^[:alnum:]]","",$name));
		
		$this->tocNode->addChild($toc);
		$this->tocNode =& $toc;
		
		$this->processChildren();
	}
	
	function output() {
		print "<div class='inlinetitle'>".$this->tocNode->buildFullNumber()." <a name='".
		ereg_replace("[^[:alnum:]]","",$this->tocNode->displayName)."'>".
		$this->tocNode->displayName."</a></div>\n";
		print "<div class='section'>\n";
		$this->outputChildren();
		print "</div>\n";
	}
}

/* :: The actual content classes :: */

class InlineText extends DisplayNode {
	function process() {
		$text = $this->domNode->get_content();
		if (ereg("\w",$text)) {
			print "Ignoring InlineText: '$text'\n--> it should be within 'p' tags.\n\n";
		}
	}
	
	function output() { /* blank */ }
}

class NullMe extends DisplayNode {
	function process() {
		// :: do nothing!
	}
	
	function output() {
		// :: do nothing!
	}
}

class TextBlock extends DisplayNode {
	var $text;
	function process() {
		//print "paragraph... ";
		$this->text = domxml_dump_node($this->domDoc, $this->domNode);
	}
	
	function output() {
		print "<p>" . $this->text . "</p>\n";
	}
}

class Heading extends DisplayNode {
	var $text;
	function process() {
		//print "heading... ";
		$this->text = $this->domNode->get_content();
	}
	
	function output() {
		print "<div class='heading'>:: ".$this->text." ::</div>\n";
	}
}

class Note extends DisplayNode {
	var $text;
	function process() {
		//print "note... ";
		$this->text = domxml_dump_node($this->domDoc, $this->domNode);
	}
	
	function output() {
		print "<div class='padding'><div class='notetitle'>NOTE</div><div class='note'>".$this->text."</div></div>\n";
	}
}

class FormattedTextBlock extends TextBlock {
	function process() {
		$this->text = $this->domNode->get_content();
	}
	
	function output() {
		$t = $this->text;
		$t = ereg_replace(
		"^[\t\n\r ]*","",
		ereg_replace(
		"[\t\n\r ]*$","",$t
		)
		);
		$t = ereg_replace("\n$","",$t);
		$t = str_replace(" ","&nbsp;",$t);
		$t = str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$t);
		$t = str_replace("\n","<br />",$t);
		print "<div class='block'><code>".$t."</code></div>\n";
	}
}

class Example extends DisplayNode {
	var $text = "";
	var $allPHP = true;
	
	function process() {
		//$text = $this->domNode->get_content();
		$children =& $this->domNode->children();
		for ($i=0; $i<count($children); $i++) {
			$c =& $children[$i];
			if ($c->node_type() == XML_TEXT_NODE) {
				$text .= $c->get_content();
			} elseif ($c->node_type() == XML_ELEMENT_NODE && $c->node_name() == "file") {
				$filename = $c->get_content();
				$file = mkFile($this,"examples".DIRECTORY_SEPARATOR.$filename);
				if (!file_exists($file)) doError("Example: file '$file' does not exist!");
				$text = file_get_contents($file);
			} else {
				doError("Example::process - don't know what to do with '".$c->node_name()."'");
			}
		}
		//print "example ... ";
		$this->text = $text;
		
		// :: 'allPHP' attribute
		if ($attr =& $this->domNode->get_attribute("allPHP")) {
			$val =& $attr->get_content();
			if ($val == "no") $this->allPHP = false;
		}
	}
	
	function output() {
		// :: add the <?php crap
		$t = $this->text;
		$t = ereg_replace("^[\t\n ]+","",$t);
		$t = ereg_replace("[\t ]+$","",$t);
		if ($this->allPHP) $t = "<?php".$t;
		$h = highlight_string($t,true);
		if ($this->allPHP) $f = ereg_replace("&lt;\?php(<br />)?","",$h);
		print "<div class='padding'><div class='notetitle'>Example</div><div class='example'>$f</div></div>\n";
	}
}

class Term extends DisplayNode {
	var $term;
	var $defs=array();
	
	function process() {
		$children =& $this->domNode->children();
		
		for ($i=0; $i<count($children); $i++) {
			$c =& $children[$i];
			if ($c->node_type() == XML_ELEMENT_NODE) {
				if ($c->node_name() == "term") {
					$this->term = $c->get_content();
				}
				if ($c->node_name() == "def") {
					$this->defs[] = $c->get_content();
				}
			}
		}
	}
	
	function output() {
		print "<div class='term'>".$this->term."</div>\n";
		foreach ($this->defs as $def)
		print "<div class='def'>$def</div>\n";
	}
}