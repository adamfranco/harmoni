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
		$result = $this->_javaClass->createAgent($agentType, $name);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public void deleteAgent(Id & $id);
	function deleteAgent(& $id) {
		$this->_javaClass->deleteAgent($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
	}

	// public Agent & getAgent(Id & $id);
	function & getAgent(& $id) {
		$result = $this->_javaClass->getAgent($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public AgentIterator & getAgents();
	function & getAgents() {
		$result = $this->_javaClass->getAgents();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public TypeIterator & getAgentTypes();
	function & getAgentTypes() {
		$result = $this->_javaClass->getAgentTypes();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public Group & createGroup(String $description, String $name, Type & $groupType);
	function & createGroup($description, $name, & $groupType) {
		$result = $this->_javaClass->createGroup($description, $name, $groupType);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public void deleteGroup(Id & $id);
	function deleteGroup(& $id) {
		$this->_javaClass->deleteGroup($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
	}

	// public Group & getGroup(Id & $id);
	function & getGroup(& $id) {
		$result = $this->_javaClass->getGroup($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public AgentIterator & getGroups();
	function & getGroups() {
		$result = $this->_javaClass->getGroups();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public TypeIterator & getGroupTypes();
	function & getGroupTypes() {
		$result = $this->_javaClass->getGroupTypes();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public Id & createId();
	function & createId() {
		$result = $this->_javaClass->createId();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	// public Id & getId(String $idString);
	function & getId($idString) {
		$result = $this->_javaClass->getId($idString);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}
/*
	// public AgentIterator & getAgents(osid.shared.Type & $agentType);
	function & getAgents(& $agentType) {
		return $this->_javaClass->getAgents($agentType);
	}

	// public AgentIterator & getGroups(osid.shared.Type & $groupType);
	function & getGroups(& $groupType) {
		return $this->_javaClass->getGroups($groupType);
	}*/
}

?>