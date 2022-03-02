SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `vereinsapp`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_bewertung_notenverzeichnis`
--

CREATE TABLE `vereinsapp_bewertung_notenverzeichnis` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL DEFAULT 0,
  `objekt_id` int(11) NOT NULL,
  `wert` int(11) NOT NULL,
  `mitglied_id` int(11) NOT NULL,
  `archiv` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_mitglieder`
--

CREATE TABLE `vereinsapp_mitglieder` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL,
  `loginversuche` tinyint(2) NOT NULL DEFAULT 3,
  `passwort` varchar(255) DEFAULT NULL,
  `login_schluessel` varchar(255) DEFAULT NULL,
  `login_schluessel_zeitpunkt` int(11) DEFAULT NULL,
  `login_erlaubt` varchar(255) DEFAULT NULL,
  `rechte` varchar(255) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `geburt` int(11) NOT NULL,
  `postleitzahl` int(5) NOT NULL,
  `wohnort` varchar(50) NOT NULL,
  `geschlecht` varchar(1) NOT NULL DEFAULT 'd',
  `register` varchar(50) NOT NULL,
  `funktion` varchar(50) NOT NULL,
  `vorstandschaft` tinyint(2) NOT NULL DEFAULT 0,
  `aktiv` tinyint(2) NOT NULL DEFAULT 1,
  `archiv` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `vereinsapp_mitglieder`
--

INSERT INTO `vereinsapp_mitglieder` (`id`, `zeitpunkt`, `email`, `loginversuche`, `passwort`, `login_schluessel`, `login_schluessel_zeitpunkt`, `login_erlaubt`, `rechte`, `vorname`, `nachname`, `geburt`, `postleitzahl`, `wohnort`, `geschlecht`, `register`, `funktion`, `vorstandschaft`, `aktiv`, `archiv`) VALUES
(1, 1646250644, 'admin@eingetragener-verein.de', 3, '$2y$10$5aneFm4SK9AMV9v68FDmQ.dPkV8v7kyQSEXRfDU3GZFto9ZJc0ekC', NULL, NULL, NULL, '-t -a -n -m -r -e', 'Ad', 'Min', 0, 12345, 'Musterstadt', 'd', '', '', 0, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_mitglieder_abwesenheiten`
--

CREATE TABLE `vereinsapp_mitglieder_abwesenheiten` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `mitglied_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `ende` int(11) NOT NULL,
  `bemerkung` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_mitglieder_dauerhaft_angemeldet`
--

CREATE TABLE `vereinsapp_mitglieder_dauerhaft_angemeldet` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `mitglied_id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `securitytoken` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_mitglieder_einstellungen`
--

CREATE TABLE `vereinsapp_mitglieder_einstellungen` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `mitglied_id` int(11) NOT NULL,
  `gruppe` varchar(20) NOT NULL,
  `funktion` varchar(50) NOT NULL,
  `wert` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_mitglieder_vertretungen`
--

CREATE TABLE `vereinsapp_mitglieder_vertretungen` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `mitglied_id` int(11) NOT NULL,
  `vertretung_id` int(11) NOT NULL,
  `recht` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_notenbank_notenverzeichnis`
--

CREATE TABLE `vereinsapp_notenbank_notenverzeichnis` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `titel_nr` int(3) NOT NULL,
  `titel` varchar(30) NOT NULL,
  `archiv` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_termine`
--

CREATE TABLE `vereinsapp_termine` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `titel` varchar(30) NOT NULL,
  `organisator` varchar(50) NOT NULL,
  `bemerkung` varchar(100) NOT NULL,
  `start` int(11) NOT NULL,
  `ort` varchar(50) NOT NULL,
  `typ` varchar(30) NOT NULL,
  `beschr_mitglieder` varchar(9999) NOT NULL,
  `setlist` varchar(1000) NOT NULL,
  `archiv` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_termine_anwesenheiten`
--

CREATE TABLE `vereinsapp_termine_anwesenheiten` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `termin_id` int(11) NOT NULL,
  `mitglied_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vereinsapp_termine_rueckmeldungen`
--

CREATE TABLE `vereinsapp_termine_rueckmeldungen` (
  `id` int(11) NOT NULL,
  `zeitpunkt` int(11) NOT NULL,
  `termin_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `mitglied_id` int(11) NOT NULL,
  `bemerkung` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `vereinsapp_bewertung_notenverzeichnis`
--
ALTER TABLE `vereinsapp_bewertung_notenverzeichnis`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_mitglieder`
--
ALTER TABLE `vereinsapp_mitglieder`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_mitglieder_abwesenheiten`
--
ALTER TABLE `vereinsapp_mitglieder_abwesenheiten`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_mitglieder_dauerhaft_angemeldet`
--
ALTER TABLE `vereinsapp_mitglieder_dauerhaft_angemeldet`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_mitglieder_einstellungen`
--
ALTER TABLE `vereinsapp_mitglieder_einstellungen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_mitglieder_vertretungen`
--
ALTER TABLE `vereinsapp_mitglieder_vertretungen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_notenbank_notenverzeichnis`
--
ALTER TABLE `vereinsapp_notenbank_notenverzeichnis`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_termine`
--
ALTER TABLE `vereinsapp_termine`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_termine_anwesenheiten`
--
ALTER TABLE `vereinsapp_termine_anwesenheiten`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vereinsapp_termine_rueckmeldungen`
--
ALTER TABLE `vereinsapp_termine_rueckmeldungen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_bewertung_notenverzeichnis`
--
ALTER TABLE `vereinsapp_bewertung_notenverzeichnis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_mitglieder`
--
ALTER TABLE `vereinsapp_mitglieder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_mitglieder_abwesenheiten`
--
ALTER TABLE `vereinsapp_mitglieder_abwesenheiten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_mitglieder_dauerhaft_angemeldet`
--
ALTER TABLE `vereinsapp_mitglieder_dauerhaft_angemeldet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_mitglieder_einstellungen`
--
ALTER TABLE `vereinsapp_mitglieder_einstellungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_mitglieder_vertretungen`
--
ALTER TABLE `vereinsapp_mitglieder_vertretungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_notenbank_notenverzeichnis`
--
ALTER TABLE `vereinsapp_notenbank_notenverzeichnis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_termine`
--
ALTER TABLE `vereinsapp_termine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_termine_anwesenheiten`
--
ALTER TABLE `vereinsapp_termine_anwesenheiten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vereinsapp_termine_rueckmeldungen`
--
ALTER TABLE `vereinsapp_termine_rueckmeldungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
