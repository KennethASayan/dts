/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.6.17 : Database - das_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`das_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `das_db`;

/*Table structure for table `doc_class` */

DROP TABLE IF EXISTS `doc_class`;

CREATE TABLE `doc_class` (
  `dclass_id` int(255) NOT NULL AUTO_INCREMENT,
  `dclass_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`dclass_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

/*Data for the table `doc_class` */

insert  into `doc_class`(`dclass_id`,`dclass_name`) values (1,'Central Office Special Order'),(2,'Provincial Special Order'),(3,'Regional Special Order'),(4,'Administrative Order'),(5,'Memorandum Circular'),(6,'Executive Order'),(7,'Joint Administrative Order'),(8,'Annual Report'),(9,'Semi-Annual Report'),(10,'Quarterly Report'),(11,'Monthly Report'),(12,'Memorandum of Agreement'),(13,'Work and Financial Plan\r\n'),(14,'Annual Procurement Plan\r\n'),(15,'Purchase Documents\r\n'),(16,'Project Procurement Management Plan '),(17,'Project Procurement Plan '),(18,'Supplemental Annual Procurement Management Plan'),(19,'Supplemental Project Procurement Management Plan '),(20,'Supplemental Project Procurement Plan '),(21,'Supplemental Annual Procurement Plan'),(22,'General Appropriations Act'),(23,'Financial Accounting and Reporting'),(24,'Financial Performance Report '),(25,'Financial Statement'),(26,'Monthly Disbursement Program'),(27,'Minimum Required Distribution\r\n'),(28,'Notice of Cash Allocation'),(29,'Notice of Transfer Allocation'),(30,'Sub-Allotment Allocation'),(31,'Special Allotment Release Order'),(32,'Statement of Allotment Obligation & Balances'),(33,'Trial Balance\r\n'),(34,'Breakdown of Income'),(35,'Monthly Disbursement Report'),(36,'Authority to Debit Account'),(37,'Advice of Checks Issued and Cancelled'),(38,'Central Office'),(39,'Regional Office'),(40,'Provincial Environment and Natural Office'),(41,'Community Environment and Natural Office\r\n'),(42,'Letter of Protest\r\n'),(43,'Case Filed\r\n'),(44,'201 Files\r\n'),(45,'Court Order\r\n'),(46,'Complaints\r\n'),(47,'Letters\r\n'),(48,'Notices\r\n');

/*Table structure for table `doc_type` */

DROP TABLE IF EXISTS `doc_type`;

CREATE TABLE `doc_type` (
  `doc_id` int(255) NOT NULL AUTO_INCREMENT,
  `doc_name` varchar(100) DEFAULT NULL,
  `ug_alias` varchar(20) DEFAULT NULL,
  `no_views` int(10) DEFAULT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `doc_type` */

insert  into `doc_type`(`doc_id`,`doc_name`,`ug_alias`,`no_views`) values (1,'Procurement Documents','aei',0),(2,'Special Order','abgh',21),(3,'Policies','abgh',25),(4,'Memorandum','abgh',5),(5,'External Communications','abgh',1),(6,'Financial Documents','acde',0),(7,'Reports','abgh',2),(8,'Other Documents','abf',1),(9,'Confidential Files','ab',10);

/*Table structure for table `input_control` */

DROP TABLE IF EXISTS `input_control`;

CREATE TABLE `input_control` (
  `ic_id` int(255) NOT NULL AUTO_INCREMENT,
  `doc_id` int(255) DEFAULT NULL,
  `dclass_id` int(255) DEFAULT NULL,
  `input_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`ic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

/*Data for the table `input_control` */

insert  into `input_control`(`ic_id`,`doc_id`,`dclass_id`,`input_id`) values (1,2,1,1),(2,2,1,2),(3,2,1,3),(4,2,2,1),(5,2,2,2),(6,2,2,3),(7,2,3,1),(8,2,3,2),(9,2,3,3),(10,3,4,1),(11,3,4,2),(12,3,4,3),(13,3,5,1),(14,3,5,2),(15,3,5,3),(16,3,6,1),(17,3,6,2),(18,3,6,3),(19,3,7,1),(20,3,7,2),(21,3,7,3),(22,7,8,2),(23,7,8,4),(24,7,9,2),(25,7,9,4),(26,7,10,2),(27,7,10,4),(28,7,11,2),(29,7,11,4),(30,8,12,2),(31,8,12,4),(32,8,13,2),(33,8,13,4),(34,1,14,4),(35,1,15,4),(36,1,15,5),(37,1,15,6),(38,1,15,7),(39,1,16,4),(40,1,17,4),(41,1,18,4),(42,1,19,4),(43,1,20,4),(44,1,21,4),(45,6,22,4),(46,6,23,4),(47,6,23,8),(48,6,23,9),(49,6,25,4),(50,6,25,8),(51,6,26,10),(52,6,26,4),(53,6,27,10),(54,6,27,4),(55,6,28,1),(56,6,28,2),(57,6,28,22),(58,6,29,1),(59,6,29,22),(60,6,30,1),(61,6,30,2),(62,6,30,22),(63,6,31,1),(64,6,31,2),(65,6,31,11),(66,6,31,22),(67,6,32,1),(68,6,32,2),(69,6,32,22),(70,6,33,4),(71,6,33,8),(72,6,34,4),(73,6,34,9),(74,6,35,4),(75,6,35,9),(76,6,36,1),(77,6,36,22),(78,6,37,1),(79,6,37,22),(80,4,38,2),(81,4,38,3),(82,4,38,12),(83,4,38,13),(84,4,39,2),(85,4,39,3),(86,4,39,12),(87,4,39,13),(88,4,40,2),(89,4,40,3),(90,4,40,12),(91,4,40,13),(92,4,41,2),(93,4,41,3),(94,4,41,12),(95,4,41,13),(96,5,47,3),(97,5,47,17),(98,5,47,21),(99,5,48,3),(100,5,48,17),(101,9,42,3),(102,9,42,12),(103,9,42,13),(104,9,43,1),(105,9,43,15),(106,9,43,16),(107,9,44,1),(108,9,44,17),(109,9,44,18),(110,9,45,3),(111,9,45,19),(112,9,46,3),(113,9,46,20),(114,4,38,23),(115,4,39,23),(116,4,40,23),(117,4,41,23),(118,1,15,23);

/*Table structure for table `inputs` */

DROP TABLE IF EXISTS `inputs`;

CREATE TABLE `inputs` (
  `input_id` int(255) NOT NULL AUTO_INCREMENT,
  `input_name` varchar(100) DEFAULT NULL,
  `input_alias` varchar(100) DEFAULT NULL,
  `priority` int(50) DEFAULT NULL,
  PRIMARY KEY (`input_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `inputs` */

