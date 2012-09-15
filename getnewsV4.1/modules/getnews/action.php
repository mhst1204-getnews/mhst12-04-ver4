<?php

/**
 * @Project NUKEVIET 3.4
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 - 2012 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 08 Apr 2012 00:00:00 GMT GMT
 */

if(!defined('NV_IS_FILE_MODULES'))die('Stop!!!');

$sql_drop_module=array();
$sql_drop_module[]='DROP TABLE IF EXISTS `nv_xpath_new`';
$sql_drop_module[]='DROP TABLE IF EXISTS `nv_new_tem`';
$sql_drop_module[]='DROP TABLE IF EXISTS `config`';
$sql_drop_module[]='DROP TABLE IF EXISTS `tinchuyenmuc`';
$sql_drop_module[]='DROP TABLE IF EXISTS `chuyenmuc`';
$sql_drop_module[]='DROP TABLE IF EXISTS `auto_news`';
$sql_drop_module[]='DROP TABLE IF EXISTS `article_path`';

$sql_create_module=$sql_drop_module;
$sql_create_module[]='CREATE TABLE IF NOT EXISTS `nv_xpath_new` (
                      `site` varchar(100) NOT NULL,
                      `title` varchar(100) NOT NULL,
                      `head` varchar(300) NOT NULL,
                      `content` varchar(2000) NOT NULL,
                      PRIMARY KEY  (`site`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';

$sql_create_module[]='CREATE TABLE IF NOT EXISTS `nv_new_temp` (
                      `site` varchar(100) NOT NULL,
                      `link` varchar(100) NOT NULL
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
                    
$sql_create_module[]='CREATE TABLE IF NOT EXISTS `config` (
                      `action` varchar(10) NOT NULL,
                      `select` tinyint(1) NOT NULL,
                      PRIMARY KEY  (`action`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
                    
$sql_create_module[]='CREATE TABLE IF NOT EXISTS `tinchuyenmuc` (
                      `id` int(11) NOT NULL auto_increment,
                      `idcm` int(11) NOT NULL,
                      `link` varchar(200) NOT NULL,
                      `lastlink` varchar(100) NOT NULL,
                      PRIMARY KEY  (`id`)
                    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
                    
$sql_create_module[]='CREATE TABLE IF NOT EXISTS `chuyenmuc` (
                      `idcm` int(11) NOT NULL auto_increment,
                      `tencm` varchar(100) NOT NULL,
                      `link` varchar(200) NOT NULL,
                      `host` varchar(100) NOT NULL,
                      `rss` tinyint(1) NOT NULL,
                      PRIMARY KEY  (`idcm`)
                    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
                    
$sql_create_module[]='CREATE TABLE IF NOT EXISTS `auto_news` (
                      `id` int(11) NOT NULL auto_increment,
                      `idcm` int(11) NOT NULL,
                      `Title` varchar(200) NOT NULL,
                      `Description` varchar(300) NOT NULL,
                      `Contents` mediumtext NOT NULL,
                      PRIMARY KEY  (`id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
                    
$sql_create_module[]='CREATE TABLE IF NOT EXISTS `article_path` (
                      `id` int(11) NOT NULL auto_increment,
                      `host` varchar(100) NOT NULL,
                      `path` varchar(200) NOT NULL,
                      `titlepath` varchar(200) NOT NULL,
                      `despath` varchar(200) NOT NULL,
                      PRIMARY KEY  (`id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
?>