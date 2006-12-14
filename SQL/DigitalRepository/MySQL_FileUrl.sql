-- --------------------------------------------------------

-- 
-- Table structure for table `dr_file_url`
-- 

CREATE TABLE dr_file_url (
  FK_file varchar(75) NOT NULL default '',
  url text NOT NULL,
  PRIMARY KEY  (FK_file)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;