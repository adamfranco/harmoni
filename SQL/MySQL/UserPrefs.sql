
-- --------------------------------------------------------

--
-- Table structure for table `user_prefs`
--

CREATE TABLE IF NOT EXISTS `user_prefs` (
  `agent_id` varchar(100) NOT NULL,
  `pref_key` varchar(100) NOT NULL,
  `pref_val` varchar(255) NOT NULL,
  UNIQUE KEY `agent_key_unique` (`agent_id`,`pref_key`),
  KEY `agent_id` (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
