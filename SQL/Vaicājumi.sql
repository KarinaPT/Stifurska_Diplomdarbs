USE kiriyena_db;
ALTER TABLE `pardevejs` CHANGE `Izveidosanas_datums` `Izveidosanas_datums` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

INSERT INTO `kategorija` (`Kategorija_ID`, `Nosaukums_kategorija`, `Kat_attela`) VALUES (NULL, 'Kosmētika', 'uploads/6463d41f2832c0.86656799.png');
INSERT INTO `kategorija` (`Kategorija_ID`, `Nosaukums_kategorija`, `Kat_attela`) VALUES (NULL, 'Apģērbs', 'uploads/6463d4a2925549.14582951.png');
INSERT INTO `kategorija` (`Kategorija_ID`, `Nosaukums_kategorija`, `Kat_attela`) VALUES (NULL, 'Roku darbs', 'uploads/6463db9bd7ec84.50129827.png');

INSERT INTO `k_apakssadala` (`Kapakssadala_ID`, `Nosaukums_sadala`) VALUES (NULL, 'Lūpu krāsas'), (NULL, 'Pildspalvas un kodoloņi');
INSERT INTO `k_apakssadala` (`Kapakssadala_ID`, `Nosaukums_sadala`) VALUES (NULL, 'Pušķi');

INSERT INTO `pardevejs` (`Pardevejs_ID`, `Vards_pardevejs`, `Uzvards_pardevejs`, `E_pasts_pardevejs`, `T_numurs_pardevejs`, `Loma`, `Apraksts`, `Izveidosanas_datums`, `Brenda_nosaukums`, `Attela_URL`, `Parole_pardevejs`) VALUES (NULL, 'Karina', 'Štifurska', 'kstifurska@gmail.com', '+37127079797', 'Pārdevējs', 'Laipni lūdzam mūsu veikalā \"Papīra tauriņi\" - mājīgā vietā, kur dzimst burvīgi pušķi, kas atdzīvina pasaku tēlus! Mēs esam mazs ģimenes bizness, kas specializējas unikālu pušķu izveidē no skaistiem papīra tauriņiem.\r\n\r\nKatrs mūsu pušķis ir radošas procesa rezultāts, kurā mēs apvienojam maigo papīra tekstūru ar izsmalcinātu dizainu. Mēs ar mīlestību un prasmi izgriežam, saliekam un veidojam dažādu izmēru, krāsu un faktūru tauriņus. Katrs tauriņš mūsu pušķos iemieso dabas skaistumu un izsmalcinātību.\r\n\r\nMūsu pušķi ar papīra tauriņiem sniegs prieku un sajūsminājumu jūsu tuviniekiem visos īpašajos dzīves brīžos: dzimšanas dienas, jubilejas, kāzas vai vienkārši kā uzmanības un mīlestības simbols. Tie ir lieliski interjera rotaslietas un ideāls dāvana, kas saglabās savu skaistumu uz ilgu laiku.', 
current_timestamp(), 'KIRIYENA', 'uploads/6463d7d3f0c859.06150434.png', '202cb962ac59075b964b07152d234b70');

INSERT INTO `prece` (`Prece_ID`, `Nosaukums_prece`, `Cena`, `Statuss`, `Apraksts_prece`, `Attela_prece`, `Ipatnibas_prece`, `ID_Pardevejs`, `IDKapakssadala`, `ID_Kategorija`) VALUES (NULL, 'Papīra tauriņi', '25.50', 'Ir pieejams', 'Šis skaistais pušķis no papīra tauriņiem ir patiesa mākslas darba izpausme, ko radījis talantīgs cilvēks. Katrs tauriņš šajā pušķī tiek izgriezts ar rokām, rūpīgi salocīts un uzmanīgi nostiprināts.\r\n\r\nKatras tauriņa izgatavošana prasa meistarību, uzmanību pret detaļām un radošu pieeju. Izmantojot dažādus papīra toņus un faktūras, šī pušķa autors veiksmīgi nodod dabiskās tauriņu skaistuma un izsmalcinātības jūtu. Viņš katrā darbā ievieto savu aizrautību un mīlestību pret mākslu, lai rezultātā tiktu radīts unikāls un nenopietojams pušķis.\r\n\r\nŠis pušķis no papīra tauriņiem nav tikai skaista dekorācija, bet arī maiguma, elegances un iedvesmas simbols. Tas būs lielisks dāvana īpašiem dzīves brīžiem - dzimšanas dienai, jubilejai, kāzām vai vienkārši kā simbols uzmanībai un mīlestībai pret tuvajām personām.', 'uploads/6463de967a0af8.78003787.jpg', '\r\nŠī pušķa trīs izcelšanās īpašības ir šādas:\r\n\r\nIndividualitāte: Šis pušķis no būmaļiem piedāvā klientam iespēju izvēlēties krāsu, kas viņam vislabāk patīk vai atbilst konkrētajai situācijai. Tas dod iespēju pielāgot pušķa izskatu un saskaņot to ar personiskajām vēlmēm vai notikuma tematiku.\r\n\r\nMāksliniecisks dizains: Katrs būmaļu pušķa elements ir rūpīgi izstrādāts, lai radītu skaisti izkārtojumu un harmoniju. Kombinējot dažādus būmaļu veidus, krāsas un izmērus, pušķis iegūst unikālu māksliniecisku izskatu, kas piesaista uzmanību un iepriecina acis.\r\n\r\nDabiskums un ilgstošība: Būmaļi ir dabiski un ilgstoši materiāli, kas nodrošina, ka šis pušķis saglabās savu skaistumu un svaigumu ilgāku laiku. Tas ir lielisks veids, kā izteikt mīlestību un rūpes, dāvinot kaut ko dabisku un ilgstošu saviem tuviniekiem vai sev.', '1', '3', '3');

