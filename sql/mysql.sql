# SQL Dump for wgfilemanager module
# PhpMyAdmin Version: 4.0.4
# https://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Sat Jun 29, 2024 to 13:11:46
# Server version: 8.0.31
# PHP Version: 7.4.33

#
# Structure table for `wgfilemanager_directory` 7
#

CREATE TABLE `wgfilemanager_directory` (
  `id`           INT(8)          UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id`    INT(8)         NOT NULL DEFAULT '0',
  `name`         VARCHAR(255)    NOT NULL DEFAULT '',
  `description`  TEXT            NOT NULL ,
  `fullpath`     VARCHAR(255)    NOT NULL DEFAULT '',
  `weight`       INT(10)         NOT NULL DEFAULT '0',
  `date_created` INT(11)         NOT NULL DEFAULT '0',
  `submitter`    INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

#
# Structure table for `wgfilemanager_file` 10
#

CREATE TABLE `wgfilemanager_file` (
  `id`           INT(8)          UNSIGNED NOT NULL AUTO_INCREMENT,
  `directory_id` INT(8)         NOT NULL DEFAULT '0',
  `name`         VARCHAR(255)    NOT NULL DEFAULT '',
  `description`  TEXT            NOT NULL ,
  `mimetype`     VARCHAR(255)    NOT NULL DEFAULT '',
  `mtime`        INT(11)         NOT NULL DEFAULT '0',
  `ctime`        INT(11)         NOT NULL DEFAULT '0',
  `size`         INT(11)         NOT NULL DEFAULT '0',
  `ip`           VARCHAR(45)     NOT NULL DEFAULT '',
  `status`       INT(1)          NOT NULL DEFAULT '0',
  `date_created` INT(11)         NOT NULL DEFAULT '0',
  `submitter`    INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

#
# Structure table for `wgfilemanager_mimetype` 9
#

CREATE TABLE `wgfilemanager_mimetype` (
   `id`           INT(8)          UNSIGNED NOT NULL AUTO_INCREMENT,
   `extension`    VARCHAR(255)    NOT NULL DEFAULT '',
   `mimetype`     VARCHAR(255)    NOT NULL DEFAULT '',
   `desc`         VARCHAR(255)    NOT NULL DEFAULT '',
   `admin`        INT(1)          NOT NULL DEFAULT '0',
   `user`         INT(1)          NOT NULL DEFAULT '0',
   `category`     INT(1)          NOT NULL DEFAULT '0',
   `date_created` INT(11)         NOT NULL DEFAULT '0',
   `submitter`    INT(10)         NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB;

#
# Structure table for `wgfilemanager_favorite` 5
#

CREATE TABLE `wgfilemanager_favorite` (
    `id`           INT(8)       UNSIGNED NOT NULL AUTO_INCREMENT,
    `directory_id` INT(8)       NOT NULL DEFAULT '0',
    `file_id`      INT(8)       NOT NULL DEFAULT '0',
    `date_created` INT(11)      NOT NULL DEFAULT '0',
    `submitter`    INT(10)      NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;
