<?php

class JavaPOCSharedManager {
	var $_javaClassName;
	var $_javaClass;
	
	function JavaPOCSharedManager( $className ) {
		$this->_javaClassName = $className;
		$testClass = new Java($className);
		$ex = java_last_exception_get();
		if ($ex) die("Could not instantiate '$className' (Java): ".$ex->toString);
		java_last_exception_clear();
		
		$this->_javaClass =& $testClass;
	}
	
	// public Agent & createAgent(Type & $agentType, String $name);
	function & createAgent(& $agentType, $name) {
		return $this->_javaClass->createAgent($agentType, $name);
	}

	// public void deleteAgent(Id & $id);
	function deleteAgent(& $id) {
		$this->_javaClass->deleteAgent($id);
	}

	// public Agent & getAgent(Id & $id);
	function & getAgent(& $id) {
		return $this->_javaClass->getAgent($id);
	}

	// public AgentIterator & getAgents();
	function & getAgents() {
		return $this->_javaClass->getAgents();
	}

	// public TypeIterator & getAgentTypes();
	function & getAgentTypes() {
		return $this->_javaClass->getAgentTypes();
	}

	// public Group & createGroup(String $description, String $name, Type & $groupType);
	function & createGroup($description, $name, & $groupType) {
		return $this->_javaClass->createGroup($description, $name, $groupType);
	}

	// public void deleteGroup(Id & $id);
	function deleteGroup(& $id) {
		$this->_javaClass->deleteGroup($id);
	}

	// public Group & getGroup(Id & $id);
	function & getGroup(& $id) {
		return $this->_javaClass->getGroup($id);
	}

	// public AgentIterator & getGroups();
	function & getGroups() {
		return $this->_javaClass->getGroups();
	}

	// public TypeIterator & getGroupTypes();
	function & getGroupTypes() {
		return $this->_javaClass->getGroupTypes();
	}

	// public Id & createId();
	function & createId() {
		return $this->_javaClass->createId();
	}

	// public Id & getId(String $idString);
	function & getId($idString) {
		return $this->_javaClass->getId($idString);
	}

	// public AgentIterator & getAgents(osid.shared.Type & $agentType);
	function & getAgents(& $agentType) {
		return $this->_javaClass->getAgents($agentType);
	}

	// public AgentIterator & getGroups(osid.shared.Type & $groupType);
	function & getGroups(& $groupType) {
		return $this->_javaClass->getGroups($groupType);
	}
}

?>