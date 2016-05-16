+SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
+SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
+SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
+
+
+-- -----------------------------------------------------
+-- Table `organization_archive`
+-- -----------------------------------------------------
+CREATE TABLE IF NOT EXISTS `organization_archive` LIKE `organization`;
+
+ALTER TABLE `organization_archive` MODIFY COLUMN `id` int(11) NOT NULL,
+   DROP PRIMARY KEY, ENGINE = MyISAM, ADD action VARCHAR(8) DEFAULT 'insert' FIRST,
+   ADD revision INT(6) NOT NULL AUTO_INCREMENT AFTER action,
+   ADD dt_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() AFTER revision,
+   ADD PRIMARY KEY (`id`, revision);
+
+DROP TRIGGER IF EXISTS organization__ai;
+DROP TRIGGER IF EXISTS organization__au;
+DROP TRIGGER IF EXISTS organization__bd;
+
+CREATE TRIGGER organization__ai AFTER INSERT ON `organization` FOR EACH ROW
+   INSERT INTO `organization_archive` SELECT 'insert', NULL, NOW(), d.*
+                                 FROM `organization` AS d WHERE d.id = NEW.id;
+
+CREATE TRIGGER organization__au AFTER UPDATE ON `organization` FOR EACH ROW
+   INSERT INTO `organization_archive` SELECT 'update', NULL, NOW(), d.*
+                                 FROM `organization` AS d WHERE d.id = NEW.id;
+
+CREATE TRIGGER organization__bd BEFORE DELETE ON `organization` FOR EACH ROW
+   INSERT INTO `organization_archive` SELECT 'delete', NULL, NOW(), d.*
+                                 FROM `organization` AS d WHERE d.id = OLD.id;
+
+
+-- -----------------------------------------------------
+-- Table `patient_archive`
+-- -----------------------------------------------------
+CREATE TABLE IF NOT EXISTS `patient_archive` LIKE `patient`;
+
+ALTER TABLE `patient_archive` MODIFY COLUMN `id` int(11) NOT NULL,
+   DROP PRIMARY KEY, ENGINE = MyISAM, ADD action VARCHAR(8) DEFAULT 'insert' FIRST,
+   ADD revision INT(6) NOT NULL AUTO_INCREMENT AFTER action,
+   ADD dt_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER revision,
+   ADD PRIMARY KEY (`id`, revision);
+
+DROP TRIGGER IF EXISTS patient__ai;
+DROP TRIGGER IF EXISTS patient__au;
+DROP TRIGGER IF EXISTS patient__bd;
+
+CREATE TRIGGER patient__ai AFTER INSERT ON `patient` FOR EACH ROW
+   INSERT INTO `patient_archive` SELECT 'insert', NULL, NOW(), d.*
+                                      FROM `patient` AS d WHERE d.id = NEW.id;
+
+CREATE TRIGGER patient__au AFTER UPDATE ON `patient` FOR EACH ROW
+   INSERT INTO `patient_archive` SELECT 'update', NULL, NOW(), d.*
+                                      FROM `patient` AS d WHERE d.id = NEW.id;
+
+CREATE TRIGGER patient__bd BEFORE DELETE ON `patient` FOR EACH ROW
+   INSERT INTO `patient_archive` SELECT 'delete', NULL, NOW(), d.*
+                                      FROM `patient` AS d WHERE d.id = OLD.id;