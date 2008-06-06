-- /**
-- @package harmoni.osid_v2.authentication
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: AuthN_Example_Authentication.sql,v 1.1 2007/09/11 19:06:27 adamfranco Exp $
-- */
-- --------------------------------------------------------

--
-- Table structure for table `auth_visitor`
--

CREATE TABLE `auth_visitor` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `create_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `email_confirmed` tinyint(1) NOT NULL default '0',
  `confirmation_code` varchar(100) NOT NULL,
  PRIMARY KEY  (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
