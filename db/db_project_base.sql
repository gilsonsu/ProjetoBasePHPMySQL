--
-- Table structure for table `tb_attribute`
--

DROP TABLE IF EXISTS `tb_attribute`;

CREATE TABLE `tb_attribute` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_table` varchar(500) DEFAULT NULL COMMENT 'Table name there have a relationship white tb_attribute',
  `cl_table_fk` varchar(500) DEFAULT NULL COMMENT 'Table Foreign key name there have relationshop white cl_id',
  `cl_description` longtext,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Register all values fixed. ex: Gender(Male, Female)';

--
-- Dumping data for table `tb_attribute`
--

LOCK TABLES `tb_attribute` WRITE;

INSERT INTO `tb_attribute` VALUES 
(1,'tb_access_user','cl_id_sopt_att_active','ACTIVE'),
(2,'tb_access_user','cl_id_sopt_att_active','INACTIVE');

UNLOCK TABLES;


--
-- Table structure for table `tb_access_profile`
--

DROP TABLE IF EXISTS `tb_access_profile`;

CREATE TABLE `tb_access_profile` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_name` varchar(500) DEFAULT NULL COMMENT 'Title user category. Ex: Admistrador',
  `cl_description` longtext COMMENT 'More detail about category',
  `cl_date_insert` datetime DEFAULT NULL,
  `cl_date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Regiter all users category';


--
-- Dumping data for table `tb_access_profile`
--

LOCK TABLES `tb_access_profile` WRITE;

INSERT INTO `tb_access_profile` VALUES 
(1,'ADMINISTRATOR','All permission','2020-05-06 16:05:03','2020-05-06 16:05:03'),
(2,'OPERATOR','Without permission to insert or update users','2020-05-06 16:05:03','2020-05-06 16:05:03'),
(3,'VISITOR','Just can see datas','2020-05-06 16:05:03','2020-05-06 16:05:03');

UNLOCK TABLES;

--
-- Table structure for table `tb_access_user`
--

DROP TABLE IF EXISTS `tb_access_user`;

CREATE TABLE `tb_access_user` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_id_access_profile` int(11) NOT NULL,
  `cl_id_sopt_att_active` int(11) DEFAULT '1',
  `cl_name` varchar(500) NOT NULL COMMENT 'Full user name',
  `cl_email` varchar(500) NOT NULL COMMENT 'E-mail to recive password',
  `cl_pwd` varchar(100) NOT NULL COMMENT 'Password to access app',
  `cl_date_insert` datetime DEFAULT NULL,
  `cl_date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`cl_id`),
  KEY `fk_tb_access_user_to_tb_access_profile` (`cl_id_access_profile`),
  KEY `fk_tb_access_user_to_tb_attribute` (`cl_id_sopt_att_active`),
  CONSTRAINT `fk_tb_access_user_to_tb_access_profile` FOREIGN KEY (`cl_id_access_profile`) REFERENCES `tb_access_profile` (`cl_id`),
  CONSTRAINT `fk_tb_access_user_to_tb_attribute` FOREIGN KEY (`cl_id_sopt_att_active`) REFERENCES `tb_attribute` (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


--
-- Dumping data for table `tb_access_user`
--

LOCK TABLES `tb_access_user` WRITE;

INSERT INTO `tb_access_user` VALUES 
(1,1,1,'YOUR MANE','admin@admin.com','abcd1234','2020-05-06 16:06:36','2020-05-06 16:06:36'),
(2,2,1,'YOUR MANE','operator@operator.com','abcd1234','2020-05-06 16:06:36','2020-05-06 16:06:36'),
(3,3,1,'YOUR MANE','visitor@visitor.com','abcd1234','2020-05-06 16:06:36','2020-05-06 16:06:36');

UNLOCK TABLES;



--
-- Table structure for table `tb_access_page`
--

DROP TABLE IF EXISTS `tb_access_page`;

CREATE TABLE `tb_access_page` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_name` varchar(500) DEFAULT NULL COMMENT 'Page name ex: formClient.php',
  `cl_description` longtext COMMENT 'Page title',
  `cl_date_insert` datetime DEFAULT NULL,
  `cl_date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Register all page there have on app.';


--
-- Dumping data for table `tb_access_page`
--

LOCK TABLES `tb_access_page` WRITE;

INSERT INTO `tb_access_page` VALUES 
(1,'listAccessUser.php','User list','2020-05-06 16:05:05','2020-05-06 16:05:05'),
(2,'formAccessUser.php','User form','2020-05-06 16:05:05','2020-05-06 16:05:05'),
(3,'listAccessPage.php','Page list','2020-05-06 16:05:05','2020-05-06 16:05:05'),
(4,'formAccessPage.php','Page form','2020-05-06 16:05:05','2020-05-06 16:05:05'),
(5,'listAccessPermission.php','Permission list','2020-05-06 16:05:05','2020-05-06 16:05:05'),
(6,'formAccessPermission.php','Permission form','2020-05-06 16:05:05','2020-05-06 16:05:05'),
(7,'listAccessProfile.php','Profile List','2020-05-17 11:55:39','2020-05-17 11:55:39'),
(8,'formAccessProfile.php','Profile Form','2020-05-17 11:55:39','2020-05-17 11:55:39');

UNLOCK TABLES;


--
-- Table structure for table `tb_access_crud`
--

DROP TABLE IF EXISTS `tb_access_crud`;

CREATE TABLE `tb_access_crud` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_id_access_profile` int(11) NOT NULL,
  `cl_id_access_page` int(11) NOT NULL,
  `cl_create` int(1) DEFAULT '0' COMMENT 'Accept two values 0 or 1, 0 iguals no permission and 1 iguals permission',
  `cl_read` int(1) DEFAULT '0' COMMENT 'Accept two values 0 or 1, 0 iguals no permission and 1 iguals permission',
  `cl_update` int(1) DEFAULT '0' COMMENT 'Accept two values 0 or 1, 0 iguals no permission and 1 iguals permission',
  `cl_delete` int(1) DEFAULT '0' COMMENT 'Accept two values 0 or 1, 0 iguals no permission and 1 iguals permission',
  `cl_date_insert` datetime DEFAULT NULL,
  `cl_date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`cl_id`),
  KEY `fk_tb_access_crud_to_tb_access_profile` (`cl_id_access_profile`),
  KEY `fk_tb_access_crud_to_tb_id_access_page` (`cl_id_access_page`),
  CONSTRAINT `fk_tb_access_crud_to_tb_access_profile` FOREIGN KEY (`cl_id_access_profile`) REFERENCES `tb_access_profile` (`cl_id`),
  CONSTRAINT `fk_tb_access_crud_to_tb_access_page` FOREIGN KEY (`cl_id_access_page`) REFERENCES `tb_access_page` (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Register page permisson to create, read, update and delete';


--
-- Dumping data for table `tb_access_crud`
--

LOCK TABLES `tb_access_crud` WRITE;

INSERT INTO `tb_access_crud` VALUES 
(1,1,1,1,1,1,1,'2020-05-06 16:06:37','2020-05-06 16:06:37'),
(2,1,2,1,1,1,1,'2020-05-06 16:06:37','2020-05-06 16:06:37'),
(3,1,3,1,1,1,1,'2020-05-06 16:06:37','2020-05-06 16:06:37'),
(4,1,4,1,1,1,1,'2020-05-06 16:06:37','2020-05-06 16:06:37'),
(5,1,5,1,1,1,1,'2020-05-06 16:06:37','2020-05-06 16:06:37'),
(6,1,6,1,1,1,1,'2020-05-06 16:06:37','2020-05-06 16:06:37'),
(7,1,7,1,1,1,1,'2020-05-17 00:00:43','2020-05-17 00:09:18'),
(8,1,8,1,1,1,1,'2020-05-17 00:00:43','2020-05-17 00:09:18');

UNLOCK TABLES;

--
-- Table structure for table `tb_access_log`
--

DROP TABLE IF EXISTS `tb_access_log`;

CREATE TABLE `tb_access_log` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_id_access_user` int(11) NOT NULL,
  `cl_ip` varchar(200) DEFAULT NULL,
  `cl_date_insert` datetime DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



