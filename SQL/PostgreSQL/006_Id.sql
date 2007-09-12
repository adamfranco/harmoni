-- /**
-- @package harmoni.osid_v2.id
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 006_Id.sql,v 1.1 2007/09/12 13:02:12 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `id`
-- 

CREATE TABLE id (
  id_value SERIAL NOT NULL
);

ALTER TABLE ONLY id
	ADD CONSTRAINT id_primary_key PRIMARY KEY (id_value);
