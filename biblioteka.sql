-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 16, 2025 at 10:43 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `id` int(11) NOT NULL,
  `klasa` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `klasy`
--

INSERT INTO `klasy` (`id`, `klasa`) VALUES
(1, '1P'),
(2, '2P'),
(3, '3P'),
(4, '4P'),
(5, '5P');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ksiazki`
--

CREATE TABLE `ksiazki` (
  `id` int(11) NOT NULL,
  `tytul` varchar(128) NOT NULL,
  `autor` varchar(128) NOT NULL,
  `kategoria` varchar(128) NOT NULL,
  `rok_wydania` int(11) NOT NULL,
  `dostepna` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ksiazki`
--

INSERT INTO `ksiazki` (`id`, `tytul`, `autor`, `kategoria`, `rok_wydania`, `dostepna`) VALUES
(1, 'Chłopcy z placu broni', 'ktos', 'Dla dzieci', 1996, 0),
(2, 'Lalka', 'Bolesław Prus', 'Powieść', 1890, 1),
(3, 'Pan Tadeusz', 'Adam Mickiewicz', 'Epopeja narodowa', 1834, 1),
(4, 'Potop', 'Henryk Sienkiewicz', 'Powieść historyczna', 1886, 1),
(5, 'Ferdydurke', 'Witold Gombrowicz', 'Powieść', 1937, 1),
(6, 'Solaris', 'Stanisław Lem', 'Science fiction', 1961, 1),
(7, 'Kamienie na szaniec', 'Aleksander Kamiński', 'Literatura faktu', 1943, 1),
(8, 'Sklepy cynamonowe', 'Bruno Schulz', 'Opowiadania', 1934, 1),
(9, 'Quo Vadis', 'Henryk Sienkiewicz', 'Powieść historyczna', 1896, 1),
(10, 'Cesarz', 'Ryszard Kapuściński', 'Reportaż', 1978, 1),
(11, 'Zbrodnia i kara', 'Fiodor Dostojewski', 'Powieść psychologiczna', 1866, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `imie` varchar(64) NOT NULL,
  `nazwisko` varchar(64) NOT NULL,
  `id_klasa` int(11) NOT NULL,
  `isAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `imie`, `nazwisko`, `id_klasa`, `isAdmin`) VALUES
(2, 'titapiotr@gmail.com', '$2y$10$zhOZAm/omVaripYogRdB9uJF1h6O4o4slDVS.1/Xxov8BS2xfHt9i', 'Piotr', 'Maras', 1, 1),
(3, 'marcin@dubiel.com', '$2y$10$Eq5VwkCizm/Y.TJjcxWqSugxiLpUWlTv32Cv8hiVN2XFmePYZpGvK', 'Marcin', 'Dubiel', 4, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenia`
--

CREATE TABLE `wypozyczenia` (
  `id` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `data_wypozyczenia` date NOT NULL,
  `data_zwrotu` date DEFAULT NULL,
  `termin_zwrotu` date NOT NULL,
  `oddana` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `wypozyczenia`
--

INSERT INTO `wypozyczenia` (`id`, `id_ksiazki`, `id_uzytkownika`, `data_wypozyczenia`, `data_zwrotu`, `termin_zwrotu`, `oddana`) VALUES
(1, 1, 3, '2025-05-16', '0000-00-00', '2025-05-15', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_klasa_users` (`id_klasa`);

--
-- Indeksy dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_wypozyczenia` (`id_uzytkownika`),
  ADD KEY `fk_ksiazki_wypozyczenia` (`id_ksiazki`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klasy`
--
ALTER TABLE `klasy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ksiazki`
--
ALTER TABLE `ksiazki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_klasa_users` FOREIGN KEY (`id_klasa`) REFERENCES `klasy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD CONSTRAINT `fk_ksiazki_wypozyczenia` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_wypozyczenia` FOREIGN KEY (`id_uzytkownika`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
