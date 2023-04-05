 USE kiriyena_db;
 
 ALTER TABLE `pardevejs` CHANGE `Izveidosanas_datums` `Izveidosanas_datums` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;
 ALTER TABLE `administrators` ADD `Attela_admin` TEXT NOT NULL AFTER `Parole`;
 ALTER TABLE `prece` CHANGE `Cena` `Cena` FLOAT(6,2) NOT NULL;
 
 INSERT INTO `pardevejs` (`Pardevejs_ID`, `Vards_pardevejs`, `Uzvards_pardevejs`, `E_pasts_pardevejs`, `T_numurs_pardevejs`, `Loma`, `Apraksts`, `Izveidosanas_datums`, `Brenda_nosaukums`, `Attela_URL`, `Parole_pardevejs`) VALUES (NULL, 'Karina', 'Roga', 'bluffHelp@gmail.com', '-', 'Pārdevējs', 'Я создаю косметику!', current_timestamp(), 'Bluff cosmetics', NULL, '123');
 INSERT INTO `kategorija` (`Kategorija_ID`, `Nosaukums_kategorija`) VALUES (NULL, 'Kosmētika');
 INSERT INTO `k_apakssadala` (`Kapakssadala_ID`, `Nosaukums_sadala`, `ID_Kategorija`) VALUES (NULL, 'Lūpu krāsas', '1');
 INSERT INTO `prece` (`Prece_ID`, `Nosaukums_prece`, `Cena`, `Statuss`, `Apraksts_prece`, `Attela_prece`, `Ipatnibas_prece`, `ID_Pardevejs`, `ID_KApakssadala`, `ID_Kategorija_KApakssadala`) VALUES (NULL, 'Bluff cosmetics', '6.50', 'Ir pieejams', 'BLUFF \"CLASSIC\" это кристально чистый блеск для губ со вкусом АРБУЗ, который ИДЕАЛЬНО увлажнит и смягчит ваши губы', NULL, 'Ручная работа\r\nТовар будет доставлен из: Латвия\r\nМатериалы: кокосовое масло, масло виноградных косточек, масло сладкого миндаля', '1', '1', '1');
