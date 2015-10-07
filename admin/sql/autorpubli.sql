
CREATE TABLE IF NOT EXISTS `#__storepapers_autorpubli` (
  `ida` int(11) NOT NULL,
  `idp` int(11) NOT NULL,
  `prioridad` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`ida`,`idp`)
) ENGINE=MyISAM;
