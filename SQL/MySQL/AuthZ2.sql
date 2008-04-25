-- phpMyAdmin SQL Dump
-- version 2.11.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2008 at 01:14 PM
-- Server version: 5.0.37
-- PHP Version: 5.2.3

--
-- Database: `afranco_segue2_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `az2_explicit_az`
--

CREATE TABLE IF NOT EXISTS `az2_explicit_az` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fk_agent` varchar(150) character set utf8 collate utf8_bin NOT NULL,
  `fk_function` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `fk_qualifier` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `effective_date` datetime default NULL,
  `expiration_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `fk_agent_2` (`fk_agent`,`fk_function`,`fk_qualifier`),
  KEY `fk_qualifier` (`fk_qualifier`),
  KEY `fk_agent` (`fk_agent`),
  KEY `fk_function` (`fk_function`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `az2_function`
--

CREATE TABLE IF NOT EXISTS `az2_function` (
  `id` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `reference_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fk_qualifier_hierarchy` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `fk_type` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `function_display_name` (`reference_name`),
  KEY `fk_qualifier_hierarchy_id` (`fk_qualifier_hierarchy`),
  KEY `fk_type` (`fk_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `az2_function_type`
--

CREATE TABLE IF NOT EXISTS `az2_function_type` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `domain` varchar(255) NOT NULL default '',
  `authority` varchar(255) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `domain` (`domain`),
  KEY `authority` (`authority`),
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `az2_hierarchy`
--

CREATE TABLE IF NOT EXISTS `az2_hierarchy` (
  `id` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `multiparent` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `hierarchy_display_name` (`display_name`),
  KEY `hierarchy_multiparent` (`multiparent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `az2_implicit_az`
--

CREATE TABLE IF NOT EXISTS `az2_implicit_az` (
  `fk_explicit_az` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  `fk_agent` varchar(150) character set utf8 collate utf8_bin NOT NULL,
  `fk_function` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `fk_qualifier` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `effective_date` datetime default NULL,
  `expiration_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_qualifier` (`fk_qualifier`),
  KEY `fk_agent` (`fk_agent`),
  KEY `fk_explicit_az` (`fk_explicit_az`),
  KEY `fk_function` (`fk_function`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `az2_j_node_node`
--

CREATE TABLE IF NOT EXISTS `az2_j_node_node` (
  `fk_hierarchy` varchar(75) collate utf8_bin NOT NULL,
  `fk_parent` varchar(75) collate utf8_bin NOT NULL,
  `fk_child` varchar(75) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`fk_parent`,`fk_child`),
  KEY `fk_parent` (`fk_parent`),
  KEY `fk_child` (`fk_child`),
  KEY `fk_hierarchy` (`fk_hierarchy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `az2_node`
--

CREATE TABLE IF NOT EXISTS `az2_node` (
  `id` varchar(75) collate utf8_bin NOT NULL,
  `display_name` varchar(255) character set utf8 NOT NULL default '',
  `description` text character set utf8 NOT NULL,
  `fk_hierarchy` varchar(75) collate utf8_bin NOT NULL,
  `fk_type` int(10) unsigned NOT NULL default '0',
  `last_changed` timestamp NULL default NULL COMMENT 'Used to determine AZ cache invalidation.',
  PRIMARY KEY  (`fk_hierarchy`,`id`),
  KEY `id` (`id`),
  KEY `display_name` (`display_name`),
  KEY `fk_hierarchy` (`fk_hierarchy`),
  KEY `fk_type` (`fk_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `az2_node_ancestry`
--

CREATE TABLE IF NOT EXISTS `az2_node_ancestry` (
  `fk_hierarchy` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `fk_node` varchar(75) character set utf8 collate utf8_bin NOT NULL,
  `fk_ancestor` varchar(75) character set utf8 collate utf8_bin default NULL,
  `level` smallint(6) NOT NULL default '0',
  `fk_ancestors_child` varchar(75) character set utf8 collate utf8_bin default NULL,
  KEY `fk_ancestor` (`fk_ancestor`),
  KEY `fk_hierarchy` (`fk_hierarchy`),
  KEY `fk_node` (`fk_node`),
  KEY `fk_ancestors_child` (`fk_ancestors_child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `az2_node_type`
--

CREATE TABLE IF NOT EXISTS `az2_node_type` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `domain` varchar(255) NOT NULL default '',
  `authority` varchar(255) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `domain` (`domain`),
  KEY `authority` (`authority`),
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `az2_explicit_az`
--
ALTER TABLE `az2_explicit_az`
  ADD CONSTRAINT `az2_explicit_az_ibfk_3` FOREIGN KEY (`fk_qualifier`) REFERENCES `az2_node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_explicit_az_ibfk_4` FOREIGN KEY (`fk_function`) REFERENCES `az2_function` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `az2_function`
--
ALTER TABLE `az2_function`
  ADD CONSTRAINT `az2_function_ibfk_1` FOREIGN KEY (`fk_qualifier_hierarchy`) REFERENCES `az2_hierarchy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_function_ibfk_2` FOREIGN KEY (`fk_type`) REFERENCES `az2_function_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `az2_implicit_az`
--
ALTER TABLE `az2_implicit_az`
  ADD CONSTRAINT `az2_implicit_az_ibfk_3` FOREIGN KEY (`fk_function`) REFERENCES `az2_function` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_implicit_az_ibfk_1` FOREIGN KEY (`fk_explicit_az`) REFERENCES `az2_explicit_az` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_implicit_az_ibfk_2` FOREIGN KEY (`fk_qualifier`) REFERENCES `az2_node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `az2_j_node_node`
--
ALTER TABLE `az2_j_node_node`
  ADD CONSTRAINT `az2_j_node_node_ibfk_7` FOREIGN KEY (`fk_hierarchy`) REFERENCES `az2_hierarchy` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `az2_j_node_node_ibfk_8` FOREIGN KEY (`fk_parent`) REFERENCES `az2_node` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `az2_j_node_node_ibfk_9` FOREIGN KEY (`fk_child`) REFERENCES `az2_node` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `az2_node`
--
ALTER TABLE `az2_node`
  ADD CONSTRAINT `az2_node_ibfk_2` FOREIGN KEY (`fk_hierarchy`) REFERENCES `az2_hierarchy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_node_ibfk_3` FOREIGN KEY (`fk_type`) REFERENCES `az2_node_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `az2_node_ancestry`
--
ALTER TABLE `az2_node_ancestry`
  ADD CONSTRAINT `az2_node_ancestry_ibfk_1` FOREIGN KEY (`fk_hierarchy`) REFERENCES `az2_hierarchy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_node_ancestry_ibfk_2` FOREIGN KEY (`fk_node`) REFERENCES `az2_node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_node_ancestry_ibfk_3` FOREIGN KEY (`fk_ancestor`) REFERENCES `az2_node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `az2_node_ancestry_ibfk_4` FOREIGN KEY (`fk_ancestors_child`) REFERENCES `az2_node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
