# MySQL-Front 3.2  (Build 7.19)

# Host: mysql164.locaweb.com.br    Database: muraski1
# ------------------------------------------------------
# Server version 4.0.27-locaweb-log

#
# Table structure for table clientes_site
#

DROP TABLE IF EXISTS `clientes_site`;
CREATE TABLE `clientes_site` (
  `cs_cod` int(5) NOT NULL auto_increment,
  `cs_nome` varchar(150) NOT NULL default '',
  `cs_cpf` varchar(20) NOT NULL default '',
  `cs_nasc` date NOT NULL default '0000-00-00',
  `cs_tel` varchar(50) NOT NULL default '',
  `cs_cel` varchar(50) default NULL,
  `cs_email` varchar(200) NOT NULL default '',
  `cs_cep` varchar(8) NOT NULL default '',
  `cs_end` varchar(150) NOT NULL default '',
  `cs_bairro` varchar(50) NOT NULL default '',
  `cs_cidade` varchar(100) NOT NULL default '',
  `cs_estado` char(2) NOT NULL default '',
  `cs_pais` varchar(50) NOT NULL default '',
  `cs_senha` varchar(6) NOT NULL default '',
  PRIMARY KEY  (`cs_cod`)
) TYPE=MyISAM;


#
# Table structure for table imoveis_temp
#

DROP TABLE IF EXISTS `imoveis_temp`;
CREATE TABLE `imoveis_temp` (
  `sid` varchar(200) NOT NULL default '',
  `cod` varchar(50) NOT NULL default '',
  `p_data` date NOT NULL default '0000-00-00'
) TYPE=MyISAM;


#
# Table structure for table listas
#

DROP TABLE IF EXISTS `listas`;
CREATE TABLE `listas` (
  `l_cod` int(5) unsigned NOT NULL auto_increment,
  `l_sid` varchar(200) NOT NULL default '',
  `l_cliente` varchar(20) NOT NULL default '',
  `l_data` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`l_cod`),
  KEY `l_cod` (`l_cod`)
) TYPE=MyISAM;

