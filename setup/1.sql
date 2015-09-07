CREATE TABLE `pictures` (
	`pid` INT(9) NOT NULL,
	`uid` INT(9) NULL DEFAULT NULL,
	`image` VARCHAR(255) NULL DEFAULT NULL,
	`title` VARCHAR(30) NULL DEFAULT NULL,
	`description` VARCHAR(255) NULL DEFAULT NULL,
	`link` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`pid`),
	UNIQUE INDEX `uid` (`uid`)
)
ENGINE=InnoDB
;