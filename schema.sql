-- Datenbank löschen, falls sie existiert
DROP DATABASE IF EXISTS boxkampf_management;

-- Neue Datenbank erstellen
CREATE DATABASE boxkampf_management;
USE boxkampf_management;

-- Tabelle für Benutzer
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,             -- Primärschlüssel für Benutzer
    firstname VARCHAR(50) NOT NULL,                -- Vorname des Benutzers
    lastname VARCHAR(50) NOT NULL,                 -- Nachname des Benutzers
    email VARCHAR(100) NOT NULL UNIQUE,            -- Eindeutige E-Mail-Adresse des Benutzers
    username VARCHAR(50) NOT NULL UNIQUE,          -- Eindeutiger Benutzername
    password_hash VARCHAR(255) NOT NULL,           -- Gehashter Passwort-String
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Zeitstempel für Erstellung
);

-- Tabelle für Gewichtsklassen
CREATE TABLE weight_classes (
    id INT AUTO_INCREMENT PRIMARY KEY,             -- Primärschlüssel für Gewichtsklassen
    class_name VARCHAR(50) NOT NULL UNIQUE         -- Eindeutiger Name der Gewichtsklasse
);

-- Tabelle für Städte
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,             -- Primärschlüssel für Städte
    name VARCHAR(100) NOT NULL UNIQUE              -- Eindeutiger Name der Stadt
);

-- Tabelle für Kämpfer
CREATE TABLE fighters (
    id INT AUTO_INCREMENT PRIMARY KEY,             -- Primärschlüssel für Kämpfer
    full_name VARCHAR(255) NOT NULL,               -- Vollständiger Name des Kämpfers
    fighter_name VARCHAR(100) NOT NULL,            -- Kämpfername
    birthdate DATE NOT NULL,                       -- Geburtsdatum
    height INT NOT NULL,                           -- Größe des Kämpfers in cm
    weight INT NOT NULL,                           -- Gewicht des Kämpfers in kg
    weight_class_id INT NOT NULL,                  -- Fremdschlüssel für Gewichtsklasse
    city_id INT NOT NULL,                          -- Fremdschlüssel für Stadt
    experience_level ENUM('Amateur', 'Profi') NOT NULL, -- Erfahrungslevel
    FOREIGN KEY (weight_class_id) REFERENCES weight_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE
);

-- Tabelle für Arenen
CREATE TABLE arenas (
    id INT AUTO_INCREMENT PRIMARY KEY,             -- Primärschlüssel für Arenen
    name VARCHAR(100) NOT NULL UNIQUE,             -- Eindeutiger Name der Arena
    city_id INT NOT NULL,                          -- Fremdschlüssel für Stadt
    weight_class_id INT NOT NULL,                  -- Fremdschlüssel für Gewichtsklasse
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE,
    FOREIGN KEY (weight_class_id) REFERENCES weight_classes(id) ON DELETE CASCADE
);

-- Tabelle für Kämpfe
CREATE TABLE fights (
    id INT AUTO_INCREMENT PRIMARY KEY,             -- Primärschlüssel für Kämpfe
    fighter1_id INT NOT NULL,                      -- Fremdschlüssel für Kämpfer 1
    fighter2_id INT NOT NULL,                      -- Fremdschlüssel für Kämpfer 2
    arena_id INT NOT NULL,                         -- Fremdschlüssel für Arena
    date DATE NOT NULL,                            -- Datum des Kampfes
    contact_type ENUM('Leichtkontakt', 'Vollkontakt') NOT NULL, -- Kontaktart
    result VARCHAR(50) DEFAULT 'ausstehend',       -- Ergebnis des Kampfes (Standard: ausstehend)
    FOREIGN KEY (fighter1_id) REFERENCES fighters(id) ON DELETE CASCADE,
    FOREIGN KEY (fighter2_id) REFERENCES fighters(id) ON DELETE CASCADE,
    FOREIGN KEY (arena_id) REFERENCES arenas(id) ON DELETE CASCADE
);

-- Daten einfügen für Gewichtsklassen
INSERT INTO weight_classes (class_name) VALUES
('Leicht'),
('Mittel'),
('Schwer');

-- Daten einfügen für Städte
INSERT INTO cities (name) VALUES
('Basel'),
('Luzern'),
('Zürich'),
('Genf'),
('Bern');

-- Daten einfügen für Arenen
INSERT INTO arenas (name, city_id, weight_class_id) VALUES
('Mystischer Ring', 1, 1), -- Basel, Leicht
('Arena der Titanen', 2, 2), -- Luzern, Mittel
('Ewiger Thron', 3, 3), -- Zürich, Schwer
('Kriegerhalle', 4, 2), -- Genf, Mittel
('Schattentempel', 5, 1); -- Bern, Leicht

-- Beispiel-Kämpfer hinzufügen
INSERT INTO fighters (full_name, fighter_name, birthdate, height, weight, weight_class_id, city_id, experience_level) VALUES
('Max Mustermann', 'The Hammer', '1990-05-20', 180, 75, 2, 1, 'Profi'),
('John Doe', 'Iron Fist', '1988-03-15', 185, 80, 2, 2, 'Amateur'),
('Jane Smith', 'Lightning', '1995-07-10', 170, 60, 1, 3, 'Profi'),
('Anna Muster', 'Firestorm', '2000-11-25', 160, 55, 1, 4, 'Amateur'),
('Peter Schmid', 'Steel', '1992-08-30', 190, 90, 3, 5, 'Profi');

-- Beispiel-Kämpfe hinzufügen
INSERT INTO fights (fighter1_id, fighter2_id, arena_id, date, contact_type, result) VALUES
(1, 2, 2, '2024-12-01', 'Vollkontakt', 'ausstehend'),
(3, 4, 1, '2024-12-05', 'Leichtkontakt', 'ausstehend'),
(5, 1, 3, '2024-12-10', 'Vollkontakt', 'ausstehend');

-- Beispiel-Benutzer hinzufügen
INSERT INTO users (firstname, lastname, email, username, password_hash) VALUES
('Max', 'Mustermann', 'max.mustermann@example.com', 'maxmuster', 'hashedpassword1'),
('John', 'Doe', 'john.doe@example.com', 'johndoe', 'hashedpassword2'),
('Jane', 'Smith', 'jane.smith@example.com', 'janesmith', 'hashedpassword3');
