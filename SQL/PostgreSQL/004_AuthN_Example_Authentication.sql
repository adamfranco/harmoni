-- /**
-- @package harmoni.osid_v2.authentication
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 004_AuthN_Example_Authentication.sql,v 1.1 2007/09/12 13:02:11 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `auth_db_user`
-- 

CREATE TABLE auth_db_user (
  username varchar(75) NOT NULL default '',
  password text NOT NULL
);

ALTER TABLE ONLY auth_db_user
	ADD CONSTRAINT auth_db_user_primary_key PRIMARY KEY (username);