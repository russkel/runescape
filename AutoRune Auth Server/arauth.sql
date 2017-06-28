CREATE TABLE `ARusers` (
  `id` int(4) NOT NULL auto_increment,
  `User` varchar(12) NOT NULL default '',
  `Pass` varchar(12) NOT NULL default '',
  `Email` varchar(30) default NULL,
  `Description` tinyblob,
  `ExpDate` bigint(12) default '0',
  `Disabled` int(2) default '0',
  `LastInTime` int(20) default NULL,
  `Command` varchar(50) default NULL,
  `Response` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;


CREATE TABLE `ARlog` (
  `IP` varchar(20) NOT NULL default '',
  `HOST` varchar(20) default NULL,
  `time` int(20) default NULL,
  `user` varchar(15) default NULL,
  `pass` varchar(15) default NULL,
  `vers` int(5) default NULL,
  `action` varchar(50) default NULL,
  `CPU` varchar(50) default NULL,
  PRIMARY KEY  (`IP`)
) TYPE=MyISAM;                         