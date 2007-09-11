-- /**
-- @package harmoni.osid_v2.id
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: Id.sql,v 1.1 2007/09/11 19:06:29 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `id`
-- 

CREATE TABLE id (
  id_value bigint(20) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (id_value)
) 
CHARACTER SET utf8
TYPE=InnoDB;
