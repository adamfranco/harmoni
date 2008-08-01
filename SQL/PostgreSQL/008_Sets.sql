-- /**
-- @package harmoni.sets
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 008_Sets.sql,v 1.1 2007/09/12 13:02:12 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `sets`
-- 

CREATE TABLE sets (
  id varchar(150) NOT NULL default '0',
  item_id varchar(150) NOT NULL default '0',
  item_order integer NOT NULL default '0'
);

CREATE INDEX set_item_index ON sets (id, item_id);