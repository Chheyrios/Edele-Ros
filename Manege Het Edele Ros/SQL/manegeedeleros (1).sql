-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 okt 2024 om 10:25
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manegeedeleros`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `examens`
--

CREATE TABLE `examens` (
  `examen_id` int(11) NOT NULL,
  `leerling_id` int(11) DEFAULT NULL,
  `instructeur_id` int(11) DEFAULT NULL,
  `discipline` enum('springen','dressuur') NOT NULL,
  `datum` date NOT NULL,
  `resultaat` enum('geslaagd','gezakt') NOT NULL,
  `opmerking` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `examens`
--

INSERT INTO `examens` (`examen_id`, `leerling_id`, `instructeur_id`, `discipline`, `datum`, `resultaat`, `opmerking`) VALUES
(1, 4, 2, 'springen', '2024-10-20', 'geslaagd', 'Excellent jumping skills'),
(2, 5, 3, 'dressuur', '2024-10-21', 'gezakt', 'Needs more practice in dressage');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `gebruiker_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `adres` varchar(255) DEFAULT NULL,
  `telefoonnummer` varchar(15) DEFAULT NULL,
  `geboortedatum` date DEFAULT NULL,
  `gebruikersrol` enum('eigenaar','instructeur','leerling') NOT NULL,
  `profielfoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`gebruiker_id`, `naam`, `email`, `wachtwoord`, `adres`, `telefoonnummer`, `geboortedatum`, `gebruikersrol`, `profielfoto`) VALUES
(1, 'Florian de Koning', 'florian@example.com', '482c811da5d5b4bc6d497ffa98491e38', '123 Kings Street, Amsterdam', '0612345678', '1982-11-15', 'eigenaar', NULL),
(2, 'Sophie Bakker', 'sophie@example.com', '482c811da5d5b4bc6d497ffa98491e38', '456 Riders Avenue, Rotterdam', '0612345679', '1990-08-24', 'instructeur', NULL),
(3, 'Lars Janssen', 'lars@example.com', '482c811da5d5b4bc6d497ffa98491e38', '789 Horse Way, Utrecht', '0612345680', '1985-05-12', 'instructeur', NULL),
(4, 'Mia de Jong', 'mia@example.com', '482c811da5d5b4bc6d497ffa98491e38', '101 Horse Park, Den Haag', '0612345681', '2005-09-10', 'leerling', NULL),
(5, 'Emma Verhoeven', 'emma@example.com', '482c811da5d5b4bc6d497ffa98491e38', '202 Saddle Street, Eindhoven', '0612345682', '2002-03-25', 'leerling', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lespakketten`
--