insert  into `inputs`(`input_id`,`input_name`,`input_alias`,`priority`) values (1,'No.','doc_num',2),(2,'Subject','subject',4),(3,'Date','datex',1),(4,'Year','year',7),(5,'Project Title\r\n','proj_title',4),(6,'Project Cost\r\n','proj_cost',10),(7,'Name of Supplier\r\n','supplier',11),(8,'Quarter','quarter',8),(9,'Month','month',9),(10,'Barcode','barcode',2),(11,'Date Approved\r\n','date_appr',11),(12,'Destination','destination',10),(13,'Origin','origin',11),(14,'Case Number','case_num',2),(15,'Plaintiff\r\n','plaintiff',11),(16,'Respondents\r\n','respondent',11),(17,'Name','namex',5),(18,'Position','position',6),(19,'Type of Case\r\n','type_case',11),(20,'Complainant\r\n','complainant',11),(21,'Name of Office\r\n','name_off',11),(22,'Amount','amnt',10),(23,'Status','mem_stat',3);

/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `log_id` int(255) NOT NULL AUTO_INCREMENT,
  `emp_name` varchar(50) DEFAULT NULL,
  `ug_name` varchar(50) DEFAULT NULL,
  `activity` varchar(100) DEFAULT NULL,
  `date_time` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;

/*Data for the table `logs` */

