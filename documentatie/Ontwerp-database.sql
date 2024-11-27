CREATE TABLE `paarden_lijst` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` VARCHAR(255) NOT NULL, -- Naam van het paard
    `geslacht` ENUM('M', 'V', 'N') NOT NULL,  -- 'M' for Male, 'V' for Female
    `tamheid` TEXT NOT NULL -- Tamheids level van het paard
);

CREATE TABLE `les_pakketen` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `lespakket_1` VARCHAR(255) NOT NULL, -- Les pakket 1
    `lespakket_2` VARCHAR(255) NOT NULL, -- Les pakket 2
    `lespakket_3` VARCHAR(255) NOT NULL -- Les pakket 3
);

CREATE TABLE `examen_informatie` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `examen_1` VARCHAR(255) NOT NULL, -- Examen 1
    `examen_2` VARCHAR(255) NOT NULL, -- Examen 2
    `examen_3` VARCHAR(255) NOT NULL -- Examen 3
);

CREATE TABLE `instructeur_lijst` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` VARCHAR(255) NOT NULL, -- Naam instructeur
    `achternaam` VARCHAR(255) NOT NULL, -- Achternaam instructeur
    `email` VARCHAR(255) NOT NULL UNIQUE -- Email instructeur
);

CREATE TABLE `roosters` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `les_tijden` DATETIME NOT NULL, -- Lestijden van de paardrijlessen
    `naam_leerling` VARCHAR(255) NOT NULL, -- Naam van de leerling
    `naam_instructeur` VARCHAR(255) NOT NULL, -- Naam van de instructeur
    `doel` VARCHAR(255) NOT NULL, -- Doel van de rijles
    `behandeling_ontwerp` VARCHAR(255) NOT NULL -- Welk onderwerp er behandeld word in de les
);

CREATE TABLE `leerling_lijst` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` VARCHAR(255) NOT NULL, -- Naam van de leerling
    `achternaam` VARCHAR(255) NOT NULL, -- Achternaam van de leerling
    `email` VARCHAR(255) NOT NULL UNIQUE -- Email van de leerling
);

CREATE TABLE `login` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` VARCHAR(255) NOT NULL, -- Naam voor de login
    `achternaam` VARCHAR(255) NOT NULL, -- Achternaam voor de login
    `email` VARCHAR(255) NOT NULL UNIQUE, -- Email voor de login
    `wachtwoord` VARCHAR(255) NOT NULL  -- Wachtwoord voor het aangemaakte account
);

-- Foreign Key Constraints
ALTER TABLE `les_pakketen` 
    ADD CONSTRAINT `fk_les_pakketen_paarden` 
    FOREIGN KEY (`id`) REFERENCES `paarden_lijst`(`id`);

ALTER TABLE `login` 
    ADD CONSTRAINT `fk_login_instructeur` 
    FOREIGN KEY (`id`) REFERENCES `instructeur_lijst`(`id`);

ALTER TABLE `roosters` 
    ADD CONSTRAINT `fk_roosters_leerling` 
    FOREIGN KEY (`naam_leerling`) REFERENCES `leerling_lijst`(`naam`);

ALTER TABLE `roosters` 
    ADD CONSTRAINT `fk_roosters_instructeur` 
    FOREIGN KEY (`naam_instructeur`) REFERENCES `instructeur_lijst`(`naam`);

ALTER TABLE `examen_informatie` 
    ADD CONSTRAINT `fk_examen_leerling` 
    FOREIGN KEY (`id`) REFERENCES `leerling_lijst`(`id`);