UPDATE `politika` SET `Politika_apraksts` = 'Mēs apņemamies nodrošināt ātru un efektīvu atbildi uz visiem jautājumiem unsūdzībām, kas saistītas ar failu lejupielādi vai konta izveidošanu mūsu tirgū. Mēs novērtējam mūsu klientu laiku un cenšamies risināt jebkādas problēmas maksimāli ātri un efektīvi\r\n\r\nMūsu tehniskā atbalsta komanda ir gatava palīdzēt jums ar jebkuriem jautājumiem, kas saistīti ar failu lejupielādi vai konta izveidošanu. Mēs cenšamies atbildēt uz klientu jautājumiem un sūdzībām noteiktā laika periodā, kas tiks publicēts mūsu mājaslapā.\r\n\r\nMēs esam pārliecināti, ka ātras un efektīvas atbildes uz klientu jautājumiem palīdzēs uzlabot viņu apmierinātību ar mūsu tirgu un radīs pozitīvu iespaidu par mūsu uzņēmumu viņu acīs. Mēs cenšamies nodrošināt augstas kvalitātes klientu apkalpošanu un esam gatavi jums palīdzēt jebkurā laikā.\r\n' WHERE `politika`.`Politica_ID` = 1;
UPDATE `politika` SET `Politika_apraksts` = 'Mēs uzskatām, ka viena no mūsu galvenajām prioritātēm ir klientu apmācība, kā izmantot mūsu tirgu vislabāk. Mēs cenšamies padarīt procesu, kas saistīts ar mūsu tirgus izmantošanu, vienkāršu un saprotamu, un tam mēs sniedzam visu nepieciešamo informāciju mūsu vietnē.\r\n\r\nTurklāt, mēs piedāvājam iespēju saņemt personīgu konsultāciju no mūsu klientu atbalsta dienesta. Mūsu speciālisti ir gatavi palīdzēt jums atrisināt jebkādas problēmas, kas var rasties, izmantojot mūsu tirgu.\r\n' WHERE `politika`.`Politica_ID` = 2;
UPDATE `politika` SET `Politika_apraksts` = 'Mēs vēlamies uzsvērt, ka mūsu tirgus vieta ir tikai platforma, lai\r\nsavienotu pārdevējus un pircējus, un mums nav nekādas saistības ar preču apmaksas procesu. Pilna atbildība par preču apmaksu un patērētāju\r\naizsardzību pret krāpšanu ir pārdevēju un pircēju ziņā. Mēs nepieņemam\r\nsamaksu par precēm un ne sniedzam garantijas to kvalitātei un atbilstībai aprakstam. Mēs iesakām mūsu lietotājiem būt uzmanīgiem,\r\nveicot pirkumus, un obligāti pārbaudīt visus pasūtījuma detalizējumus,\r\npirms veicat apmaksu. Ja jums rodas kādas problēmas ar preču apmaksu,\r\nlūdzu, sazinieties ar pārdevēju tiešsaistē.\r\n' WHERE `politika`.`Politica_ID` = 4;
UPDATE `politika` SET `Politika_apraksts` = 'Mūsu tirgusvietā mēs neprasām pircējiem izveidot kontu, jo mūsu\r\nplatforma nav maksājumu apstrādātājs un nepārvalda maksājumu datus.\r\nTurklāt pircēju konta izveidošana nav obligāta, jo viņi var tieši sazināties ar pārdevēju, izmantojot e-pastu, ko pārdevējs norāda precī aprakstā vai zīmolu aprakstā. Tas padara pirkšanas procesu pārskatāmāku un vienkāršāku pircējiem, jo viņi var sazināties ar pārdevēju bez starpniekiem un saņemt informāciju par precēm. \r\n\r\nMūsu tirgusvietas pārdevējiem ir nepieciešams izveidot kontu, jo tikai reģistrēti pārdevēji var publicēt savas preces mūsu platformā. Bez\r\nkonta pārdevējs nevar publicēt sludinājumus par precēm, nepieņemt pasūtījumus un nevar sazināties ar potenciālajiem pircējiem. Konta izveide ļauj pārdevējiem pārvaldīt savus sludinājumus, saņemt paziņojumus par pasūtījumiem, tos apstrādāt un sazināties ar pircējiem ērtā laikā.\r\n\r\nTurklāt konta izveide mūsu platformā pārdevējiem ir garantija pircējiem, ka viņi strādā ar reālu pārdevēju, kurš neizvairās no anonimitātes. Mēs arī nodrošinām pārdevēju personības pārbaudi un\r\napstiprināšanu, kas palīdz aizsargāt patērētājus no krāpšanas.\r\n' WHERE `politika`.`Politica_ID` = 5;