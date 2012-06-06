CREATE TABLE `wiki_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL,
  `caption` varchar(255) NOT NULL,
  `type` enum('nav','link','page') NOT NULL DEFAULT 'page',
  `page_alias` varchar(255) NOT NULL,
  `link_url` text NOT NULL,
  `link_target` varchar(16) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wiki_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `content_length` int(11) unsigned NOT NULL,
  `content_keywords` varchar(255) NOT NULL,
  `content_numwords` int(11) NOT NULL,
  `locked` tinyint(1) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `internal` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idxUniqueAlias` (`alias`),
  FULLTEXT KEY `idxFtContent` (`content`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

