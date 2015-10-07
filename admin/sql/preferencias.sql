
CREATE TABLE IF NOT EXISTS `#__storepapers_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` float(6) NOT NULL,
  `first` SMALLINT(6) NOT NULL DEFAULT '1980',
  `current` SMALLINT(6) NOT NULL DEFAULT '2013',
  `last` SMALLINT(6) NOT NULL DEFAULT '2020',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2;

INSERT IGNORE INTO `#__storepapers_config` (`id`, `version`, `first`, `current`, `last`) VALUES
(1, 1.4, 1980, 2013, 2020);