insert  into `logs`(`log_id`,`emp_name`,`ug_name`,`activity`,`date_time`) values (1,'A D Min','Administrator','Logged In','Jul-02-2018; 03:46:23am'),(2,'A D Min','Administrator','Added document record no.: PBUK-2018-07-0001','Jul-02-2018; 03:49:02am'),(3,'A D Min','Administrator','Generated Report: Record Statistics','Jul-02-2018; 03:49:31am'),(4,'A D Min','Administrator','Logged Out','Jul-02-2018; 04:01:07am'),(5,'A D Min','Administrator','Logged In','Jul-04-2018; 01:57:57am'),(6,'A D Min','Administrator','Logged Out','Jul-04-2018; 01:58:13am'),(7,'Nida Teresa Babanto Juarez','Accountant','Logged In','Jul-04-2018; 01:58:49am'),(8,'Nida Teresa Babanto Juarez','Accountant','Logged Out','Jul-04-2018; 01:58:51am'),(9,'A D Min','Administrator','Logged In','Jul-04-2018; 01:59:07am'),(10,'A D Min','Administrator','Logged Out','Jul-04-2018; 01:59:21am'),(11,'Marites Caneos Salo','Records Officer','Logged In','Jul-04-2018; 01:59:32am'),(12,'Marites Caneos Salo','Records Officer','Added document record no.: PBUK-2018-07-0002','Jul-04-2018; 02:24:12am'),(13,'Marites Caneos Salo','Records Officer','Updated Password','Jul-04-2018; 02:27:34am'),(14,'Marites Caneos Salo','Records Officer','Logged In','Jul-04-2018; 02:28:05am'),(15,'Marites Caneos Salo','Records Officer','Added document record no.: PBUK-2018-07-0003','Jul-04-2018; 02:34:11am'),(16,'A D Min','Administrator','Logged In','Jul-04-2018; 05:31:06am'),(17,'A D Min','Administrator','Deleted document record no.: PBUK-2018-07-0001','Jul-04-2018; 05:32:59am'),(18,'Marites Caneos Salo','Records Officer','Logged In','Jul-04-2018; 05:53:14am'),(19,'A D Min','Administrator','Logged In','Jul-04-2018; 08:21:35am'),(20,'0','0','Logged Out','Jul-04-2018; 09:01:13am'),(21,'A D Min','Administrator','Logged In','Jul-10-2018; 08:15:55am'),(22,'A D Min','Administrator','Logged Out','Jul-10-2018; 08:32:29am'),(23,'A D Min','Administrator','Logged In','Jul-16-2018; 03:56:40am'),(24,'A D Min','Administrator','Logged Out','Jul-16-2018; 03:57:07am'),(25,'Rosalie Albastro Minquez','Receiving Clerk','Logged In','Jul-16-2018; 03:57:15am'),(26,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0004','Jul-16-2018; 04:00:34am'),(27,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0005','Jul-16-2018; 04:02:55am'),(28,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0006','Jul-16-2018; 04:04:29am'),(29,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0007','Jul-16-2018; 04:05:57am'),(30,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0008','Jul-16-2018; 04:07:36am'),(31,'Rosalie Albastro Minquez','Receiving Clerk','Logged In','Jul-16-2018; 04:09:44am'),(32,'A D Min','Administrator','Logged In','Jul-16-2018; 04:11:19am'),(33,'A D Min','Administrator','Logged In','Jul-16-2018; 04:13:49am'),(34,'A D Min','Administrator','Logged In','Jul-16-2018; 04:16:50am'),(35,'A D Min','Administrator','Logged In','Jul-16-2018; 04:22:29am'),(36,'A D Min','Administrator','Logged Out','Jul-16-2018; 05:21:21am'),(37,'Rosalie Albastro Minquez','Receiving Clerk','Logged In','Jul-16-2018; 05:22:28am'),(38,'Rosalie Albastro Minquez','Receiving Clerk','Logged In','Jul-16-2018; 05:22:28am'),(39,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0009','Jul-16-2018; 05:23:45am'),(40,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0010','Jul-16-2018; 05:25:49am'),(41,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0011','Jul-16-2018; 05:28:04am'),(42,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0012','Jul-16-2018; 05:32:22am'),(43,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0013','Jul-16-2018; 05:33:26am'),(44,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0014','Jul-16-2018; 05:35:25am'),(45,'A D Min','Administrator','Logged In','Jul-16-2018; 05:49:44am'),(46,'Rosalie Albastro Minquez','Receiving Clerk','Logged Out','Jul-16-2018; 05:55:24am'),(47,'A D Min','Administrator','Logged In','Jul-16-2018; 05:55:43am'),(48,'A D Min','Administrator','Logged Out','Jul-16-2018; 05:56:01am'),(49,'Christian Carson Jebulan','Planning Officer','Logged In','Jul-16-2018; 05:56:10am'),(50,'Christian Carson Jebulan','Planning Officer','Logged Out','Jul-16-2018; 05:56:27am'),(51,'Rosalie Albastro Minquez','Receiving Clerk','Logged In','Jul-16-2018; 05:56:57am'),(52,'Rosalie Albastro Minquez','Receiving Clerk','Added document record no.: PBUK-2018-07-0015','Jul-16-2018; 05:58:24am'),(53,'A D Min','Administrator','Logged Out','Jul-16-2018; 06:06:35am'),(54,'Rosalie Albastro Minquez','Receiving Clerk','Logged Out','Jul-16-2018; 06:06:46am'),(55,'Rosalie Albastro Minquez','Receiving Clerk','Logged In','Jul-16-2018; 06:07:11am'),(56,'Rosalie Albastro Minquez','Receiving Clerk','Logged In','Jul-16-2018; 06:38:27am'),(57,'A D Min','Administrator','Logged In','Jul-16-2018; 06:39:07am'),(58,'A D Min','Administrator','Logged Out','Jul-16-2018; 06:43:12am'),(59,'A D Min','Administrator','Logged In','Jul-16-2018; 07:03:33am'),(60,'A D Min','Administrator','Logged In','Jul-16-2018; 07:28:44am'),(61,'A D Min','Administrator','Logged In','Jul-30-2018; 08:19:42am'),(62,'A D Min','Administrator','Logged Out','Jul-30-2018; 08:20:17am'),(63,'A D Min','Administrator','Logged In','Aug-08-2018; 09:35:03am'),(64,'A D Min','Administrator','Logged Out','Aug-08-2018; 09:35:22am'),(65,'A D Min','Administrator','Logged In','Aug-15-2018; 05:22:54am'),(66,'A D Min','Administrator','Logged In','Aug-15-2018; 06:19:22am'),(67,'A D Min','Administrator','Generated Report: Record Statistics','Aug-15-2018; 06:19:58am'),(68,'A D Min','Administrator','Logged In','Oct-09-2018; 06:17:31am'),(69,'A D Min','Administrator','Logged In','Jan-26-2019; 09:03:05am'),(70,'A D Min','Administrator','Logged Out','Jan-26-2019; 09:05:05am'),(71,'A D Min','Administrator','Logged In','Feb-15-2019; 11:48:29am'),(72,'A D Min','Administrator','Logged In','Feb-15-2019; 12:17:22pm'),(73,'Lendie Bastasa Caracol','Administrator','Logged In','Mar-07-2019; 04:01:35am'),(74,'Lendie Bastasa Caracol','Administrator','Logged In','Mar-07-2019; 04:34:18am'),(75,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0016','Mar-07-2019; 04:34:58am'),(76,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0017','Mar-07-2019; 04:37:19am'),(77,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0018','Mar-07-2019; 04:43:36am'),(78,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0019','Mar-07-2019; 04:45:27am'),(79,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0020','Mar-07-2019; 04:46:49am'),(80,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0021','Mar-07-2019; 04:47:28am'),(81,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0022','Mar-07-2019; 04:49:39am'),(82,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0023','Mar-07-2019; 04:50:23am'),(83,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0024','Mar-07-2019; 04:51:14am'),(84,'Lendie Bastasa Caracol','Administrator','Logged In','Mar-07-2019; 04:51:46am'),(85,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0025','Mar-07-2019; 04:52:46am'),(86,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0026','Mar-07-2019; 04:54:32am'),(87,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0027','Mar-07-2019; 04:55:22am'),(88,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0028','Mar-07-2019; 04:56:10am'),(89,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0029','Mar-07-2019; 04:57:59am'),(90,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0030','Mar-07-2019; 04:58:54am'),(91,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0031','Mar-07-2019; 04:59:35am'),(92,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0032','Mar-07-2019; 05:03:43am'),(93,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0033','Mar-07-2019; 05:04:51am'),(94,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0034','Mar-07-2019; 05:06:38am'),(95,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0035','Mar-07-2019; 05:07:57am'),(96,'Lendie Bastasa Caracol','Administrator','Added document record no.: PBUK-2019-03-0036','Mar-07-2019; 05:09:09am'),(97,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:10:26am'),(98,'Lendie Bastasa Caracol','Administrator','Logged In','Mar-07-2019; 05:20:14am'),(99,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:20:26am'),(100,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:22:47am'),(101,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:23:22am'),(102,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:23:37am'),(103,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:24:05am'),(104,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:24:28am'),(105,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:25:14am'),(106,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:25:31am'),(107,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:26:24am'),(108,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:26:46am'),(109,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:27:00am'),(110,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:27:53am'),(111,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:28:13am'),(112,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:28:23am'),(113,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:28:31am'),(114,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:28:40am'),(115,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:28:50am'),(116,'Lendie Bastasa Caracol','Administrator','Generated Report: Record Statistics','Mar-07-2019; 05:29:03am');

/*Table structure for table `office` */

DROP TABLE IF EXISTS `office`;

CREATE TABLE `office` (
  `off_id` int(20) NOT NULL AUTO_INCREMENT,
  `off_name` varchar(50) DEFAULT NULL,
  `off_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`off_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `office` */

insert  into `office`(`off_id`,`off_name`,`off_code`) values (1,'Regional Office','REG'),(2,'PENRO Camiguin','PCAM'),(3,'PENRO Bukidnon','PBUK'),(4,'PENRO Lanao del Norte','PLDN'),(5,'PENRO Misamis Occidental','PMOC'),(6,'PENRO Misamis Oriental','PMOR');

/*Table structure for table `records` */

DROP TABLE IF EXISTS `records`;

CREATE TABLE `records` (
  `rec_id` int(255) NOT NULL AUTO_INCREMENT,
  `rec_num` varchar(50) DEFAULT NULL,
  `doc_id` int(255) DEFAULT NULL,
  `dclass_id` int(255) DEFAULT NULL,
  `u_id` int(255) DEFAULT NULL,
  `dt_upload` varchar(50) DEFAULT NULL,
  `doc_num` varchar(50) DEFAULT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `datex` varchar(50) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL,
  `proj_title` varchar(300) DEFAULT NULL,
  `proj_cost` varchar(20) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `quarter` varchar(10) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `date_appr` varchar(20) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `origin` varchar(50) DEFAULT NULL,
  `case_num` varchar(20) DEFAULT NULL,
  `plaintiff` varchar(50) DEFAULT NULL,
  `respondent` varchar(50) DEFAULT NULL,
  `namex` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `type_case` varchar(20) DEFAULT NULL,
  `complainant` varchar(50) DEFAULT NULL,
  `name_off` varchar(50) DEFAULT NULL,
  `amnt` varchar(20) DEFAULT NULL,
  `mem_stat` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Data for the table `records` */

insert  into `records`(`rec_id`,`rec_num`,`doc_id`,`dclass_id`,`u_id`,`dt_upload`,`doc_num`,`subject`,`datex`,`year`,`proj_title`,`proj_cost`,`supplier`,`quarter`,`month`,`barcode`,`date_appr`,`destination`,`origin`,`case_num`,`plaintiff`,`respondent`,`namex`,`position`,`type_case`,`complainant`,`name_off`,`amnt`,`mem_stat`) values (2,'PBUK-2019-01-0002',2,2,10,'Jan-14-2018; 02:24:12am','PENRO Special Order No. 1, Series of 2018','REACTIVATION OF PUBLIC ASSISTANCE COMPLAINTS DESK AND SCHEDULE OF EMPLOYEES AS OFFICER OF THE DAY.','Jan-03-2018',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'PBUK-2019-01-0003',2,2,10,'Jan-14-2018; 02:34:11am','PENRO Special Order No. 002, Series of 2018','REASSIGNMENT AND DESIGNATION OF SOME PERSONNEL OF PENRO BUKIDNON.','Jan-03-2018',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'PBUK-2019-01-0004',3,4,11,'Jan-14-2018; 08:00:34am','DAO 92-30','GUIDELINES FOR THE TRANSFER AND IMPLEMENTATION OF DENR FUNCTIONS DEVOLVED TO THE LOCAL GOVERNMENT UNITS','Jun-30-1992',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'PBUK-2019-01-0005',3,4,11,'Jan-14-2018; 08:02:55am','DAO 91-54','INCREASING THE REFORESTATION DEPOSIT PAID BY LOGGING CONCESSIONAIRES TO INCLUDE MAINTENANCE COSTS AND FURTHER AMENDING DENR ADMINISTRATIVE ORDER 31, SERIES OF 1988','Jan-23-1991',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'PBUK-2019-01-0006',3,4,11,'Jan-14-2018; 08:04:29am','DAO 2004-59','CHEMICAL CONTROL ORDER FOR POLYCHLORINATED BIPHENYLS','Feb-16-2004',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'PBUK-2019-01-0007',3,4,11,'Jan-14-2018; 08:05:57am','DAO 2010-11','REVISED REGULATIONS GOVERNING FOREST TREE SEED AND SEEDLING PRODUCTION, COLLECTION AND DISPOSITION','May-05-2010',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'PBUK-2019-01-0008',3,5,11,'Jan-14-2018; 08:07:36am','DMC 2007-09','CLARIFICATION ON THE IMPLEMENTATION OF DAO 2007-23 \"LIFTING IF THE MORATORIUM ON THE NEW WOOD PROCESSING PLANTS','Jul-19-2007',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'PBUK-2019-01-0009',3,5,11,'Jan-14-2018; 08:23:45am','DMC 2008-05','GUIDELINES IN THE PREPARATION OF INTEGRATED WATERSHED MANAGEMENT PLANS','Oct-22-2008',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'PBUK-2019-01-0010',3,6,11,'Jan-14-2018; 08:25:49am','EO 23','DECLARING A MORATORIUM ON THE CUTTING AND HARVESTING OF TIMBER IN THE NATURAL AND RESIDUAL FORESTS AND CREATING ANTI-ILLEGAL LOGGING TAKS FORCE','Mar-14-2008',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'PBUK-2019-01-0011',3,6,11,'Jan-14-2018; 08:28:04am','EO 192','PROVIDING FOR THE REORGANIZATION OF DEPARTMENT OF ENVIRONMENT, ENERGY AND NATURAL RESOURCES, RENAMING IT AS THE DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES','Jan-30-1987',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'PBUK-2019-01-0012',3,4,11,'Jan-14-2018; 08:32:21am','DAO 2003-2','IMPLEMENTING RULES AND REGULATIONS OF THE CHAINSAW ACT OF 002 (RA NO. 9175) ENTITLED \"AN ACT REGULATING THE OWNERSHIP, POSSESSION, SALE, IMPORTATION AND USE OF CHAINSAWS, PENALIZING VIOLATIONS THEREOF AND FOR OTHER PURPOSES','Jun-30-2003',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'PBUK-2019-01-0013',3,4,11,'Jan-14-2018; 08:33:26am','DAO 2004-16','PRESCRIBING THE REVISED SCHEDULE OF FORESTRY ADMINISTRATIVE FEES','Jun-15-2004',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'PBUK-2019-01-0014',3,4,11,'Jan-14-2018; 09:35:25am','DAO 2004-52','THE REVISED GUIDELINES IN THE ISSUANCE OF CUTTING/HARVESTING PERMITS IN PRIVATE TITLED LANDS','Aug-31-2004',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'PBUK-2019-01-0015',7,8,11,'Jan-14-2018; 09:58:24am',NULL,'PENRO BUKIDON ANNUAL REPORT',NULL,'2016',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'PBUK-2019-02-0016',9,44,8,'Feb-17-2019; 04:34:58am','OSEC-DENRB-FORA-1369-1998',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ALIMA, DARRYL PAIRAT','FOREST RANGER',NULL,NULL,NULL,NULL,NULL),(17,'PBUK-2019-02-0017',9,44,8,'Feb-17-2019; 04:37:19am','OSEC-DENRB-ADA6-174-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ARAT, ARHLEEN ARNADO','ADMINISTRATIVE AIDE VI',NULL,NULL,NULL,NULL,NULL),(18,'PBUK-2019-02-0018',9,44,8,'Feb-17-2019; 04:43:36am','OSEC-DENRB-ADA6-178-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'BACASAN, FLOREDEL SALVAÑA','ADMINISTRATIVE AIDE VI',NULL,NULL,NULL,NULL,NULL),(19,'PBUK-2019-02-0019',9,44,8,'Feb-17-2019; 04:45:27am','OSEC-DENRB-FORT2-232-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'BAGUIO,  FELIX  VANZUELA JR','FOREST TECHNICIAN II',NULL,NULL,NULL,NULL,NULL),(20,'PBUK-2019-02-0020',9,44,8,'Feb-17-2019; 04:46:49am','OSEC-DENRB-ADA6-208-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'BALMOCENA, APRIL ALICE ANGELIE CAÑETE','ADMINISTRATIVE AIDE VI',NULL,NULL,NULL,NULL,NULL),(21,'PBUK-2019-02-0021',9,44,8,'Feb-17-2019; 04:47:28am','OSEC-DENRB-FORA-1415-1998',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'BINAYAO, JOCELYN HERNANDEZ','FOREST RANGER',NULL,NULL,NULL,NULL,NULL),(22,'PBUK-2019-02-0022',9,44,8,'Feb-17-2019; 04:49:39am','OSEC-DENRB-FORT1-258-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CALLANTA,  ALDE  ELEANOR TINOY','FOREST TECHNICIAN I',NULL,NULL,NULL,NULL,NULL),(23,'PBUK-2019-02-0023',9,44,8,'Feb-17-2019; 04:50:23am','OSEC-DENRB-ENG2-134-1998',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CRUZ, QUENNE  BALIOLA','ENGINEER II',NULL,NULL,NULL,NULL,NULL),(24,'PBUK-2019-02-0024',9,44,8,'Feb-17-2019; 04:51:14am','OSEC-DENRB-FORA-1372-1998',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'DALIMO-OS, MARIA MARLITA GULLE','FOREST RANGER',NULL,NULL,NULL,NULL,NULL),(25,'PBUK-2019-02-0025',9,44,8,'Feb-17-2019; 04:52:46am','OSEC-DENRB-INFOSA2-31-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'DOMINGO, EARL MARC JAPUZ','INFORMATION SYSTEMS ANALYST II',NULL,NULL,NULL,NULL,NULL),(26,'PBUK-2019-02-0026',9,44,8,'Feb-17-2019; 04:54:32am','OSEC-DENRB-FORT1-252-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'AGRAMON, JICK MONDEJAR','FOREST TECHNICIAN I',NULL,NULL,NULL,NULL,NULL),(27,'PBUK-2019-02-0027',9,44,8,'Feb-17-2019; 04:55:22am','OSEC-DENRB-FORT2-231-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'AGUANTA, ROY RULE','FOREST TECHNICIAN II',NULL,NULL,NULL,NULL,NULL),(28,'PBUK-2019-02-0028',9,44,8,'Feb-17-2019; 04:56:10am','OSEC-DENRB-ADA6-209-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'IBAÑES, ALETH LOU QUINDALA','ADMINISTRATIVE AIDE VI',NULL,NULL,NULL,NULL,NULL),(29,'PBUK-2019-02-0029',9,44,8,'Feb-17-2019; 04:57:59am','OSEC-DENRB-ADA6-176-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'JABONERO, HAYDEE CAPACIO','ADMINISTRATIVE AIDE VI',NULL,NULL,NULL,NULL,NULL),(30,'PBUK-2019-02-0030',9,44,8,'Feb-17-2019; 04:58:53am','OSEC-DENRB-ADA6-177-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'JEBULAN, CHRISTIAN CARSON','ADMINISTRATIVE AIDE VI',NULL,NULL,NULL,NULL,NULL),(31,'PBUK-2019-02-0031',9,44,8,'Feb-17-2019; 04:59:35am','OSEC-DENRB-ADA4-1004-2004',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ORTIZ, CHRISTIAN MEDEZ','ADMINISTRATIVE AIDE IV',NULL,NULL,NULL,NULL,NULL),(32,'PBUK-2019-02-0032',9,44,8,'Feb-17-2019; 05:03:43am','OSEC-DENRB-FORST1-796-1998',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'PAREJO, LUZVIMINDA SALPID','FORESTER I',NULL,NULL,NULL,NULL,NULL),(33,'PBUK-2019-02-0033',9,44,8,'Feb-17-2019; 05:04:51am','OSEC-DENRB-FORT1-256-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SABILLO, LEOPOLDO PACULBA','FOREST TECHNICIAN I',NULL,NULL,NULL,NULL,NULL),(34,'PBUK-2019-02-0034',9,44,8,'Feb-17-2019; 05:06:38am','OSEC-DENRB-LAMI-44-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SALAUM, ANTONIO ANOSA','LAND MANAGEMENT INSPECTOR',NULL,NULL,NULL,NULL,NULL),(35,'PBUK-2019-02-0035',9,44,8,'Feb-17-2019; 05:07:57am','OSEC-DENRB-ADA6-181-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SANTIAGO, MYSCHELLE SUJETADO','ADMINISTRATIVE AIDE VI',NULL,NULL,NULL,NULL,NULL),(36,'PBUK-2019-02-0036',9,44,8,'Feb-17-2019; 05:09:09am','OSEC-DENRB-FORT1-257-2014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'TINGSON, ARNULFO CHAN JR','FOREST TECHNICIAN I',NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `uplink` */

DROP TABLE IF EXISTS `uplink`;

CREATE TABLE `uplink` (
  `file_id` int(50) NOT NULL AUTO_INCREMENT,
  `rec_num` varchar(100) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

/*Data for the table `uplink` */

insert  into `uplink`(`file_id`,`rec_num`,`file_name`) values (2,'PBUK-2019-01-0002','PENRO_Special_Order_No._1_.pdf'),(3,'PBUK-2019-01-0003','PENRO_Special_Order_No._2_.pdf'),(4,'PBUK-2019-01-0004','DAO_92-30-Guidelines-Implementation-DENR_Devolved-LGU.pdf'),(5,'PBUK-2019-01-0005','DAO_91-54.pdf'),(6,'PBUK-2019-01-0006','DAO_2004-59.pdf'),(7,'PBUK-2019-01-0007','dao_2010_11.pdf'),(8,'PBUK-2019-01-0008','dmc-2007-09_135.pdf'),(9,'PBUK-2019-01-0009','dmc-2008-05_627.pdf'),(10,'PBUK-2019-01-0010','Executive_Order_No._23_.pdf'),(11,'PBUK-2019-01-0011','EO-192-Reorganization.pdf'),(12,'PBUK-2019-01-0012','dao2003-24.pdf'),(13,'PBUK-2019-01-0013','dao2004-16.pdf'),(14,'PBUK-2019-01-0014','dao2004-52.pdf'),(15,'PBUK-2019-01-0015','Annual.pdf'),(16,'PBUK-2019-02-0016','AFFIDAVIT.pdf'),(17,'PBUK-2019-02-0016','ASSUMPTION_OF_DUTY.pdf'),(18,'PBUK-2019-02-0016','ASSUMPTION_OF_DUTY2.pdf'),(19,'PBUK-2019-02-0016','CERT_CSC.pdf'),(20,'PBUK-2019-02-0016','CERT_NET_PAY.pdf'),(21,'PBUK-2019-02-0017','APPOINTMENT.pdf'),(22,'PBUK-2019-02-0017','LEAVES.pdf'),(23,'PBUK-2019-02-0017','MEDICAL_CERTIFICATE.pdf'),(24,'PBUK-2019-02-0017','OFFICE_CLEARANCE.pdf'),(25,'PBUK-2019-02-0017','PDF.pdf'),(26,'PBUK-2019-02-0017','PDS.pdf'),(27,'PBUK-2019-02-0017','SALN.pdf'),(28,'PBUK-2019-02-0017','SO_MEMO.pdf'),(29,'PBUK-2019-02-0018','APPOINTMENT1.pdf'),(30,'PBUK-2019-02-0018','PDS1.pdf'),(31,'PBUK-2019-02-0018','SALN1.pdf'),(32,'PBUK-2019-02-0018','SO.pdf'),(33,'PBUK-2019-02-0019','APPOINTMENT2.pdf'),(34,'PBUK-2019-02-0019','ASSUMPTION_OF_DUTY1.pdf'),(35,'PBUK-2019-02-0019','OTHER_DOC.pdf'),(36,'PBUK-2019-02-0019','SALN2.pdf'),(37,'PBUK-2019-02-0020','APPOINTMENT3.pdf'),(38,'PBUK-2019-02-0020','OTHER_DOC1.pdf'),(39,'PBUK-2019-02-0020','PDS2.pdf'),(40,'PBUK-2019-02-0020','SALN3.pdf'),(41,'PBUK-2019-02-0021','APPOINTMENT4.pdf'),(42,'PBUK-2019-02-0021','SALN4.pdf'),(43,'PBUK-2019-02-0022','APPOINTMENT5.pdf'),(44,'PBUK-2019-02-0022','CERTIFICATES.pdf'),(45,'PBUK-2019-02-0022','MEDICAL_CERTIFICATE1.pdf'),(46,'PBUK-2019-02-0022','OFFICE_CLEARANCE1.pdf'),(47,'PBUK-2019-02-0022','OTHER_DOC2.pdf'),(48,'PBUK-2019-02-0022','PDS3.pdf'),(49,'PBUK-2019-02-0022','SALN5.pdf'),(50,'PBUK-2019-02-0022','SO_MEMO1.pdf'),(51,'PBUK-2019-02-0023','APPOINTMENT6.pdf'),(52,'PBUK-2019-02-0023','MEDICAL_DOC.pdf'),(53,'PBUK-2019-02-0023','SALN6.pdf'),(54,'PBUK-2019-02-0024','APPOINTMENT7.pdf'),(55,'PBUK-2019-02-0024','SALN7.pdf'),(56,'PBUK-2019-02-0025','APPOINTMENT8.pdf'),(57,'PBUK-2019-02-0025','SO_MEMO2.pdf'),(58,'PBUK-2019-02-0026','APPOINTMENT9.pdf'),(59,'PBUK-2019-02-0026','PDS4.pdf'),(60,'PBUK-2019-02-0026','SALN8.pdf'),(61,'PBUK-2019-02-0027','APPOINTMENT10.pdf'),(62,'PBUK-2019-02-0027','OTHER_DOC3.pdf'),(63,'PBUK-2019-02-0027','PDS5.pdf'),(64,'PBUK-2019-02-0027','SALN9.pdf'),(65,'PBUK-2019-02-0027','SO_MEMO3.pdf'),(66,'PBUK-2019-02-0028','APPOINTMENT11.pdf'),(67,'PBUK-2019-02-0028','PDS6.pdf'),(68,'PBUK-2019-02-0028','SALN10.pdf'),(69,'PBUK-2019-02-0028','SO_MEMO4.pdf'),(70,'PBUK-2019-02-0029','APPOINTMENT12.pdf'),(71,'PBUK-2019-02-0029','PDS7.pdf'),(72,'PBUK-2019-02-0029','SALN11.pdf'),(73,'PBUK-2019-02-0030','APPOINTMENT13.pdf'),(74,'PBUK-2019-02-0030','PDS8.pdf'),(75,'PBUK-2019-02-0030','SO_MEMO5.pdf'),(76,'PBUK-2019-02-0031','APPOINTMENT14.pdf'),(77,'PBUK-2019-02-0031','PDS9.pdf'),(78,'PBUK-2019-02-0031','SO_MEMO6.pdf'),(79,'PBUK-2019-02-0032','APPOINTMENT15.pdf'),(80,'PBUK-2019-02-0032','OTHER_DOC4.pdf'),(81,'PBUK-2019-02-0032','PDS10.pdf'),(82,'PBUK-2019-02-0032','SALN12.pdf'),(83,'PBUK-2019-02-0032','SO_MEMO7.pdf'),(84,'PBUK-2019-02-0033','APPOINTMENT16.pdf'),(85,'PBUK-2019-02-0033','ELIGIBILITY.pdf'),(86,'PBUK-2019-02-0033','OTHER_DOC5.pdf'),(87,'PBUK-2019-02-0033','PDS11.pdf'),(88,'PBUK-2019-02-0033','TOR.pdf'),(89,'PBUK-2019-02-0034','APPOINTMENT17.pdf'),(90,'PBUK-2019-02-0034','OTHER_DOC6.pdf'),(91,'PBUK-2019-02-0034','PDS12.pdf'),(92,'PBUK-2019-02-0034','SALN13.pdf'),(93,'PBUK-2019-02-0035','APPOINTMENT18.pdf'),(94,'PBUK-2019-02-0035','MARR_CERT.pdf'),(95,'PBUK-2019-02-0035','OTHER_DOC7.pdf'),(96,'PBUK-2019-02-0035','PDS13.pdf'),(97,'PBUK-2019-02-0035','SO_MEMO8.pdf'),(98,'PBUK-2019-02-0036','APPOINTMENT19.pdf'),(99,'PBUK-2019-02-0036','OTHER_DOC8.pdf'),(100,'PBUK-2019-02-0036','PDS14.pdf');

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `ug_id` int(20) NOT NULL AUTO_INCREMENT,
  `ug_name` varchar(50) DEFAULT NULL,
  `ug_alias` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ug_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `user_group` */

insert  into `user_group`(`ug_id`,`ug_name`,`ug_alias`) values (1,'Administrator','a'),(2,'Records Officer','b'),(3,'Accountant','c'),(4,'Budget Officer','d'),(5,'Cashier','e'),(6,'Planning Officer','f'),(7,'Receiving Clerk','g'),(8,'Releasing Clerk','h'),(9,'Property Custodian','i');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `u_id` int(255) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(20) DEFAULT NULL,
  `m_name` varchar(20) DEFAULT NULL,
  `l_name` varchar(20) DEFAULT NULL,
  `u_name` varchar(50) DEFAULT NULL,
  `u_pwd` varchar(50) DEFAULT NULL,
  `emp_name` varchar(50) DEFAULT NULL,
  `ug_id` int(20) DEFAULT NULL,
  `stat_flag` int(20) DEFAULT NULL,
  `off_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`u_id`,`f_name`,`m_name`,`l_name`,`u_name`,`u_pwd`,`emp_name`,`ug_id`,`stat_flag`,`off_id`) values (1,'A','D','Min','admin','21232f297a57a5a743894a0e4a801fc3','A D Min',1,1,3),(2,'Earl Marc','Japuz','Domingo','emjdomingo','12bea9674f3d121afd7750d332933b41','Earl Marc Japuz Domingo',1,1,3),(3,'Dummy','Dummy','Dummy','dddummy','12bea9674f3d121afd7750d332933b41','Dummy Dummy Dummy',2,1,3),(6,'Nida Teresa','Babanto','Juarez','ntbjuarez','12bea9674f3d121afd7750d332933b41','Nida Teresa Babanto Juarez',3,1,3),(7,'Andres Luis','Alvizo','Cabigas','alacabigas','12bea9674f3d121afd7750d332933b41','Andres Luis Alvizo Cabigas',4,1,3),(8,'Lendie','Bastasa','Caracol','lbcaracol','12bea9674f3d121afd7750d332933b41','Lendie Bastasa Caracol',1,1,3),(9,'Christian','Carson','Jebulan','ccjebulan','12bea9674f3d121afd7750d332933b41','Christian Carson Jebulan',6,1,3),(10,'Marites','Caneos','Salo','mcsalo','402dd9fd49e9d9b7a3f72cdc6e8f6251','Marites Caneos Salo',2,1,3),(11,'Rosalie','Albastro','Minquez','raminquez','12bea9674f3d121afd7750d332933b41','Rosalie Albastro Minquez',7,1,3),(12,'Delia','Bingat','Sario','dbsario','12bea9674f3d121afd7750d332933b41','Delia Bingat Sario',7,1,3),(13,'Emma','Sallarda','Denque','esdenque','12bea9674f3d121afd7750d332933b41','Emma Sallarda Denque',5,1,3),(14,'Leonardo','Revaca','Luceño','lrluceño','12bea9674f3d121afd7750d332933b41','Leonardo Revaca Luceño',1,0,3),(15,'Teresita','Exclamador','Ebora','teebora','12bea9674f3d121afd7750d332933b41','Teresita Exclamador Ebora',9,1,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
