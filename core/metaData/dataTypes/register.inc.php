<?php

/* this file is meant to register some DataTypes that ship with Harmoni */

/* example: $this->registerType( "name", "className" ); */

include_once(HARMONI."metaData/dataTypes/SimpleDataTypes.classes.php");

$this->registerType("integer","IntegerDataType");
$this->registerType("string","StringDataType");
$this->registerType("boolean","BooleanDataType");
$this->registerType("float","FloatDataType");
$this->registerType("shortstring","ShortStringDataType");
//$this->registerType("datetime","DateTimeDataType");
//$this->registerType("fuzzydate","FuzzyDateDataType");
//$this->registerType("blob","BlobDataType");

?>