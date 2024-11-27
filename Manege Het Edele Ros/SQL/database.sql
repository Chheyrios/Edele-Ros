CREATE DATABASE IF NOT EXISTS manegeedeleros;

    -- Tabel voor gebruikers (eigenaar, instructeurs, leerlingen)
    CREATE TABLE gebruikers (
        gebruiker_id INT AUTO_INCREMENT PRIMARY KEY,
        naam VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        wachtwoord VARCHAR(255) NOT NULL,
        adres VARCHAR(255),
        telefoonnummer VARCHAR(15),
        geboortedatum DATE,
        gebruikersrol ENUM('eigenaar', 'instructeur', 'leerling') NOT NULL,
        profielfoto VARCHAR(255)
    );

    -- Tabel voor paarden
    CREATE TABLE paarden (
        paard_id INT AUTO_INCREMENT PRIMARY KEY,
        naam VARCHAR(255) NOT NULL,
        geslacht ENUM('hengst', 'ruin', 'merrie') NOT NULL,
        tamheid ENUM('tam', 'gemiddeld', 'wild') NOT NULL,
        afbeelding VARCHAR(255)
    );

    -- Tabel voor lessen
    CREATE TABLE lessen (
        les_id INT AUTO_INCREMENT PRIMARY KEY,
        leerling_id INT,
        instructeur_id INT,
        paard_id INT,
        datum DATE NOT NULL,
        tijd TIME NOT NULL,
        lesdoel VARCHAR(255),
        opmerking TEXT,
        status ENUM('gepland', 'gevolgd', 'geannuleerd') DEFAULT 'gepland',
        annuleringsreden TEXT,
        FOREIGN KEY (leerling_id) REFERENCES gebruikers(gebruiker_id),
        FOREIGN KEY (instructeur_id) REFERENCES gebruikers(gebruiker_id),
        FOREIGN KEY (paard_id) REFERENCES paarden(paard_id)
    );


    -- Tabel voor examens
    CREATE TABLE examens (
        examen_id INT AUTO_INCREMENT PRIMARY KEY,
        leerling_id INT,
        instructeur_id INT,
        discipline ENUM('springen', 'dressuur') NOT NULL,
        datum DATE NOT NULL,
        resultaat ENUM('geslaagd', 'gezakt') NOT NULL,
        opmerking TEXT,
        FOREIGN KEY (leerling_id) REFERENCES gebruikers(gebruiker_id),
        FOREIGN KEY (instructeur_id) REFERENCES gebruikers(gebruiker_id)
    );

    -- Tabel voor lespakketten
    CREATE TABLE lespakketten (
        pakket_id INT AUTO_INCREMENT PRIMARY KEY,
        naam VARCHAR(255) NOT NULL,
        aantal_lessen INT NOT NULL,
        prijs DECIMAL(10, 2) NOT NULL
    );

    -- Tabel voor ziekmeldingen (instructeurs kunnen zich ziekmelden)
    CREATE TABLE ziekmeldingen (
        ziekmelding_id INT AUTO_INCREMENT PRIMARY KEY,
        instructeur_id INT,
        datum DATE NOT NULL,
        opmerking TEXT,
        FOREIGN KEY (instructeur_id) REFERENCES gebruikers(gebruiker_id)
    );

    -- Tabel voor mededelingen (door de eigenaar geplaatst)
    CREATE TABLE mededelingen (
        mededeling_id INT AUTO_INCREMENT PRIMARY KEY,
        titel VARCHAR(255) NOT NULL,
        inhoud TEXT NOT NULL,
        gebruiker_id INT NOT NULL,
        doelgroep ENUM('klant', 'instructeur') NOT NULL,
        datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (gebruiker_id) REFERENCES gebruikers(gebruiker_id)
    );


    -- Tabel voor omzet (overzicht van inkomsten)
    CREATE TABLE omzet (
        omzet_id INT AUTO_INCREMENT PRIMARY KEY,
        datum DATE NOT NULL,
        bedrag DECIMAL(10, 2) NOT NULL,
        leerling_id INT,
        FOREIGN KEY (leerling_id) REFERENCES gebruikers(gebruiker_id)
    );

    -- Tabel voor omzet (overzicht van klanten)
    CREATE TABLE inschrijvingen (
        inschrijving_id INT AUTO_INCREMENT PRIMARY KEY,
        naam VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        telefoon VARCHAR(15) NOT NULL,
        geboortedatum DATE NOT NULL,
        postcode VARCHAR(10) NOT NULL,
        straat VARCHAR(255) NOT NULL,
        stad VARCHAR(255) NOT NULL,
        opmerkingen TEXT
    );

    CREATE TABLE contact_submissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        message TEXT NOT NULL,
        is_read TINYINT(1) DEFAULT 0, -- 0 for unread, 1 for read
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );


    INSERT INTO `gebruikers` (`naam`, `email`, `wachtwoord`, `adres`, `telefoonnummer`, `geboortedatum`, `gebruikersrol`, `profielfoto`) VALUES
    ('John Doe', 'john.doe@example.com', MD5('test'), '123 Elm Street, Amsterdam', '0612345678', '2000-04-15', 'leerling', NULL),
    ('Jane Smith', 'jane.smith@example.com', MD5('test'), '456 Oak Avenue, Rotterdam', '0623456789', '1998-07-21', 'leerling', NULL),
    ('Lars de Vries', 'lars.vries@example.com', MD5('test'), '789 Maple Road, Utrecht', '0634567890', '2004-11-30', 'leerling', NULL),
    ('Emma Jansen', 'emma.jansen@example.com', MD5('test'), '101 Pine Lane, Den Haag', '0645678901', '2010-03-05', 'leerling', NULL),
    ('Sven van Dijk', 'sven.dijk@example.com', MD5('test'), '202 Birch Boulevard, Eindhoven', '0656789012', '2002-12-18', 'leerling', NULL),
    ('Daniel', 'daniel@example.com', MD5('test'), '123 Instructor Lane, Amsterdam', '0612345671', '1985-02-10', 'instructeur', NULL),
    ('Maria', 'maria@example.com', MD5('test'), '456 Teacher Road, Rotterdam', '0623456782', '1987-05-22', 'instructeur', NULL),
    ('Reafon', 'reafon@example.com', MD5('test'), '789 Mentor Avenue, Utrecht', '0634567893', '1986-08-18', 'instructeur', NULL),
    ('Vika', 'vika@example.com', MD5('test'), '101 Tutor Street, Den Haag', '0645678904', '1989-01-12', 'instructeur', NULL),
    ('Florian', 'florian@example.com', MD5('test'), '202 Director Boulevard, Eindhoven', '0656789015', '1982-11-02', 'eigenaar', NULL),
    ('Jan de Vries', 'jan.devries@example.com', MD5('test'), '1234 Elmstraat, Amsterdam', '+31612345678', '1985-06-15', 'eigenaar', NULL),
    ('Patrick Star', 'Patrick.Star@example.com', MD5('test'), '120 Conch Street', '1234567890', '1990-01-01', 'instructeur', NULL);


    INSERT INTO lespakketten (pakket_id, naam, aantal_lessen, prijs) VALUES
    (1, '1 Lessenpakket', 1, 90.00),
    (2, '5 Lessenpakket', 5, 405.00),
    (3, '10 Lessenpakket', 10, 765.00);

    INSERT INTO paarden (paard_id, naam, geslacht, tamheid, afbeelding) VALUES
    (1, 'Thunder', 'hengst', 'wild', '../images/paarden/thunder.jpg'),
    (2, 'Blaze', 'hengst', 'gemiddeld', '../images/paarden/blaze.jpg'),
    (3, 'Spirit', 'ruin', 'tam', '../images/paarden/spirit.jpg'),
    (4, 'Shadow', 'ruin', 'gemiddeld', '../images/paarden/shadow.jpg'),
    (5, 'Storm', 'ruin', 'wild', '../images/paarden/storm.jpg'),
    (6, 'Bolt', 'ruin', 'tam', '../images/paarden/bolt.jpg'),
    (7, 'Max', 'ruin', 'gemiddeld', '../images/paarden/max.jpg'),
    (8, 'Bella', 'merrie', 'tam', '../images/paarden/bella.jpg'),
    (9, 'Luna', 'merrie', 'gemiddeld', '../images/paarden/luna.jpg'),
    (10, 'Star', 'merrie', 'wild', '../images/paarden/star.jpg'),
    (11, 'Daisy', 'merrie', 'gemiddeld', '../images/paarden/daisy.jpg'),
    (12, 'Grace', 'merrie', 'tam', '../images/paarden/grace.jpg'),
    (13, 'Rosie', 'merrie', 'wild', '../images/paarden/rosie.jpg');


    INSERT INTO lessen (leerling_id, instructeur_id, paard_id, datum, tijd, lesdoel, opmerking, status) VALUES
    (1, 6, 1, '2024-10-15', '09:00:00', 'Springles', 'Introductieles voor springen', 'gepland'),
    (2, 7, 2, '2024-10-16', '10:00:00', 'Dressuurles', 'Basis dressuurtraining', 'gepland'),
    (3, 6, 3, '2024-10-17', '11:00:00', 'Springles', 'Verbetering springtechniek', 'gepland'),
    (4, 8, 4, '2024-10-18', '12:00:00', 'Kennis maken met het paard', 'Eerste kennismaking', 'gepland'),
    (5, 7, 5, '2024-10-19', '13:00:00', 'Dressuurles', 'Geavanceerde dressuurtechnieken', 'gepland');


    INSERT INTO mededelingen (titel, inhoud, gebruiker_id, doelgroep) VALUES
    ('Nieuw Lessenpakket Beschikbaar', 'We hebben een nieuw lessenpakket van 10 lessen toegevoegd. Boek nu voor korting.', 11, 'klant'),
    ('Opleiding Dressuur Veranderd', 'De dressuurlessen zijn aangepast aan de nieuwste richtlijnen. Bekijk de planning.', 11, 'instructeur'),
    ('Ziekmelding Instructeur', 'Instructeur Maria zal de komende week afwezig zijn vanwege ziekte.', 12, 'instructeur'),
    ('Nieuwe Openingstijden', 'De manege is nu ook open op zondag!', 10, 'klant'),
    ('Springwedstrijd Aankondiging', 'Er wordt een springwedstrijd gehouden op 20 oktober. Schrijf je snel in!', 10, 'klant');

    INSERT INTO contact_submissions (name, email, phone, message) VALUES
    ('Klaas Bakker', 'klaas.bakker@example.com', '0623456789', 'Ik wil meer informatie over de springlessen.'),
    ('Sophie Visser', 'sophie.visser@example.com', '0612345670', 'Zijn er nog plekken beschikbaar voor dressuurlessen?'),
    ('Joris de Groot', 'joris.degroot@example.com', '0634567891', 'Kunnen we de manege huren voor een evenement?'),
    ('Anouk Smit', 'anouk.smit@example.com', '0629876543', 'Kan ik mijn zoon inschrijven voor paardrijlessen?'),
    ('Bram Jansen', 'bram.jansen@example.com', '0645678902', 'Wat zijn de kosten voor een privéles?');


    INSERT INTO inschrijvingen (naam, email, telefoon, geboortedatum, postcode, straat, stad, opmerkingen) VALUES
    ('Sara de Wit', 'sara.wit@example.com', '0623456789', '1990-01-15', '1011AB', 'Damstraat 5', 'Amsterdam', 'Geen opmerkingen.'),
    ('Mark van der Meer', 'mark.meer@example.com', '0612345670', '1988-06-22', '2020CD', 'Nieuwstraat 8', 'Rotterdam', 'Graag contact opnemen over lespakketten.'),
    ('Sanne de Jong', 'sanne.jong@example.com', '0634567891', '1995-11-03', '3030EF', 'Kerkstraat 12', 'Utrecht', 'Heeft ervaring met paardrijden.'),
    ('Wouter Smit', 'wouter.smit@example.com', '0629876543', '1999-07-19', '4040GH', 'Grote Markt 9', 'Den Haag', 'Zoekt beginnerslessen.'),
    ('Lotte van Dijk', 'lotte.dijk@example.com', '0645678902', '1993-04-17', '5050IJ', 'Prinsengracht 20', 'Eindhoven', 'Interesse in dressuurlessen.');





