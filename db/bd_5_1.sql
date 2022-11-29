SET FOREIGN_KEY_CHECKS=0
; 
/* Drop Tables */

DROP TABLE IF EXISTS `button` CASCADE
;

DROP TABLE IF EXISTS `const` CASCADE
;

DROP TABLE IF EXISTS `files` CASCADE
;

DROP TABLE IF EXISTS `label` CASCADE
;

DROP TABLE IF EXISTS `users` CASCADE
;

/* Create Tables */

CREATE TABLE `button`
(
	`b_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`b_key` VARCHAR(150) NULL,
	`b_value` VARCHAR(50) NULL,
	CONSTRAINT `PK_button` PRIMARY KEY (`b_id` ASC)
)

;

CREATE TABLE `const`
(
	`c_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`c_key` VARCHAR(150) NULL,
	`c_value` VARCHAR(150) NULL,
	CONSTRAINT `PK_const` PRIMARY KEY (`c_id` ASC)
)

;

CREATE TABLE `files`
(
	`f_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`login_id` INT UNSIGNED NULL,
	`extension` VARCHAR(150) NULL,
	`limit` INT UNSIGNED NULL,
	CONSTRAINT `PK_files` PRIMARY KEY (`f_id` ASC)
)

;

CREATE TABLE `label`
(
	`l_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`l_key` VARCHAR(150) NULL,
	`l_value` VARCHAR(150) NULL,
	CONSTRAINT `PK_other` PRIMARY KEY (`l_id` ASC)
)

;

CREATE TABLE `users`
(
	`u_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(150) NULL,
	`password` VARCHAR(150) NULL,
	`directory` VARCHAR(150) NULL,
	`limit_all` INT UNSIGNED NULL,
	CONSTRAINT `PK_users` PRIMARY KEY (`u_id` ASC)
)

;

/* Create Primary Keys, Indexes, Uniques, Checks */

ALTER TABLE `files` 
 ADD INDEX `IXFK_files_users` (`login_id` ASC)
;

/* Create Foreign Key Constraints */

ALTER TABLE `files` 
 ADD CONSTRAINT `FK_files_users`
	FOREIGN KEY (`login_id`) REFERENCES `users` (`u_id`) ON DELETE Cascade ON UPDATE Cascade
;

SET FOREIGN_KEY_CHECKS=1
; 
