-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema kiriyena_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema kiriyena_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kiriyena_db` DEFAULT CHARACTER SET utf8 ;
USE `kiriyena_db` ;

-- -----------------------------------------------------
-- Table `kiriyena_db`.`Administrators`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiriyena_db`.`Administrators` (
  `Administrators_ID` INT NOT NULL AUTO_INCREMENT,
  `Vards` VARCHAR(50) NOT NULL,
  `Uzvards` VARCHAR(50) NOT NULL,
  `E_pasts` VARCHAR(100) NOT NULL,
  `T_numurs` VARCHAR(12) NULL,
  `Loma` VARCHAR(15) NOT NULL DEFAULT 'Administrātors',
  `Parole` VARCHAR(50) NOT NULL,
  `Attela_admin` TEXT NULL,
  PRIMARY KEY (`Administrators_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kiriyena_db`.`Pardevejs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiriyena_db`.`Pardevejs` (
  `Pardevejs_ID` INT NOT NULL AUTO_INCREMENT,
  `Vards_pardevejs` VARCHAR(50) NOT NULL,
  `Uzvards_pardevejs` VARCHAR(50) NOT NULL,
  `E_pasts_pardevejs` VARCHAR(100) NOT NULL,
  `T_numurs_pardevejs` VARCHAR(12) NULL,
  `Loma` VARCHAR(10) NOT NULL DEFAULT 'Pārdevējs',
  `Apraksts` TEXT NULL,
  `Izveidosanas_datums` DATETIME NULL,
  `Brenda_nosaukums` VARCHAR(100) NOT NULL,
  `Attela_URL` TEXT NULL,
  `Parole_pardevejs` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Pardevejs_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kiriyena_db`.`K_apakssadala`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiriyena_db`.`K_apakssadala` (
  `Kapakssadala_ID` INT NOT NULL AUTO_INCREMENT,
  `Nosaukums_sadala` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`Kapakssadala_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kiriyena_db`.`Kategorija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiriyena_db`.`Kategorija` (
  `Kategorija_ID` INT NOT NULL AUTO_INCREMENT,
  `Nosaukums_kategorija` VARCHAR(30) NOT NULL,
  `Kat_attela` TEXT NOT NULL,
  PRIMARY KEY (`Kategorija_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kiriyena_db`.`Prece`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiriyena_db`.`Prece` (
  `Prece_ID` INT NOT NULL AUTO_INCREMENT,
  `Nosaukums_prece` VARCHAR(100) NOT NULL,
  `Cena` FLOAT NOT NULL,
  `Statuss` ENUM('Nav pieejams', 'Ir pieejams') NOT NULL DEFAULT 'Ir pieejams',
  `Apraksts_prece` TEXT NULL,
  `Attela_prece` TEXT NULL,
  `Ipatnibas_prece` TEXT NULL,
  `ID_Pardevejs` INT NOT NULL,
  `IDKapakssadala` INT NOT NULL,
  `ID_Kategorija` INT NOT NULL,
  PRIMARY KEY (`Prece_ID`, `ID_Pardevejs`, `IDKapakssadala`, `ID_Kategorija`),
--  INDEX `fk_Prece_Pārdevējs_idx` (`ID_Pardevejs` ASC) VISIBLE,
--  INDEX `fk_Prece_K_apakssadala1_idx` (`IDKapakssadala` ASC) VISIBLE,
--  INDEX `fk_Prece_Kategorija1_idx` (`ID_Kategorija` ASC) VISIBLE,
  CONSTRAINT `fk_Prece_Pārdevējs`
    FOREIGN KEY (`ID_Pardevejs`)
    REFERENCES `kiriyena_db`.`Pardevejs` (`Pardevejs_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Prece_K_apakssadala1`
    FOREIGN KEY (`IDKapakssadala`)
    REFERENCES `kiriyena_db`.`K_apakssadala` (`Kapakssadala_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Prece_Kategorija1`
    FOREIGN KEY (`ID_Kategorija`)
    REFERENCES `kiriyena_db`.`Kategorija` (`Kategorija_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `kiriyena_db`.`Administrators`
-- -----------------------------------------------------
START TRANSACTION;
USE `kiriyena_db`;
INSERT INTO `kiriyena_db`.`Administrators` (`Administrators_ID`, `Vards`, `Uzvards`, `E_pasts`, `T_numurs`, `Loma`, `Parole`, `Attela_admin`) VALUES (DEFAULT, 'Karina', 'Štifurska', 'kstifurska@gmail.com', '+37126459875', 'Administrātors', '21232f297a57a5a743894a0e4a801fc3', 'https://cdn.onlinewebfonts.com/svg/img_325788.png');

COMMIT;

