<?php
// +-----------------------------------------------------------------------+
// | Copyright (c) 2002-2003, Richard Heyes                                |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.|
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <richard@phpguru.org>                           |
// +-----------------------------------------------------------------------+

/**
* A Tree class. I wrote this as my other OO Tree class is a tad slow for
* larger tree structures. This shouldn't have that problem as it is array
* based.
* If you use this class and wish to show your appreciation then visit my
* wishlist here:   http://www.amazon.co.uk/exec/obidos/wishlist/S8H2UOGMPZK6
*
* Structure
* =========
* There are two arrays in the object which are used for structure, and another
* which holds the node data. The "structure" array holds a simple mapping of
* node id to node parent id, where the array key is the node id, and the value
* is the parent id. The "childIDs" array is a mapping of node ids and their
* child node ids. The key is the node id, and the value an indexed array of
* the child node ids. You should though never access these directly, and always
* use the methods.
*
* Usage:
* For a tree with this structure:
*   Node1
*   Node2
*   Node3
*    +-Node3_1
*    |  +-Node3_1_1
*    +-Node3_2
*
*   $tree      = new Tree();
*   $node1     = $tree->addNode('1');
*   $node2     = $tree->addNode('2');
*   $node3     = $tree->addNode('3');
*   $node3_1   = $tree->addNode('3_1', $node3);     // Pass parent node id as second argument
*   $node3_2   = $tree->addNode('3_2', $node3);     // Pass parent node id as second argument
*   $node3_1_1 = $tree->addNode('3_1_1', $node3_1); // Pass parent node id as second argument
*   print_r($tree);
* 
* The data for a node is supplied by giving it as the argument to the addNode() method.
* You can retreive the data by using the getTag() method to which you supply the node id as 
* an argument, and alter it using the setTag() method (again, pass the node id as an argument).
*
*   &createFromList(array data [, string separator])          (static) Returns a tree structure create from the supplied list
*   &createFromMySQL(array $params)                           (static) Returns a tree structure created using a common DB storage technique
*   &createFromXMLTree(object $xmlTree [, bool $ignoreRoot])  (static) Returns a tree structure created using an PEAR::XML_Tree object
*   &createFromFileSystem(string $path [, bool $includeRoot]) (static) Returns a tree structure created from the given filesystem path
*
*   addNode(mixed data [, integer parent_id])                Adds a node to the collection
*   removeNode(integer node_id)                              Removes the given node
*   totalNodes()                                             Returns the total number of nodes in the tree currently
*   getData(integer node_id)                                 Retreives the tag data
*   setData(integer node_id, mixed data)                     Sets the tag data
*   getParentID(integer node_id)                             Returns the nodes parent id
*   depth(integer node_id)                                   Returns the depth of this node in the tree (zero based)
*   isChildOf(integer node_id, integer parent_id)            Returns whether the node id is a direct child of the given parent id
*   hasChildren(integer node_id)                             Returns whether the node id has child nodes or not
*   numChildren(integer node_id)                             Returns number of child nodes the node id has
*   getChildren(integer node_id)                             Returns an array of the child node ids for the given node id
*   moveChildrenTo(integer parent_id, integer new_parent_id) Moves child nodes of the given parent id to the given new parent id
*   copyChildrenTo(integer parent_id, integer new_parent_id) Copies child nodes of the given parent id to the given new parent id
*   prevSibling(integer node_id)                             Retrieves the id of the previous sibling of the given node id
*   nextSibling(integer node_id)                             Retrieves the id of the next sibling of the given node id
*   moveTo(integer node_id, integer new_parent_id)           Moves the given node id to be a child of the given new parent id
*   copyTo(integer node_id, integer new_parent_id)           Copies the given node id to be a child of the given new parent id
*   firstNode([integer parent_id])                           Retrieves the id of the first child node of the given parent id
*   lastNode([integer parent_id])                            Retrieves the id of the last child node of the given parent id
*   getNodeCount([integer node_id])                          Retreives the number of nodes in the tree, optionally starting beneath the given node id
*   getFlatList([integer node_id])                           Retrieves an indexed array of the node ids from top to bottom, left to right, optionally starting at the given node id
*   traverse(callback function)                              Traverses the tree suppling each node id (and tree object) to the callback function
*   search(mixed searchData [, bool strict])                 Basic search function for searching the nodes' data
*/

