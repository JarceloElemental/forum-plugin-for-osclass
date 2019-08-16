CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ddforums (
  `ddf_id` int(11) NOT NULL AUTO_INCREMENT,
  `ddf_title` varchar(250) CHARACTER SET utf8 NOT NULL,
  `ddf_slug` varchar(150) NOT NULL,
  `ddf_description` text CHARACTER SET utf8 NOT NULL,
  `ddf_order` int(11) DEFAULT NULL,
  `ddf_date` date NOT NULL,
   PRIMARY KEY (`ddf_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';


CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ddtopics (
  `ddt_id` int(11) NOT NULL AUTO_INCREMENT,
  `ddf_fkid` tinyint(11),
  `ddt_title` varchar(250) CHARACTER SET utf8 NOT NULL,
  `ddt_slug` varchar(150) NOT NULL,
  `ddt_description` text CHARACTER SET utf8 NOT NULL,
  `ddt_user` varchar(250) CHARACTER SET utf8 NOT NULL,
  `ddt_views` varchar(150) NOT NULL,
  `ddt_locked` enum('1', '0') NOT NULL,
  `ddt_stick` enum('1', '0') NOT NULL,
  `ddt_date` timestamp NOT NULL,
  `ddt_last_update` timestamp NOT NULL,
 
  PRIMARY KEY (`ddt_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';


CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ddreplies (
  `ddr_id` int(11) NOT NULL AUTO_INCREMENT,
  `ddf_fkid` tinyint(11),
  `ddt_fkid` tinyint(11),
  `ddr_title` varchar(250) CHARACTER SET utf8 NOT NULL,
  `ddr_slug` varchar(150) NOT NULL,
  `ddr_description` text CHARACTER SET utf8 NOT NULL,
  `ddr_user` varchar(250) CHARACTER SET utf8 NOT NULL,
  `ddr_views` varchar(150) NOT NULL,
  `ddr_date` date NOT NULL,
 
  PRIMARY KEY (`ddr_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';