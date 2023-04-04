-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 04 2023 г., 18:49
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kiriyena_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `administrators`
--

CREATE TABLE `administrators` (
  `Administrators_ID` int(11) NOT NULL,
  `Vards` varchar(50) NOT NULL,
  `Uzvards` varchar(50) NOT NULL,
  `E_pasts` varchar(100) NOT NULL,
  `T_numurs` varchar(12) DEFAULT NULL,
  `Loma` varchar(15) NOT NULL DEFAULT 'Administrators',
  `Parole` varchar(50) NOT NULL,
  `Attela` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `administrators`
--

INSERT INTO `administrators` (`Administrators_ID`, `Vards`, `Uzvards`, `E_pasts`, `T_numurs`, `Loma`, `Parole`, `Attela`) VALUES
(1, 'Karina', 'Štifurska', 'kstifurska@gmail.com', '+37122006957', 'Administrators', '123', 'https://media.istockphoto.com/id/1192884194/ru/%D0%B2%D0%B5%D0%BA%D1%82%D0%BE%D1%80%D0%BD%D0%B0%D1%8F/%D0%B0%D0%B4%D0%BC%D0%B8%D0%BD-%D0%B7%D0%BD%D0%B0%D0%BA-%D0%BD%D0%B0-%D0%B7%D0%BD%D0%B0%D1%87%D0%BE%D0%BA-%D0%BD%D0%BE%D1%83%D1%82%D0%B1%D1%83%D0%BA%D0%B0-%D1%84%D0%BE%D0%BD%D0%B4%D0%BE%D0%B2%D1%8B%D0%B9-%D0%B2%D0%B5%D0%BA%D1%82%D0%BE%D1%80.jpg?s=170667a&w=0&k=20&c=IQQWi_Avb7R7ttuxgxkuPs63YIrGlAOpoxeeJZNlDdk=');

-- --------------------------------------------------------

--
-- Структура таблицы `kategorija`
--

CREATE TABLE `kategorija` (
  `Kategorija_ID` int(11) NOT NULL,
  `Nosaukums` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `kategorija`
--

INSERT INTO `kategorija` (`Kategorija_ID`, `Nosaukums`) VALUES
(1, 'Kosmētika');

-- --------------------------------------------------------

--
-- Структура таблицы `k_apakssadala`
--

CREATE TABLE `k_apakssadala` (
  `Kapakssadala_ID` int(11) NOT NULL,
  `Nosaukums_sadala` varchar(30) NOT NULL,
  `ID_Kategorija` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `k_apakssadala`
--

INSERT INTO `k_apakssadala` (`Kapakssadala_ID`, `Nosaukums_sadala`, `ID_Kategorija`) VALUES
(1, 'Lūpu krāsas', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pardevejs`
--

CREATE TABLE `pardevejs` (
  `Pardevejs_ID` int(11) NOT NULL,
  `Vards_pardevejs` varchar(50) NOT NULL,
  `Uzvards_pardevejs` varchar(50) NOT NULL,
  `E_pasts_pardevejs` varchar(100) NOT NULL,
  `T_numurs_pardevejs` varchar(12) DEFAULT NULL,
  `Loma` varchar(10) NOT NULL DEFAULT 'Pārdevējs',
  `Apraksts` varchar(250) DEFAULT NULL,
  `Izveidosanas_datums` datetime DEFAULT NULL,
  `Brenda_nosaukums` varchar(100) NOT NULL,
  `Attela_URL` text DEFAULT NULL,
  `Parole_pardevejs` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pardevejs`
--

INSERT INTO `pardevejs` (`Pardevejs_ID`, `Vards_pardevejs`, `Uzvards_pardevejs`, `E_pasts_pardevejs`, `T_numurs_pardevejs`, `Loma`, `Apraksts`, `Izveidosanas_datums`, `Brenda_nosaukums`, `Attela_URL`, `Parole_pardevejs`) VALUES
(1, 'Karina', 'Roga', 'bluffHelp@gmail.com', NULL, 'Pārdevējs', 'Apraksts', '2023-04-03 19:58:25', 'Bluff cosmetics', NULL, '123');

-- --------------------------------------------------------

--
-- Структура таблицы `prece`
--

CREATE TABLE `prece` (
  `Prece_ID` int(11) NOT NULL,
  `Nosaukums_prece` varchar(100) NOT NULL,
  `Cena` double NOT NULL,
  `Statuss` varchar(45) NOT NULL,
  `Apraksts_prece` text DEFAULT NULL,
  `Attela_prece` text DEFAULT NULL,
  `Ipatnibas` text DEFAULT NULL,
  `ID_Pardevejs` int(11) NOT NULL,
  `ID_KApakssadala` int(11) NOT NULL,
  `ID_Kategorija_KApakssadala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`Administrators_ID`);

--
-- Индексы таблицы `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`Kategorija_ID`);

--
-- Индексы таблицы `k_apakssadala`
--
ALTER TABLE `k_apakssadala`
  ADD PRIMARY KEY (`Kapakssadala_ID`,`ID_Kategorija`),
  ADD KEY `fk_K_apakssadala_Kategorija1` (`ID_Kategorija`);

--
-- Индексы таблицы `pardevejs`
--
ALTER TABLE `pardevejs`
  ADD PRIMARY KEY (`Pardevejs_ID`);

--
-- Индексы таблицы `prece`
--
ALTER TABLE `prece`
  ADD PRIMARY KEY (`Prece_ID`,`ID_Pardevejs`,`ID_KApakssadala`,`ID_Kategorija_KApakssadala`),
  ADD KEY `fk_Prece_Pārdevējs` (`ID_Pardevejs`),
  ADD KEY `fk_Prece_K_apakssadala1` (`ID_KApakssadala`,`ID_Kategorija_KApakssadala`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `administrators`
--
ALTER TABLE `administrators`
  MODIFY `Administrators_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `Kategorija_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `k_apakssadala`
--
ALTER TABLE `k_apakssadala`
  MODIFY `Kapakssadala_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pardevejs`
--
ALTER TABLE `pardevejs`
  MODIFY `Pardevejs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `prece`
--
ALTER TABLE `prece`
  MODIFY `Prece_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `k_apakssadala`
--
ALTER TABLE `k_apakssadala`
  ADD CONSTRAINT `fk_K_apakssadala_Kategorija1` FOREIGN KEY (`ID_Kategorija`) REFERENCES `kategorija` (`Kategorija_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `prece`
--
ALTER TABLE `prece`
  ADD CONSTRAINT `fk_Prece_K_apakssadala1` FOREIGN KEY (`ID_KApakssadala`,`ID_Kategorija_KApakssadala`) REFERENCES `k_apakssadala` (`Kapakssadala_ID`, `ID_Kategorija`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Prece_Pārdevējs` FOREIGN KEY (`ID_Pardevejs`) REFERENCES `pardevejs` (`Pardevejs_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