/******************************************************************************
 * Changes by Adam Franco:
 * - Added nodeExists function
 * - '=' changed to '=&' $data containing objects
 ******************************************************************************/


class Tree
{
	/**
	* Next available node id
    * @var integer
    */
	var $uid;

	/**
	* Stores a node id (key) to parent node id
	* (value) relation
    * @var array
    */
	var $structure;
	
	/**
	* Stores a node id (key) to indexed array of
	* child node ids (value)
    * @var array
    */
	var $childIDs;
	
	/**
	* Stores the node data
    * @var array
    */
	var $data;

	/**
    * Constructor. Inits the variables
    */
	function Tree()
	{
		$this->structure = array();
		$this->data      = array();
		$this->uid       = 1;
	}
	
    /**
    * Creates a tree structure from a list of items.
    * Items must be separated using the supplied separator.
    * Eg:    array('foo',
    *              'foo/bar',
    *              'foo/bar/jello',
    *              'foo/bar/jello2',
    *              'foo/bar2/jello')
    *
    * Would create a structure thus:
    *   foo
    *    +-bar
    *    |  +-jello
    *    |  +-jello2
    *    +-bar2
    *       +-jello
    * 
    * Example code:
    *   $list = array('Foo/Bar/blaat', 'Foo', 'Foo/Bar', 'Foo/Bar/Jello', 'Foo/Bar/Jello2', 'Foo/Bar2/Jello/Jello2');
    *   $tree = Tree::createFromList($list);
    *
    * @param  array  $data      The list as an indexed array
    * @param  string $separator The separator to use
    * @return object            A tree structure (Tree object)
    */
    function &createFromList($data, $separator = '/')
    {
		$nodeList = array();
        $tree     =& new Tree();

        for ($i=0; $i<count($data); $i++) {
            $pathParts = explode($separator, $data[$i]);

            // If only one part then add it as a root node if
            // it's not already present.
            if (count($pathParts) == 1) {
                if (!empty($nodeList[$pathParts[0]])) {
                    continue;
                } else {
					$nodeList[$pathParts[0]] = $tree->addNode(array($pathParts[0], $data[$i]));
                }

            // Multiple parts means each part/parent combination
            // needs checking to see if it needs adding.
            } else {
                $parentID = 0;

                for ($j=0; $j<count($pathParts); $j++) {
                    $currentPath = implode($separator, array_slice($pathParts, 0, $j + 1));
                    if (!empty($nodeList[$currentPath])) {
                        // Update parent object to be the existing node
                        $parentID = $nodeList[$currentPath];
                        continue;
                    } else {
						$parentID = $nodeList[$currentPath] = $tree->addNode(array($pathParts[$j], $currentPath), $parentID);
                    }
                }
            }
        }
        
        return $tree;
	}

