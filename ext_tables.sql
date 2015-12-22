#
# Table structure for table 'tt_news'
#
CREATE TABLE tt_news (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime int(11) unsigned DEFAULT '0' NOT NULL,
  endtime int(11) unsigned DEFAULT '0' NOT NULL,
  fe_group varchar(100) DEFAULT '0' NOT NULL,
  title text,
  datetime int(11) unsigned DEFAULT '0' NOT NULL,
  image text,

  # @todo write migration script and then remove me
  imagecaption text,
  imagealttext text,
  imagetitletext text,

  related int(11) DEFAULT '0' NOT NULL,
  short text,
  bodytext mediumtext,
  author varchar(255) DEFAULT '' NOT NULL,
  author_email varchar(255) DEFAULT '' NOT NULL,

  news_files text,
  links text,
  type tinyint(4) DEFAULT '0' NOT NULL,
  page int(11) DEFAULT '0' NOT NULL,
  keywords text,
  archivedate int(11) DEFAULT '0' NOT NULL,
  ext_url varchar(255) DEFAULT '' NOT NULL,

  sys_language_uid int(11) DEFAULT '0' NOT NULL,
  l18n_parent int(11) DEFAULT '0' NOT NULL,
  l18n_diffsource mediumblob NOT NULL,


  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY datetime (datetime)

);

