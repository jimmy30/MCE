/*
SQLyog - Free MySQL GUI v5.19
Host - 5.0.22-community-nt : Database - mce
*********************************************************************
Server version : 5.0.22-community-nt
*/

SET NAMES utf8;

SET SQL_MODE='';

create database if not exists `mce`;

USE `mce`;

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';

/*Table structure for table `accounttype` */

DROP TABLE IF EXISTS `accounttype`;

CREATE TABLE `accounttype` (
  `AccountTypeId` bigint(20) NOT NULL auto_increment,
  `AccountTypeName` varchar(100) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`AccountTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `accounttype` */

insert into `accounttype` (`AccountTypeId`,`AccountTypeName`,`CreateDate`,`IsActive`) values (1,'Free','2003-07-06',1);
insert into `accounttype` (`AccountTypeId`,`AccountTypeName`,`CreateDate`,`IsActive`) values (2,'Premium','2003-07-06',1);

/*Table structure for table `adds` */

DROP TABLE IF EXISTS `adds`;

CREATE TABLE `adds` (
  `AddsId` int(11) NOT NULL auto_increment,
  `AddsName` varchar(150) default NULL,
  `AddsDescription` varchar(300) default NULL,
  `Image` varchar(300) default NULL,
  `ExpiryDate` date default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  `AdSize` varchar(50) default NULL,
  `Sniffed` text,
  PRIMARY KEY  (`AddsId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `adds` */

insert into `adds` (`AddsId`,`AddsName`,`AddsDescription`,`Image`,`ExpiryDate`,`CreateDate`,`IsActive`,`AdSize`,`Sniffed`) values (51,'asdfds','dfgsdf','searchCrimeResult.jpg','1982-01-01','2006-08-21',1,'','<script type=\"text/javascript\"><!--\r\ngoogle_ad_client = \"pub-7882659949558313\";\r\ngoogle_ad_width = 200;\r\ngoogle_ad_height = 200;\r\ngoogle_ad_format = \"200x200_as\";\r\ngoogle_ad_type = \"image\";\r\ngoogle_ad_channel = \"\";\r\ngoogle_color_border = \"FFFFFF\";\r\ngoogle_color_bg = \"FFFFFF\";\r\ngoogle_color_link = \"000000\";\r\ngoogle_color_text = \"000000\";\r\ngoogle_color_url = \"000000\";\r\n//--></script>\r\n<script type=\"text/javascript\"\r\n  src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">\r\n</script>');

/*Table structure for table `addsgroup` */

DROP TABLE IF EXISTS `addsgroup`;

CREATE TABLE `addsgroup` (
  `AddsGroupId` bigint(20) NOT NULL auto_increment,
  `AddsId` int(11) default NULL,
  `GroupId` int(11) default NULL,
  PRIMARY KEY  (`AddsGroupId`),
  KEY `FK_addsgroup` (`AddsId`),
  KEY `FK_groupadds` (`GroupId`),
  CONSTRAINT `addsgroup_ibfk_1` FOREIGN KEY (`AddsId`) REFERENCES `adds` (`AddsId`),
  CONSTRAINT `addsgroup_ibfk_2` FOREIGN KEY (`GroupId`) REFERENCES `groups` (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `addsgroup` */

insert into `addsgroup` (`AddsGroupId`,`AddsId`,`GroupId`) values (18,51,1);
insert into `addsgroup` (`AddsGroupId`,`AddsId`,`GroupId`) values (19,51,2);
insert into `addsgroup` (`AddsGroupId`,`AddsId`,`GroupId`) values (20,51,3);

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) character set latin1 collate latin1_bin default NULL,
  PRIMARY KEY  (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert into `admin` (`Email`,`Password`) values ('jimmy30@gmail.com','123456');

/*Table structure for table `cellularprovider` */

DROP TABLE IF EXISTS `cellularprovider`;

CREATE TABLE `cellularprovider` (
  `CellularId` bigint(20) NOT NULL auto_increment,
  `CellularCode` bigint(20) default NULL,
  `CellularProvider` varchar(100) default NULL,
  `Email` varchar(150) default NULL,
  `CreatedDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  `CountryId` bigint(20) default NULL,
  PRIMARY KEY  (`CellularId`),
  KEY `FK_cellularprovider` (`CountryId`),
  CONSTRAINT `cellularprovider_ibfk_1` FOREIGN KEY (`CountryId`) REFERENCES `country` (`CountryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cellularprovider` */

insert into `cellularprovider` (`CellularId`,`CellularCode`,`CellularProvider`,`Email`,`CreatedDate`,`IsActive`,`CountryId`) values (1,1,'3 River Wireless',NULL,'2006-10-19',1,1);
insert into `cellularprovider` (`CellularId`,`CellularCode`,`CellularProvider`,`Email`,`CreatedDate`,`IsActive`,`CountryId`) values (2,2,'ACS Wireless',NULL,'2006-10-19',1,1);
insert into `cellularprovider` (`CellularId`,`CellularCode`,`CellularProvider`,`Email`,`CreatedDate`,`IsActive`,`CountryId`) values (3,3,'Ufone Pakistan','ufone.com','2006-10-19',1,2);
insert into `cellularprovider` (`CellularId`,`CellularCode`,`CellularProvider`,`Email`,`CreatedDate`,`IsActive`,`CountryId`) values (4,4,'Mobilink','mobilinkgsm.com','2006-10-19',1,2);
insert into `cellularprovider` (`CellularId`,`CellularCode`,`CellularProvider`,`Email`,`CreatedDate`,`IsActive`,`CountryId`) values (5,5,'Nextel',NULL,'2006-11-01',1,1);
insert into `cellularprovider` (`CellularId`,`CellularCode`,`CellularProvider`,`Email`,`CreatedDate`,`IsActive`,`CountryId`) values (6,6,'Cingular','mms.mycingular.com','2007-01-07',1,1);

/*Table structure for table `consumer` */

DROP TABLE IF EXISTS `consumer`;

CREATE TABLE `consumer` (
  `ConsumerId` bigint(20) NOT NULL auto_increment,
  `CountryId` bigint(20) default NULL,
  `StateId` bigint(20) default NULL,
  `AccountType` bigint(20) default NULL,
  `QuestionId` bigint(11) default NULL,
  `Email` varchar(100) default NULL,
  `Password` varchar(100) default NULL,
  `FirstName` varchar(100) default NULL,
  `LastName` varchar(100) default NULL,
  `Address` varchar(200) default NULL,
  `City` varchar(100) default NULL,
  `ZipCode` varchar(100) default NULL,
  `Telephone1` varchar(100) default NULL,
  `DateOfBirth` date default NULL,
  `Answer` varchar(250) default NULL,
  `ActivationCode` varchar(250) default NULL,
  `IsVarified` tinyint(1) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  `Mobile` varchar(100) default NULL,
  `CellularId` bigint(20) default NULL,
  PRIMARY KEY  (`ConsumerId`),
  UNIQUE KEY `Email` (`Email`),
  KEY `CUTOMER_COUNTRY` (`CountryId`),
  KEY `CUSTOMER_STATE` (`StateId`),
  KEY `CUSTOMER_ACCOUNTTYPE` (`AccountType`),
  KEY `CUSTOMER_SECERETQUESTION` (`QuestionId`),
  KEY `FK_consumer` (`CellularId`),
  CONSTRAINT `consumer_ibfk_1` FOREIGN KEY (`CountryId`) REFERENCES `country` (`CountryId`),
  CONSTRAINT `consumer_ibfk_2` FOREIGN KEY (`StateId`) REFERENCES `state` (`StateId`),
  CONSTRAINT `consumer_ibfk_3` FOREIGN KEY (`AccountType`) REFERENCES `accounttype` (`AccountTypeId`),
  CONSTRAINT `consumer_ibfk_4` FOREIGN KEY (`QuestionId`) REFERENCES `seceretquestion` (`QuestionId`),
  CONSTRAINT `consumer_ibfk_5` FOREIGN KEY (`CellularId`) REFERENCES `cellularprovider` (`CellularId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `consumer` */

insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (21,1,1,1,1,'alirazvi@gmail.com','abc123','Ali','Razvi','xyz','xyz','123456','9059021214-','1981-01-30','testing','yc9wfr3y3j4rk6i6bdv0',1,'2006-06-14',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (22,1,1,2,1,'kmir@fiveriverstech.com','khurram','khurram','mir','22 fleming road ','Lahoew','111111','7227598-','1999-01-01','dog','yvuemeyxx1fzjep2h0mw',1,'2006-06-14',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (23,1,1,2,1,'smilingmir@hotmail.com','khurram','Khurram','mir','22 fleming road','22 fleming road ','123456','7227598-111','1990-01-20','dog','hf1va1c8rj9jqndjsrrm',1,'2006-06-14',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (24,1,1,1,1,'zeeshank2000@yahoo.com','letmein','Zeeshan','Khawar','59 sadadasd','Lahore','434343','3234234-433','1980-01-01','Pesto','3id3ptaemstvoah68286',1,'2006-06-15',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (32,2,52,1,1,'jimmy30@gmail.com','123456','jamshaid','bukhari','Zafar Ali road, Gulberg','Lahore','12345','123456789-111','1980-01-01','a','pf4bjsnllawvcsx1y95p',1,'2006-06-20',1,'923334415532',3);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (60,1,1,1,1,'nabeelbinezad@yahoo.com','123456','Test ','ete','sea','sadf','123456','324-33','1982-01-01','2','novv60tkahe8eui63d23',0,'0106-07-31',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (61,1,1,1,1,'nabeel.ezad@gmail.com','123456','Nabeel','Ezad','asdf','asdf','343444','34343-343','1982-01-01','a','uy4uvbxmxtqdpfe7meby',1,'0106-07-31',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (62,1,1,1,1,'anxious30@hotmail.com','123456','abc','producer','sldkj','lkjsjdf','123456','123-','1980-01-01','a','zv491205f5664m52443d',0,'2006-08-01',0,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (63,1,1,1,1,'test@gmail.com','test','asdfd','mir','22 fleming road lahore','asdf','34343','343434-34343','1980-01-01','abc','wt4z4gq335vaqv0xt0ew',1,'2006-09-19',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (64,1,1,1,1,'nabeelbinezada@hotmail.com','123456','asdfd','asdf','22 fleming road lahore','asdf','34343','111-127','1978-01-01','a','0sei752jcyxvqvdulgt1',0,'2006-09-19',1,NULL,NULL);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (65,1,1,1,1,'nabeelbineaaazad@hotmail.com','123456','asdfd','asdf','234','asdf','343434','0321-4826995-127','1978-01-01','aa','va495ruyfcjdarfbozvn',0,'2006-09-19',1,'0321-4826995',1);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (66,1,1,1,1,'Testjimmy@gmail.com','123456','asdfdsdf','asdf','22 fleming road lahore','asdf','343434','0321-4826995-3','1978-01-01','a','llidhhbhtw3o3rml5x2z',0,'2006-09-19',1,'34553434',1);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (67,2,52,1,1,'nabeelezad@hotmail.com','123456','testcellular','asd','sdf','sdaf','54600','0321-4826995-','1980-01-01','abc','v61cufv57clyd6hwopgz',0,'2006-10-01',1,'0321-4826995',3);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (68,2,52,1,2,'csofts@hotmail.com','smk123','Khurrum ','Dawood','lahore','lahore','54322','7212327-92','2006-07-01','dawood','mcbgc5bo5a5wh743dfyg',1,'2006-10-02',1,'5127738644',6);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (69,1,1,1,1,'jimmy31@gmail.com','123456','dfg','dfg','dfg','dfg','123456','654654654-','1980-01-01','a','00w0zugkujr61lydsu5y',1,'2006-10-06',1,'4654132165',1);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (70,1,1,1,1,'abcdefgh@hotmail.com','123456','ABCDEFGHI','SDLKJF','sldkjf','lsdkfj','12345','123-123','1980-01-01','a','kwhkufb4qpd98cidoiuh',1,'2006-10-22',1,'123456789',1);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (72,1,1,1,1,'jimmi_31@yahoo.com','123456','jimmy','sldkjf','sdldkjf','sldkjf','12345','123165465-123','1980-01-01','a','hzx4dduamf2f4bxo0afr',1,'2006-10-23',1,'45646546565',1);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (75,1,1,1,1,'abcd@gmail.com','123456','sdf','sdf','sdf','dfg','12345','12312-','1980-01-01','a','jnjrxyeqnhlt9wsqkgsq',1,'2006-10-23',1,'1223132',1);
insert into `consumer` (`ConsumerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`,`Mobile`,`CellularId`) values (76,2,52,2,1,'simplykashifali@yahoo.com','abcdef','kashif','Ali','Huu1222','Lahore','54440','0425152868-','1980-09-01','lahore','v621d6yyn65nk1aq42q9',1,'0106-11-14',1,'03004718010',4);

/*Table structure for table `consumeralerts` */

DROP TABLE IF EXISTS `consumeralerts`;

CREATE TABLE `consumeralerts` (
  `ConsumerAlertId` bigint(20) NOT NULL auto_increment,
  `ConsumerId` bigint(20) default NULL,
  `CountryId` bigint(20) default NULL,
  `AddAction` tinyint(4) default NULL,
  `ModifyAction` tinyint(4) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(4) default NULL,
  PRIMARY KEY  (`ConsumerAlertId`),
  KEY `FK_consumeralerts` (`ConsumerId`),
  CONSTRAINT `consumeralerts_ibfk_1` FOREIGN KEY (`ConsumerId`) REFERENCES `consumer` (`ConsumerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `consumeralerts` */

insert into `consumeralerts` (`ConsumerAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (33,32,1,1,1,'2006-08-08',1);
insert into `consumeralerts` (`ConsumerAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (34,32,2,1,1,'2006-08-14',0);
insert into `consumeralerts` (`ConsumerAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (35,32,-1,1,1,'2006-08-14',0);
insert into `consumeralerts` (`ConsumerAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (36,61,1,1,0,'2006-08-15',0);
insert into `consumeralerts` (`ConsumerAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (40,68,1,1,1,'2006-10-24',1);

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `CountryId` bigint(20) NOT NULL auto_increment,
  `CountryName` varchar(100) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`CountryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `country` */

insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (1,'United States','2003-07-06',1);
insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (2,'Pakistan','2006-07-28',1);
insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (3,'India','2006-07-28',1);
insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (16,'pakistan',NULL,NULL);
insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (17,'pakistan',NULL,NULL);
insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (18,'pakistan',NULL,NULL);
insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (19,'pakistan',NULL,NULL);
insert into `country` (`CountryId`,`CountryName`,`CreateDate`,`IsActive`) values (20,'pakistan',NULL,NULL);

/*Table structure for table `featurestat` */

DROP TABLE IF EXISTS `featurestat`;

CREATE TABLE `featurestat` (
  `StatId` bigint(20) NOT NULL auto_increment,
  `UserType` tinyint(1) default '0',
  `PageTitle` varchar(250) default NULL,
  `PageUrl` varchar(250) default NULL,
  `hits` int(11) default '0',
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default '0',
  PRIMARY KEY  (`StatId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `featurestat` */

insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (1,0,'SignUp Options','/SignUpOption.php',13,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (2,2,'Registration','/registration.php',9,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (3,1,'Registration','/registration.php',7,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (4,2,'Account Activation','/ProducerActivation.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (5,1,'Account Activation','/ConsumerActivation.php',6,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (6,0,'Home','/index.php',31,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (7,0,'Features','/Features.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (8,0,'About Us','/AboutUs.php',2,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (9,0,'Contact Us','/ContactUs.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (10,0,'Help','/Help.php',1,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (11,0,'Sign In','/CustomerSignIn.php',161,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (12,0,'Forget Password','/ForgetPassword.php',9,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (13,2,'View PlaceCast','/viewPlaceCast.php',239,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (14,1,'View PlaceCast','/viewPlaceCast.php',51,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (15,2,'PlaceCast Detail','/PlaceCastDetail.php',6,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (16,1,'PlaceCast Detail','/PlaceCastDetail.php',2,'2006-02-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (17,2,'View Waypoint','/ViewWaypoint.php',202,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (18,1,'View Waypoint','/ViewWaypoint.php',1,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (19,2,'Waypoint Detail','/WaypointDetail.php',10,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (20,1,'Waypoint Detail','/WaypointDetail.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (21,1,'View Slide Show','/ViewSlideShow.php',11,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (22,1,'Add Email Alert','/AddConsumerAlerts.php',7,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (23,1,'View Email Alert','/ViewConsumerAlerts.php',6,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (24,1,'Edit Email Alert','/EditConsumerAlerts.php',2,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (25,1,'Add Sms Alert','/AddSmsAlerts.php',3,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (26,1,'View Sms Alert','/ViewSmsAlerts.php',4,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (27,1,'Edit sms Alert','/EditSmsAlerts.php',1,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (28,0,'Preferences','/Preferences.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (29,2,'Change Password','/ProducerChangePassword.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (30,1,'Change Password','/ConsumerChangePassword.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (31,2,'Edit Profile','/ProducerProfile.php',4,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (32,1,'Edit Profile','/ConsumerProfile.php',3,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (33,0,'Switch','/switch.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (34,2,'Add PlaceCast','/AddPlaceCast.php',527,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (35,2,'Edit PlaceCast','/EditPlaceCast.php',103,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (36,2,'Add Waypoint','/AddWaypoint.php',192,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (37,2,'Edit Waypoint','/EditWaypoint.php',76,'2006-01-04',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (38,2,'Content Editor','/mce.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (39,2,'File Manager','/FileDetail.php',54,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (40,2,'Search Text','/SearchSpider.php',0,'2006-01-01',1);
insert into `featurestat` (`StatId`,`UserType`,`PageTitle`,`PageUrl`,`hits`,`CreateDate`,`IsActive`) values (41,0,'Sign Out','/CustomerSignout.php',24,'2006-01-01',1);

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `GroupId` int(11) NOT NULL,
  `GroupName` varchar(300) default NULL,
  PRIMARY KEY  (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `groups` */

insert into `groups` (`GroupId`,`GroupName`) values (1,'PlaceCast');
insert into `groups` (`GroupId`,`GroupName`) values (2,'WayPoints');
insert into `groups` (`GroupId`,`GroupName`) values (3,'Main');
insert into `groups` (`GroupId`,`GroupName`) values (4,'Admin');
insert into `groups` (`GroupId`,`GroupName`) values (5,'Alert');
insert into `groups` (`GroupId`,`GroupName`) values (6,'Producer');

/*Table structure for table `page` */

DROP TABLE IF EXISTS `page`;

CREATE TABLE `page` (
  `PageId` int(11) NOT NULL auto_increment,
  `PageName` varchar(300) NOT NULL,
  PRIMARY KEY  (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `page` */

insert into `page` (`PageId`,`PageName`) values (1,'Waypoint/Consumer/ViewWaypoint.php');
insert into `page` (`PageId`,`PageName`) values (2,'index.php');
insert into `page` (`PageId`,`PageName`) values (3,'Features.php');
insert into `page` (`PageId`,`PageName`) values (4,'AboutUs.php');
insert into `page` (`PageId`,`PageName`) values (5,'ContactUs.php');
insert into `page` (`PageId`,`PageName`) values (6,'CustomerSignIn.php');
insert into `page` (`PageId`,`PageName`) values (7,'placecast/consumer/viewPlaceCast.php');
insert into `page` (`PageId`,`PageName`) values (9,'Alert/ConsumerAlerts/AddConsumerAlerts.php');
insert into `page` (`PageId`,`PageName`) values (10,'CustomerSignout.php');
insert into `page` (`PageId`,`PageName`) values (11,'placecast/consumer/PlaceCastDetail.php');
insert into `page` (`PageId`,`PageName`) values (12,'admin/ads/EditAds.php');
insert into `page` (`PageId`,`PageName`) values (13,'placecast/Producer/viewPlaceCast.php');
insert into `page` (`PageId`,`PageName`) values (14,'Waypoint/Producer/ViewWaypoint.php');
insert into `page` (`PageId`,`PageName`) values (15,'mce.php');

/*Table structure for table `pagegroup` */

DROP TABLE IF EXISTS `pagegroup`;

CREATE TABLE `pagegroup` (
  `PageGroupId` bigint(20) NOT NULL,
  `GroupId` int(11) default NULL,
  `PageId` int(11) default NULL,
  PRIMARY KEY  (`PageGroupId`),
  KEY `FK_pagegroup` (`PageId`),
  KEY `FK_grouppage` (`GroupId`),
  CONSTRAINT `pagegroup_ibfk_1` FOREIGN KEY (`PageId`) REFERENCES `page` (`PageId`),
  CONSTRAINT `pagegroup_ibfk_2` FOREIGN KEY (`GroupId`) REFERENCES `groups` (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pagegroup` */

insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (1,3,2);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (2,3,3);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (3,3,4);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (4,3,5);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (5,1,7);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (6,1,11);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (8,2,1);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (9,5,9);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (10,6,13);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (11,6,14);
insert into `pagegroup` (`PageGroupId`,`GroupId`,`PageId`) values (12,3,15);

/*Table structure for table `placecast` */

DROP TABLE IF EXISTS `placecast`;

CREATE TABLE `placecast` (
  `PlaceCastId` bigint(20) NOT NULL auto_increment,
  `ProducerId` bigint(20) default NULL,
  `CountryId` bigint(20) default NULL,
  `StateId` bigint(20) default NULL,
  `Name` varchar(100) default NULL,
  `Address` varchar(200) NOT NULL,
  `City` varchar(100) default NULL,
  `ZipCode` varchar(100) default NULL,
  `Lat1` double default NULL,
  `Long1` double default NULL,
  `Lat2` double default NULL,
  `Long2` double default NULL,
  `Lat3` double default NULL,
  `Long3` double default NULL,
  `Lat4` double default NULL,
  `Long4` double default NULL,
  `Description` text,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`PlaceCastId`),
  KEY `FK_placecast_state` (`StateId`),
  KEY `FK_placecast` (`ProducerId`),
  KEY `placecast_country` (`CountryId`),
  CONSTRAINT `placecast_ibfk_3` FOREIGN KEY (`StateId`) REFERENCES `state` (`StateId`),
  CONSTRAINT `placecast_ibfk_5` FOREIGN KEY (`ProducerId`) REFERENCES `producer` (`ProducerId`),
  CONSTRAINT `placecast_ibfk_6` FOREIGN KEY (`CountryId`) REFERENCES `country` (`CountryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `placecast` */

insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (1,32,2,52,'Test Placecast','Test Street','Lahore','54600',31.835565983656,73.36669921875,31.994100723261,75.05859375,31.208103321325,75.1904296875,31.179909598664,73.575439453125,'ok','2006-10-22',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (2,81,2,52,'Test PlaceCast 1','Lahore','Lahore','54322',31.5748792971462,74.3448257446289,31.5680053858233,74.3887710571289,31.5431380714437,74.3904876708984,31.5364081294396,74.348087310791,'Test PlaceCast','2006-10-22',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (3,88,2,52,'sdf','sdf','sdf','12345',33.5230788089042,-102.3046875,34.5065566216456,-97.91015625,30.9964458974264,-102.392578125,31.409912194071,-97.3828125,'dfgdf','2006-10-23',0);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (5,81,1,1,'new','new','LAhore','54233',40.463666324588,-101.865234375,40.730608477797,-96.4599609375,37.90953361677,-96.0205078125,37.492293998629,-100.9423828125,'new','2006-10-24',0);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (7,81,1,44,'University of Austin at Texas','none','Austin','54322',30.288346853731,-97.7381086349487,30.2884209683434,-97.7251482009888,30.2808239293006,-97.7242040634155,30.2794156330466,-97.7374219894409,'New the','2006-10-30',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (8,32,1,44,'Univeristy of Texas ','none','Austin ','12345',30.288346853731,-97.7381086349487,30.2871980700781,-97.7251482009888,30.2808239293006,-97.7242040634155,30.2794156330466,-97.7374219894409,'College Campus Tour ','2006-10-30',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (9,32,1,44,'abc','none','abc','54322',30.2870498389495,-97.7358341217041,30.2873463009828,-97.7263927459717,30.2806756885414,-97.7242469787598,30.2803792063513,-97.7372074127197,'new','2006-10-30',0);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (10,32,1,44,'Texas Wine','none','Austin','12345',30.7583587125645,-99.239501953125,30.6355488265332,-97.66845703125,30.095236981933,-99.239501953125,29.9001866371774,-97.66845703125,'wine ','2006-11-02',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (11,32,1,44,'Texas Camps','none','Hunt ','12345',30.4889176761268,-99.77783203125,30.2685562490477,-98.85498046875,29.7953676632093,-98.7451171875,30.0144089732489,-100.203552246094,'Camps for kids','2006-11-02',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (12,32,1,44,'Austin Music Scene','none','Austin','12345',30.563443452781,-98.280944824219,30.561078433806,-97.40478515625,30.110681880126,-97.311401367188,30.198552988693,-98.171081542969,'Austin Music Scene','2006-11-02',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (13,81,2,52,'Park','none','Lahore','54322',35.6929946320988,-100.7666015625,36.2974181865081,-95.9765625,33.1927309419069,-95.712890625,30.8833693216923,-99.228515625,'new','2006-11-06',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (14,89,1,32,'New York, NY, USA','none','New York','54440',40.685845030007,-73.9469146728516,40.776381784829,-73.7491607666016,40.6848036615913,-73.5699462890625,40.6035267998859,-73.7766265869141,'123456','0106-11-14',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (15,89,1,32,'Ny','none','Ny','64444',34.5427623872348,-94.9658203125,38.9764924855394,-88.681640625,36.6155276313492,-85.6494140625,41.6564971944114,-97.03125,'ass','0106-11-14',0);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (16,32,1,1,'jimmy','none','sdlkf','12345',33.559706648412,-100.634765625,34.034452609676,-93.8232421875,29.935895213372,-93.4716796875,30.202113679097,-100.283203125,'$#%DFG DFGDFGDFG$%REG#$%$^$56\'\"\\-()<>','2006-11-18',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (17,81,2,52,'near FRT1','none','lahore','54322',31.5367190341881,74.3469178676605,31.5366733129665,74.3475615978241,31.5363075423876,74.3478941917419,31.5362343880998,74.3469500541687,'gulberg','2006-11-27',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (18,81,2,52,'Fiverivers','none','lahore','54322',31.5384930002987,74.3468105792999,31.5388770503788,74.3480658531189,31.5377706161055,74.3485057353973,31.5369019188507,74.3476474285126,'new','2006-11-27',1);
insert into `placecast` (`PlaceCastId`,`ProducerId`,`CountryId`,`StateId`,`Name`,`Address`,`City`,`ZipCode`,`Lat1`,`Long1`,`Lat2`,`Long2`,`Lat3`,`Long3`,`Lat4`,`Long4`,`Description`,`CreateDate`,`IsActive`) values (19,81,2,52,'land mark plaza','none','lahore','54322',31.5354479758865,74.3466711044312,31.5353748209253,74.3477654457092,31.5346889903763,74.3483340740204,31.5348078680324,74.3464779853821,'lahore','2006-11-27',1);

/*Table structure for table `placecastdownload` */

DROP TABLE IF EXISTS `placecastdownload`;

CREATE TABLE `placecastdownload` (
  `PlaceCastDownloadId` bigint(20) NOT NULL auto_increment,
  `CountryId` bigint(20) default NULL,
  `ConsumerId` bigint(20) default NULL,
  `PlaceCastId` bigint(20) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`PlaceCastDownloadId`),
  KEY `FK_consumer_placecastdownlaod` (`ConsumerId`),
  KEY `FK_placecast_placecastdownload` (`PlaceCastId`),
  KEY `FK_placecastdownload_country` (`CountryId`),
  CONSTRAINT `placecastdownload_ibfk_1` FOREIGN KEY (`ConsumerId`) REFERENCES `consumer` (`ConsumerId`),
  CONSTRAINT `placecastdownload_ibfk_2` FOREIGN KEY (`PlaceCastId`) REFERENCES `placecast` (`PlaceCastId`),
  CONSTRAINT `placecastdownload_ibfk_3` FOREIGN KEY (`CountryId`) REFERENCES `country` (`CountryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `placecastdownload` */

insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (1,2,32,1,'2006-10-24',1);
insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (2,1,32,14,'2006-11-15',1);
insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (3,1,32,14,'2006-11-15',1);
insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (4,2,32,2,'2006-11-15',1);
insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (5,1,32,5,'2006-11-18',1);
insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (6,2,32,1,'2006-11-18',1);
insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (7,1,32,8,'2006-11-18',1);
insert into `placecastdownload` (`PlaceCastDownloadId`,`CountryId`,`ConsumerId`,`PlaceCastId`,`CreateDate`,`IsActive`) values (8,1,32,16,'2006-11-18',1);

/*Table structure for table `producer` */

DROP TABLE IF EXISTS `producer`;

CREATE TABLE `producer` (
  `ProducerId` bigint(20) NOT NULL auto_increment,
  `CountryId` bigint(20) default NULL,
  `StateId` bigint(20) default NULL,
  `AccountType` bigint(20) default NULL,
  `QuestionId` bigint(11) default NULL,
  `Email` varchar(100) default NULL,
  `Password` varchar(100) default NULL,
  `FirstName` varchar(100) default NULL,
  `LastName` varchar(100) default NULL,
  `Address` varchar(200) default NULL,
  `City` varchar(100) default NULL,
  `ZipCode` varchar(100) default NULL,
  `Telephone1` varchar(100) default NULL,
  `DateOfBirth` date default NULL,
  `Answer` varchar(250) default NULL,
  `ActivationCode` varchar(250) default NULL,
  `IsVarified` tinyint(1) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`ProducerId`),
  UNIQUE KEY `Email` (`Email`),
  KEY `CUTOMER_COUNTRY` (`CountryId`),
  KEY `CUSTOMER_STATE` (`StateId`),
  KEY `CUSTOMER_ACCOUNTTYPE` (`AccountType`),
  KEY `CUSTOMER_SECERETQUESTION` (`QuestionId`),
  CONSTRAINT `producer_ibfk_1` FOREIGN KEY (`CountryId`) REFERENCES `country` (`CountryId`),
  CONSTRAINT `producer_ibfk_2` FOREIGN KEY (`StateId`) REFERENCES `state` (`StateId`),
  CONSTRAINT `producer_ibfk_3` FOREIGN KEY (`AccountType`) REFERENCES `accounttype` (`AccountTypeId`),
  CONSTRAINT `producer_ibfk_4` FOREIGN KEY (`QuestionId`) REFERENCES `seceretquestion` (`QuestionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `producer` */

insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (21,1,1,1,1,'alirazvi@gmail.com','abc123','Ali','Razvi','xyz','xyz','123456','9059021214-','1981-01-30','testing','yc9wfr3y3j4rk6i6bdv0',1,'2006-06-14',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (22,1,1,2,1,'kmir@fiveriverstech.com','khurram','khurram','mir','22 fleming road ','Lahoew','111111','7227598-','1999-01-01','dog','yvuemeyxx1fzjep2h0mw',1,'2006-06-14',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (23,1,1,2,1,'smilingmir@hotmail.com','khurram','Khurram','mir','22 fleming road','22 fleming road','123456','7227598-111','1990-01-20','dog','hf1va1c8rj9jqndjsrrm',1,'2006-06-14',0);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (25,1,1,1,1,'kk@kk.com','123456','test','test','tette','stts','111111','6666666-','1999-01-01','dog','atz02v80ryt25fjkn9nj',1,'2006-06-17',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (32,1,1,1,1,'jimmy30@gmail.com','123456','jimmy','sdf','sdlkfj','Lahore','12345','345345-1234','1980-01-01','a','pf4bjsnllawvcsx1y95p',1,'2006-06-20',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (78,1,1,1,1,'nabeelbinezad@yahoo.com','123456','Nabeel','Ezad','dasf','asdf','433444','3434-33','1982-01-01','123','3wd3f2xwmstvo362w3na',0,'1980-07-31',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (80,2,52,1,1,'nabeel.ezad@gmail.com','123456','Nabeel','Ezad','622-Kashmir Block Alama Iqbal Town','lahore','54600','1221212-12','1982-08-09','a','klnn26zo4hn7r7vtbvfv',1,'2006-08-15',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (81,2,52,2,1,'csofts@hotmail.com','smk123','khurrum','dawood','lahore','lahore','54322','3004416780-92','1982-01-01','smk123','vqwxfctd3pjchffb2zvn',1,'2006-09-19',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (82,1,1,1,1,'jimmy31@gmail.com','123456','testing','testing','sldkjf','lkjsdf','123456','123456-123','1980-01-01','a','xl4me61anlialoxshcqj',1,'2006-10-06',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (84,1,1,1,1,'abcdefgh@hotmail.com','123456','ABCDEFGHI','SDLKJF','sldkjf','lsdkfj','12321','123-123','1980-01-01','a','kwhkufb4qpd98cidoiuh',1,'2006-10-22',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (86,1,1,1,1,'jimmi_30@yahoo.com','123456','jimmy','sldkjf','sdldkjf','sldkjf','12345','123165465-123','1980-01-01','a','hzx4dduamf2f4bxo0afr',1,'2006-10-23',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (88,1,1,1,1,'abcd@gmail.com','123456','sdf','sdf','sdf','dfg','12345','12312-','1980-01-01','a','jnjrxyeqnhlt9wsqkgsq',1,'2006-10-23',1);
insert into `producer` (`ProducerId`,`CountryId`,`StateId`,`AccountType`,`QuestionId`,`Email`,`Password`,`FirstName`,`LastName`,`Address`,`City`,`ZipCode`,`Telephone1`,`DateOfBirth`,`Answer`,`ActivationCode`,`IsVarified`,`CreateDate`,`IsActive`) values (89,2,52,2,1,'simplykashifali@yahoo.com','abcdef','kashif','Ali','Huu1222','Lahore','54440','0425152868-','1980-09-01','lahore','v621d6yyn65nk1aq42q9',1,'0106-11-14',1);

/*Table structure for table `seceretquestion` */

DROP TABLE IF EXISTS `seceretquestion`;

CREATE TABLE `seceretquestion` (
  `QuestionId` bigint(20) NOT NULL auto_increment,
  `QuestionName` varchar(200) default NULL,
  `CreateDate` date default NULL,
  `IsActive` int(11) default NULL,
  PRIMARY KEY  (`QuestionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `seceretquestion` */

insert into `seceretquestion` (`QuestionId`,`QuestionName`,`CreateDate`,`IsActive`) values (1,'What is your pet\'s name?',NULL,1);
insert into `seceretquestion` (`QuestionId`,`QuestionName`,`CreateDate`,`IsActive`) values (2,'What is you father\'s middle name?',NULL,1);
insert into `seceretquestion` (`QuestionId`,`QuestionName`,`CreateDate`,`IsActive`) values (3,'What is you first school name?',NULL,1);
insert into `seceretquestion` (`QuestionId`,`QuestionName`,`CreateDate`,`IsActive`) values (4,'What is you mother\'s maiden name?',NULL,1);

/*Table structure for table `smsalerts` */

DROP TABLE IF EXISTS `smsalerts`;

CREATE TABLE `smsalerts` (
  `SmsAlertId` bigint(20) NOT NULL auto_increment,
  `ConsumerId` bigint(20) default NULL,
  `CountryId` bigint(20) default NULL,
  `AddAction` tinyint(1) default NULL,
  `ModifyAction` tinyint(1) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`SmsAlertId`),
  KEY `FK_smsalerts` (`CountryId`),
  KEY `FK_smsalerts_consumer` (`ConsumerId`),
  CONSTRAINT `smsalerts_ibfk_2` FOREIGN KEY (`ConsumerId`) REFERENCES `consumer` (`ConsumerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `smsalerts` */

insert into `smsalerts` (`SmsAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (8,32,1,1,1,'2006-09-20',1);
insert into `smsalerts` (`SmsAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (9,32,2,1,1,'2006-09-20',1);
insert into `smsalerts` (`SmsAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (12,75,1,1,1,'2006-10-23',1);
insert into `smsalerts` (`SmsAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (13,68,2,1,1,'2007-00-05',1);
insert into `smsalerts` (`SmsAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (14,68,-1,1,1,'2007-00-05',1);
insert into `smsalerts` (`SmsAlertId`,`ConsumerId`,`CountryId`,`AddAction`,`ModifyAction`,`CreateDate`,`IsActive`) values (15,32,-1,1,1,'2007-00-05',1);

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `StateId` bigint(20) NOT NULL auto_increment,
  `CountryId` bigint(20) default NULL,
  `StateName` varchar(100) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`StateId`),
  KEY `COUNTRY_STATE` (`CountryId`),
  CONSTRAINT `state_ibfk_1` FOREIGN KEY (`CountryId`) REFERENCES `country` (`CountryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `state` */

insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (1,1,'Alabama','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (2,1,'Alaska ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (3,1,'Arizona','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (4,1,'Arkansas','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (5,1,'California','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (6,1,'Colorado','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (7,1,'Connecticut','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (8,1,'Delaware','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (9,1,'Florida','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (10,1,'Georgia','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (11,1,'Hawaii ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (12,1,'Idaho ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (13,1,'Illinois ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (14,1,'Indiana ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (15,1,'Iowa ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (16,1,'Kansas','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (17,1,'Kentucky','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (18,1,'Louisiana','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (19,1,'Maine','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (20,1,'Maryland','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (21,1,'Massachusetts','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (22,1,'Michigan','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (23,1,'Minnesota','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (24,1,'Mississippi ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (25,1,'Missouri ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (26,1,'Montana','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (27,1,'Nebraska','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (28,1,'Nevada ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (29,1,'New Hampshire','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (30,1,'New Jersey ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (31,1,'New Mexico','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (32,1,'New York','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (33,1,'North Carolina','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (34,1,'North Dakota','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (36,1,'Ohio','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (37,1,'Oklahoma','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (38,1,'Oregon','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (39,1,'Pennsylvania','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (40,1,'Rhode Island','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (41,1,'South Carolina','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (42,1,'South Dakota','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (43,1,'Tennessee ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (44,1,'Texas','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (45,1,'Utah','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (46,1,'Vermont','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (47,1,'Virginia','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (48,1,'Washington','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (49,1,'West Virginia','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (50,1,'Wisconsin ','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (51,1,'Wyoming','2006-07-07',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (52,2,'Punjab','2006-07-28',1);
insert into `state` (`StateId`,`CountryId`,`StateName`,`CreateDate`,`IsActive`) values (53,2,'Sindh','2006-07-28',1);

/*Table structure for table `waypoint` */

DROP TABLE IF EXISTS `waypoint`;

CREATE TABLE `waypoint` (
  `WaypointId` bigint(20) NOT NULL auto_increment,
  `PlaceCastId` bigint(20) default NULL,
  `Name` varchar(100) default NULL,
  `Address` varchar(200) default NULL,
  `City` varchar(100) default NULL,
  `Lat1` double default NULL,
  `Long1` double default NULL,
  `Description` text,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  `Radius` double default '0',
  PRIMARY KEY  (`WaypointId`),
  KEY `FK_placecast` (`PlaceCastId`),
  CONSTRAINT `waypoint_ibfk_5` FOREIGN KEY (`PlaceCastId`) REFERENCES `placecast` (`PlaceCastId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `waypoint` */

insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (1,1,'Test Waypoint','Test Street','Lahore',31.7211585428985,73.5479736328125,'test','2006-10-22',1,800);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (2,2,'WayPoint Test1','Lahore','Lahore',31.4474102914287,-96.3720703125,'Test','2006-10-22',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (3,2,'way point3','Lahore','Lahore',31.6346755495413,74.0478515625,'way point3','2006-10-23',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (4,2,'way point 4','lahore','Lahore',32.4170663284628,73.663330078125,'way point 4','2006-10-23',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (5,2,'way point 5','lahore','Lahore',31.559999,74.349998,'abc','2006-10-23',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (6,2,'waypoint 6','Lahore','Lahore',31.0341083449035,72.685546875,'Lahore','2006-10-23',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (7,1,'sdf','sdf','sdf',35.1558457022654,-90.3955078125,'sdf','2006-10-24',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (10,8,'Darrell K Royal Stadium','Memorial Stadium','Austin ',30.2836775202642,-97.7324438095093,'Football ','2006-10-30',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (11,8,'Mike A. Myers Track and Soccer Stadium','at I 35','Austin ',30.2825286819343,-97.7299976348877,'Soccer Field ','2006-10-30',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (13,10,'Bell Mountain Vineyards','463 Bell Mountain Road','fredericksburg',30.27548,-98.871918,'BMW','2006-11-02',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (14,11,'Camp Arrowhead','200 Arrowhead Rd, South','Hunt ',30.07053,-99.3367,'Rebecca\'s First Camp ','2006-11-02',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (15,8,'Disch-Falk Field ','123 Main ','Austin ',30.279489754406,-97.7258777618408,'Baseball Field ','2006-11-02',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (16,12,'Frank Erwin Center','1701 Red River St','Austin',30.276904,-97.733215,'Major Music Venue','2006-11-02',1,5);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (17,10,'wildrose winery','662 Woodrose Lane','stonewall',30.2361,-98.6684,'Winery','2006-11-04',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (18,7,'cool','cool','cool',30.2834922246693,-97.7326369285584,'new','2006-11-06',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (19,7,'new','cool','new',30.285011638218,-97.730255126953,'new','2006-11-06',1,600);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (20,13,'new','new','new',33.4864354509999,-96.6796875,'new','2006-11-06',1,NULL);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (21,1,'sdf  sdfsdf','xcf','fsd',31.541089879586,73.8720703125,'fg sdf','2006-11-12',1,200);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (22,14,'NY','ashbk','NY',40.7639012809459,-73.5301208496094,'dhki','2006-11-14',1,12);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (23,16,'waypoint 1','654','sdf',31.840232667909,-96.7236328125,'sdf','2006-11-18',1,100);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (24,1,'test new','sdlkjf','sldkjf',31.66974593076,73.93798828125,'sdlkjf','2006-11-27',1,10);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (25,17,'kids campus','gulberg','lahore',31.5364904278562,74.3472826480865,'gulberg','2006-11-27',1,5);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (27,18,'FRT office','lahore','lahore',31.5381089486388,74.3476259708405,'Lahore - Wikipedia, the free encyclopedia \r\n Summary:  Lahore Government Website ... such as, the Badshahi Mosque, Lahore Fort, Shalimar Gardens and the mausoleums','2006-11-27',1,4);
insert into `waypoint` (`WaypointId`,`PlaceCastId`,`Name`,`Address`,`City`,`Lat1`,`Long1`,`Description`,`CreateDate`,`IsActive`,`Radius`) values (29,19,'land mark plaza','lahore','lahore',31.5351416391039,74.3471431732178,'lahore','2006-11-27',1,1);

/*Table structure for table `waypointdownload` */

DROP TABLE IF EXISTS `waypointdownload`;

CREATE TABLE `waypointdownload` (
  `WaypointDownloadId` bigint(20) NOT NULL auto_increment,
  `CountryId` bigint(20) default NULL,
  `ConsumerId` bigint(20) default NULL,
  `WaypointId` bigint(20) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`WaypointDownloadId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `waypointdownload` */

insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (3,1,32,52,'2006-09-06',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (4,2,32,55,'2006-09-06',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (5,2,32,55,'2006-08-05',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (6,2,32,59,'2006-07-05',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (7,2,32,78,'2006-10-06',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (8,1,32,23,'2006-11-18',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (9,2,32,3,'2006-11-18',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (10,2,32,2,'2006-11-18',1);
insert into `waypointdownload` (`WaypointDownloadId`,`CountryId`,`ConsumerId`,`WaypointId`,`CreateDate`,`IsActive`) values (11,2,32,4,'2006-11-18',1);

/*Table structure for table `websitehits` */

DROP TABLE IF EXISTS `websitehits`;

CREATE TABLE `websitehits` (
  `HitsId` bigint(20) NOT NULL auto_increment,
  `SessionId` varchar(100) default NULL,
  `ClientIP` varchar(100) default NULL,
  `CreateDate` date default NULL,
  `IsActive` tinyint(1) default NULL,
  PRIMARY KEY  (`HitsId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `websitehits` */

insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (1,'l0p9u8f0l2o43b7ahasl2rnnl1fg5dfg5','127.0.0.1','2006-10-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (2,'rdcaucc6skutptb41p79ve3du4','127.0.0.3','2006-10-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (3,'dfg456dfg4555yfgh57tyjuthjt','127.0.0.1','2005-10-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (4,'2s89lfvb4q1qc3153jutv4obq6','127.0.0.1','2006-10-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (5,'e7u21c3rno7k710jevshkea1c7','127.0.0.1','2006-10-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (6,'hdrhqhce8cpae8qp0nomj6seq2','192.168.0.77','2006-10-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (7,'hae4j4sil9cr1eij5188m67pj5','192.168.0.77','2006-10-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (8,'lq4u4qls6bl6sbsqqh6piu1321','127.0.0.1','2006-10-12',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (9,'jicog2muhg14rq88bsbn12la63','202.163.69.50','2006-10-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (10,'17rrae6i7a99jm3avs8jhv8ie5','202.163.69.50','2006-10-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (11,'biptlaa5oihjvtt70lsebf18t5','127.0.0.1','2006-10-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (12,'nh2rh85a79cr5ucgu3tlcblqv4','127.0.0.1','2006-10-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (13,'nh2rh85a79cr5ucgu3tlcblqv4','127.0.0.1','2006-10-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (14,'s6eu9uitgns2ac8divdghp7gc4','202.163.67.153','2006-10-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (15,'p44anqt93kgiqmqj8naigpkan1','202.163.67.153','2006-10-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (16,'4qvo0201j2lg8u9mo34lefmag1','202.163.69.52','2006-10-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (17,'vuhbq228i2934hfttc6qmlsdl3','127.0.0.1','2006-10-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (18,'l76cg6ujjm62dun7agnfkr6vg6','202.163.69.52','2006-10-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (19,'htbmnldmp7t6g5ph11cml162f1','127.0.0.1','2006-10-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (20,'uj5hlg07up6eosmgo60ml6uht3','202.163.69.52','2006-10-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (21,'e673f9pfd23cjca1s0kbq831k1','202.163.69.52','2006-10-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (22,'vl8fjld9lb3fo4a4i83vm38o57','202.163.69.52','2006-10-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (23,'v2hmqolvtbe6p3anncf4h3hja1','202.163.69.52','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (24,'aslses0gk40uf4pp6qcdk57b87','67.79.200.115','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (25,'6edduob33tthl2v2hnm7df76r3','127.0.0.1','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (26,'q5cfuo048q7qr2kukm3ofjh275','202.163.69.52','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (27,'qllgue08um4bjvihpgnhm0r6s2','202.163.69.52','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (28,'cjoc9ne24ebp9uvan4pbihk5s2','202.163.69.52','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (29,'d0nctbj0u5nlon10td1pu1kp36','127.0.0.1','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (30,'n8p7svt9dqd1v62tpmv669fvi7','127.0.0.1','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (31,'3phs7a8lp9v7p7lr3k81d02m95','202.163.69.52','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (32,'0uslnbm42kaueo3a3nefrujd40','202.163.69.52','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (33,'rgfffn5msl2v8i4rguj6qbq8q5','127.0.0.1','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (34,'svj1isrdbbg07iaq9cj0p30c96','127.0.0.1','2006-10-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (35,'cqk7p2fj2qafrlop3eog4dh0i0','127.0.0.1','2006-10-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (36,'itaah5eltqlpufsgaunadqcp04','202.163.69.52','2006-10-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (37,'c5vas315pb6po78gkh413ns186','192.168.0.77','2006-10-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (38,'2jfl0mj2qvggsu4mesu7qg5o82','202.163.69.52','2006-10-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (39,'rm1nbv1g3mg26m1tj4i1fu1dm5','127.0.0.1','2006-10-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (40,'ae2ao3ucb17uo6mvr9u4o37111','202.163.69.52','2006-10-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (41,'cm213d38u1vjk2jsu1q5tmmlm2','211.213.178.106','2006-10-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (42,'oiosafntgm3a8cqnjt0hb5t3j2','211.213.178.106','2006-10-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (43,'1j3vv87tqrgel1sv5jmh7p15k3','202.163.69.52','2006-10-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (44,'hk0mmcvfp3h9r4n23oee2p2ba3','82.44.32.113','2006-10-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (45,'bmvu6vntpudsgc0qjv4bouhtc6','127.0.0.1','2006-10-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (46,'p9iocfk9uc4v9fbvtbsianhfr6','127.0.0.1','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (47,'i5duriqgi5oeh4a589qn2e4bg5','202.163.69.50','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (48,'8u12hoesdr7h8595s5k80eskt2','202.163.69.52','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (49,'p9iocfk9uc4v9fbvtbsianhfr6','127.0.0.1','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (50,'taaujtdp79u2bbrle6ohl942q7','192.168.0.77','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (51,'e7dkmqmr6j4u0sa1ul2lsf3004','127.0.0.1','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (52,'m0qn4df5eqoftj56li4tg1uhp6','202.163.69.50','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (53,'b5ng9u1db4rmd0ve2qq4sgt9g3','192.168.0.75','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (54,'r1atp2ppn4fltauhak3tb1cbg2','192.168.0.75','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (55,'3sa22hhpqu6pqclu649bh3pb24','192.168.0.75','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (56,'rppm49o1c0tfdsfk2ikus9u084','192.168.0.75','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (57,'o95frdl6plf9ovt4dg46e3dvf0','127.0.0.1','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (58,'b2rueatde8mg0cq6s46upm9k17','127.0.0.1','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (59,'a8k792gj2qvhmqu5ba294q3034','127.0.0.1','2006-10-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (60,'gmra06ebv61nd74qohd65vckb3','127.0.0.1','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (61,'nm3pedt67rk8rvmg9380jkhqu3','127.0.0.1','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (62,'k5kc0qn9pplhg61eo7ln1t6ni1','127.0.0.1','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (63,'6ovvn29rub2ut2o3u8re0fg8e6','202.163.69.50','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (64,'0grkmilcdk32ulnm76ec94ilp5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (65,'blb9unjv4ugs32sdhlc1tovt62','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (66,'2pmtmg5e1v7lt7u5kjhiodame3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (67,'90c638u9alfj0r0flaf4kiqh06','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (68,'boiqrnf90ao2l7h0mqgkbi4l47','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (69,'g2o1k9t6ahnang2a4irj9l6pk5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (70,'1lkqb53n5ne34ipcij29hitaf6','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (71,'c84th4og57i7oflnddvniaf294','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (72,'0r7ojaq3fav9tkg3q3jnugpgv4','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (73,'k174prq8um90f6941opb333335','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (74,'slcg7to2266qa521eegqhb7he2','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (75,'mgi87krkddpjqfibpnnrgokir1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (76,'1p0bu2spmps0sp6gipnae9lim3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (77,'bu653jo102um8pjo69vk0a26q6','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (78,'fg0oon4f3bukdgmlnoqjoe1to7','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (79,'ccl6j879ikt3igpsf342hharb1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (80,'8bpt8bsv8sq1gl9qsvdfkg7253','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (81,'jseg34h6ibnnebap6omu2badc3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (82,'0tus4o9dk87q9a0imelmtn5cc2','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (83,'i266cdc439g0r6koa9kt218713','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (84,'m9ltpfmkrbvhmomavmnb1uk5d4','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (85,'abeqt9rtblqmj4khrpd4n36c14','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (86,'da8k4611s34rbdf3gej86rbmj1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (87,'vfvnf9icj3omcmcbgrvkvsfbq5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (88,'5sbgihfhc1jnkkfa5rpdgckr42','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (89,'dpokorioskj4k9lc63pmmhtdr3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (90,'9b2d6t4bch1p4c8jklbhgncei6','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (91,'j2t4ujj3tj3ojj21jpmr46lbj0','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (92,'i5ibklp2b2ot44vnhkst146j72','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (93,'sr14tg17k9urinvu3ge51n6o91','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (94,'r8iqvg1d7vcn5j100r8suj9s73','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (95,'kg66kknotni6n4q3pnfaou6h40','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (96,'jrasnnpic5hv2jfufkga1v1s20','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (97,'4qgdlm49c52imfol6vcfoooh77','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (98,'6ptq4t9587gai022d07cdim2b1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (99,'ubnomqekqe0gnqc40m8jdctfc3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (100,'m9v6026gocsvbeapc2lb8gdts1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (101,'5qhbeb5ta0b0gjd59mnmnbcd96','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (102,'ntu00l6l045vcqoa5irgaje0t4','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (103,'uc3cfghscomjdj447nl07369i2','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (104,'bmnji4hf35pvb4j6aitr28jau1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (105,'f7235i39chnr4peqikgo2hv780','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (106,'tjl9gl4h3nu216bdr4d19u8hk1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (107,'p08dse0hnrsds0bf62fij0lhh1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (108,'mrte0al1nhv1619ktspq6tm065','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (109,'vbo8b4cac1gs6dh0c8mavun462','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (110,'er25hf7qimihglh2i0erj6kth3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (111,'44pgmpr5o5sqoemg1pla3sd761','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (112,'miu5a90c96fckq8r6973q1u2t1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (113,'i1g9cvbkg5jq3lvb6oqeibbej5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (114,'5i1u9sb8aehbfeme3qu32vd463','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (115,'3qcc0l7gtb755q7vf9tsb6tof5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (116,'1lkm7mbmilp1bp58fti9u5sgl5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (117,'mcd5igliabaje1a48fv03tklq7','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (118,'klg3eg2m8hp5sl21s0hl8fnbs7','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (119,'62dlv9c44n0prj8ftoem8bcik5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (120,'da1kq6n18bh31kh661u911v6r4','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (121,'54fb239gtba2rg354tr7veo137','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (122,'e931qa3csre7oghk7tjkm7hfi6','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (123,'kbrul7n08rs5ao0qh45fn3no71','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (124,'u430ssovpbtdjcsbt1d9oeu0s3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (125,'sn1ivj7b26s8jco39jcfn4mtp7','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (126,'6cvjpdf78tpim96q1hr7hmbf45','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (127,'e5mlf544a88cn0brsi94gjpnu5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (128,'pk4fq847t2e055md7v7cp906l1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (129,'psknrp8q8kqaf01mshs93h50n1','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (130,'ov3m5rgg5so664b5htq1i0sru3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (131,'j901i4pelmcbn1jeb98qhp5dc0','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (132,'2d5lq2lajjglfkb1be42jd3t91','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (133,'k5dv7mf6bji1kmu27pln9b13n6','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (134,'edbqebc6tk9ndkcqdmu4e7ldd7','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (135,'6uqk73qvu7j9fqrqrvcbk5vfv4','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (136,'7ro6uccpuhp2u3cqhmjv4naji2','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (137,'dgdfm9r37phrt5ji8ol0jui9v5','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (138,'2tnsq1e36ui8kkgjrjad72gko3','66.249.72.45','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (139,'1gm6civ5vpqbojc631fs3h7717','127.0.0.1','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (140,'flog7ahtifcf4r8q2q6qnos8c7','127.0.0.1','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (141,'l43cm8e9p0e7ngmtq6f20tngn2','127.0.0.1','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (142,'nsuq1707d7q0kndf139j8c4lv2','127.0.0.1','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (143,'c8eg7phnkoedpj5dj0u14kgq91','202.163.69.52','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (144,'d9ki63k1ocfimci2u3kf4rerq5','67.79.200.114','2006-10-31',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (145,'kmbpono24tdq7dg8bpfks9e8d4','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (146,'s8dpbg2letnvqcu7n7fbms1f36','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (147,'3s35atfl1og1vl160f77hborq2','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (148,'72ah8biq1hflp8jqc19tp70l26','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (149,'7sc4a27e457ajmhgdri4i9u8k0','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (150,'aq075fp4cna46gchb2khctr1v4','202.163.69.52','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (151,'i1pik81douq3969g4d4a6ou315','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (152,'tunas9cavsh7rgrnfh8avu36s3','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (153,'c3cuqq39t11lj9prdav5tkgqp5','192.168.0.77','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (154,'m59at790ilua4b2shcnc0a8u97','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (155,'ootqs8vj8jedo3tlpqhgs8cp62','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (156,'t6bkqehje8bq1a5dipkjlvksb1','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (157,'736tn6cr63rukmleu7hc6se231','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (158,'bqd8rc0b1p9ud4vhsecdu3eh53','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (159,'r37ogrc3bgsqisjo1gb6qhmr80','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (160,'tm144itu6f6o3c9l3ep6krjlf5','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (161,'qhlvt4465ndvofnm1839bgqb64','127.0.0.1','2006-11-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (162,'5f7on49lfsk73o3nep4mtltl40','67.79.200.114','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (163,'q7s0n3973241dtr1a6rm2i5222','67.79.200.114','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (164,'6ajbt7l1vlhpmpftp7d1lqr306','67.79.200.114','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (165,'dibvb6n6gn2qcprgo8074vn1u5','67.79.200.114','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (166,'3av065u35i59v8dpfiu17amqv7','127.0.0.1','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (167,'h7s11uh5244hn92lf2f1stb4a4','202.163.69.50','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (168,'j86an636bhmfp33kb1o06q9226','202.163.69.52','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (169,'hijh4rhamsas64g7kuddoqetm0','127.0.0.1','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (170,'va8oo2gdhf2rfsa3ibho7jto06','202.163.69.52','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (171,'agkkcu5vks8f6bn8sf315i1og0','67.79.200.114','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (172,'iq3pm6b4q9cve4qa1jbd95lse2','202.163.69.52','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (173,'ih9qfv2kps5e9rj4ntpbv0hi46','202.163.69.52','2006-11-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (174,'8dekq9rvd5vndp0ibm0f9qodj7','127.0.0.1','2006-11-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (175,'pj4jou7i3b0mbc44pmeak9coo5','127.0.0.1','2006-11-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (176,'52k6vn3fl0aeihhnknd45cckt2','202.163.69.52','2006-11-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (177,'k0pgnt9cfdneghbdgbc3v0hmo3','202.163.69.52','2006-11-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (178,'skjloa4db83i2oaj460fl77h34','127.0.0.1','2006-11-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (179,'48trtase55d08titr9th9t3gn0','202.163.69.52','2006-11-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (180,'gm7hrlggo3pdmd3pueaprqasc5','202.163.69.52','2006-11-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (181,'e8i8t82o8peloeqqstlk3cmel1','202.163.69.52','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (182,'q7ncdhs244kj470odhrbg7k5q0','202.163.69.50','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (183,'rugopqm5ic2b2rv2k31ngmfnp4','202.163.69.50','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (184,'thl0spg8hps0jm3gv4ut8gs9c7','202.163.69.50','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (185,'130ljlllco4go54m32sdbo4kt4','127.0.0.1','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (186,'rcvem9lt3d6s3grnfc8v63bg56','127.0.0.1','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (187,'ubufk9um3quthk12mnat85f8p7','202.163.69.50','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (188,'i826t0uaq6am14r2vvmmat16q1','202.163.69.52','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (189,'jckptaojg50a9g21ed276pf2f3','127.0.0.1','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (190,'n2c4cgtvoheufus3p4vjm416o7','202.163.69.52','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (191,'f9lnflndc8oln1506cvimh3er7','202.163.69.52','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (192,'lm6qn426j96rgqvlvv9jvrao26','127.0.0.1','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (193,'fpk3h0sl6uocpp80bhumub3se2','202.163.69.50','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (194,'4p9hkhptkp626hk5sh2k4jr4r5','202.163.69.52','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (195,'9a1qdrd0coi3svg3m0sc9ncqs0','202.163.69.52','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (196,'io5d8h2hh0oels5ntc849jehc3','66.174.93.98','2006-11-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (197,'polgfmukgtqjujsshpq4n4it51','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (198,'c916i5r2b9kldc4clkpi85mev3','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (199,'3l0e1lrdoeu4bbfqhqsrhiock3','202.163.69.52','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (200,'5c51u8f3j79da0jerirod2i5d2','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (201,'0tojqenaoaojcs97s2fgvmcqv1','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (202,'qcnqhg21f76vprtdbohhabg2s6','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (203,'o7rsedbn5mcc42d13u79mvmb57','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (204,'9k9m4k7j4onim0gm0d4gc3hu62','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (205,'aiissh1gi2nqrg7nf8i9hmp3n6','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (206,'b78rk06j0kjgc9v7uia6i5tk85','127.0.0.1','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (207,'94ee2lh98k6uni9jd43ijodgh2','202.57.8.175','2006-11-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (208,'oh5vdoph2i1ee7fhgtk6201od4','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (209,'eb00s4icrha5sa6sceae10ngk2','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (210,'l0pt1rlotq5e7bn0rvbopb3du1','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (211,'na49v8tb37nbnhdo4a4lgt9ik1','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (212,'1vtb5nq7visi296ijne9a0b083','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (213,'aq9sb30gj8hrf4510jmc77u473','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (214,'6hjjaqo27e9v720prep1mei8h4','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (215,'51baft3s1fta0tg7tp8cnckeh7','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (216,'9o4qbo3vj2cvu24u6t9dkbpch0','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (217,'6uuohopguq3pc8c0b7v5okrnb6','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (218,'59je2knia9nn0524po6o03guu7','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (219,'uibnnc6ftqhk8e068t5kutr6u0','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (220,'hglfer2vjf0h9k19ed4qs20o80','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (221,'qh80gs8lr84rgjmqvd71db9ff5','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (222,'2k2ov7aq6s0k30cuik0r0muho7','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (223,'gnog6f4ib9u6ic9cf59soc7cj3','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (224,'gaf6d0h9a62hfp2p72q04t9pf3','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (225,'e0ig4cvqanjbafbr83se9up0c6','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (226,'ej6nmcigvub9o78mb42iks3vu2','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (227,'uvhj6btqg2ncs5o1hq10nog884','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (228,'smb1313l5hcsqngl8g50evb785','127.0.0.1','2006-11-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (229,'1t4vj5so7jdsvppj4va46jrka1','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (230,'ftpe42fmaigoaakb3lsc2pv5d1','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (231,'9o1esgkvphifn5fdmtl7go6kr4','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (232,'1c11pf25khpikmn3pv95v0b097','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (233,'ddnhudmvikmmiba3iv46e5hi94','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (234,'00hfcfqihk7e432kdp2ugl9mc6','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (235,'9df6ts7v62s6dk4afg4tp7dpe2','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (236,'2eeneqf7scg5mor6qb12rdguo5','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (237,'9vb262h193qapvki7l9c3opui1','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (238,'0i1b769pfa7siccb6or5cqhev3','127.0.0.1','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (239,'g01lo76qkgcdmq68bqtugqaj41','203.215.177.101','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (240,'0b4lfukis2ubk4dm5kshb259f4','124.29.216.55','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (241,'0fjkkoi5ckn3ifg81v7575hhp7','202.163.69.50','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (242,'pptb13ol1hjfhn0r0dpaetutv4','124.29.216.55','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (243,'s3m5o9qugoighiga35i2jludp6','202.163.69.52','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (244,'phc5aubgbrvp6oom87lb4b71i4','202.163.69.50','2006-11-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (245,'3dgvu9hv1og1qkgnnvdr3i6947','203.135.19.145','2006-11-12',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (246,'7g55jm0k03k3klaqeae0ug5i35','127.0.0.1','2006-11-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (247,'ivjooieon6d4lllngn5l3uega3','127.0.0.1','2006-11-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (248,'acjjge8hv5u7k9754lb98brl15','202.163.69.50','2006-11-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (249,'rftlq69ovuks227gfk24ba8431','127.0.0.1','2006-11-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (250,'2oi20ua78u4aq847p65mqndla6','202.163.69.52','2006-11-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (251,'h6etis963v9c9jmu7c10cqnpc6','202.163.69.52','2006-11-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (252,'k977ptde76edpmi97bpl2t0j37','202.163.69.52','2006-11-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (253,'emcurmv191glrhsr8l9bml4fv3','67.79.200.114','2006-11-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (254,'8qke8f2qi2afvobb96p2974j75','67.79.200.114','2006-11-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (255,'ml83adfgn4230su6erhnpfhpb4','202.163.69.52','2006-11-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (256,'fcq5bgd76q8hvl9tsp2i3tr1b2','127.0.0.1','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (257,'l5q2vvgnsugiacpcchqhhhf8o3','202.163.69.52','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (258,'j9r3jq3fqgjg8ac91oisk92v84','127.0.0.1','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (259,'4jegtpenf9diufghj982qjqh34','202.163.69.52','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (260,'mcodqn7i761jqg1u0g0h46t2q3','202.163.69.52','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (261,'sfc21vkjrdsi9l255lcqmoa986','192.168.0.58','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (262,'nb5sf66cigjfa054cpjjom45b1','192.168.0.58','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (263,'4b4eh08tb85pjb64ub8qsb7fl3','202.163.69.52','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (264,'asok60sgh16694r17jgmbp5nd0','202.163.69.52','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (265,'odts9uqcb1f2ul2dqbeta13gv7','202.163.69.52','2006-11-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (266,'83co4rqgonjd6u08cn46b78hn6','202.163.69.52','2006-11-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (267,'8e5gra14cks7mql9hi2f7cqtc3','127.0.0.1','2006-11-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (268,'lp14ks6v9lq7eqth41oedii774','127.0.0.1','2006-11-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (269,'8pba6qkdce04o5ap36m0i9v207','127.0.0.1','2006-11-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (270,'3dgc2c0sc2mretinjrf2os0d96','66.249.72.229','2006-11-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (271,'4eafumpfqjsju0qb94l3gemae2','202.163.69.50','2006-11-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (272,'ujo2nbiep4fkedpe5rbq5ifgl6','202.163.69.50','2006-11-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (273,'lm1v4r34ps2rtjrudpverv32h4','127.0.0.1','2006-11-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (274,'3hnkvoeiulim7oiif88d0hv204','127.0.0.1','2006-11-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (275,'1qv32r24icuajp8pn9r6ro3l67','127.0.0.1','2006-11-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (276,'qm3ktim60c1bkdrv838etkeqt5','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (277,'6qphubos0rfbn0ta4kinh5b191','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (278,'ddd048jkg5qpjcjdc2qm2bqql2','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (279,'281ls9c7sn9qmc1g4rdkkbgnr3','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (280,'g63up3k7q2udgokj3s8gqpej41','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (281,'1ccbejkthsumum3npoqdr1np64','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (282,'u917k9li78p5a41305u605ls73','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (283,'euo20hvopt972cerhcj9vmhqm2','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (284,'n6j4b5sc2rv8ss7qr1tjf8gig1','127.0.0.1','2006-11-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (285,'1ms1kbtovsi8qq18uj6ug2ctr2','127.0.0.1','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (286,'qounkvpe8lg684sl2psmmvpg63','127.0.0.1','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (287,'0vkdkji2bfu24nb17ih4r3s2l2','192.168.0.77','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (288,'lfeu0gpbljjei6jeljvhmbbvs7','202.163.69.50','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (289,'2n5k5r548iss0r7sodcdh7j0j2','202.163.69.52','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (290,'ulrpl94fk56gsg31okej4uh9h1','67.79.200.114','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (291,'jqbe11eqi922vrgqjl9i0gtnv0','67.79.200.114','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (292,'eg1pfvath9nvel570c1cb3fim2','202.163.69.52','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (293,'t7daklmum36e85h20og1r2b7j4','202.163.69.50','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (294,'uqlqf36iksf3l3jojl205rnd92','202.163.69.52','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (295,'eamm261vl085mbpoeflcah9nl4','202.163.69.50','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (296,'vvog2vt2u6dbpi7q1g1p9e3mm0','127.0.0.1','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (297,'eeu7q638mddflh55ahq372aqc5','202.163.69.50','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (298,'4nuoi7onro7e4dqsbc2gatmc26','202.163.69.50','2006-11-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (299,'0jdgl06vqeentaovb6n8d2pl53','127.0.0.1','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (300,'hutbqaq4794phrhjnfk0a293i4','202.163.69.52','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (301,'junl8q2quu0c6qlgs15d569jp3','127.0.0.1','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (302,'8qe40unad62gmf4o9ekda49vf4','202.163.69.50','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (303,'56glujn0tdmt0ib0vjom00kir6','202.163.69.52','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (304,'8hdtk238nb8j2v4574flucse37','202.163.69.50','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (305,'m7n7b25n6p1b9jht9n72u378p6','127.0.0.1','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (306,'9fjn33necmmntqf05tg5abnu31','202.163.69.50','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (307,'dn7ipneva14f07r6bau18146v2','202.163.69.50','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (308,'uo5p216j98hljli1h0nfemshn5','192.168.0.58','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (309,'0cbo6494eapnr4aj41rkjhp4p2','202.163.69.52','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (310,'bp124ofrk5i18vk722q031pbp2','66.249.72.45','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (311,'h04ko3fh4gdnmr9093hr6b27m4','127.0.0.1','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (312,'jpo64kokt23o5tmru2u6h7dki4','202.163.69.52','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (313,'30qgb880v6j3htfc6gokj3s9q5','127.0.0.1','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (314,'n2l7rq7q6imef9kgd40ia4i1j7','127.0.0.1','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (315,'s588uo63jf7gi6dpr70oto8jp1','127.0.0.1','2006-11-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (316,'p0cv7r0tcovjkgi53bod3vlir3','127.0.0.1','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (317,'obqgcvnkdija3bkbt20k6dnhj6','127.0.0.1','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (318,'okhg875dgb28q23b1032oheqd3','127.0.0.1','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (319,'e4tqf2hseal663fsum03e0riv6','192.168.0.75','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (320,'ci1aklrkp6mb7pbc20qlsrb0f0','127.0.0.1','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (321,'91hjfle8c3krjn7dkc6bhr1al0','202.163.69.50','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (322,'sf8uri77nvjs56lekvpvvdkn72','127.0.0.1','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (323,'179lc8emjt38psae6eq6uc0ga1','202.163.69.52','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (324,'hrkvtibfvrj7tkah54daqsf6t6','127.0.0.1','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (325,'mrn8nvjrteqbm646tvmpcstmc6','202.163.69.52','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (326,'p6s912kp42cmvqmgn49osim0b3','202.163.69.52','2006-11-23',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (327,'mutbtkue1jcjfaflrj1aheksp2','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (328,'stahu84nibn84ijf3jbdsf1tc1','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (329,'ddvgi1id99q608alupbh68djr1','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (330,'ddvgi1id99q608alupbh68djr1','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (331,'ukuftkmv6eqh29m90kmcm7dla2','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (332,'mk8fh8s1h7grl7n0j1s6hvjsj6','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (333,'65625uambgqf4cebulilp8ock5','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (334,'64qrq04r7bd6c9l62sd76c5353','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (335,'o2ukrtvpt7imj83ruq66ru0js3','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (336,'iv7lcnv72u0o8binlia0pn92v5','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (337,'ou29s59hi8jm3221mqfhmrd3q5','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (338,'sflovaga5argtqtckf4ss381v3','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (339,'70koarfapej7gav2pvgrgj5i57','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (340,'6dvp0ettk2l5q3no3bl4qv78c6','192.168.0.77','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (341,'pri78u18k90auhhk8vuaa9c3r7','192.168.0.77','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (342,'eu6vv964s2lrpn6grn59rnot91','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (343,'2847pj4ad8tkfrgu48mae3srp0','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (344,'nhagsv70qhqshipv7r5j7erof4','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (345,'lm3uq526i6k8vh9tggr5af4e07','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (346,'jhn3aqpuj56hcin1rpks6lo1q2','202.163.69.52','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (347,'u9jr4t9otcv16p4p5relj23ue1','192.168.0.58','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (348,'chietfueo1vim56muk92kubkt1','202.163.69.50','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (349,'vpvohvu600ivrqgp4vt0tfnrk3','202.163.69.50','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (350,'ubm4dch9aao7j5k5g6mjlttq42','66.249.72.45','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (351,'f25rs5aobk5ld6h425j61n7q43','192.168.0.77','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (352,'m2klnt9udm5v9s8brcur55bbq7','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (353,'9qq4dm2jnpnvrsb5nse7g3cbe5','202.163.69.52','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (354,'g6rpg191b9mokekbae7acj60j3','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (355,'n5o06usjg3mhueebjrs6e9lh23','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (356,'aj4k4l6gm8h45kdj354ihjtfc4','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (357,'mjrqlmpved14hj0an5g6lgle86','202.163.69.52','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (358,'ecn4cq69ns3m5fd301bkeno1n6','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (359,'8e2n4j62n44eul9u8i3cg32ov5','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (360,'hma4nsj4cgqghuk8a5ie9jspa0','127.0.0.1','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (361,'3mkkjhkbfvfgg0v78htba7deb7','202.163.69.52','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (362,'2rh2sla7hu8hr0fojj6shv3el1','202.163.69.52','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (363,'hj4n40nikcjahj3fepoobtfop2','202.163.69.50','2006-11-24',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (364,'pnggpkm6qi1n3f77k5ngdjmi92','203.215.177.101','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (365,'7ko9b9landpg6fbf4d6vhqiin2','66.249.72.45','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (366,'n5sjo43ni77adm10rb1lqpk161','203.128.7.213','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (367,'ur5u0fc1vrk007ag4deca3m432','127.0.0.1','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (368,'jirnb8k7578dkrrs0m4ftg6ql7','127.0.0.1','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (369,'0591of4agc9cqi27hgd3fj85n5','127.0.0.1','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (370,'e43ep9iajh93dvi6en7d6hfo15','127.0.0.1','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (371,'usu3s0tv7qqal5bltqvifp4fe6','127.0.0.1','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (372,'jsbfdk3dkv5m4aecihl15ijgd4','127.0.0.1','2006-11-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (373,'jsf41nfji44aafdaqselmb4m11','127.0.0.1','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (374,'73ijaad7hejgrgocseb40cutc1','127.0.0.1','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (375,'e924o0sohpl7gqe2v8k2or0057','127.0.0.1','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (376,'3grb4j7er99mdhtvual6mi64i5','202.163.69.52','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (377,'7do4gm5ojleeo6m9sitt8r8925','202.163.69.52','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (378,'v51r1vfgmgva6apadfs5jj8ds7','202.163.69.52','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (379,'i0s9p474n0tq5t9fijqhu88l94','202.163.69.52','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (380,'hsudagor33t73is17ojbfvrfq6','127.0.0.1','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (381,'dq9mbftoaqv9ko6b44rscjo777','202.163.69.52','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (382,'4udoqfupk44sjgjvlcceph1lq1','202.163.69.50','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (383,'lnrkqrpsc9agc6cjqv3kssgf57','202.163.69.50','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (384,'0vafr47rlkel4fp7uvj8h0d8m7','202.163.69.50','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (385,'9tv8kstr089sn7iv23f3risqr2','202.163.69.52','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (386,'5eftgf5ciqgjgcttquje3ebn50','192.168.0.58','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (387,'kqpu3u83sql6kkl4fsvvovped4','192.168.0.58','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (388,'9i72on4ta9seahq31m12csgvb1','127.0.0.1','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (389,'6h8oo4sjflfodent87oef5q5i0','202.163.69.52','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (390,'5d6ctjc2uiihbiiqhakrf5mmb7','67.79.200.117','2006-11-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (391,'bmlpu4g77h35ooob05lnggv3b0','202.163.69.50','2006-11-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (392,'h3enovb41aovl71fql3281jlg1','127.0.0.1','2006-11-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (393,'4uhlh5srrbtqn71qteneavivf7','127.0.0.1','2006-11-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (394,'ci01nlqn499h8tuokusdssfl37','202.163.69.50','2006-11-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (395,'o1fi6evsj64v6vse6o5rmgof00','127.0.0.1','2006-11-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (396,'ulvvbp2gv4t172felkgeab52j3','127.0.0.1','2006-11-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (397,'u2un7nacjhhpmh6lbno6c2i412','127.0.0.1','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (398,'5u3vcc9ufus9ml63gnjjb14hd0','127.0.0.1','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (399,'vb41rngq40buejml3eiaeb8622','127.0.0.1','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (400,'brsbk9568hv0imonj7fkfg3h17','127.0.0.1','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (401,'grpir9b5lakt79qmbersgtu1v6','127.0.0.1','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (402,'l3dmo11g6p6nv5231cpmropr22','202.163.69.52','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (403,'8h0nv08c8igep37s6ke2fhhrb6','67.79.200.114','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (404,'oltsgfk8tjecpbjj5qcskcplh1','202.163.69.52','2006-11-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (405,'t6jeflrqcd98bnaro7dg1gman1','127.0.0.1','2006-12-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (406,'46s1vbp5pa54vr50aps3ptcei7','127.0.0.1','2006-12-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (407,'jdcvd2u62lp2oeg810uvfc44j2','202.163.69.52','2006-12-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (408,'kogksss7jtmj9kabt9h6dpep77','127.0.0.1','2006-12-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (409,'89bil7o1ijs0v45ianugl9s512','202.163.69.50','2006-12-01',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (410,'pu1huqirc47fpj1a6lnftg4hf4','67.79.200.114','2006-12-02',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (411,'8r6bsf63tln4nnl6a3c47sd3l6','67.79.200.114','2006-12-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (412,'sevq8go4p9oh46jtv4liujn562','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (413,'28gt8v40taesm7mgarfvtmf5g0','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (414,'ea5kq4h3rbp316cf2h51c6q565','202.163.69.52','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (415,'qnkp80kcfpk1lmd9jo68hc8il7','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (416,'ioc51vh0h7u6ihmvdc7rfkcch1','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (417,'cotkuu3n04rsmvkpkofdlvd626','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (418,'hp583fcb1rinnmgj4j9lot5b90','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (419,'dt2atcnq18v9p9c6526ru1a577','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (420,'mgpd16llaok7h6o58n0715uii7','127.0.0.1','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (421,'abc4mmo1llr7s66rgpo3dlhqr0','67.79.200.114','2006-12-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (422,'lsmjritp50088212kbt0vgr7c7','67.79.200.114','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (423,'a2ipc31e5isib3ru6d6ljfk501','67.79.200.114','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (424,'29dm940htule7mftlofibgfko0','67.79.200.114','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (425,'pjapg2a4r5jjde34cd606kv1t0','67.79.200.114','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (426,'gsmlh7e0kc10u64tpeuf5p8ks3','127.0.0.1','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (427,'gdvfhv9jlougbcqtgd6mq63p90','192.168.0.58','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (428,'g47884mrosujbg8te5v7j2j541','127.0.0.1','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (429,'qm2ae8k4jv8m254er5tmuavil0','127.0.0.1','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (430,'req7at6amfforik7rg6rmig3m6','202.163.69.52','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (431,'b7dbb5804d0ri8kr3ik5qlumg7','202.163.69.52','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (432,'tp20cu7ep6f50mv093d4m5l7a5','127.0.0.1','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (433,'r829vc1623d8cloktcqq912ti6','192.168.0.58','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (434,'c6jhpu2fo6scp13o2edgqo21j3','202.163.69.50','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (435,'c5e6eet21buamsbavrmjoqdtb4','72.177.122.137','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (436,'kujom3s2eroiuj5kinr12sop90','202.163.69.52','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (437,'v6jb8dbrvjnd4i59vd9un7niu7','202.163.69.52','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (438,'vn2fmi3bod6cl4bhorfpkbrm17','192.168.0.58','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (439,'qj7k35epphiuk68liluvql2q45','192.168.0.61','2006-12-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (440,'5gl2532hgbfiip3h70i2hodd74','127.0.0.1','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (441,'73lvnj70dao5bo4435vpanfcd4','202.163.69.52','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (442,'uskaj5d1k7l5qdrdtvtuf0rt42','127.0.0.1','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (443,'dc66khuq844mdngfib9981gb94','202.163.69.50','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (444,'udthj4b8m4kt2e6dbtf0ccjfg0','202.163.69.50','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (445,'v76d73dcp9dama0c8vggvcpie4','127.0.0.1','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (446,'a1ti0c481u73kji1lfhqpm4jf3','127.0.0.1','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (447,'cpv2lcs2go0l7mahfjin90mva5','202.163.69.52','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (448,'183h170rbofc7n97l0moh97lt5','127.0.0.1','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (449,'r0la150tnq9shkvh2lo9p283v1','127.0.0.1','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (450,'htd9a2qokb6s408rnk5oseuml2','202.163.69.52','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (451,'m73r7ulqjtmh3i9ss0va7be5p6','202.163.69.52','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (452,'bbkap5hffmcd6kvd8rut9bhou4','202.163.69.52','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (453,'0vdko0inlnhrtd2chgd7a2f511','202.163.69.52','2006-12-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (454,'n5ibpsgjju9c7n6c0hf6igoh15','127.0.0.1','2006-12-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (455,'ht0bm7lihc9ipfhfmkjlvoia47','127.0.0.1','2006-12-07',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (456,'augquo39abuq6fkkstg79voj83','72.177.122.137','2006-12-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (457,'gek3ia838ni5p3dfbuj1ers850','202.163.69.52','2006-12-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (458,'kn6jpk963h71feifuujn8t9l35','127.0.0.1','2006-12-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (459,'f454bi2fqede2ncn5tt12sdqe6','127.0.0.1','2006-12-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (460,'in6bjaj43gkt41ue3nocnfui77','202.163.69.50','2006-12-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (461,'eo77dallkd5lgquejq5h755ol7','66.249.72.44','2006-12-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (462,'4netvv5kekc1laosj51i8c7n33','202.163.69.50','2006-12-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (463,'f5vftmjng5bip34vmoacf2pd66','127.0.0.1','2006-12-09',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (464,'snt4g3uad3o8fbakauqcivbq44','127.0.0.1','2006-12-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (465,'dprkenu8713lcc4562mmk0q732','127.0.0.1','2006-12-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (466,'n7ss6vbk0bjnn4472fdqnk8ar6','202.163.69.50','2006-12-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (467,'hg0c8ssq0ps8l62ivl5p0vorb2','66.249.72.209','2006-12-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (468,'3ftrfklpgv5oa8st2ko36ek7d4','202.163.69.50','2006-12-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (469,'dusl8avbl41hogrheg67ul8bg5','127.0.0.1','2006-12-12',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (470,'os7jaaqtf963svrldihgdtjm61','127.0.0.1','2006-12-12',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (471,'g22mli194cvhu34si4198i4436','127.0.0.1','2006-12-12',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (472,'0tmmfkutr6ts1suhfnj4jckn12','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (473,'0ipb0j9dnelav1ukfv28n1t3b4','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (474,'88itjdajsrskan9njnmflti171','124.29.215.84','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (475,'q9efnbev7fifcdelvqc2fr6pa1','124.29.215.84','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (476,'7imrg2s0rlh2gl0p28g0nfkoe1','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (477,'u6bqahgc3q6a2eris4a5vtu6o4','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (478,'ktq91bsd4925pa5gpki5ve1uj0','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (479,'uubnnpel91lr4bpu7l3fub5sc3','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (480,'kap9ogcqblkln8au9eufhqu6c2','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (481,'7imrg2s0rlh2gl0p28g0nfkoe1','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (482,'plv02vqbr44ie5a2u9dg0k3u77','192.168.0.77','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (483,'qkugt91daslvss7qrdudp8d7s4','127.0.0.1','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (484,'30scpttj9cbbqse37i639a2uj6','124.29.215.84','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (485,'sc53kkav5mucsl93lo6g3d7317','124.29.215.82','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (486,'evrpploae32jm51k42v7c26tr6','66.249.66.43','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (487,'ab9ag8k0d0hs9mahsdp8rsjku4','124.29.215.84','2006-12-13',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (488,'ot3ogqmrnjpnb7e6kp807fmob5','124.29.215.82','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (489,'r6uhgeu0utasasba822ag7h8o6','66.249.66.43','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (490,'jfgb51f6ac8bapbl70qhtep4r5','124.29.215.82','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (491,'03an605bucs4ksp3sd9uq4k824','127.0.0.1','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (492,'p86f58gb0642q45a0aqd4q0rp7','127.0.0.1','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (493,'ff1m1bbcaitbrdnl2ai18nvbj2','124.29.215.82','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (494,'imb84toplqg9mekroqatgkc7p1','127.0.0.1','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (495,'2p367p3e9l5i08v3om8ad4vaf0','127.0.0.1','2006-12-14',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (496,'igjm1ld4lv5v4bfekdg09fpbr0','124.29.215.82','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (497,'8rsal3bh39s6dsd4jgp9ugnlm3','66.249.66.43','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (498,'c4u9jmgqf6dim7gtc1tagiekd4','124.29.215.82','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (499,'vsrj2abi3pbaot2go1pon8dgf2','127.0.0.1','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (500,'5ii0kgags26hoqtartuohkivv1','127.0.0.1','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (501,'fama5ti9ognchfic2nhu9gdjk3','127.0.0.1','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (502,'3kop1o1j1or02tkg552gurvhm0','127.0.0.1','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (503,'ee91nka04os905pvesvn88mce1','124.29.215.82','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (504,'j3a9rtgdh9llgqkg4apdmbo4i3','127.0.0.1','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (505,'b8gg7mfnpdd1m1q620u7d1rho6','124.29.215.82','2006-12-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (506,'icp5ictabnu3rtqgr4g6pt92a0','127.0.0.1','2006-12-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (507,'m2cf08u6jei6un3nfu4s7hc9s2','127.0.0.1','2006-12-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (508,'l6rmtkmkvp6jgfos7l1pb25cf3','124.29.215.84','2006-12-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (509,'6gpn7c31kronmbhh2g4h7o3tr1','124.29.215.82','2006-12-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (510,'lln88brc0fbbrbe9616mk2q9j0','124.29.215.82','2006-12-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (511,'1fvlluluh120i94inkp84ij2n4','124.29.215.84','2006-12-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (512,'ui0clqrmegavrfq8mq0sgotb52','124.29.215.84','2006-12-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (513,'9lv7bqd61io5j29eljcelt6525','124.29.215.82','2006-12-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (514,'89ausqp7o2enfsn2vpti79sah0','127.0.0.1','2006-12-19',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (515,'0hhlt3c1qb16f83p5v08eu6u95','127.0.0.1','2006-12-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (516,'k840sf97k4pjm42bv9u7i4i5q3','127.0.0.1','2006-12-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (517,'bk2p97s0f1otdasbr470pf3i70','127.0.0.1','2006-12-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (518,'ab85e97ntahvfu8ccvr8qos421','127.0.0.1','2006-12-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (519,'4ibjgfl0jck95s9jq8jlqlijs6','127.0.0.1','2006-12-20',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (520,'ljh39pdhsp66hhqseeg4407084','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (521,'dfdq420rdspl9e8gps8no0vj05','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (522,'7an3d6pb0749rkggmma6jqsq64','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (523,'5tha210oc8effggd0ai6i79i73','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (524,'n8hsvff36picjmka2pu9pltss6','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (525,'cpi070a4nudsvq2ou6o8a49ng3','124.29.215.82','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (526,'njj045vmb7s35anm5t4rtmooq4','66.249.66.212','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (527,'ql9c93tokqk39042dj4hndn8e3','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (528,'b7tiribb3gc1ktulq8jgddve16','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (529,'v9c0arlpmocn3ska45mn49vt36','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (530,'022dpu3u4osinb95ml53ui3322','127.0.0.1','2006-12-21',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (531,'44fg2j43k81bvcvcdanbteu484','127.0.0.1','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (532,'0et204rbln1o431ud3nldj6ae0','127.0.0.1','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (533,'l8pb4fu54tbcpag7fi9r2melc7','124.29.215.82','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (534,'1t4rmbc0tifvdu0kgf5h5o35k2','66.249.66.212','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (535,'ip7vmnsr80vfu5luboqjdrcbg2','127.0.0.1','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (536,'7d1rshtqo9m6ocia9cffcic5s7','124.29.215.82','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (537,'1h5g9gnl0ta4mkuiopmapai011','127.0.0.1','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (538,'im735mri4f6c90g7cnc530a5t1','127.0.0.1','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (539,'vfqsgg801jg8ohg3shuqk4gh60','124.29.215.82','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (540,'qi3c6er4l55tgn7g11drq8sof0','124.29.215.82','2006-12-22',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (541,'vv1jvutj59tiuv8oae4dp21mo6','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (542,'pg33k5ia8m421bn2kgfn4u6em4','124.29.215.84','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (543,'kmtk4j9eunqp7cb98fumgsa5s1','124.29.215.84','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (544,'ibo4cl2arvmvep9789gimbt122','124.29.215.84','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (545,'6avf000gcv267m44mnb5v5qgl5','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (546,'cf97udvgt16km5844hbg2ilvu0','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (547,'2qbo2ivk167n1vs3fupriv2ng3','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (548,'6oafi0q7v2hf4r0impvel5ref5','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (549,'v21tnbf1u6b8kfgfv8st0rlcu6','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (550,'s6395aj4ijf5esarret072p8l3','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (551,'3s4t0a3q97ecf4e9bcfq1nd664','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (552,'aq1q0k8p9rb7nsmieqmp5f9sf3','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (553,'jm45cl11c427ccstd5a1dmioe5','127.0.0.1','2006-12-26',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (554,'eskj8t2njcg8kgpcq9cvccq386','127.0.0.1','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (555,'d22tuh9vl80smmftv3feqp92d0','127.0.0.1','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (556,'q6vbn1lqdg0min9tckc8uko2i7','127.0.0.1','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (557,'tc75pf8eonu4gm0ru7vsoc5n26','192.168.0.77','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (558,'4ckvd34c692a0hl3g2a97adil5','127.0.0.1','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (559,'4gm3g9a82aom30gc4b6ba5gte6','127.0.0.1','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (560,'roh0fd57ifqgb5gvrknn2422t2','124.29.215.84','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (561,'b7jopcptdk5c3uoqolh75mdnn0','124.29.215.82','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (562,'056qisb15ec0c7t2pqrk5oj5r7','124.29.215.84','2006-12-27',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (563,'i4e3af0tqlidihkecdpf8mmdb7','202.163.67.153','2006-12-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (564,'h6rmata4fqc869njn871mai454','127.0.0.1','2006-12-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (565,'conlprfl8bkiplrp1qr9c71cd1','124.29.215.82','2006-12-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (566,'s23ilsotm4alfobhs5t3pe9hq7','127.0.0.1','2006-12-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (567,'lrc9ff3p99ok3pslg5oaqausp3','127.0.0.1','2006-12-28',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (568,'ntev6uhqjbv4f0b4d7jerppoi0','127.0.0.1','2006-12-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (569,'h67vjern3aj44804i4tp7vm3l3','124.29.215.84','2006-12-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (570,'9psqo2gtcsqvma26i13rbjavu3','124.29.215.82','2006-12-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (571,'7vgap0psfj2cql7jma068rjv24','127.0.0.1','2006-12-29',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (572,'vqcthhctt4ecnc2lvafkqplhd5','127.0.0.1','2006-12-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (573,'6bvjaa1ajrctoo3lbf6cok15r5','127.0.0.1','2006-12-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (574,'bd97vcmvm9954qe86t730hmu63','169.254.2.2','2006-12-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (575,'t82221oh9tjclos9fdeh3lhac1','169.254.2.2','2006-12-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (576,'ni3lq57g5ip04et7872fg7arf2','169.254.2.2','2006-12-30',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (577,'cl2o6soi2roqdug2qq00sieg00','127.0.0.1','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (578,'s9m1hgt2vfrlslmj30jk4kopc6','124.29.215.82','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (579,'an1b9hgin0j9c4j1uja0saero0','66.249.72.234','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (580,'2idds8659fnvbn107jg63ism47','127.0.0.1','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (581,'k0in6igf1hrnvnl23hqmm5jj87','124.29.215.84','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (582,'p4h6u8oo6e5pbh0ar9a1jo80a0','124.29.215.84','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (583,'r9qrlfqo9ndjrr4rb6imgs1q16','124.29.215.84','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (584,'s82ok2dq6grgmb4vo5rp1ulc15','192.168.0.47','2007-01-03',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (585,'3ed9hrnb5agp049a3jtbs4pmi7','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (586,'lj5hboog4lp9af66a7j049red2','124.29.215.84','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (587,'tns4rcnkm8q8ef7jc2ipgs8015','124.29.215.84','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (588,'t8ke8v76m7ejufgcb6maagfi30','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (589,'g4sdd1rv28bfg5e5pl31hj7qm2','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (590,'irlhmqc674ug2dn45srdk206m6','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (591,'0m0vnmui78fa8uo7oeb6k5u1e7','124.29.215.82','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (592,'i8vjiuqf7d94rk2klf97re50v7','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (593,'m3saujusnueo25ndjqu4m61rm5','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (594,'7i803j5v4bndbgu3553jtmmm55','124.29.215.84','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (595,'opf67i7n7trlq5vp8559qlanu4','124.29.215.84','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (596,'dpcuo7otbps8d74r8mhbdpgg51','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (597,'b1b6bvg79ccfh71vvdekte69t2','124.29.215.84','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (598,'r2uehpvrfsm0g7sa6eqqfr2h92','192.168.0.47','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (599,'61lmo46qt20knj8ppfmj3sdog7','127.0.0.1','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (600,'6ibmtnjq6aeoagdb5ta4fja7q7','124.29.215.84','2007-01-04',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (601,'rle7el5lsf9d86gf7mbt844hd7','124.29.215.82','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (602,'gh9hficqo0rsav1b8mc4uufo22','127.0.0.1','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (603,'0hg31grbt412pqhcpt5oj1i454','124.29.215.84','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (604,'gtgsd94mtfo2snj66j5ooatlu0','124.29.215.84','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (605,'urmj382qhiehhdqs89h3kitiu4','124.29.215.84','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (606,'upl79f6ugt68nbn3ha4jedn5e4','127.0.0.1','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (607,'24dm50c9h4kcal84jqibsj9mb5','169.254.2.2','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (608,'7d0mu7oq19ihul3diht20uuhh1','127.0.0.1','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (609,'n600ritdk4252piguhntihvlo5','124.29.215.82','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (610,'4bkqbqa3dl9co55tbfpug46qc1','66.249.65.7','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (611,'rle7el5lsf9d86gf7mbt844hd7','124.29.215.82','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (612,'mturmt6foqs3grghues2v6n026','192.168.0.49','2007-01-05',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (613,'89dtfpjvrrlhs245nbdcnjbsd0','127.0.0.1','2007-01-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (614,'a278tnbi338903lktnqvjta6c7','127.0.0.1','2007-01-06',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (615,'h0pk7jmd99iq2ot6b2u3jq7h55','127.0.0.1','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (616,'7004b3q1h5gi54g1ad63abfh57','124.29.215.84','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (617,'eommbssrp9qh9j8tr14erd11b6','124.29.215.84','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (618,'lg7e5d7pqdnb63n4v3ome23hj0','127.0.0.1','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (619,'so8udkse3f34m4tv0pqb8qbgi4','124.29.215.82','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (620,'kp8gpv08q6mmthbtf6vrp0s4r4','124.29.215.82','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (621,'knf8sijldhmca98l2aga1ds8s0','127.0.0.1','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (622,'ldctc1ji2cag0ulptp1o5l1g10','203.81.200.45','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (623,'5irfne3vns32icmhel2e4qcu55','66.249.66.207','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (624,'ibng572mlv4j7g7r5dqmofqd92','66.249.66.207','2007-01-08',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (625,'ps40hjj6f9o06uveuvh781f2k1','127.0.0.1','2007-01-09',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (626,'2ao4sf4u74gvebkmh9qoi1c780','124.29.215.84','2007-01-09',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (627,'4bhch8kemto84ims3b5chbgmf5','127.0.0.1','2007-01-09',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (628,'1jbtmtc7n1osh6dr2s83s7lcn1','124.29.215.84','2007-01-09',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (629,'530ccbqmculs10ts8ufjainsd0','124.29.215.84','2007-01-09',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (630,'kpt0nipmd845l02ocvgpu8m3t1','127.0.0.1','2007-01-09',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (631,'k25ndr4lselmufo14coaug0ol2','127.0.0.1','2007-01-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (632,'fmau30ek7eiielgvs01hhca5d1','124.29.215.84','2007-01-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (633,'vusidgao33rkpad13v1oonr256','127.0.0.1','2007-01-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (634,'lp0a1irocs2i78109np0vo44l4','203.81.220.230','2007-01-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (635,'20c95gn54mctldk8g6fuleg9h7','66.249.65.83','2007-01-10',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (636,'tc9n6jkdvads0nokktt157huq6','127.0.0.1','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (637,'1iq9irdt4ejco4gdpmqagoflq4','127.0.0.1','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (638,'mhmc67oqokcc555ilk5ejq7nl3','127.0.0.1','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (639,'f4j4acroovi32hllgo1rt02rp2','127.0.0.1','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (640,'5df4amj2fcppbh9a6041jmca21','124.29.215.84','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (641,'879bmj3ntjajpejj08rm6ic2t5','124.29.215.84','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (642,'imaroubsks4d5e1j7vkovhi0b7','124.29.215.84','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (643,'gt2bqrmuqiq0t9lr1d6p2g4ec2','124.29.215.84','2007-01-11',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (644,'b50mqc6gmf7gjm3m31ee2tv5n4','127.0.0.1','2007-01-12',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (645,'3rdhsdjisamoaq2sp0n3p9trm2','124.29.215.84','2007-01-12',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (646,'0vd9m5910qitbeh5nqs1hcqfs4','127.0.0.1','2007-01-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (647,'miopjmggrdagsu1c3sq0ive3o3','124.29.215.82','2007-01-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (648,'sf4b6l9p3p975pv7i6jauvnju5','66.249.65.209','2007-01-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (649,'ce9tjgk7ds47msfdb003jev7j6','124.29.215.82','2007-01-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (650,'llod9km4vuc6fplsnbj8jaoei5','124.29.215.82','2007-01-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (651,'0vi7j86j736unek77tbe0g85t7','127.0.0.1','2007-01-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (652,'rirgbosuj59je156hgt6ou4kr6','124.29.215.82','2007-01-15',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (653,'p3n84jmcapgar73k8pbo4vhp14','124.29.215.82','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (654,'iph6vsfattnc712gdpikrt0ku2','124.29.215.82','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (655,'f4msljlc0irdp93a0f27b0otl6','127.0.0.1','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (656,'8cei9j9m5d06fu180h2l8ncsk6','127.0.0.1','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (657,'bt8ckdb1083fopvkdkj71jhi11','124.29.215.84','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (658,'et1pnmi5evr4743o7ocb4bt1a0','124.29.215.82','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (659,'6ob8v329h2p252ce1oqqtj4571','127.0.0.1','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (660,'tv8jkgk3tm0loussvu3pinn1e6','124.29.215.84','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (661,'3nht5t9upluinkm42b480tidl0','127.0.0.1','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (662,'n64q0oavdq8ohcnv8178s2k3o7','124.29.215.84','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (663,'d0db1kagarhhub6ug9en1a5dc5','124.29.215.84','2007-01-16',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (664,'qihm6du5coprtp6u6vh758e940','124.29.215.82','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (665,'vg1p3u5gtho1769in94jjfebj1','66.249.65.209','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (666,'3j8lor0spljdhivjqp9tu61lt5','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (667,'vb7pivqtcoi9f8e1e5mqc0sif7','124.29.215.82','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (668,'0s5cvpn944e3nrlk7d9fspbfb1','124.29.215.82','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (669,'ok0rcah1oii6o2rgrmqibk7ir5','192.168.0.47','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (670,'erqsnplia1btpkk6d4o4161sa2','192.168.0.47','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (671,'v4a4bunrk6uctisj8loku3egm0','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (672,'jtjrda86u7vtfj89uj32sc5at1','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (673,'qv4b27oodmmj57f7m3npuru3v7','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (674,'0s5cvpn944e3nrlk7d9fspbfb1','124.29.215.82','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (675,'pf8ki4j5v1pj1cuhbt28f19vn4','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (676,'e5ms8i6bmgh26kgegnj3ijl123','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (677,'9b1a3v2r2qpjcbac4mog9gee83','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (678,'oc3i98td0ciqnd1ndmbqr1se05','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (679,'4s2igeq6p6v2m7vsm728urik35','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (680,'r5c4l2gtrjjnm8ojlq4o1kult0','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (681,'rg67ht4mgqhrh6ghj17eqdskp1','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (682,'dq8a5sarn8n73jifi6jkbvpq25','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (683,'vse78ceqbfrfrko1b0clod58i5','192.168.0.47','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (684,'aehkfm6vd4bggdfea9tstd8k84','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (685,'g330r25vtqj3dgtuusoiamuh93','192.168.0.47','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (686,'1jcjonaspre38fb9smgl5af2q3','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (687,'ce1b01g66er2ovmds7ldpb7v33','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (688,'ki0ibpd21sfj340joqub97a762','67.79.200.114','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (689,'63htk9eau3f5fk8lf1o3hvo276','124.29.215.82','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (690,'hkju4oa7e76jtj2n0vpk12ilf4','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (691,'0hgpe0allf1j3go9u1lh92ua90','124.29.215.82','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (692,'of4hjkmi5jkdv6nnmpeieql8t6','124.29.215.82','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (693,'uumv8nfkavthr46t0s4v2teg52','127.0.0.1','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (694,'kspcf4pemddaukhqiht3gb8m97','124.29.215.84','2007-01-17',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (695,'oks6dntso012m3gbfgnsrtavo7','124.29.215.82','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (696,'ijcjiqv1sgdfebtsfm1tns37e1','127.0.0.1','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (697,'tpl7rl4s10mdf95f4mg6mqs657','124.29.215.82','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (698,'43qfeo4nepooj6cfe7ggrgi5p0','124.29.215.82','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (699,'mabdngqnhi94hctci5fq2sp562','127.0.0.1','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (700,'8picf4jghr6qkts8h0jnsvam64','127.0.0.1','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (701,'nl3ml16kvv8mjuqsrv3i12d265','127.0.0.1','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (702,'lib3lp90ti7j142isqtk9v9775','124.29.215.84','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (703,'anpcieci8aq1s9m716s6b76su5','127.0.0.1','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (704,'dkk6fluo6dl1lmcsftkcqcokj0','127.0.0.1','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (705,'5amu8nbgnc8s66c9pd0bna7m86','127.0.0.1','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (706,'sgtpplq32nns320ouivokgtsc6','124.29.215.82','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (707,'q9glo1g6cq5hjnptk8io0lodo3','66.249.72.12','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (708,'ql8jhboe568ul53d8emkcmjvh4','124.29.215.84','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (709,'ftqj6imntq97igbl41f3729i17','124.29.215.82','2007-01-18',1);
insert into `websitehits` (`HitsId`,`SessionId`,`ClientIP`,`CreateDate`,`IsActive`) values (710,'bvm0p3b144f0hrqbt5p2rh2lj6','124.29.215.82','2007-01-18',1);

/* Procedure structure for procedure `ACCOUNTTYPE_LIST_ACTIVE` */

drop procedure if exists `ACCOUNTTYPE_LIST_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ACCOUNTTYPE_LIST_ACTIVE`(	
pIsActive INT
)
BEGIN
SELECT * FROM 
	`ACCOUNTTYPE`
	WHERE IsActive=pIsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `ADDS_GROUP_INSERT` */

drop procedure if exists `ADDS_GROUP_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADDS_GROUP_INSERT`(
pAddsId bigint,
pGroupId bigint)
BEGIN
INSERT INTO 
		ADDSGROUP
		(
			AddsId,
			GroupId	
		)
	VALUES 
		(
			pAddsId,
			pGroupId
		);
	SELECT 1 AS STATUS;
END$$

DELIMITER ;

/* Procedure structure for procedure `ADDs_INSERT` */

drop procedure if exists `ADDs_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADDs_INSERT`(
pAdsId int,
pAddsName varchar(150),
pAddsDescription varchar(300),
pImage varchar(300),
pExpiryDate date,
pCreatedDate date,
pIsActive tinyint,
pAdSize varchar(50),
pSniffed text
)
BEGIN
INSERT INTO 
		ADDS
		(
			AddsId,
			AddsName,
			AddsDescription,
			Image,
			ExpiryDate,
			CreateDate,
			IsActive,
			AdSize,
			Sniffed
		)
	VALUES 
		(
			pAdsId,
			pAddsName,
			pAddsDescription,
			pImage,
			pExpiryDate,
			pCreatedDate,
			pIsActive,
			pAdSize,
			pSniffed
		);
	SELECT 1 AS STATUS;
END$$

DELIMITER ;

/* Procedure structure for procedure `ADDS_RECORD_COUNT` */

drop procedure if exists `ADDS_RECORD_COUNT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADDS_RECORD_COUNT`(
)
BEGIN
	SELECT
		count(1)
	FROM
		ADDS;
END$$

DELIMITER ;

/* Procedure structure for procedure `ADD_DELETE_BY_ID` */

drop procedure if exists `ADD_DELETE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADD_DELETE_BY_ID`(
pAddId int
)
BEGIN
	DELETE FROM
		ADDSGROUP
	WHERE
		AddsId=pAddId;
	DELETE FROM 
		Adds
	WHERE
		AddsId=pAddId;
END$$

DELIMITER ;

/* Procedure structure for procedure `ADMIN_FORGET_PASSWORD` */

drop procedure if exists `ADMIN_FORGET_PASSWORD`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADMIN_FORGET_PASSWORD`(
PEMAIL VARCHAR(100)
)
BEGIN
	SELECT 
		EMAIL,PASSWORD
	FROM 
		ADMIN
	WHERE
		EMAIL=PEMAIL;
END$$

DELIMITER ;

/* Procedure structure for procedure `ADMIN_LOGIN` */

drop procedure if exists `ADMIN_LOGIN`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADMIN_LOGIN`(
PEMAIL VARCHAR(100),
PPASSWORD VARCHAR(100)
)
BEGIN
	DECLARE VEMAIL VARCHAR(100);
	DECLARE VPASSWORD VARCHAR(100);
	
	SELECT 
		EMAIL INTO VEMAIL
	FROM 
		ADMIN
	WHERE
		EMAIL=PEMAIL;
IF VEMAIL<>"" THEN
	
	SELECT 
		EMAIL INTO VPASSWORD
	FROM 
		ADMIN
	WHERE
		PASSWORD=PPASSWORD;
	IF VPASSWORD<>"" THEN
		SELECT VEMAIL AS EMAIL;
	ELSE
		SELECT -1 AS STATUS;
	END IF;		
ELSE
	SELECT 0 AS EMAIL;
END IF;		
	
END$$

DELIMITER ;

/* Procedure structure for procedure `ADMIN_PASSWORD_UPDATE` */

drop procedure if exists `ADMIN_PASSWORD_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADMIN_PASSWORD_UPDATE`(
PEMAIL VARCHAR(250),
POLDPASSWORD VARCHAR(250),
PNEWPASSWORD VARCHAR(250)
)
BEGIN
	DECLARE VEMAIL VARCHAR(100);
	
	SELECT 
		EMAIL INTO VEMAIL
	FROM 
		ADMIN
	WHERE
		EMAIL=PEMAIL AND PASSWORD = POLDPASSWORD;
	
	IF VEMAIL<>"" THEN
		UPDATE
			ADMIN
		SET
			PASSWORD = PNEWPASSWORD
		WHERE
			EMAIL=PEMAIL;
	
		SELECT 1 AS STATUS;
	ELSE
		SELECT 0 AS STATUS;
	END IF;	
END$$

DELIMITER ;

/* Procedure structure for procedure `ADS_RECORD_COUNT_REPORT` */

drop procedure if exists `ADS_RECORD_COUNT_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ADS_RECORD_COUNT_REPORT`()
BEGIN
	SELECT 
		COUNT(ag.GROUPID),g.GROUPNAME
	FROM
		ADDSGROUP ag, GROUPS g
	WHERE
		g.GROUPID=ag.GROUPID
	GROUP BY 
		ag.GROUPID;
END$$

DELIMITER ;

/* Procedure structure for procedure `CELLULARPROVIDER_LIST_ACTIVE` */

drop procedure if exists `CELLULARPROVIDER_LIST_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CELLULARPROVIDER_LIST_ACTIVE`(
pIsActive INT
)
BEGIN
SELECT * FROM 
	`CELLULARPROVIDER` 
	WHERE IsActive=pIsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `CELLULAR_PROVIDER_GET_BY_COUNTRY_ID` */

drop procedure if exists `CELLULAR_PROVIDER_GET_BY_COUNTRY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CELLULAR_PROVIDER_GET_BY_COUNTRY_ID`(
pCountryId INT,
pIsActive INT
)
BEGIN
SELECT * FROM 
	CELLULARPROVIDER 
	WHERE IsActive=pIsActive 
	and CountryId=pCountryId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CELLULAR_PROVIDER_GET_BY_ID` */

drop procedure if exists `CELLULAR_PROVIDER_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CELLULAR_PROVIDER_GET_BY_ID`(
pCellularId INT
)
BEGIN
SELECT * FROM 
	CELLULARPROVIDER 
	WHERE CellularId=pCellularId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ACTIVATE_CODE_UPDATE` */

drop procedure if exists `CONSUMER_ACTIVATE_CODE_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ACTIVATE_CODE_UPDATE`(
pEmail varchar(250),
pActivationCode varchar(250)
)
BEGIN
DECLARE VCONSUMERID BIGINT;
	SELECT 
		CONSUMERID INTO VCONSUMERID
	FROM 
		CONSUMER 
	WHERE 
		EMAIL=pEmail AND ACTIVATIONCODE=pActivationCode; 
IF VCONSUMERID>0 THEN
	UPDATE 
		CONSUMER
	SET 
		ISVARIFIED=1
	WHERE 
		EMAIL=pEmail AND ACTIVATIONCODE=pActivationCode;
	SELECT 1 AS STATUS;
ELSE
	SELECT 0 AS STATUS;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ALERT_BY_COUNTRY_ACTION` */

drop procedure if exists `CONSUMER_ALERT_BY_COUNTRY_ACTION`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ALERT_BY_COUNTRY_ACTION`(
pIntCountryId bigint,
pIntAction tinyint
)
BEGIN
	IF pIntAction = 1 THEN
		SELECT 
			c.EMAIL,c.FIRSTNAME,c.LASTNAME, ct.CountryName
		FROM 
			CONSUMER C, CONSUMERALERTS ca, COUNTRY ct
		WHERE
			c.CONSUMERID = ca.CONSUMERID 
			AND
			ca.ADDACTION = 1
			AND 
			(ca.COUNTRYID = pIntCountryId OR ca.COUNTRYID = -1)
			AND
			ca.COUNTRYID = ct.COUNTRYID
			AND
			ca.ISACTIVE = 1
			AND
			c.ISACTIVE = 1;
	ELSEIF pIntAction = 2 THEN
		SELECT 
			c.EMAIL,c.FIRSTNAME,c.LASTNAME, ct.CountryName
		FROM 
			CONSUMER C, CONSUMERALERTS ca, COUNTRY ct
		WHERE
			c.CONSUMERID = ca.CONSUMERID 
			AND
			ca.MODIFYACTION = 1
			AND 
			(ca.COUNTRYID = pIntCountryId OR ca.COUNTRYID = -1)
			AND
			ca.COUNTRYID = ct.COUNTRYID
			AND
			ca.ISACTIVE = 1
			AND
			c.ISACTIVE = 1;
		
	END IF;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ALERT_DELETE_BY_ID` */

drop procedure if exists `CONSUMER_ALERT_DELETE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ALERT_DELETE_BY_ID`(
pConsumerAlertId bigint
)
BEGIN
	DELETE FROM 
		CONSUMERALERTS
	WHERE 
		CONSUMERALERTID = pConsumerAlertId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ALERT_GET_BY_ID` */

drop procedure if exists `CONSUMER_ALERT_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ALERT_GET_BY_ID`(
pConsumerAlertId bigint
)
BEGIN
	SELECT * 
		FROM 		
		CONSUMERALERTS
	WHERE 
		CONSUMERALERTID = pConsumerAlertId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ALERT_INSERT` */

drop procedure if exists `CONSUMER_ALERT_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ALERT_INSERT`(
pIntConsumerId bigint,
pCountryId bigint,
pAdd tinyint,
pModify tinyint,
pCreateDate date,
pIsActive tinyint
)
BEGIN
	DECLARE VCONSUMERID BIGINT;
	DECLARE PCONSUMERID BIGINT;
	SELECT 
		CONSUMERID INTO VCONSUMERID
	FROM 
		CONSUMERALERTS
	WHERE
		COUNTRYID=-1 AND CONSUMERID = pIntConsumerId AND pCountryId=-1;
	SELECT 
		CONSUMERID INTO PCONSUMERID 
	FROM 
		CONSUMERALERTS
	WHERE
		COUNTRYID=pCountryId AND CONSUMERID = pIntConsumerId;
	IF VCONSUMERID>0 THEN
		SELECT -1 AS STATUS;
		
	ELSE	
	
		IF PCONSUMERID>0 THEN
			SELECT 0 AS STATUS;
		ELSE
			INSERT INTO 
				CONSUMERALERTS 
				(
					ConsumerId,
					CountryId,
					AddAction,
					ModifyAction,
					CreateDate,
					IsActive
				)
			VALUES 
				(
					pIntConsumerId,
					pCountryId,
					pAdd,
					pModify,
					pCreateDate,
					pIsActive
				);
			SELECT 1 AS STATUS;
		
		END IF;
	
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ALERT_LIST_BY_CONSUMER_ID` */

drop procedure if exists `CONSUMER_ALERT_LIST_BY_CONSUMER_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ALERT_LIST_BY_CONSUMER_ID`(
pConsumerId bigint,
pIntStart bigint,
pIntRecordLimit bigint,
pSortListBy bigint
)
BEGIN
SET @start=pIntStart; 
SET @numrows=pIntRecordLimit; 
SET @ConsumerId=pConsumerId;
IF pSortListBy=1 THEN
	PREPARE STMT FROM 
		'SELECT 
			c.CountryName, a.*
		FROM 
			COUNTRY c, CONSUMERALERTS a
		WHERE
			(a.CONSUMERID = ?) 
		and 
			((c.CountryId = a.CountryId) 
			or 
			(a.CountryId = -1)) 
		group by a.ConsumerAlertId
		Order By a.CONSUMERALERTID desc
		LIMIT ?,?';
ELSE
	PREPARE STMT FROM 
		'SELECT 
			c.CountryName, a.*
		FROM 
			COUNTRY c, CONSUMERALERTS a
		WHERE
			(a.CONSUMERID = ?) 
		and 
			((c.CountryId = a.CountryId) 
			or 
			(a.CountryId = -1)) 
		group by a.ConsumerAlertId
		Order By a.CONSUMERALERTID
		LIMIT ?,?';
END IF;
EXECUTE STMT USING @ConsumerId, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ALERT_RECORD_COUNT_BY_CONSUMER` */

drop procedure if exists `CONSUMER_ALERT_RECORD_COUNT_BY_CONSUMER`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ALERT_RECORD_COUNT_BY_CONSUMER`(
pIntConsumerId bigint
)
BEGIN
	SELECT
		count(1)
	FROM
		CONSUMERALERTS
	WHERE
		CONSUMERID= pIntConsumerId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_ALERT_UPDATE` */

drop procedure if exists `CONSUMER_ALERT_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_ALERT_UPDATE`(
pIntConsumerAlertId bigint,
pIntConsumerId bigint,
pCountryId bigint,
pAdd tinyint,
pModify tinyint,
pIsActive tinyint
)
BEGIN
	DECLARE VCONSUMERID BIGINT;
	DECLARE PCONSUMERID BIGINT;
	SELECT 
		CONSUMERID INTO VCONSUMERID
	FROM 
		CONSUMERALERTS
	WHERE
		COUNTRYID=-1 AND CONSUMERID = pIntConsumerId AND pCountryId=-1 
		AND CONSUMERALERTID<>pIntConsumerAlertId;
	SELECT 
		CONSUMERID INTO PCONSUMERID 
	FROM 
		CONSUMERALERTS
	WHERE
		COUNTRYID=pCountryId AND CONSUMERID = pIntConsumerId
		AND CONSUMERALERTID<>pIntConsumerAlertId;
	IF VCONSUMERID>0 THEN
		SELECT -1 AS STATUS;
		
	ELSE	
	
		IF PCONSUMERID>0 THEN
			SELECT 0 AS STATUS;
		ELSE
			UPDATE 
				CONSUMERALERTS 
			SET
				CountryId = pCountryId,
				AddAction = pAdd,
				ModifyAction = pModify,
				IsActive = pIsActive
			WHERE 
				CONSUMERALERTID = pIntConsumerAlertId;
			SELECT 1 AS STATUS;
		
		END IF;
	
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_DELETE_BY_ID` */

drop procedure if exists `CONSUMER_DELETE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_DELETE_BY_ID`(
pConsumerId bigint
)
BEGIN
	DELETE FROM 
		CONSUMER
	WHERE 
		CONSUMERID = pConsumerId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_GET_BY_ID` */

drop procedure if exists `CONSUMER_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_GET_BY_ID`(
pConsumerId bigint
)
BEGIN
	SELECT p.*, c.CountryName, s.StateName, sc.QuestionName, a.AccountTypeName
FROM 
	CONSUMER p, COUNTRY c, STATE s, SECERETQUESTION sc, ACCOUNTTYPE a
WHERE
	p.ConsumerId = pConsumerId
	AND
	p.CountryId = c.CountryId
	AND
	p.StateId = s.StateId
	AND
	p.QuestionId = sc.QuestionId
	AND
	p.AccountType = a.AccountTypeId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_INSERT` */

drop procedure if exists `CONSUMER_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_INSERT`(
CountryId bigint,
StateId bigint,
AccountType bigint,
QuestionId bigint,
Email varchar(100),
Password varchar(100),
FirstName varchar(100),
LastName varchar(100),
Address varchar(200),
City varchar(100),
ZipCode varchar(100),
Telephone1 varchar(100),
DateOfBirth date,
Answer varchar(250),
ActivationCode varchar(250),
IsVarified tinyint,
CreateDate date,
IsActive tinyint,
pMobileNo varchar(100),
pCellularId bigint
)
BEGIN
INSERT INTO 
	CONSUMER 
	(
		CountryId,
		StateId,
		AccountType,
		QuestionId,
		Email,
		Password,
		FirstName,
		LastName,
		Address,
		City,
		ZipCode,
		Telephone1,
		DateOfBirth,
		Answer,
		ActivationCode,
		IsVarified,
		CreateDate,
		IsActive,
		Mobile,
		CellularId
	)
VALUES 
	(
		CountryId,
		StateId,
		AccountType,
		QuestionId,
		Email,
		Password,
		FirstName,
		LastName,
		Address,
		City,
		ZipCode,
		Telephone1,
		DateOfBirth,
		Answer,
		ActivationCode,
		IsVarified,
		CreateDate,
		IsActive,
		pMobileNo,
		pCellularId
	);
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_LIST_ANSWER_BY_EMAIL` */

drop procedure if exists `CONSUMER_LIST_ANSWER_BY_EMAIL`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_LIST_ANSWER_BY_EMAIL`(
PEMAIL VARCHAR(100),
PQUESTIONID BIGINT,
PANSWER VARCHAR(250)
)
BEGIN
	
	SELECT 
		FIRSTNAME,LASTNAME,EMAIL,PASSWORD
	FROM 
		CONSUMER
	WHERE
		EMAIL=PEMAIL AND QUESTIONID=PQUESTIONID AND ANSWER=PANSWER;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_LIST_BY_EMAIL` */

drop procedure if exists `CONSUMER_LIST_BY_EMAIL`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_LIST_BY_EMAIL`(
pEmail varchar(250)
)
BEGIN
SELECT * 
FROM 
	CONSUMER
WHERE
	Email = pEmail;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_LIST_BY_STATUS` */

drop procedure if exists `CONSUMER_LIST_BY_STATUS`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_LIST_BY_STATUS`(
pIntStart bigint,
pIntRecordLimit bigint,
pIsActive bigint,
pSortListBy bigint
)
BEGIN
SET @start=pIntStart; SET @numrows=pIntRecordLimit; SET @IsActive=pIsActive; 
IF pSortListBy=1 THEN
	IF pIsActive = 3 THEN
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				CONSUMER
			WHERE
				ISACTIVE <> ?
			ORDER BY
				FIRSTNAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				CONSUMER
			WHERE
				ISACTIVE = ?
			ORDER BY
				FIRSTNAME desc
			LIMIT ?,?';
	END IF;
ELSE
	IF pIsActive = 3 THEN
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				CONSUMER
			WHERE
				ISACTIVE <> ?
			ORDER BY
				FIRSTNAME
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				CONSUMER
			WHERE
				ISACTIVE = ?
			ORDER BY
				FIRSTNAME
			LIMIT ?,?';
	END IF;
END IF;
EXECUTE STMT USING @IsActive, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_LOGIN` */

drop procedure if exists `CONSUMER_LOGIN`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_LOGIN`(
PEMAIL VARCHAR(250),
PPASSWORD VARCHAR(250)
)
BEGIN
	DECLARE VEMAILSTATUS BIGINT;
	DECLARE VPASSWORDSTATUS BIGINT;
	
	SELECT 
		CONSUMERID INTO VEMAILSTATUS 
	FROM 
		CONSUMER
	WHERE
		EMAIL=PEMAIL AND ISVARIFIED=1 AND ISACTIVE=1; 
IF VEMAILSTATUS>0 THEN
	/*SELECT 1 AS STATUS;*/
	SELECT 
		CONSUMERID INTO VPASSWORDSTATUS 
	FROM 
		CONSUMER
	WHERE
		PASSWORD=PPASSWORD AND EMAIL=PEMAIL AND ISVARIFIED=1 AND ISACTIVE=1;
	IF VPASSWORDSTATUS>0 THEN
		SELECT 
			ConsumerId,
			Email,
			FirstName,
			LastName
			
		FROM	
			CONSUMER
		WHERE 
			EMAIL=PEMAIL;
	ELSE
		SELECT -1 AS ConsumerId, "null" AS Email, "null" AS FirstName, "null" AS LastName;
	END IF;		
ELSE
	SELECT 0 AS ConsumerId, "null" AS Email, "null" AS FirstName, "null" AS LastName;
END IF;		
	
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_PASSWORD_UPDATE` */

drop procedure if exists `CONSUMER_PASSWORD_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_PASSWORD_UPDATE`(
PEMAIL VARCHAR(250),
POLDPASSWORD VARCHAR(250),
PNEWPASSWORD VARCHAR(250)
)
BEGIN
	DECLARE VPASSWORDSTATUS BIGINT;
	SELECT 
		CONSUMERID INTO VPASSWORDSTATUS
	FROM 
		CONSUMER
	WHERE
		EMAIL=PEMAIL AND PASSWORD = POLDPASSWORD;
	IF VPASSWORDSTATUS>0 THEN
		UPDATE
			CONSUMER
		SET
			PASSWORD = PNEWPASSWORD
		WHERE
			EMAIL=PEMAIL;
	
		SELECT 1 AS STATUS;
	ELSE
		SELECT 0 AS STATUS;
	END IF;	
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_RECORD_COUNT_BY_STATUS` */

drop procedure if exists `CONSUMER_RECORD_COUNT_BY_STATUS`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_RECORD_COUNT_BY_STATUS`(
pIntIsActive bigint
)
BEGIN
	IF pIntIsActive=3 THEN
		SELECT
			count(1)
		FROM
			CONSUMER;
	ELSE
		SELECT
			count(1)
		FROM
			CONSUMER
		WHERE
			ISACTIVE = pIntIsActive;
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_SECRETQUESTION_LIST_BY_EMAIL` */

drop procedure if exists `CONSUMER_SECRETQUESTION_LIST_BY_EMAIL`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_SECRETQUESTION_LIST_BY_EMAIL`(
PEMAIL VARCHAR(255)
)
BEGIN
	DECLARE VEMAILSTATUS BIGINT;
	SELECT 
		CONSUMERID INTO VEMAILSTATUS
	FROM 
		CONSUMER
	WHERE 
		EMAIL=PEMAIL AND ISVARIFIED=1 AND ISACTIVE=1;
IF VEMAILSTATUS>0 THEN
	
	SELECT 
		SECERETQUESTION.QUESTIONNAME 
	FROM
		CONSUMER,SECERETQUESTION
	WHERE
		CONSUMER.EMAIL=PEMAIL AND CONSUMER.QUESTIONID=SECERETQUESTION.QUESTIONID AND CONSUMER.ISVARIFIED=1 AND CONSUMER.ISACTIVE=1;
ELSE
SELECT 0 AS STATUS;
END IF;		
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_SMS_ALERT_RECORD_COUNT_BY_CONSUMER` */

drop procedure if exists `CONSUMER_SMS_ALERT_RECORD_COUNT_BY_CONSUMER`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_SMS_ALERT_RECORD_COUNT_BY_CONSUMER`(
pIntConsumerId bigint
)
BEGIN
	SELECT
		count(1)
	FROM
		SMSALERTS
	WHERE
		CONSUMERID= pIntConsumerId;
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_UPDATE` */

drop procedure if exists `CONSUMER_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_UPDATE`(
pEmail varchar(250),
PCountryId bigint,
PStateId bigint,
PAccountType bigint,
PQuestionId bigint,
PFirstName varchar(100),
PLastName varchar(100),
PAddress varchar(200),
PCity varchar(100),
PZipCode varchar(100),
PTelephone1 varchar(100),
PDateOfBirth date,
PAnswer varchar(250),
pMobile varchar(100),
CellularId bigint
)
BEGIN
UPDATE
	CONSUMER 
SET
	
		CountryId = PCountryId,
		StateId = PStateId,
		AccountType = PAccountType,
		QuestionId = PQuestionId,
		FirstName = PFirstName,
		LastName = PLastName,
		Address = PAddress,
		City = PCity,
		ZipCode = PZipCode,
		Telephone1 = PTelephone1,
		DateOfBirth = PDateOfBirth,
		Answer = PAnswer,
		Mobile = pMobile,
		CellularId = CellularId
WHERE 
		Email = pEmail;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `CONSUMER_UPDATE_BY_ID` */

drop procedure if exists `CONSUMER_UPDATE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CONSUMER_UPDATE_BY_ID`(
pConsumerId bigint,
PCountryId bigint,
PStateId bigint,
PAccountType bigint,
PQuestionId bigint,
pEmail varchar(250),
pPassword varchar(100),
PFirstName varchar(100),
PLastName varchar(100),
PAddress varchar(200),
PCity varchar(100),
PZipCode varchar(100),
PTelephone1 varchar(100),
PDateOfBirth date,
PAnswer varchar(250),
pActivationCode varchar(100),
pIsVarify tinyint,
PCreateDate date,
pIsActive tinyint,
pMobile varchar(100),
CellularId bigint
)
BEGIN
UPDATE
	CONSUMER 
SET
	
		CountryId = PCountryId,
		StateId = PStateId,
		AccountType = PAccountType,
		QuestionId = PQuestionId,
		Email = pEmail,
		Password = pPassword,
		FirstName = PFirstName,
		LastName = PLastName,
		Address = PAddress,
		City = PCity,
		ZipCode = PZipCode,
		Telephone1 = PTelephone1,
		DateOfBirth = PDateOfBirth,
		Answer = PAnswer,
		ActivationCode = pActivationCode,
		IsVarified = pIsVarify,
		CreateDate = PCreateDate,
		IsActive = pIsActive,
		Mobile = pMobile,
		CellularId = CellularId
WHERE 
		ConsumerId = pConsumerId;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `COUNTRY_GET_BY_ID` */

drop procedure if exists `COUNTRY_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `COUNTRY_GET_BY_ID`(
pCountryId INT,
pIsActive INT
)
BEGIN
SELECT * FROM 
	COUNTRY 
	WHERE IsActive=pIsActive 
	and CountryId=pCountryId;
END$$

DELIMITER ;

/* Procedure structure for procedure `COUNTRY_LIST_ACTIVE` */

drop procedure if exists `COUNTRY_LIST_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `COUNTRY_LIST_ACTIVE`(
pIsActive INT
)
BEGIN
SELECT * FROM 
	`COUNTRY` 
	WHERE IsActive=pIsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `FEATURE_STAT_HITS_REPORT` */

drop procedure if exists `FEATURE_STAT_HITS_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FEATURE_STAT_HITS_REPORT`(
pUserType tinyint
)
BEGIN
	IF (pUserType=-1) THEN
		SELECT
			*
		FROM
			FEATURESTAT
		WHERE
			ISACTIVE = 1;
	
	ELSE IF (pUserType=-2) THEN
		SELECT
			*
		FROM
			FEATURESTAT
		WHERE
			ISACTIVE = 1
		ORDER BY HITS desc
		LIMIT 0,5;
	ELSE
		SELECT
			*
		FROM
			FEATURESTAT
		WHERE
			UserType=pUserType
		AND
			ISACTIVE = 1;
	END IF;
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `FEATURE_STAT_UPDATE_HITS` */

drop procedure if exists `FEATURE_STAT_UPDATE_HITS`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FEATURE_STAT_UPDATE_HITS`(
PURL VARCHAR(250),
PUSERTYPE TINYINT
)
BEGIN
	DECLARE VHITS INT;
	SELECT 
		HITS INTO VHITS
	FROM
		FEATURESTAT
	WHERE
		PAGEURL=PURL
		AND
		USERTYPE=PUSERTYPE
		AND
		ISACTIVE=1;
IF VHITS>-1 THEN
	UPDATE 
		FEATURESTAT
	SET
		HITS = VHITS+1
	WHERE
		PAGEURL=PURL
		AND
		USERTYPE=PUSERTYPE
		AND
		ISACTIVE=1;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `GET_ADDS_BY_ID` */

drop procedure if exists `GET_ADDS_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_ADDS_BY_ID`(
pAddsId int
)
BEGIN
	SELECT 
		*
	FROM
		ADDS
	WHERE
		ADDSID = pAddsId;
END$$

DELIMITER ;

/* Procedure structure for procedure `GET_ADDS_LIST` */

drop procedure if exists `GET_ADDS_LIST`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_ADDS_LIST`(pIntStart bigint,
pIntRecordLimit bigint,
pSortListBy bigint
)
BEGIN
SET @start=pIntStart; 
SET @numrows=pIntRecordLimit; 
IF pSortListBy=1 THEN
	PREPARE STMT FROM 
		'SELECT
			AddsId,AddsName,Image,ExpiryDate,CreateDate,IsActive,AdSize,Sniffed
		FROM
			Adds
		ORDER BY AddsId desc	
		LIMIT ?,?';
ELSE
	PREPARE STMT FROM 
		'SELECT
			AddsId,AddsName,Image,ExpiryDate,CreateDate,IsActive,AdSize,Sniffed
		FROM
			Adds
		ORDER BY AddsId
		LIMIT ?,?';
		
END IF;
EXECUTE STMT USING @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `GET_ADDS_MAX_ID` */

drop procedure if exists `GET_ADDS_MAX_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_ADDS_MAX_ID`()
BEGIN
	SELECT
		max(addsid)
	FROM 
		ADDS;
END$$

DELIMITER ;

/* Procedure structure for procedure `GET_GROUP_BY_ADDID` */

drop procedure if exists `GET_GROUP_BY_ADDID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_GROUP_BY_ADDID`(
pAddsId int
)
BEGIN
	SELECT 
		g.*
	FROM 
		GROUPS g, ADDSGROUP ag
	WHERE 
		g.GROUPID = ag.GROUPID
		AND
		ag.ADDSID = pAddsId;
END$$

DELIMITER ;

/* Procedure structure for procedure `GET_IMAGE_LIST_BY_PAGE` */

drop procedure if exists `GET_IMAGE_LIST_BY_PAGE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_IMAGE_LIST_BY_PAGE`(
pPageName varchar(300)
)
BEGIN
	SELECT
		a.AddsId,a.Image,ag.groupid
	FROM
		ADDS a,ADDSGROUP ag
	WHERE
		a.ADDSID=ag.ADDSID
		AND
		ag.GROUPID=(	
			    SELECT 
				   pg.GROUPID
			    FROM
				   PAGE p, PAGEGROUP pg 
			    WHERE
				   p.PAGEID=pg.PAGEID
				   AND
				   p.PAGENAME=pPageName
			    );
END$$

DELIMITER ;

/* Procedure structure for procedure `GET_SNIFFED_LIST_BY_PAGE` */

drop procedure if exists `GET_SNIFFED_LIST_BY_PAGE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_SNIFFED_LIST_BY_PAGE`(
pPageName varchar(300)
)
BEGIN
	SELECT
		a.AddsId,a.sniffed,ag.groupid,a.AdSize
	FROM
		ADDS a,ADDSGROUP ag
	WHERE
		a.ADDSID=ag.ADDSID
		AND
		ag.GROUPID=(	
			    SELECT 
				   pg.GROUPID
			    FROM
				   PAGE p, PAGEGROUP pg 
			    WHERE
				   p.PAGEID=pg.PAGEID
				   AND
				   p.PAGENAME=pPageName
			    );
END$$

DELIMITER ;

/* Procedure structure for procedure `GET_STATE_BY_ID` */

drop procedure if exists `GET_STATE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_STATE_BY_ID`(
pStateId INT,
pIsActive INT
)
BEGIN
SELECT * FROM 
	STATE 
	WHERE IsActive=pIsActive 
	and StateId=pStateId;
END$$

DELIMITER ;

/* Procedure structure for procedure `IS_CONSUMER_PRODUCER` */

drop procedure if exists `IS_CONSUMER_PRODUCER`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `IS_CONSUMER_PRODUCER`(
pEmail varchar(100)
)
BEGIN
DECLARE VEMAIL VARCHAR(100);
	SELECT 
		email INTO VEMAIL
	FROM 
		PRODUCER
	WHERE
		EMAIL=PEMAIL;
IF VEMAIL<>"" THEN
SELECT 1 AS STATUS;
ELSE
	SELECT 
		email INTO VEMAIL
	FROM 
		CONSUMER
	WHERE
		EMAIL=PEMAIL;
	IF VEMAIL<>"" THEN
		SELECT 1 AS STATUS;
	ELSE
		SELECT 0 AS STATUS;
	END IF;
END IF;
select VEMAIL;
END$$

DELIMITER ;

/* Procedure structure for procedure `PAGEGROUP_LIST` */

drop procedure if exists `PAGEGROUP_LIST`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PAGEGROUP_LIST`()
BEGIN
	SELECT 
		p.pageid,p.pagename,g.groupid,g.groupname
	FROM 
		page p,groups g,pagegroup pg
	WHERE
		p.pageid=pg.pageid
		and 
		g.groupid=pg.groupid;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_CONSUMER_SEARCH` */

drop procedure if exists `PLACECAST_CONSUMER_SEARCH`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_CONSUMER_SEARCH`(
pIntStart bigint,
pIntRecordLimit bigint,
pQuery varchar(200),
pCheckCountry tinyint,
pCheckState tinyint,
pCheckCity tinyint,
pCheckZip tinyint,
pIsActive bigint,
pSortListBy bigint
)
BEGIN
	
SET @start=pIntStart; 
SET @numrows=pIntRecordLimit; 
SET @IsActive=pIsActive; 
SET @name = pQuery;
IF pCheckCountry=1 THEN
	SET @CheckCountry=pQuery;
	SET @name = '';
ELSE
	SET @CheckCountry='';
END IF;
IF pCheckState=1 THEN
	SET @CheckState=pQuery;
	SET @name = '';
ELSE
	SET @CheckState='';
END IF;
IF pCheckCity=1 THEN
	SET @CheckCity=pQuery;
	SET @name = '';
ELSE
	SET @CheckCity='';
END IF;
IF pCheckZip=1 THEN
	SET @CheckZip=pQuery;
	SET @name = '';
ELSE
	SET @CheckZip='';
END IF;
IF pIsActive=3 THEN
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE <> ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
				AND
				(p.Name like ?
				OR c.CountryName like ?
				OR s.StateName like ?
				OR p.City like ?
				OR p.ZipCode like ?)
			ORDER BY
				p.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE <> ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
				AND
				(p.Name like ?
				OR c.CountryName like ?
				OR s.StateName like ?
				OR p.City like ?
				OR p.ZipCode like ?)
			ORDER BY
				p.NAME
			LIMIT ?,?';
	END IF;
ELSE
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE = ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
				AND
				(p.Name like ?
				OR c.CountryName like ?
				OR s.StateName like ?
				OR p.City like ?
				OR p.ZipCode like ?)
			ORDER BY
				p.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE = ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
				AND
				(p.Name like ?
				OR c.CountryName like ?
				OR s.StateName like ?
				OR p.City like ?
				OR p.ZipCode like ?)
			ORDER BY
				p.NAME
			LIMIT ?,?';
	END IF;
END IF;
EXECUTE STMT USING @IsActive, @name, @CheckCountry, @CheckState, @CheckCity, @CheckZip,@start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_DELETE_BY_ID` */

drop procedure if exists `PLACECAST_DELETE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_DELETE_BY_ID`(
pPlaceCastId bigint
)
BEGIN
	DELETE FROM 
		PLACECAST
	WHERE 
		PlaceCastId = pPlaceCastId;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_DOWNLOAD_INSERT` */

drop procedure if exists `PLACECAST_DOWNLOAD_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_DOWNLOAD_INSERT`(
pConsumerId bigint,
pPlaceCastId bigint,
pCreateDate date,
pIsActive tinyint
)
BEGIN
DECLARE vCountryId BIGINT;
	
	SELECT CountryId into vCountryId 
	FROM PLACECAST 
	WHERE PLACECASTID=pPlaceCastId;
	INSERT INTO 
		PLACECASTDOWNLOAD
	SET
		CountryId=vCountryId,
		CONSUMERID=pConsumerId,
		PLACECASTID=pPlaceCastId,
		CREATEDATE=pCreateDate,
		ISACTIVE=pIsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_DOWNLOAD_RECORD_COUNT_REPORT` */

drop procedure if exists `PLACECAST_DOWNLOAD_RECORD_COUNT_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_DOWNLOAD_RECORD_COUNT_REPORT`(
pFromDate date,
pToDate date
)
BEGIN
	IF (pFromDate is null OR pToDate is null) THEN
		SELECT 
		COUNT(pd.PlaceCastDownloadId),pd.PLACECASTID, p.NAME
		FROM  PLACECASTDOWNLOAD pd, PLACECAST p
		WHERE p.PlaceCastId=pd.PlaceCastId GROUP BY pd.PlaceCastId
			ORDER BY COUNT(pd.PlaceCastDownloadId) desc;
	ELSE
		SELECT 
		COUNT(pd.PlaceCastDownloadId),pd.PLACECASTID, p.NAME
		FROM  PLACECASTDOWNLOAD pd, PLACECAST p
		WHERE p.PlaceCastId=pd.PlaceCastId
		AND pd.CREATEDATE BETWEEN pFromDate AND pToDate 
		GROUP BY pd.PlaceCastId
			ORDER BY COUNT(pd.PlaceCastDownloadId) desc;
	END IF;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_GET_BY_ID` */

drop procedure if exists `PLACECAST_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_GET_BY_ID`(
pPlaceCastId bigint,
pIsActive bigint
)
BEGIN
IF pIsActive=3 THEN
	SELECT 
		p.*, c.CountryName, s.StateName
	FROM 
		PLACECAST p, COUNTRY c, STATE s
	WHERE
		p.PlaceCastId = pPlaceCastId 
		AND 
		p.ISACTIVE <> pIsActive
		AND
		p.CountryId = c.CountryId
		AND
		p.StateId = s.StateId;
ELSE
	SELECT 
		p.*, c.CountryName, s.StateName
	FROM 
		PLACECAST p, COUNTRY c, STATE s
	WHERE
		p.PlaceCastId = pPlaceCastId 
		AND 
		p.ISACTIVE = pIsActive
		AND
		p.CountryId = c.CountryId
		AND
		p.StateId = s.StateId;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_INSERT` */

drop procedure if exists `PLACECAST_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_INSERT`(
ProducerId bigint,
CountryId bigint,
StateId bigint,
Name varchar(100),
Address varchar(200),
City varchar(100),
ZipCode varchar(100),
Lat1 double,
Long1 double,
Lat2 double,
Long2 double,
Lat3 double,
Long3 double,
Lat4 double,
Long4 double,
Description varchar(250),
CreateDate date,
IsActive tinyint
)
BEGIN
INSERT INTO 
	PLACECAST 
	(
		ProducerId,
		CountryId,
		StateId,
		Name,
		Address,
		City,
		ZipCode,
		Lat1,
		Long1,
		Lat2,
		Long2,
		Lat3,
		Long3,
		Lat4,
		Long4,
		Description,
		CreateDate,
		IsActive
	)
VALUES 
	(
		ProducerId,
		CountryId,
		StateId,
		Name,
		Address,
		City,
		ZipCode,
		Lat1,
		Long1,
		Lat2,
		Long2,
		Lat3,
		Long3,
		Lat4,
		Long4,
		Description,
		CreateDate,
		IsActive
	);
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_LIST_ACTIVE` */

drop procedure if exists `PLACECAST_LIST_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_LIST_ACTIVE`(
pIntStart bigint,
pIntRecordLimit bigint,
pIsActive bigint,
pSortListBy bigint
)
BEGIN
	
SET @start=pIntStart; SET @numrows=pIntRecordLimit; SET @IsActive=pIsActive; 
#SET @start=0; SET @numrows=5; SET @IsActive=1;
IF pIsActive=3 THEN
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE <> ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
			ORDER BY
				p.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE <> ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
			ORDER BY
				p.NAME
			LIMIT ?,?';
	END IF;
ELSE
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE = ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
			ORDER BY
				p.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.ISACTIVE = ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId
			ORDER BY
				p.NAME
			LIMIT ?,?';
	END IF;
END IF;
EXECUTE STMT USING @IsActive, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_LIST_BY_PRODUCER_ID` */

drop procedure if exists `PLACECAST_LIST_BY_PRODUCER_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_LIST_BY_PRODUCER_ID`(
pProducerId bigint,
pIntStart bigint,
pIntRecordLimit bigint,
pIsActive bigint,
pSortListBy bigint
)
BEGIN
SET @start=pIntStart; 
SET @numrows=pIntRecordLimit; 
SET @IsActive=pIsActive; 
SET @ProducerId=pProducerId;
IF pIsActive=3 THEN
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.PRODUCERID = ? 
				AND 
				p.ISACTIVE <> ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId Order By p.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.PRODUCERID = ? 
				AND 
				p.ISACTIVE <> ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId Order By p.NAME
			LIMIT ?,?';
	END IF;
ELSE
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.PRODUCERID = ? 
				AND 
				p.ISACTIVE = ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId Order By p.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				p.*, c.CountryName, s.StateName
			FROM 
				PLACECAST p, COUNTRY c, STATE s
			WHERE
				p.PRODUCERID = ? 
				AND 
				p.ISACTIVE = ?
				AND
				p.CountryId = c.CountryId
				AND
				p.StateId = s.StateId Order By p.NAME
			LIMIT ?,?';
	END IF;
END IF;
EXECUTE STMT USING @ProducerId, @IsActive, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_RECORD_COUNT` */

drop procedure if exists `PLACECAST_RECORD_COUNT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_RECORD_COUNT`(
pIntIsActive bigint
)
BEGIN
IF pIntIsActive=3 THEN
	SELECT
		count(1)
	FROM
		PLACECAST
	WHERE
		ISACTIVE <> pIntIsActive;
ELSE
	SELECT
		count(1)
	FROM
		PLACECAST
	WHERE
		ISACTIVE = pIntIsActive;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_RECORD_COUNT_BY_CUSTOMER` */

drop procedure if exists `PLACECAST_RECORD_COUNT_BY_CUSTOMER`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_RECORD_COUNT_BY_CUSTOMER`(
pIntCustomerId bigint,
pIntIsActive bigint
)
BEGIN
	SELECT
		count(1)
	FROM
		PLACECAST
	WHERE
		ISACTIVE = pIntIsActive
		AND
		CustomerId = pIntCustomerId;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_RECORD_COUNT_BY_PRODUCER` */

drop procedure if exists `PLACECAST_RECORD_COUNT_BY_PRODUCER`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_RECORD_COUNT_BY_PRODUCER`(
pIntProducerId bigint,
pIntIsActive bigint
)
BEGIN
IF pIntIsActive=3 THEN
	SELECT
		count(1)
	FROM
		PLACECAST
	WHERE
		ISACTIVE <> pIntIsActive
		AND
		ProducerId = pIntProducerId;
ELSE
	SELECT
		count(1)
	FROM
		PLACECAST
	WHERE
		ISACTIVE = pIntIsActive
		AND
		ProducerId = pIntProducerId;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_RECORD_COUNT_REPORT` */

drop procedure if exists `PLACECAST_RECORD_COUNT_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_RECORD_COUNT_REPORT`(
pFromDate date,
pToDate date,
pCountryId bigint
)
BEGIN
		
	IF (pFromDate is null OR pToDate is null) AND pCountryId is null THEN
		SELECT 
		COUNT(p.PlaceCastId),c.COUNTRYNAME, p.ISACTIVE
		FROM  COUNTRY c, PLACECAST p
		WHERE p.COUNTRYID=c.COUNTRYID GROUP BY p.COUNTRYID,p.ISACTIVE;
	ELSEIF (pFromDate is null AND pToDate is null) AND pCountryId is not null THEN
		SELECT 
		COUNT(p.PlaceCastId),c.COUNTRYNAME, p.ISACTIVE 	
		FROM PLACECAST p, COUNTRY c
		WHERE p.COUNTRYID=pCountryId 
		AND p.COUNTRYID=c.COUNTRYID GROUP BY p.COUNTRYID,p.ISACTIVE;
	ELSE
		SELECT COUNT(p.PlaceCastId), c.COUNTRYNAME, p.ISACTIVE
		FROM PLACECAST p, COUNTRY c 
		WHERE p.COUNTRYID=c.COUNTRYID 
		AND p.CREATEDATE BETWEEN pFromDate AND pToDate 
		GROUP BY p.COUNTRYID,p.ISACTIVE;
	END IF;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_SEARCH_RECORD_COUNT` */

drop procedure if exists `PLACECAST_SEARCH_RECORD_COUNT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_SEARCH_RECORD_COUNT`(
pQuery varchar(200),
pCheckCountry tinyint,
pCheckState tinyint,
pCheckCity tinyint,
pCheckZip tinyint,
pIsActive bigint
)
BEGIN
	
SET @IsActive=pIsActive; 
SET @name = pQuery;
IF pCheckCountry=1 THEN
	SET @CheckCountry=pQuery;
	SET @name = '';
ELSE
	SET @CheckCountry='';
END IF;
IF pCheckState=1 THEN
	SET @CheckState=pQuery;
	SET @name = '';
ELSE
	SET @CheckState='';
END IF;
IF pCheckCity=1 THEN
	SET @CheckCity=pQuery;
	SET @name = '';
ELSE
	SET @CheckCity='';
END IF;
IF pCheckZip=1 THEN
	SET @CheckZip=pQuery;
	SET @name = '';
ELSE
	SET @CheckZip='';
END IF;
IF pIsActive=3 THEN
	PREPARE STMT FROM 
		'SELECT 
			count(1)
		FROM 
			PLACECAST p, COUNTRY c, STATE s
		WHERE
			p.ISACTIVE <> ?
			AND
			p.CountryId = c.CountryId
			AND
			p.StateId = s.StateId
			AND
			(p.Name like ?
			OR c.CountryName like ?
			OR s.StateName like ?
			OR p.City like ?
			OR p.ZipCode like ?)';
ELSE
	PREPARE STMT FROM 
		'SELECT 
			count(1)
		FROM 
			PLACECAST p, COUNTRY c, STATE s
		WHERE
			p.ISACTIVE = ?
			AND
			p.CountryId = c.CountryId
			AND
			p.StateId = s.StateId
			AND
			(p.Name like ?
			OR c.CountryName like ?
			OR s.StateName like ?
			OR p.City like ?
			OR p.ZipCode like ?)';
END IF;
EXECUTE STMT USING @IsActive, @name, @CheckCountry, @CheckState, @CheckCity, @CheckZip;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_TOGGLE_IS_ACTIVE` */

drop procedure if exists `PLACECAST_TOGGLE_IS_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_TOGGLE_IS_ACTIVE`(
pPlacecastId bigint,
pIsActive tinyint
)
BEGIN
	UPDATE 
		PLACECAST
		SET
		ISACTIVE = pIsActive
	WHERE
		PLACECASTID = pPlacecastId;
	SELECT pIsActive AS STATUS;
END$$

DELIMITER ;

/* Procedure structure for procedure `PLACECAST_UPDATE` */

drop procedure if exists `PLACECAST_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PLACECAST_UPDATE`(
pPlaceCastId bigint,
CountryId bigint,
StateId bigint,
Name varchar(100),
Address varchar(200),
City varchar(100),
ZipCode varchar(100),
Lat1 double,
Long1 double,
Lat2 double,
Long2 double,
Lat3 double,
Long3 double,
Lat4 double,
Long4 double,
Description varchar(250)
)
BEGIN
UPDATE
	PLACECAST 
SET
	CountryId = CountryId,
	StateId = StateId,
	Name = Name,
	Address = Address,
	City = City,
	ZipCode = ZipCode,
	Lat1 = Lat1,
	Long1 = Long1,
	Lat2 = Lat2,
	Long2 = Long2,
	Lat3 = Lat3,
	Long3 = Long3,
	Lat4 = Lat4,
	Long4 = Long4,
	Description = Description
WHERE 
		PLACECASTID = pPlaceCastId;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_ACTIVATE_CODE_UPDATE` */

drop procedure if exists `PRODUCER_ACTIVATE_CODE_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_ACTIVATE_CODE_UPDATE`(
pEmail varchar(250),
pActivationCode varchar(250)
)
BEGIN
DECLARE VPRODUCERID BIGINT;
	SELECT 
		PRODUCERID INTO VPRODUCERID
	FROM 
		PRODUCER 
	WHERE 
		EMAIL=pEmail AND ACTIVATIONCODE=pActivationCode; 
IF VPRODUCERID>0 THEN
	UPDATE 
		PRODUCER
	SET 
		ISVARIFIED=1
	WHERE 
		EMAIL=pEmail AND ACTIVATIONCODE=pActivationCode;
	UPDATE 
		CONSUMER
	SET 
		ISVARIFIED=1
	WHERE 
		EMAIL=pEmail AND ACTIVATIONCODE=pActivationCode;
	SELECT 1 AS STATUS;
ELSE
	SELECT 0 AS STATUS;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_DELETE_BY_ID` */

drop procedure if exists `PRODUCER_DELETE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_DELETE_BY_ID`(
pProducerId bigint
)
BEGIN
	DELETE FROM 
		PRODUCER
	WHERE 
		PRODUCERID = pProducerId;
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_GET_BY_ID` */

drop procedure if exists `PRODUCER_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_GET_BY_ID`(
pProducerId bigint
)
BEGIN
SELECT p.*, c.CountryName, s.StateName, sc.QuestionName, a.AccountTypeName
FROM 
	PRODUCER p, COUNTRY c, STATE s, SECERETQUESTION sc, ACCOUNTTYPE a
WHERE
	p.ProducerId = pProducerId
	AND
	p.CountryId = c.CountryId
	AND
	p.StateId = s.StateId
	AND
	p.QuestionId = sc.QuestionId
	AND
	p.AccountType = a.AccountTypeId;
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_INSERT` */

drop procedure if exists `PRODUCER_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_INSERT`(
CountryId bigint,
StateId bigint,
AccountType bigint,
QuestionId bigint,
Email varchar(100),
Password varchar(100),
FirstName varchar(100),
LastName varchar(100),
Address varchar(200),
City varchar(100),
ZipCode varchar(100),
Telephone1 varchar(100),
DateOfBirth date,
Answer varchar(250),
ActivationCode varchar(250),
IsVarified tinyint,
CreateDate date,
IsActive tinyint
)
BEGIN
INSERT INTO 
	PRODUCER 
	(
		CountryId,
		StateId,
		AccountType,
		QuestionId,
		Email,
		Password,
		FirstName,
		LastName,
		Address,
		City,
		ZipCode,
		Telephone1,
		DateOfBirth,
		Answer,
		ActivationCode,
		IsVarified,
		CreateDate,
		IsActive
	)
VALUES 
	(
		CountryId,
		StateId,
		AccountType,
		QuestionId,
		Email,
		Password,
		FirstName,
		LastName,
		Address,
		City,
		ZipCode,
		Telephone1,
		DateOfBirth,
		Answer,
		ActivationCode,
		IsVarified,
		CreateDate,
		IsActive
	);
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_LIST_ANSWER_BY_EMAIL` */

drop procedure if exists `PRODUCER_LIST_ANSWER_BY_EMAIL`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_LIST_ANSWER_BY_EMAIL`(
PEMAIL VARCHAR(100),
PQUESTIONID BIGINT,
PANSWER VARCHAR(250)
)
BEGIN
	
	SELECT 
		FIRSTNAME,LASTNAME,EMAIL,PASSWORD
	FROM 
		PRODUCER
	WHERE
		EMAIL=PEMAIL AND QUESTIONID=PQUESTIONID AND ANSWER=PANSWER;
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_LIST_BY_EMAIL` */

drop procedure if exists `PRODUCER_LIST_BY_EMAIL`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_LIST_BY_EMAIL`(
pEmail varchar(250)
)
BEGIN
SELECT * 
FROM 
	PRODUCER
WHERE
	Email = pEmail;
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_LIST_BY_STATUS` */

drop procedure if exists `PRODUCER_LIST_BY_STATUS`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_LIST_BY_STATUS`(
pIntStart bigint,
pIntRecordLimit bigint,
pIsActive bigint,
pSortListBy bigint
)
BEGIN
SET @start=pIntStart; SET @numrows=pIntRecordLimit; SET @IsActive=pIsActive; 
IF pSortListBy=1 THEN
	IF pIsActive = 3 THEN
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				PRODUCER
			WHERE
				ISACTIVE <> ?
			ORDER BY
				FIRSTNAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				PRODUCER
			WHERE
				ISACTIVE = ?
			ORDER BY
				FIRSTNAME desc
			LIMIT ?,?';
	END IF;
ELSE
	IF pIsActive = 3 THEN
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				PRODUCER
			WHERE
				ISACTIVE <> ?
			ORDER BY
				FIRSTNAME
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				*
			FROM 
				PRODUCER
			WHERE
				ISACTIVE = ?
			ORDER BY
				FIRSTNAME
			LIMIT ?,?';
	END IF;
END IF;
EXECUTE STMT USING @IsActive, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_LOGIN` */

drop procedure if exists `PRODUCER_LOGIN`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_LOGIN`(
PEMAIL VARCHAR(250),
PPASSWORD VARCHAR(250)
)
BEGIN
	DECLARE VEMAILSTATUS BIGINT;
	DECLARE VPASSWORDSTATUS BIGINT;
	
	SELECT 
		PRODUCERID INTO VEMAILSTATUS 
	FROM 
		PRODUCER
	WHERE
		EMAIL=PEMAIL AND ISVARIFIED=1 AND ISACTIVE=1; 
IF VEMAILSTATUS>0 THEN
	/*SELECT 1 AS STATUS;*/
	SELECT 
		PRODUCERID INTO VPASSWORDSTATUS 
	FROM 
		PRODUCER
	WHERE
		PASSWORD=PPASSWORD AND EMAIL=PEMAIL AND ISVARIFIED=1 AND ISACTIVE=1;
	IF VPASSWORDSTATUS>0 THEN
		SELECT 
			ProducerId,
			Email,
			FirstName,
			LastName
			
		FROM	
			PRODUCER
		WHERE 
			EMAIL=PEMAIL;
	ELSE
		SELECT -1 AS ProducerId, "null" AS Email, "null" AS FirstName, "null" AS LastName;
	END IF;		
ELSE
	SELECT 0 AS ProducerId, "null" AS Email, "null" AS FirstName, "null" AS LastName;
END IF;		
	
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_PASSWORD_UPDATE` */

drop procedure if exists `PRODUCER_PASSWORD_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_PASSWORD_UPDATE`(
PEMAIL VARCHAR(250),
POLDPASSWORD VARCHAR(250),
PNEWPASSWORD VARCHAR(250)
)
BEGIN
	DECLARE VPASSWORDSTATUS BIGINT;
	SELECT 
		PRODUCERID INTO VPASSWORDSTATUS
	FROM 
		PRODUCER
	WHERE
		EMAIL=PEMAIL AND PASSWORD = POLDPASSWORD;
	IF VPASSWORDSTATUS>0 THEN
		UPDATE
			PRODUCER
		SET
			PASSWORD = PNEWPASSWORD
		WHERE
			EMAIL=PEMAIL;
	
		SELECT 1 AS STATUS;
	ELSE
		SELECT 0 AS STATUS;
	END IF;	
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_RECORD_COUNT_BY_STATUS` */

drop procedure if exists `PRODUCER_RECORD_COUNT_BY_STATUS`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_RECORD_COUNT_BY_STATUS`(
pIntIsActive bigint
)
BEGIN
	IF pIntIsActive=3 THEN
		SELECT
			count(1)
		FROM
			PRODUCER;
	ELSE
		SELECT
			count(1)
		FROM
			PRODUCER
		WHERE
			ISACTIVE = pIntIsActive;
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_SECRETQUESTION_LIST_BY_EMAIL` */

drop procedure if exists `PRODUCER_SECRETQUESTION_LIST_BY_EMAIL`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_SECRETQUESTION_LIST_BY_EMAIL`(
PEMAIL VARCHAR(255)
)
BEGIN
	DECLARE VEMAILSTATUS BIGINT;
	SELECT 
		PRODUCERID INTO VEMAILSTATUS
	FROM 
		PRODUCER
	WHERE 
		EMAIL=PEMAIL AND ISVARIFIED=1 AND ISACTIVE=1;
IF VEMAILSTATUS>0 THEN
	
	SELECT 
		SECERETQUESTION.QUESTIONNAME 
	FROM
		PRODUCER,SECERETQUESTION
	WHERE
		PRODUCER.EMAIL=PEMAIL AND PRODUCER.QUESTIONID=SECERETQUESTION.QUESTIONID AND PRODUCER.ISVARIFIED=1 AND PRODUCER.ISACTIVE=1;
ELSE
SELECT 0 AS STATUS;
END IF;		
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_UPDATE` */

drop procedure if exists `PRODUCER_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_UPDATE`(
pEmail varchar(250),
PCountryId bigint,
PStateId bigint,
PAccountType bigint,
PQuestionId bigint,
PFirstName varchar(100),
PLastName varchar(100),
PAddress varchar(200),
PCity varchar(100),
PZipCode varchar(100),
PTelephone1 varchar(100),
PDateOfBirth date,
PAnswer varchar(250)
)
BEGIN
UPDATE
	PRODUCER 
SET
	
		CountryId = PCountryId,
		StateId = PStateId,
		AccountType = PAccountType,
		QuestionId = PQuestionId,
		FirstName = PFirstName,
		LastName = PLastName,
		Address = PAddress,
		City = PCity,
		ZipCode = PZipCode,
		Telephone1 = PTelephone1,
		DateOfBirth = PDateOfBirth,
		Answer = PAnswer
WHERE 
		Email = pEmail;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `PRODUCER_UPDATE_BY_ID` */

drop procedure if exists `PRODUCER_UPDATE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRODUCER_UPDATE_BY_ID`(
pProducerId bigint,
PCountryId bigint,
PStateId bigint,
PAccountType bigint,
PQuestionId bigint,
pEmail varchar(250),
pPassword varchar(100),
PFirstName varchar(100),
PLastName varchar(100),
PAddress varchar(200),
PCity varchar(100),
PZipCode varchar(100),
PTelephone1 varchar(100),
PDateOfBirth date,
PAnswer varchar(250),
pActivationCode varchar(100),
pIsVarify tinyint,
PCreateDate date,
pIsActive tinyint
)
BEGIN
UPDATE
	PRODUCER 
SET
	
		CountryId = PCountryId,
		StateId = PStateId,
		AccountType = PAccountType,
		QuestionId = PQuestionId,
		Email = pEmail,
		Password = pPassword,
		FirstName = PFirstName,
		LastName = PLastName,
		Address = PAddress,
		City = PCity,
		ZipCode = PZipCode,
		Telephone1 = PTelephone1,
		DateOfBirth = PDateOfBirth,
		Answer = PAnswer,
		ActivationCode = pActivationCode,
		IsVarified = pIsVarify,
		CreateDate = PCreateDate,
		IsActive = pIsActive
WHERE 
		ProducerId = pProducerId;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `SECERETQUESTION_LIST_ACTIVE` */

drop procedure if exists `SECERETQUESTION_LIST_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SECERETQUESTION_LIST_ACTIVE`(
pIsActive INT
)
BEGIN
SELECT * FROM 
	`SECERETQUESTION` 
	WHERE IsActive=pIsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `SMS_ALERT_BY_COUNTRY_ACTION` */

drop procedure if exists `SMS_ALERT_BY_COUNTRY_ACTION`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SMS_ALERT_BY_COUNTRY_ACTION`(pIntCountryId bigint,
pIntAction tinyint
)
BEGIN
	IF pIntAction = 1 THEN
		SELECT 
			c.EMAIL,c.FIRSTNAME,c.LASTNAME, ct.CountryName,
			c.mobile, cp.email
		FROM 
			CONSUMER C, SMSALERTS sa, COUNTRY ct,
			cellularprovider cp
		WHERE
			c.CONSUMERID = sa.CONSUMERID 
			AND
			sa.ADDACTION = 1
			AND 
			(sa.COUNTRYID = pIntCountryId OR sa.COUNTRYID = -1)
			AND
			sa.COUNTRYID = ct.COUNTRYID
			AND
			sa.ISACTIVE = 1
			AND
			c.ISACTIVE = 1
			AND
			c.CellularId = cp.CellularId;
	ELSEIF pIntAction = 2 THEN
		SELECT 
			c.EMAIL,c.FIRSTNAME,c.LASTNAME, ct.CountryName,
			c.mobile, cp.email
		FROM 
			CONSUMER C, SMSALERTS sa, COUNTRY ct,
			cellularprovider cp
		WHERE
			c.CONSUMERID = sa.CONSUMERID 
			AND
			sa.MODIFYACTION = 1
			AND 
			(sa.COUNTRYID = pIntCountryId OR sa.COUNTRYID = -1)
			AND
			sa.COUNTRYID = ct.COUNTRYID
			AND
			sa.ISACTIVE = 1
			AND
			c.ISACTIVE = 1
			AND
			c.CellularId = cp.CellularId;
		
	END IF;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `SMS_ALERT_DELETE_BY_ID` */

drop procedure if exists `SMS_ALERT_DELETE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SMS_ALERT_DELETE_BY_ID`(
pSmsAlertId bigint
)
BEGIN
	DELETE FROM 
		SMSALERTS
	WHERE 
		SMSALERTID = pSmsAlertId;
END$$

DELIMITER ;

/* Procedure structure for procedure `SMS_ALERT_GET_BY_ID` */

drop procedure if exists `SMS_ALERT_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SMS_ALERT_GET_BY_ID`(
pSmsAlertId bigint
)
BEGIN
	SELECT * 
		FROM 		
		SMSALERTS
	WHERE 
		SMSALERTID = pSmsAlertId;
END$$

DELIMITER ;

/* Procedure structure for procedure `SMS_ALERT_INSERT` */

drop procedure if exists `SMS_ALERT_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SMS_ALERT_INSERT`(
pIntConsumerId bigint,
pCountryId bigint,
pAdd tinyint,
pModify tinyint,
pCreateDate date,
pIsActive tinyint
)
BEGIN
	DECLARE VCONSUMERID BIGINT;
	DECLARE PCONSUMERID BIGINT;
	SELECT 
		CONSUMERID INTO VCONSUMERID
	FROM 
		SMSALERTS
	WHERE
		COUNTRYID=-1 AND CONSUMERID = pIntConsumerId AND pCountryId=-1;
	SELECT 
		CONSUMERID INTO PCONSUMERID 
	FROM 
		SMSALERTS
	WHERE
		COUNTRYID=pCountryId AND CONSUMERID = pIntConsumerId;
	IF VCONSUMERID>0 THEN
		SELECT -1 AS STATUS;
		
	ELSE	
	
		IF PCONSUMERID>0 THEN
			SELECT 0 AS STATUS;
		ELSE
			INSERT INTO 
				SMSALERTS 
				(
					ConsumerId,
					CountryId,
					AddAction,
					ModifyAction,
					CreateDate,
					IsActive
				)
			VALUES 
				(
					pIntConsumerId,
					pCountryId,
					pAdd,
					pModify,
					pCreateDate,
					pIsActive
				);
			SELECT 1 AS STATUS;
		
		END IF;
	
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `SMS_ALERT_LIST_BY_CONSUMER_ID` */

drop procedure if exists `SMS_ALERT_LIST_BY_CONSUMER_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SMS_ALERT_LIST_BY_CONSUMER_ID`(
pConsumerId bigint,
pIntStart bigint,
pIntRecordLimit bigint,
pSortListBy bigint
)
BEGIN
SET @start=pIntStart; 
SET @numrows=pIntRecordLimit; 
SET @ConsumerId=pConsumerId;
IF pSortListBy=1 THEN
	PREPARE STMT FROM 
		'SELECT 
			c.CountryName, a.*
		FROM 
			COUNTRY c, SMSALERTS a
		WHERE
			(a.CONSUMERID = ?) 
		and 
			((c.CountryId = a.CountryId) 
			or 
			(a.CountryId = -1)) 
		group by a.SmsAlertId
		Order By a.SMSALERTID desc
		LIMIT ?,?';
ELSE
	PREPARE STMT FROM 
		'SELECT 
			c.CountryName, a.*
		FROM 
			COUNTRY c, SMSALERTS a
		WHERE
			(a.CONSUMERID = ?) 
		and 
			((c.CountryId = a.CountryId) 
			or 
			(a.CountryId = -1)) 
		group by a.SmsAlertId
		Order By a.SMSALERTID
		LIMIT ?,?';
END IF;
EXECUTE STMT USING @ConsumerId, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `SMS_ALERT_UPDATE` */

drop procedure if exists `SMS_ALERT_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SMS_ALERT_UPDATE`(
pIntSmsAlertId bigint,
pIntConsumerId bigint,
pCountryId bigint,
pAdd tinyint,
pModify tinyint,
pIsActive tinyint
)
BEGIN
	DECLARE VCONSUMERID BIGINT;
	DECLARE PCONSUMERID BIGINT;
	SELECT 
		CONSUMERID INTO VCONSUMERID
	FROM 
		SMSALERTS
	WHERE
		COUNTRYID=-1 AND CONSUMERID = pIntConsumerId AND pCountryId=-1 
		AND SMSALERTID<>pIntSmsAlertId;
	SELECT 
		CONSUMERID INTO PCONSUMERID 
	FROM 
		SMSALERTS
	WHERE
		COUNTRYID=pCountryId AND CONSUMERID = pIntConsumerId
		AND SMSALERTID<>pIntSmsAlertId;
	IF VCONSUMERID>0 THEN
		SELECT -1 AS STATUS;
		
	ELSE	
	
		IF PCONSUMERID>0 THEN
			SELECT 0 AS STATUS;
		ELSE
			UPDATE 
				SMSALERTS 
			SET
				CountryId = pCountryId,
				AddAction = pAdd,
				ModifyAction = pModify,
				IsActive = pIsActive
			WHERE 
				SMSALERTID = pIntSmsAlertId;
			SELECT 1 AS STATUS;
		
		END IF;
	
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `STATE_GET_BY_COUNTRY_ID` */

drop procedure if exists `STATE_GET_BY_COUNTRY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `STATE_GET_BY_COUNTRY_ID`(
pCountryId INT,
pIsActive INT
)
BEGIN
SELECT * FROM 
	STATE 
	WHERE IsActive=pIsActive 
	and CountryId=pCountryId;
END$$

DELIMITER ;

/* Procedure structure for procedure `STATE_LIST_ACTIVE` */

drop procedure if exists `STATE_LIST_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `STATE_LIST_ACTIVE`(
IsActive INT
)
BEGIN
SELECT * FROM 
	`STATE` 
	WHERE IsActive=IsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `test` */

drop procedure if exists `test`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `test`(
pcountryid bigint,pcountryname varchar(50)
)
BEGIN
insert into country(CountryId,countryname) values(pcountryid,pcountryname);
END$$

DELIMITER ;

/* Procedure structure for procedure `UPDATE_ADDSGROUP_BY_ADD_ID` */

drop procedure if exists `UPDATE_ADDSGROUP_BY_ADD_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UPDATE_ADDSGROUP_BY_ADD_ID`(
pAddsId int,
pGroupId int,
pGroupStatus int
)
BEGIN
	DECLARE AddIdReturn TINYINT;
	SELECT count(1) INTO AddIdReturn 
	FROM ADDS a,ADDSGROUP ag
	WHERE a.addsid=ag.addsid
		AND a.addsid=pAddsId AND ag.groupid=pGroupId;
	
	IF pGroupStatus=1 THEN
		IF AddIdReturn =0 THEN
			INSERT INTO ADDSGROUP (AddsId,GroupId)
			VALUES (pAddsId,pGroupId);
		END IF;
	ELSE
		IF AddIdReturn =1 THEN
			DELETE FROM ADDSGROUP WHERE AddsId=pAddsId AND GroupId=pGroupId;
		END IF;
	END IF;
		
	     	
END$$

DELIMITER ;

/* Procedure structure for procedure `UPDATE_ADD_BY_ID` */

drop procedure if exists `UPDATE_ADD_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UPDATE_ADD_BY_ID`(
pAddsId int,
pAddsName varchar(150), 
pAddsDescription varchar(300),
pImage varchar(300),
pExpiryDate date,
pIsActive tinyint,
pStatus tinyint,
pAdSize varchar(50),
pSniffed text
)
BEGIN
	IF pStatus=1 THEN
		UPDATE
			ADDS
		SET
			AddsName=pAddsName,
			AddsDescription=pAddsDescription,
			Image=pImage,
			ExpiryDate=pExpiryDate,
			IsActive=pIsActive,
			AdSize=pAdSize,
			Sniffed=pSniffed
		WHERE 
			AddsId=pAddsId;
	ELSE
		UPDATE
			ADDS
		SET
			AddsName=pAddsName,
			AddsDescription=pAddsDescription,
			ExpiryDate=pExpiryDate,
			IsActive=pIsActive,
			AdSize=pAdSize,
			Sniffed=pSniffed
		WHERE 
			AddsId=pAddsId;
	END IF;
	SELECT 1 AS STATUS;
END$$

DELIMITER ;

/* Procedure structure for procedure `USER_RECORD_COUNT_REPORT` */

drop procedure if exists `USER_RECORD_COUNT_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USER_RECORD_COUNT_REPORT`(
pFromDate date,
pToDate date
)
BEGIN
	DECLARE FreeActiveP BIGINT;
	DECLARE FreeInActiveP BIGINT;
	DECLARE PremiumActiveP BIGINT;
	DECLARE PremiumInActiveP BIGINT;
	DECLARE FreeActiveC BIGINT;
	DECLARE FreeInActiveC BIGINT;
	DECLARE PremiumActiveC BIGINT;
	DECLARE PremiumInActiveC BIGINT;
	DECLARE SumFreeP BIGINT;
	DECLARE SumPrmiumP BIGINT;
	DECLARE SumFreeC BIGINT;
	DECLARE SumPrmiumC BIGINT;
	
	DECLARE SumP BIGINT;
	DECLARE SumC BIGINT;
	
	IF pFromDate is null OR pToDate is null THEN
		SELECT COUNT(1) INTO FreeActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1;
	
		SELECT COUNT(1) INTO FreeInActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0;
	
		SELECT COUNT(1) INTO PremiumActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1;
	
		SELECT COUNT(1) INTO PremiumInActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0;
	
	
		SELECT COUNT(1) INTO FreeActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1;
	
		SELECT COUNT(1) INTO FreeInActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0;
	
		SELECT COUNT(1) INTO PremiumActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1;
	
		SELECT COUNT(1) INTO PremiumInActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0;
	ELSE
		SELECT COUNT(1) INTO FreeActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	
		SELECT COUNT(1) INTO FreeInActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	
		SELECT COUNT(1) INTO PremiumActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	
		SELECT COUNT(1) INTO PremiumInActiveP FROM PRODUCER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	
	
		SELECT COUNT(1) INTO FreeActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	
		SELECT COUNT(1) INTO FreeInActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	
		SELECT COUNT(1) INTO PremiumActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 1
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	
		SELECT COUNT(1) INTO PremiumInActiveC FROM CONSUMER 
		WHERE ACCOUNTTYPE=1 AND ISACTIVE = 0
		AND CREATEDATE BETWEEN pFromDate AND pToDate;
	END IF;
	SET SumFreeP = FreeActiveP + FreeInActiveP;
	SET SumPrmiumP = PremiumActiveP + PremiumInActiveP;
	
	SET SumFreeC = FreeActiveC + FreeInActiveC;
	SET SumPrmiumC = PremiumActiveC + PremiumInActiveC;
	SET SumP = SumFreeP + SumPrmiumP;
	SET SumC = SumFreeC + SumPrmiumC;
	SELECT FreeActiveP,FreeInActiveP,PremiumActiveP,PremiumInActiveP,FreeActiveC,FreeInActiveC,PremiumActiveC,PremiumInActiveC,SumFreeP,SumPrmiumP,SumFreeC,SumPrmiumC,SumP,SumC;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_DELETE_BY_ID` */

drop procedure if exists `WAYPOINT_DELETE_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_DELETE_BY_ID`(
pWaypointId bigint
)
BEGIN
	DELETE FROM 
		WAYPOINT
	WHERE 
		WaypointId = pWaypointId;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_DOWNLOAD_INSERT` */

drop procedure if exists `WAYPOINT_DOWNLOAD_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_DOWNLOAD_INSERT`(pConsumerId bigint,
pWaypointId bigint,
pCreateDate date,
pIsActive tinyint
)
BEGIN
DECLARE vCountryId BIGINT;
	
	SELECT p.CountryId into vCountryId 
	FROM PLACECAST p, WAYPOINT w
	WHERE w.WAYPOINTID=pWaypointId
		AND
		w.PLACECASTID=p.PLACECASTID;
	INSERT INTO 
		WAYPOINTDOWNLOAD
	SET
		CountryId=vCountryId,
		CONSUMERID=pConsumerId,
		WAYPOINTID=pWaypointId,
		CREATEDATE=pCreateDate,
		ISACTIVE=pIsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_DOWNLOAD_RECORD_COUNT_REPORT` */

drop procedure if exists `WAYPOINT_DOWNLOAD_RECORD_COUNT_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_DOWNLOAD_RECORD_COUNT_REPORT`(
pFromDate date,
pToDate date
)
BEGIN
	IF (pFromDate is null OR pToDate is null) THEN
		SELECT 
		COUNT(wd.WaypointDownloadId),wd.WAYPOINTID, w.NAME
		FROM  WAYPOINTDOWNLOAD wd, WAYPOINT w
		WHERE w.WaypointId=wd.WaypointId GROUP BY wd.WaypointId
			ORDER BY COUNT(wd.WaypointDownloadId) desc;
	ELSE
		SELECT 
		COUNT(wd.WaypointDownloadId),wd.WAYPOINTID, w.NAME
		FROM  WAYPOINTDOWNLOAD wd, WAYPOINT w
		WHERE w.WaypointId=wd.WaypointId 
		AND wd.CREATEDATE BETWEEN pFromDate AND pToDate 
		GROUP BY wd.WaypointId 
		ORDER BY COUNT(wd.WaypointDownloadId) desc;
	END IF;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_GET_BY_ID` */

drop procedure if exists `WAYPOINT_GET_BY_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_GET_BY_ID`(
pWaypointId bigint,
pIsActive bigint
)
BEGIN
IF pIsActive=3 THEN
	SELECT 
		w.*
	FROM 
		WAYPOINT w
	WHERE
		w.WaypointId = pWaypointId 
		AND 
		w.ISACTIVE <> pIsActive;
ELSE
	SELECT 
		w.*
	FROM 
		WAYPOINT w
	WHERE
		w.WaypointId = pWaypointId 
		AND 
		w.ISACTIVE = pIsActive;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_INSERT` */

drop procedure if exists `WAYPOINT_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_INSERT`(
PlaceCastId bigint,
Name varchar(100),
Address varchar(200),
City varchar(100),
Lat1 double,
Long1 double,
Description varchar(250),
CreateDate date,
IsActive tinyint,
Radius double
)
BEGIN
INSERT INTO 
	WAYPOINT 
	(
		PlaceCastId,
		Name,
		Address,
		City,
		Lat1,
		Long1,
		Description,
		CreateDate,
		IsActive,
		Radius
	)
VALUES 
	(
		PlaceCastId,
		Name,
		Address,
		City,
		Lat1,
		Long1,
		Description,
		CreateDate,
		IsActive,
		Radius
	);
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_LIST_ACTIVE` */

drop procedure if exists `WAYPOINT_LIST_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_LIST_ACTIVE`(
pIntStart bigint,
pIntRecordLimit bigint,
pIsActive bigint,
pSortListBy bigint
)
BEGIN
	
SET @start=pIntStart; SET @numrows=pIntRecordLimit; SET @IsActive=pIsActive;
#SET @start=0; SET @numrows=5; SET @IsActive=1;
IF pSortListBy=1 THEN
	PREPARE STMT FROM 
		'SELECT 
			w.*, c.CountryName, s.StateName
		FROM 
			WAYPOINT w, COUNTRY c, STATE s
		WHERE
			w.ISACTIVE = ?
			AND
			w.CountryId = c.CountryId
			AND
			w.StateId = s.StateId
		ORDER BY
			w.NAME desc
		LIMIT ?,?';
ELSE
	PREPARE STMT FROM 
		'SELECT 
			w.*, c.CountryName, s.StateName
		FROM 
			WAYPOINT w, COUNTRY c, STATE s
		WHERE
			w.ISACTIVE = ?
			AND
			w.CountryId = c.CountryId
			AND
			w.StateId = s.StateId
		ORDER BY
			w.NAME
		LIMIT ?,?';
END IF;
EXECUTE STMT USING @IsActive, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_LIST_BY_PLACECAST_ID` */

drop procedure if exists `WAYPOINT_LIST_BY_PLACECAST_ID`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_LIST_BY_PLACECAST_ID`(
pPlaceCastId bigint,
pIntStart bigint,
pIntRecordLimit bigint,
pIsActive bigint,
pSortListBy bigint
)
BEGIN
SET @start=pIntStart; 
SET @numrows=pIntRecordLimit; 
SET @IsActive=pIsActive; 
SET @PlaceCastId=pPlaceCastId;
IF pIsActive=3 THEN
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				w.*
			FROM 
				WAYPOINT w
			WHERE
				w.PLACECASTID = ? 
				AND 
				w.ISACTIVE <> ?
			ORDER BY
				w.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				w.*
			FROM 
				WAYPOINT w
			WHERE
				w.PLACECASTID = ? 
				AND 
				w.ISACTIVE <> ?
			ORDER BY
				w.NAME
			LIMIT ?,?';
	END IF;
ELSE
	IF pSortListBy=1 THEN
		PREPARE STMT FROM 
			'SELECT 
				w.*
			FROM 
				WAYPOINT w
			WHERE
				w.PLACECASTID = ? 
				AND 
				w.ISACTIVE = ?
			ORDER BY
				w.NAME desc
			LIMIT ?,?';
	ELSE
		PREPARE STMT FROM 
			'SELECT 
				w.*
			FROM 
				WAYPOINT w
			WHERE
				w.PLACECASTID = ? 
				AND 
				w.ISACTIVE = ?
			ORDER BY
				w.NAME
			LIMIT ?,?';
	END IF;
END IF;
EXECUTE STMT USING @PlaceCastId, @IsActive, @start, @numrows;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_RECORD_COUNT` */

drop procedure if exists `WAYPOINT_RECORD_COUNT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_RECORD_COUNT`(
pIntIsActive bigint
)
BEGIN
IF pIntIsActive=3 THEN
	SELECT
		count(1)
	FROM
		WAYPOINT
	WHERE
		ISACTIVE <> pIntIsActive;
ELSE
	SELECT
		count(1)
	FROM
		WAYPOINT
	WHERE
		ISACTIVE = pIntIsActive;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_RECORD_COUNT_BY_PLACECAST` */

drop procedure if exists `WAYPOINT_RECORD_COUNT_BY_PLACECAST`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_RECORD_COUNT_BY_PLACECAST`(
pIntPlaceCastId bigint,
pIntIsActive bigint
)
BEGIN
IF pIntIsActive=3 THEN
	SELECT
		count(1)
	FROM
		WAYPOINT
	WHERE
		ISACTIVE <> pIntIsActive
		AND
		PlaceCastId = pIntPlaceCastId;
ELSE
	SELECT
		count(1)
	FROM
		WAYPOINT
	WHERE
		ISACTIVE = pIntIsActive
		AND
		PlaceCastId = pIntPlaceCastId;
END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_RECORD_COUNT_REPORT` */

drop procedure if exists `WAYPOINT_RECORD_COUNT_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_RECORD_COUNT_REPORT`(
pFromDate date,
pToDate date,
pCountryId bigint
)
BEGIN
		
	IF (pFromDate is null OR pToDate is null) AND pCountryId is null THEN
		SELECT 
		COUNT(p.WaypointId),c.COUNTRYNAME, p.ISACTIVE
		FROM  COUNTRY c, WAYPOINT p
		WHERE p.COUNTRYID=c.COUNTRYID GROUP BY p.COUNTRYID,p.ISACTIVE;
/*		SELECT 
		COUNT(p.WaypointId),c.COUNTRYNAME, p.ISACTIVE
		FROM  COUNTRY c LEFT JOIN WAYPOINT p
		ON p.COUNTRYID=c.COUNTRYID GROUP BY p.COUNTRYID,p.ISACTIVE;
		UNION
		SELECT 
		COUNT(p.WaypointId),c.COUNTRYNAME, p.ISACTIVE
		FROM  COUNTRY c LEFT JOIN WAYPOINT p
		ON p.COUNTRYID=c.COUNTRYID AND p.ISACTIVE = 0 GROUP BY p.COUNTRYID,p.ISACTIVE;*/
	ELSEIF (pFromDate is null AND pToDate is null) AND pCountryId is not null THEN
		SELECT 
		COUNT(p.WaypointId),c.COUNTRYNAME, p.ISACTIVE 	
		FROM WAYPOINT p, COUNTRY c
		WHERE p.COUNTRYID=pCountryId 
		AND p.COUNTRYID=c.COUNTRYID GROUP BY p.COUNTRYID,p.ISACTIVE;
	ELSE
		SELECT COUNT(p.WaypointId), c.COUNTRYNAME, p.ISACTIVE
		FROM WAYPOINT p, COUNTRY c 
		WHERE p.COUNTRYID=c.COUNTRYID 
		AND p.CREATEDATE BETWEEN pFromDate AND pToDate 
		GROUP BY p.COUNTRYID,p.ISACTIVE;
	END IF;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_TOGGLE_IS_ACTIVE` */

drop procedure if exists `WAYPOINT_TOGGLE_IS_ACTIVE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_TOGGLE_IS_ACTIVE`(
pWaypointId bigint,
pIsActive tinyint
)
BEGIN
	UPDATE 
		WAYPOINT
		SET
		ISACTIVE = pIsActive
	WHERE
		WAYPOINTID = pWaypointId;
	SELECT pIsActive AS STATUS;
END$$

DELIMITER ;

/* Procedure structure for procedure `WAYPOINT_UPDATE` */

drop procedure if exists `WAYPOINT_UPDATE`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WAYPOINT_UPDATE`(
pWaypointId bigint,
Name varchar(100),
Address varchar(200),
City varchar(100),
Lat1 double,
Long1 double,
Description varchar(250),
Radius double
)
BEGIN
UPDATE
	WAYPOINT 
SET
	Name = Name,
	Address = Address,
	City = City,
	Lat1 = Lat1,
	Long1 = Long1,
	Description = Description,
	Radius = Radius
WHERE 
		WAYPOINTID = pWaypointId;
	
END$$

DELIMITER ;

/* Procedure structure for procedure `WEBSITE_HITS_INSERT` */

drop procedure if exists `WEBSITE_HITS_INSERT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WEBSITE_HITS_INSERT`(
pSessionId varchar(100),
pClientIP varchar(100),
pCreatedDate date,
pIsActive tinyint
)
BEGIN
	INSERT INTO 
		WEBSITEHITS
	SET
		SESSIONID=pSessionId,
		CLIENTIP=pClientIP,
		CREATEDATE=pCreatedDate,
		ISACTIVE=pIsActive;
END$$

DELIMITER ;

/* Procedure structure for procedure `WEBSITE_HITS_RECORD_COUNT_REPORT` */

drop procedure if exists `WEBSITE_HITS_RECORD_COUNT_REPORT`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WEBSITE_HITS_RECORD_COUNT_REPORT`(
pFromDate date,
pToDate date
)
BEGIN
	IF (pFromDate is null OR pToDate is null) THEN
		SELECT
			COUNT(HITSID),CLIENTIP
		FROM
			WEBSITEHITS
			GROUP BY CLIENTIP;
	
	ELSE
		SELECT
			COUNT(HITSID),CLIENTIP
		FROM
			WEBSITEHITS
		WHERE
			CREATEDATE BETWEEN pFromDate AND pToDate
			GROUP BY CLIENTIP;
	END IF;
END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