    /**
    * This method imports a tree from a database using the common
    * id/parent_id method of storing the structure. Example code:
    *
    * $tree = &Tree::createFromMySQL(array('host'     => 'localhost',
    *                                      'user'     => 'root',
    *                                      'pass'     => '',
    *                                      'database' => 'treetest',
    *                                      'query'    => 'SELECT id, parent_id, text, icon, expandedIcon FROM structure ORDER BY parent_id, id'));
    *
    * @param array $params An associative array of information which can
    *                      consist of the following:
    *                      host       Hostname to use for connection
    *                      user       Username to use for connection
    *                      pass       Password to use for connection
    *                      connection In place of the above, you can instead supply
    *                                 this, which must be a mysql connection resource.
    *                      database   The database to use.
    *                      query      The query to perform. This must return
    *                                 at least two columns, "id", and "parent_id".
    *                                 other columns will be used as tag data. An example:
    *                                 SELECT id, parent_id FROM structure ORDER BY parent_id, id
    *                                 The query MUST be ordered by parent_id, then id.
    */
    function &createFromMySQL($params)
    {
        $tree     = &new Tree();
        $nodeList = array();

        // Connect to server and select db
        if (!isset($params['connection'])) {
            $connection = mysql_connect($params['host'], $params['user'], $params['pass']);
            mysql_select_db($params['database']);
        } else {
            $connection = $params['connection'];
            if (!empty($params['database'])) {
                mysql_select_db($params['database']);
            }
        }

        // Perform query
        if ($result = mysql_query($params['query'])) {
            if (mysql_num_rows($result)) {

                // Loop thru results
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    // Parent id is 0, thus root node.
                    if (!$row['parent_id']) {
                        unset($row['parent_id']);
						$nodeList[$row['id']] = $tree->addNode($row);

                    // Parent node has already been added to tree
                    } elseif (!empty($nodeList[$row['parent_id']])) {
                        $parentID = $nodeList[$row['parent_id']];
                        unset($row['parent_id']);
						$nodeList[$row['id']] = $tree->addNode($row, $parentID);
                        
                    } else {
                        // Orphan node ?
                    }
                }
            }
        }
        
