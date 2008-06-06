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
-- Table structure for table `auth_visitor`
--

CREATE TABLE auth_visitor (
  email varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  display_name varchar(100) NOT NULL,
  create_time timestamp with time zone default CURRENT_TIMESTAMP,
  email_confirmed INT NOT NULL default '0',
  confirmation_code varchar(100) NOT NULL,
);

ALTER TABLE ONLY auth_visitor
	ADD CONSTRAINT auth_visitor_primary_key PRIMARY KEY (email);