CREATE TABLE `lespakketten` (
  `pakket_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `aantal_lessen` int(11) NOT NULL,
  `prijs` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `lespakketten`
--

INSERT INTO `lespakketten` (`pakket_id`, `naam`, `aantal_lessen`, `prijs`) VALUES
(1, 'Basic Package', 5, 400.00),
(2, 'Advanced Package', 10, 750.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lessen`
--

CREATE TABLE `lessen` (
  `les_id` int(11) NOT NULL,
  `leerling_id` int(11) DEFAULT NULL,
  `instructeur_id` int(11) DEFAULT NULL,
  `paard_id` int(11) DEFAULT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `lesdoel` varchar(255) DEFAULT NULL,
  `opmerking` text DEFAULT NULL,
  `status` enum('gepland','gevolgd','geannuleerd') DEFAULT 'gepland',
  `annuleringsreden` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `lessen`
--

INSERT INTO `lessen` (`les_id`, `leerling_id`, `instructeur_id`, `paard_id`, `datum`, `tijd`, `lesdoel`, `opmerking`, `status`, `annuleringsreden`) VALUES
(1, 4, 2, 1, '2024-10-15', '10:00:00', 'Spring training', 'Focus on jumping', 'gepland', NULL),
(2, 5, 3, 2, '2024-10-16', '14:00:00', 'Dressage practice', 'Prepare for competition', 'gepland', NULL),
(3, 4, 2, 3, '2024-10-17', '09:00:00', 'Basic riding', 'Beginner lessons for Mia', 'gepland', NULL),
(4, 5, 3, 4, '2024-10-18', '11:00:00', 'Intermediate training', 'Improve dressage techniques', 'gepland', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mededelingen`
--

CREATE TABLE `mededelingen` (
  `mededeling_id` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `inhoud` text NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `doelgroep` enum('klant','instructeur') NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `mededelingen`
--

INSERT INTO `mededelingen` (`mededeling_id`, `titel`, `inhoud`, `gebruiker_id`, `doelgroep`, `datum`) VALUES
(1, 'New Safety Rules', 'Please follow the new safety rules during lessons.', 1, 'klant', '2024-10-07 08:24:01'),
(2, 'Staff Meeting', 'All instructors, please attend the staff meeting next Monday.', 1, 'instructeur', '2024-10-07 08:24:01');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `omzet`
--

CREATE TABLE `omzet` (
  `omzet_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `bedrag` decimal(10,2) NOT NULL,
  `leerling_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `omzet`
--

INSERT INTO `omzet` (`omzet_id`, `datum`, `bedrag`, `leerling_id`) VALUES
(1, '2024-10-15', 400.00, 4),
(2, '2024-10-16', 750.00, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `paarden`
--

CREATE TABLE `paarden` (
  `paard_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `geslacht` enum('hengst','ruin','merrie') NOT NULL,
  `tamheid` enum('tam','gemiddeld','wild') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `paarden`
--

INSERT INTO `paarden` (`paard_id`, `naam`, `geslacht`, `tamheid`) VALUES
(1, 'Storm', 'hengst', 'wild'),
(2, 'Blaze', 'ruin', 'gemiddeld'),
(3, 'Luna', 'merrie', 'tam'),
(4, 'Spirit', 'ruin', 'tam'),
(5, 'Bella', 'merrie', 'gemiddeld');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ziekmeldingen`
--

CREATE TABLE `ziekmeldingen` (
  `ziekmelding_id` int(11) NOT NULL,
  `instructeur_id` int(11) DEFAULT NULL,
  `datum` date NOT NULL,
  `opmerking` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ziekmeldingen`
--

INSERT INTO `ziekmeldingen` (`ziekmelding_id`, `instructeur_id`, `datum`, `opmerking`) VALUES
(1, 2, '2024-10-19', 'Flu, cannot attend lessons'),
(2, 3, '2024-10-20', 'Family emergency');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `examens`
--
ALTER TABLE `examens`
  ADD PRIMARY KEY (`examen_id`),
  ADD KEY `leerling_id` (`leerling_id`),
  ADD KEY `instructeur_id` (`instructeur_id`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`gebruiker_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexen voor tabel `lespakketten`
--
ALTER TABLE `lespakketten`
  ADD PRIMARY KEY (`pakket_id`);

--
-- Indexen voor tabel `lessen`
--
ALTER TABLE `lessen`
  ADD PRIMARY KEY (`les_id`),
  ADD KEY `leerling_id` (`leerling_id`),
  ADD KEY `instructeur_id` (`instructeur_id`),
  ADD KEY `paard_id` (`paard_id`);

--
-- Indexen voor tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  ADD PRIMARY KEY (`mededeling_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- Indexen voor tabel `omzet`
--
ALTER TABLE `omzet`
  ADD PRIMARY KEY (`omzet_id`),
  ADD KEY `leerling_id` (`leerling_id`);

--
-- Indexen voor tabel `paarden`
--
ALTER TABLE `paarden`
  ADD PRIMARY KEY (`paard_id`);

--
-- Indexen voor tabel `ziekmeldingen`
--
ALTER TABLE `ziekmeldingen`
  ADD PRIMARY KEY (`ziekmelding_id`),
  ADD KEY `instructeur_id` (`instructeur_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `examens`
--
ALTER TABLE `examens`
  MODIFY `examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `gebruiker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `lespakketten`
--
ALTER TABLE `lespakketten`
  MODIFY `pakket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `lessen`
--
ALTER TABLE `lessen`
  MODIFY `les_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  MODIFY `mededeling_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `omzet`
--
ALTER TABLE `omzet`
  MODIFY `omzet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `paarden`
--
ALTER TABLE `paarden`
  MODIFY `paard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `ziekmeldingen`
--
ALTER TABLE `ziekmeldingen`
  MODIFY `ziekmelding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `examens`
--
ALTER TABLE `examens`
  ADD CONSTRAINT `examens_ibfk_1` FOREIGN KEY (`leerling_id`) REFERENCES `gebruikers` (`gebruiker_id`),
  ADD CONSTRAINT `examens_ibfk_2` FOREIGN KEY (`instructeur_id`) REFERENCES `gebruikers` (`gebruiker_id`);

--
-- Beperkingen voor tabel `lessen`
--
ALTER TABLE `lessen`
  ADD CONSTRAINT `lessen_ibfk_1` FOREIGN KEY (`leerling_id`) REFERENCES `gebruikers` (`gebruiker_id`),
  ADD CONSTRAINT `lessen_ibfk_2` FOREIGN KEY (`instructeur_id`) REFERENCES `gebruikers` (`gebruiker_id`),
  ADD CONSTRAINT `lessen_ibfk_3` FOREIGN KEY (`paard_id`) REFERENCES `paarden` (`paard_id`);

--
-- Beperkingen voor tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  ADD CONSTRAINT `mededelingen_ibfk_1` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`gebruiker_id`);

--
-- Beperkingen voor tabel `omzet`
--
ALTER TABLE `omzet`
  ADD CONSTRAINT `omzet_ibfk_1` FOREIGN KEY (`leerling_id`) REFERENCES `gebruikers` (`gebruiker_id`);

--
-- Beperkingen voor tabel `ziekmeldingen`
--
ALTER TABLE `ziekmeldingen`
  ADD CONSTRAINT `ziekmeldingen_ibfk_1` FOREIGN KEY (`instructeur_id`) REFERENCES `gebruikers` (`gebruiker_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
