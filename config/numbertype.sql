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
-- Tabellenstruktur für Tabelle `numbertype`
--

CREATE TABLE IF NOT EXISTS `numbertype` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `numbertype`
--

INSERT INTO `numbertype` (`ID`, `weight`) VALUES
(1, -7),
(2, -6),
(3, -5),
(4, -4),
(5, -3),
(6, -2),
(7, -1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
