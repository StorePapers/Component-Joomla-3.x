
CREATE TABLE IF NOT EXISTS `#__storepapers_publicaciones` (
  `id` int(11) NOT NULL auto_increment,
  `idc` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `texto` mediumtext NOT NULL,
  `year` SMALLINT(6) NOT NULL,
  `published` TINYINT NOT NULL,
  `month` TINYINT(2) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
