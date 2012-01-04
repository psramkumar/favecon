-- FaveCon AddressBook MySQL dump

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `ab`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `socialtypes`
--

CREATE TABLE IF NOT EXISTS `socialtypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `socialtype` text NOT NULL,
  `weight` int(11) NOT NULL,
  `link` int(11) NOT NULL DEFAULT '0',
  `fb_pid` int(11) NOT NULL DEFAULT '0',
  `praefixUsage` int(11) NOT NULL DEFAULT '0',
  `prefix1` text NOT NULL,
  `prefix2` text NOT NULL,
  `praefix1` text NOT NULL,
  `praefix2` text NOT NULL,
  `praefix1Text` text NOT NULL,
  `praefix2Text` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `socialtypes`
--

INSERT INTO `socialtypes` (`ID`, `socialtype`, `weight`, `link`, `fb_pid`, `praefixUsage`, `prefix1`, `prefix2`, `praefix1`, `praefix2`, `praefix1Text`, `praefix2Text`) VALUES
(1, 'Facebook', -5, 1, 1, 0, 'http://www.facebook.com/', 'http://www.facebook.com/profile.php?id=', '', '', '', ''),
(2, 'Skype', -4, 1, 0, 1, 'skype:', '', '?call', '?chat', 'Call', 'Chat'),
(3, 'Twitter', -3, 1, 0, 0, 'http://twitter.com/', '', '', '', '', ''),
(4, 'ICQ', -2, 0, 0, 0, '', '', '', '', '', ''),
(5, 'MSN', -1, 1, 0, 0, 'msnim:chat?contact=', '', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