        return $tree;
	}

	/**
    * Creates a tree from an PEAR::XML_Tree object. "name", "content"
	* and "attributes" from the XML_Tree object are added as an array
	* as the tag data.
	*
	* @param  object  $xmlTree    The PEAR::XML_Tree object
	* @param  boolean $ignoreRoot Whether to ignore the root XML element
	* @return object              The Tree object
    */
	function &createFromXMLTree($xmlTree, $ignoreRoot = false)
	{
		$tree     = &new Tree();
		$parentID = 0;
		
		if (!$ignoreRoot) {
			Tree::_addXMLChildNodes($tree, $parentID, array(&$xmlTree->root));
		} else {
			Tree::_addXMLChildNodes($tree, $parentID, $xmlTree->root->children);
		}
		
		return $tree;
	}

	/**
    * Private helper function for the public createFromXMLTree() method.
	*
	* @access private
    */
	function _addXMLChildNodes(&$tree, $parentID, $xmlNodes)
	{
		foreach ($xmlNodes as $node) {
			if (!empty($node->name)) {
				$data = array('name' => $node->name, 'content'    => $node->content, 'attributes' => $node->attributes);
				$newID = $tree->addNode($data, $parentID);
			} else {
				$data = $tree->getData($parentID);
				$data['content'] .= $node->content;
				$tree->setData($parentID,  $data);
			}

			if (!empty($node->children)) {
				Tree::_addXMLChildNodes($tree, $newID, $node->children);
			}
		}
	}
	
	/**
    * Creates and returns a tree object from the filesystem, starting from
	* the supplied path. Including the supplied path if it is a directory
	* is optional. If starting point doesn't exist, or it contains no files
	* (assuming it's a dir) an empty Tree object will be returned.
	*
	* @param  string $path              Starting path (usually a dir)
	* @param  bool   $includeStartPoint Whether to include the starting dir
	* @return object                    The Tree object
    */
	function &createFromFileSystem($path, $includeStartPoint = false)
	{
		$tree = &new Tree();
		
		$path = preg_replace('/\/$/', '', realpath($path));

		if (file_exists($path) AND is_readable($path)) {
			$parentID = 0;
			if (is_dir($path) AND $includeStartPoint) {
				$parentID = $tree->addNode(array(basename($path), $path));
			}
			Tree::_addFiles($tree, $parentID, $path);
		}
		
		return $tree;
	}
	
	/**
    * Helper method for createFromFileSystem()
	*
	* @access private
    */
	function _addFiles(&$tree, $parentID, $path)
	{
		if (is_dir($path)) {
			$dir = opendir($path);
			while ($filename = readdir($dir)) {
				if ($filename == '.' OR $filename == '..') {
					continue;
				}
				
				$fullFilename = $path . DIRECTORY_SEPARATOR . $filename;

				// Directory
				if (is_dir($fullFilename) AND is_readable($fullFilename)) {
					$newNodeID = $tree->addNode(array($filename, $fullFilename), $parentID);
					Tree::_addFiles($tree, $newNodeID, $fullFilename);

				// Regular file
				} elseif (is_readable($fullFilename)) {
					$newNodeID = $tree->addNode(array($filename, $fullFilename), $parentID);
				}
			}
		}
	}

	/**
    * Adds a node to the tree.
	* 
	* @param mixed   $data     The data that pertains to this node
	* @param integer $parentID Optional parent node ID
    */
	function addNode(& $data = null, $parentID = 0)
	{
		$newID = $this->uid++;

		// Setup parent/child relationship
		$this->childIDs[$parentID][] = $newID;

		// Add to list of nodes
		$this->structure[$newID] = $parentID;
		
		// Add data
		$this->data[$newID] =& $data;
		
		// Return new id
		return $newID;
	}

	/**
    * Removes the node with given id. All child
	* nodes are also removed.
	* 
	* @param integer $id Node ID
    */
	function removeNode($id)
	{
		// Remove child nodes first
		if (isset($this->childIDs[$id])) {
			foreach ($this->childIDs[$id] as $childID) {
				$this->removeNode($childID);
			}
		}

		// Remove info from childIDs array
		if (!is_null($parentID = $this->getParentID($id))) {
			foreach ($this->childIDs[$parentID] as $k => $v) {
				if ($v == $id) {
					unset($this->childIDs[$parentID][$k]);

					// Clean up
					if (count($this->childIDs[$parentID]) == 0) {
						unset($this->childIDs[$parentID]);
					} else {
						$this->childIDs[$parentID] = array_values($this->childIDs[$parentID]);
					}
					break;
				}
			}
		}

		// Remove childIDs data
		if (isset($this->childIDs[$id])) {
			unset($this->childIDs[$id]);
		}

		// Remove data
		if (isset($this->data[$id])) {
			unset($this->data[$id]);
		}

		// Remove from structure array
		if (isset($this->structure[$id])) {
			unset($this->structure[$id]);
		}
	}
	
	/**
    * Returns total number of nodes in the tree
	*
	* @return integer Number of nodes in the tree
    */
	function totalNodes()
	{
		return count($this->structure);
	}
	
	/**
    * Gets the data associated with the given
	* node ID.
	* 
	* @param  integer $id Node ID
	* @return mixed       The data
    */
	function & getData($id)
	{
		return isset($this->data[$id]) ? $this->data[$id] : null;
	}
	
	/**
    * Sets the data associated with the given
	* node ID.
	* 
	* @param integer $id Node ID
    */
	function setData($id, & $data)
	{
		$this->data[$id] =& $data;
	}
	
	/**
    * Returns parent id of the node with
	* given id.
	* 
	* @param  integer $id Node ID
	* @return integer     The parent ID
    */
	function getParentID($id)
	{
		if (isset($this->structure[$id])) {
			return $this->structure[$id];
		}
		
		return null;
	}
	
	/**
    * Returns the depth in the tree of the node with
	* the supplied id. This is a zero based indicator,
	* so root nodes will have a depth of 0 (zero).
	*
	* @param  integer $id Node ID
	* @return integer     The depth of the node
    */
	function depth($id)
	{
		$depth  = 0;
		$currID = $id;

		while (isset($this->structure[$currID]) AND $this->structure[$currID] != 0) {
			$depth++;
			$currID = $this->structure[$currID];
		}
		
		return $depth;
	}
	
	/**
    * Returns true/false as to whether the node with given ID is a child
	* of the given parent node ID.
	*
	* @param  integer $id       Node ID
	* @param  integer $parentID Parent node ID
	* @return bool              Whether the ID is a child of the parent ID
    */
	function isChildOf($id, $parentID)
	{
		return $this->getParentID($id) == $parentID;
	}
	
	/**
    * Returns true or false as to whether the node
	* with given ID has children or not. Give 0 as
	* the id to determine if there are any root nodes.
	* 
	* @param  integer $id Node ID
	* @return bool        Whether the node has children
    */
	function hasChildren($id)
	{
		return !empty($this->childIDs[$id]);
	}
	
	/**
    * Returns the number of children the given node ID
	* has.
	* 
	* @param  integer $id Node ID
	* @return integer     Number of child nodes
    */
	function numChildren($id)
	{
		return count(@$this->childIDs[$id]);
	}
	
	/**
    * Returns an array of the child node IDs pertaining
	* to the given id. Returns an empty array if there
	* are no children.
	* 
	* @param  integer $id Node ID
	* @return array       The child node IDs
    */
	function getChildren($id)
	{
		if ($this->hasChildren($id)) {
			return $this->childIDs[$id];
		}
		
		return array();
	}
	
	/**
    * Moves all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function moveChildrenTo($parentID, $newParentID)
	{
		foreach ($this->getChildren($parentID) as $childID) {
			$this->moveTo($childID, $newParentID);
		}
	}
	
	/**
    * Copies all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function copyChildrenTo($parentID, $newParentID)
	{
		foreach ($this->getChildren($parentID) as $childID) {
			$this->CopyTo($childID, $newParentID);
		}
	}
	
	/**
    * Returns the ID of the previous sibling to the node
	* with the given ID, or null if there is no previous
	* sibling.
	* 
	* @param  integer $id Node ID
	* @return integer     The previous sibling ID
    */
	function prevSibling($id)
	{
		$parentID = $this->getParentID($id);
		$siblings = $this->getChildren($parentID);
		
		if (count($siblings) > 1) {
			for ($i=0; $i<count($siblings); $i++) {
				if ($siblings[$i] == $id AND $i != 0) {
					return $siblings[$i - 1];
				}
			}
		}
		
		return null;
	}
	
	/**
    * Returns the ID of the next sibling to the node
	* with the given ID, or null if there is no next
	* sibling.
	* 
	* @param  integer $id Node ID
	* @return integer     The next sibling ID
    */
	function nextSibling($id)
	{
		$parentID = $this->getParentID($id);
		$siblings = $this->getChildren($parentID);
		
		if (count($siblings) > 1) {
			for ($i=0; $i<count($siblings); $i++) {
				if ($siblings[$i] == $id AND $i != (count($siblings) - 1)) {
					return $siblings[$i + 1];
				}
			}
		}
		
		return null;
	}
	
	/**
    * Moves a node to a new parent. The node being
	* moved keeps it child nodes (they move with it
	* effectively).
	*
	* @param integer $id       Node ID
	* @param integer $parentID New parent ID
    */
	function moveTo($id, $parentID)
	{
		$currentParentID = $this->getParentID($id);
		
		if (!is_null($currentParentID)) {
			foreach ($this->childIDs[$currentParentID] as $k => $v) {
				if ($v == $id) {
					unset($this->childIDs[$currentParentID][$k]);
					$this->childIDs[$currentParentID] = array_values($this->childIDs[$currentParentID]);
				}
			}
			
			$this->childIDs[$parentID][] = $id;
			$this->structure[$id]        = $parentID;
		}
	}
	
	/**
    * Copies this node to a new parent. This copies the node
	* to the new parent node and all its child nodes (ie
	* a deep copy). Technically, new nodes are created with copies
	* of the data, since this is for all intents and purposes
	* the only thing that needs copying.
	*
	* @param integer $id       Node ID
	* @param integer $parentID New parent ID
    */
	function copyTo($id, $parentID)
	{
		$newID = $this->addNode($this->getData($id), $parentID);
		
		foreach ($this->getChildren($id) as $childID) {
			$this->copyTo($childID, $newID);
		}
		
		return $newID;
	}
	
	/**
    * Returns the id of the first node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer           The node ID
    */
	function firstNode($parentID = 0)
	{
		if (isset($this->childIDs[$parentID][0])) {
			return $this->childIDs[$parentID][0];
		}
		
		return null;
	}
	
	/**
    * Returns the id of the last node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer The node ID
    */
	function lastNode($parentID = 0)
	{
		if (count($this->childIDs[$parentID]) > 0) {
			return $this->childIDs[$parentID][count($this->childIDs[$parentID]) - 1];
		}

		return null;
	}
	
	/**
    * Returns the number of nodes in the tree, optionally
	* starting at (but not including) the supplied node ID.
	*
	* @param  integer $id The node ID to start at
	* @return integer     Number of nodes
    */
	function getNodeCount($id = 0)
	{
		$childNodes = $this->getChildren($id);
		$nodeCount = count($childNodes);
		
		foreach ($childNodes as $nodeID) {
			$nodeCount += $this->getNodeCount($nodeID);
		}
		
		return $nodeCount;
	}
    
    /**
    * Returns a flat list of the nodes, optionally beginning at the given
	* node ID.
    *
    * @return array Flat list of the node IDs from top to bottom, left to right.
    */
    function getFlatList($id = 0)
    {
        $return = array();

		if (!empty($this->childIDs[$id])) {
			foreach ($this->childIDs[$id] as $childID) {
				$return[] = $childID;
				// Recurse ?
				if (!empty($this->childIDs[$childID])) {
					$return = array_merge($return, $this->getFlatList($childID));
				}
			}
		}
		
		return $return;
	}

    /**
    * Traverses the tree applying a function to each and every node.
    * The function name given (though this can be anything you can supply to 
    * call_user_func(), not just a name) should take two arguments. The first
	* is this tree object, and the second is the ID of the current node. This
	* way you can get the data for the nodes in your function by doing
	* $tree->getData($id). The traversal goes from top to bottom, left to right
    * (ie same order as what you get from getFlatList()).
    *
    * @param callback $function The callback function to use
    */
    function traverse($function)
    {
		$nodeIDs = $this->getFlatList();
		
		foreach ($nodeIDs as $id) {
			call_user_func($function, $this, $id);
		}
    }

	/**
    * Searches the node collection for a node with a tag matching
	* what you supply. This is a simply "tag == your data" comparison, (=== if strict option is applied)
	* and more advanced comparisons can be made using the traverse() method.
	* This function returns null if nothing is found, and the first node ID found if a match is made.
	*
	* @param  mixed $data   Data to try to find and match
	* @param  mixed $strict Whether to use === or simply == to compare
	* @return mixed         Null if no match or the first node ID if a match is made
    */
	function &search(& $data, $strict = false)
	{
		$nodeIDs = $this->getFlatList();
		
		foreach ($nodeIDs as $id) {
			if ($strict ? ($this->getData($id) === $data) : ($this->getData($id) == $data)) {
				return $id;
			}
		}
	
		return null;
	}

	/**
    * Returns whether or not a node of the supplied id exists in the tree.
	*
	* @author Adam Franco <adam@adamfranco.com>
	* @since 2003-10-01
	*
	* @param  integer $id The node ID to look for
	* @return boolean     True if the node exists in the tree.
    */	
	function nodeExists($id) {
		if (in_array($this->structure))
			return true;
		else
			return false;
	}
}
?>