<?php

/* this file is meant to register some DataTypes that ship with Harmoni */

/* example: $this->registerType( "name", "className" ); */

include_once(HARMONI."metaData/dataTypes/SimpleDataTypes.classes.php");

$this->registerType("integer","IntegerDataType");

?>