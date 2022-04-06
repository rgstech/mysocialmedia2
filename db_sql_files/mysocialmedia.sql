# Host: localhost  (Version 5.5.5-10.4.21-MariaDB)
# Date: 2022-03-09 23:17:44
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "tbusuario"
#
-- DATABASE NAME = mysocialmedia (create it before run thta script) 
--- Developed by / desenvolvido por Rodrigo Guimarães (github: rgstech)

DROP TABLE IF EXISTS `tbusuario`;
CREATE TABLE `tbusuario` (
  `usu_pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_login` varchar(25) NOT NULL,
  `usu_senha` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `usu_nome` varchar(150) NOT NULL,
  `usu_email` varchar(45) DEFAULT NULL,
  `usu_tel` varchar(25) DEFAULT NULL,
  `usu_img` varchar(45) DEFAULT NULL,
  `usu_dt_cad` datetime DEFAULT NULL,
  `usu_sexo` char(1) DEFAULT NULL,
  `usu_bio` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`usu_pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# Data for table "tbusuario"
#

INSERT INTO `tbusuario` VALUES (1,'rodrigo','$2y$10$/Hxttd42D5cIgfqk2liPb.u5xCE1KOqOBfj3AS25JE0kz1urEe5Y2','Rodrigo Guimarães','rod@email.net','7188888888','images/rod.jpg','2022-03-02 00:00:00','m','Web developer, freelance and longboard skater amateur'),(2,'usuario','$2y$10$1Wud8fG1b9LZnw9nDpzxjOYNsjo6E9LE.hDyRJzImUd2zzNce3GVG','Manolo da Silva ','user@email.net','799999999','images/manolo.jpg','2022-03-02 00:00:00','m','Usuario de testes'),(3,'rachel','$2y$10$2sk7JplCBR8Eg26xA6WnSee5V7CSdn1qePaY3USgIybAPvub3oi0q','Rachel Lawrence','rachel@email.net','796666666','images/rachel.jpg','2022-03-02 00:00:00','f','Filosofa, vegan e mutcho doida'),(4,'jessica','$2y$10$WgkaGC3OeDQdt9AU/oK1zOAqF7pDVIv0E5Hoc92FtLc/pqJ3lFwWu','Jessica Wauters','jessi@myemail.net','7177889900','images/jessica.jpg','2022-03-02 00:00:00','f','Nutricionista , que ama nutrição esportiva e viagens'),(5,'inna','$2y$10$FUtkrHLdkNMH/FhsePueueI1DoE74s.pbAkkIRwEZIim0knnfsO7i','Elena Alexandra ','inna@clubrokcers.com','7188997766','images/inna.jpg','2022-03-02 00:00:00','f','Cantora, compositora e skatistas nas horas vagas'),(6,'amanda','$2y$10$QMo909pbJrsJMMOcb4a8Weyn10Rr1wu.jzawnMZf0xvjdhjuYHRJq','Amanda Barbosa','amanda@email.com','989898989898','images/amanda.jpg','2022-03-02 00:00:00','f','Estilista, amante de crossfit');

#
# Structure for table "tbpost"
#

DROP TABLE IF EXISTS `tbpost`;
CREATE TABLE `tbpost` (
  `pst_pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `pst_fk_usu` int(11) DEFAULT NULL,
  `pst_text` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `pst_dt_pst` datetime DEFAULT NULL,
  PRIMARY KEY (`pst_pk_id`),
  KEY `pst_fk_usu_idx` (`pst_fk_usu`),
  CONSTRAINT `pst_fk_usu` FOREIGN KEY (`pst_fk_usu`) REFERENCES `tbusuario` (`usu_pk_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

#
# Data for table "tbpost"
#

INSERT INTO `tbpost` VALUES (5,3,'Bom dia queridossss =)) S2 S2','2022-03-02 14:36:34'),(6,1,'  Fala gatenhas! XD ','2022-03-02 14:39:35'),(9,2,' Oia eu aqui pra fazer manolagem! =P','2022-03-02 02:04:58'),(10,5,'  To na area! Kisses =****','2022-03-02 02:06:03'),(11,4,'E ai gente como foi o evento ontem? ^^','2022-03-02 02:07:00'),(24,2,'Oia! Eu aqui de novo! ^^ ','2022-03-09 21:37:52'),(25,6,'Oiii genteee! =)))','2022-03-09 22:35:59'),(26,1,'Fala! Amanda =*','2022-03-09 22:41:11'),(27,3,'Ola, People! XD  #Sextou!','2022-03-09 23:07:53');

#
# Structure for table "tbcomment"
#

DROP TABLE IF EXISTS `tbcomment`;
CREATE TABLE `tbcomment` (
  `com_pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_fk_usu` int(11) DEFAULT NULL,
  `com_fk_pst` int(11) DEFAULT NULL,
  `com_text` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `com_dt_com` datetime DEFAULT NULL,
  PRIMARY KEY (`com_pk_id`),
  KEY `com_fk_usu_idx` (`com_fk_usu`),
  KEY `com_fk_pst_idx` (`com_fk_pst`),
  CONSTRAINT `com_fk_pst` FOREIGN KEY (`com_fk_pst`) REFERENCES `tbpost` (`pst_pk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `com_fk_usu` FOREIGN KEY (`com_fk_usu`) REFERENCES `tbusuario` (`usu_pk_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

#
# Data for table "tbcomment"
#

INSERT INTO `tbcomment` VALUES (38,1,11,'Otimo! =)','2022-03-02 13:13:39'),(39,1,10,'=)))','2022-03-02 16:36:08'),(46,1,5,'OI! =)','2022-03-02 15:47:28'),(48,4,6,'OI!','2022-03-07 23:18:59');

#
# Structure for table "tblike"
#

DROP TABLE IF EXISTS `tblike`;
CREATE TABLE `tblike` (
  `lik_pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `lik_fk_post` int(11) DEFAULT NULL,
  `lik_fk_usu` int(11) DEFAULT NULL,
  `lik_fk_com` int(11) DEFAULT NULL,
  PRIMARY KEY (`lik_pk_id`),
  KEY `lik_fk_post_idx` (`lik_fk_post`),
  KEY `lik_fk_usu_idx` (`lik_fk_usu`),
  KEY `lik_fk_com_idx` (`lik_fk_com`),
  CONSTRAINT `lik_fk_com` FOREIGN KEY (`lik_fk_com`) REFERENCES `tbcomment` (`com_pk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lik_fk_post` FOREIGN KEY (`lik_fk_post`) REFERENCES `tbpost` (`pst_pk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lik_fk_usu` FOREIGN KEY (`lik_fk_usu`) REFERENCES `tbusuario` (`usu_pk_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

#
# Data for table "tblike"
#

INSERT INTO `tblike` VALUES (85,6,3,NULL),(86,5,4,NULL),(87,6,1,NULL),(88,5,1,NULL),(91,10,1,NULL),(96,5,5,NULL),(97,11,1,NULL),(98,9,1,NULL),(99,9,2,NULL),(100,6,2,NULL),(101,5,2,NULL),(102,11,2,NULL),(105,NULL,1,38),(108,NULL,1,46),(111,11,4,NULL),(112,NULL,4,48),(117,24,2,NULL),(118,24,1,NULL),(119,25,6,NULL);

#
# View "home_view"
#

DROP VIEW IF EXISTS `home_view`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `home_view`
  AS
  SELECT
    `p`.`pst_pk_id` AS 'pid',
    `p`.`pst_text` AS 'texto',
    `p`.`pst_dt_pst` AS 'data',
    (SELECT COUNT(0) FROM `tblike` l2 WHERE `l2`.`lik_fk_post` = `p`.`pst_pk_id`) AS 'qtdlike',
    (SELECT COUNT(0) FROM `tbcomment` c2 WHERE `c2`.`com_fk_pst` = `p`.`pst_pk_id`) AS 'qtdcom',
    `u`.`usu_pk_id` AS 'uid',
    `u`.`usu_nome` AS 'nome',
    `u`.`usu_img` AS 'image'
  FROM
    (`tbpost` p
      LEFT JOIN `tbusuario` u ON (`p`.`pst_fk_usu` = `u`.`usu_pk_id`))
  ORDER BY `p`.`pst_dt_pst` DESC;
