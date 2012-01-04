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
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `m_header` text NOT NULL,
  `m_body` text NOT NULL,
  `m_time` text NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `for_gid` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `numbertype`
--

CREATE TABLE IF NOT EXISTS `numbertype` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `title` text NOT NULL,
  `bday` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons_addresses`
--

CREATE TABLE IF NOT EXISTS `persons_addresses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `street` text NOT NULL,
  `plz` text NOT NULL,
  `city` text NOT NULL,
  `state_code` int(11) NOT NULL COMMENT 'state_code',
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons_emails`
--

CREATE TABLE IF NOT EXISTS `persons_emails` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `email` text NOT NULL,
  `infoText` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons_numbers`
--

CREATE TABLE IF NOT EXISTS `persons_numbers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT 'person_id',
  `ntid` int(11) NOT NULL COMMENT 'numbertype_id',
  `number` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons_socialcom`
--

CREATE TABLE IF NOT EXISTS `persons_socialcom` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `soctid` int(11) NOT NULL COMMENT 'socialtype_id',
  `uname` text NOT NULL COMMENT 'username- z.b. skype, fb_permalink',
  `fb_pid` text NOT NULL COMMENT 'fb profile id -> link creation!',
  `praefixNo` int(11) NOT NULL DEFAULT '1' COMMENT 'nummer des präfixes',
  `infotext` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons_websites`
--

CREATE TABLE IF NOT EXISTS `persons_websites` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `url` text NOT NULL,
  `infoText` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `var` text NOT NULL,
  `val` text NOT NULL
) ENGINE=<ENGINE> DEFAULT CHARSET=utf8;

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
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `num_code` int(5) NOT NULL,
  `name` text NOT NULL,
  `iso2` varchar(5) NOT NULL,
  `iso3` varchar(5) NOT NULL
) ENGINE=<ENGINE> DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `passwd` text NOT NULL,
  `user_hash` text NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '0',
  `created_at` bigint(20) NOT NULL,
  `last_old_login` bigint(20) NOT NULL,
  `last_login` bigint(20) NOT NULL,
  `logins` bigint(20) NOT NULL,
  `enabled` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_data`
--

CREATE TABLE IF NOT EXISTS `users_data` (
  `uid` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `title` text NOT NULL,
  `email` text NOT NULL,
  `bday` text NOT NULL
) ENGINE=<ENGINE> DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=<ENGINE>  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_settings`
--

CREATE TABLE IF NOT EXISTS `users_settings` (
  `uid` int(11) NOT NULL,
  `var` text NOT NULL,
  `val` text NOT NULL
) ENGINE=<ENGINE> DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
