-- /**
-- @package harmoni.osid_v2.id
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_Id.sql,v 1.2 2005/04/07 15:12:28 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `id`
-- 

CREATE TABLE id (
  id_value bigint(20) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (id_value)
) TYPE=MyISAM;
