/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.1.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ticketing_system
-- ------------------------------------------------------
-- Server version	12.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `ticket_messages`
--

DROP TABLE IF EXISTS `ticket_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `date_sent` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`message_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_messages`
--

LOCK TABLES `ticket_messages` WRITE;
/*!40000 ALTER TABLE `ticket_messages` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `ticket_messages` VALUES
(3,62,1,'done.','2026-01-24 21:35:24'),
(4,63,1,'hello.','2026-01-25 07:18:46'),
(5,63,34,'hey.\r\n','2026-01-25 07:53:38'),
(6,63,1,'the ticked is closed.','2026-01-25 08:58:53'),
(8,63,1,'what is your issue?','2026-01-25 10:32:05'),
(9,63,34,'nothing much.\r\n','2026-01-25 10:32:52'),
(10,63,34,'ok.\r\n','2026-01-28 15:13:02'),
(11,63,34,'i have another issue.','2026-01-28 15:13:08'),
(12,63,34,'hello.','2026-01-28 15:39:50'),
(13,63,34,'i have another request.','2026-01-28 15:39:59'),
(14,63,1,'ty, for contacting, your request has been submitted.','2026-01-28 15:40:30'),
(15,63,34,'ok.','2026-01-28 15:40:58'),
(16,62,1,'yes?','2026-01-28 15:46:18'),
(17,63,1,'hello.','2026-01-28 15:51:06'),
(18,65,1,'hello, can you explain a bit more?','2026-01-28 16:03:09'),
(19,65,35,'the wifi isnt working, what might be the reason.','2026-01-28 16:03:46'),
(20,65,1,'your issue has been solved.','2026-01-28 16:04:12'),
(21,66,1,'hello, how can i help you?\r\n','2026-01-28 16:41:02'),
(22,66,34,'it was solved ty.\r\n','2026-01-28 16:44:49');
/*!40000 ALTER TABLE `ticket_messages` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `ticket_status_log`
--

DROP TABLE IF EXISTS `ticket_status_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_status_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `old_status` varchar(20) DEFAULT NULL,
  `new_status` varchar(20) DEFAULT NULL,
  `changed_by` int(11) DEFAULT NULL,
  `changed_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_status_log`
--

LOCK TABLES `ticket_status_log` WRITE;
/*!40000 ALTER TABLE `ticket_status_log` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `ticket_status_log` VALUES
(1,63,'Open','Closed',1,'2026-01-28 15:40:35'),
(2,63,'Closed','Closed',1,'2026-01-28 15:44:24'),
(3,63,'Closed','Closed',1,'2026-01-28 15:46:01'),
(4,62,'Open','In Progress',1,'2026-01-28 15:46:15'),
(5,63,'Closed','Open',1,'2026-01-28 15:47:12'),
(6,65,'Open','In Progress',1,'2026-01-28 16:02:57'),
(7,65,'In Progress','Closed',1,'2026-01-28 16:04:15'),
(8,63,'Open','Closed',1,'2026-01-28 16:35:49'),
(9,66,'Open','In Progress',1,'2026-01-28 16:40:55'),
(10,66,'In Progress','Closed',1,'2026-01-28 16:45:04');
/*!40000 ALTER TABLE `ticket_status_log` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','In Progress','Closed') DEFAULT 'Open',
  `date_created` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `tickets` VALUES
(3,'Cannot login to account','Login fails even with correct credentials.','Open','2026-01-22 21:34:08',2),
(4,'Password reset email not received','Tried multiple times, no email arrived.','In Progress','2026-01-23 21:34:08',2),
(5,'Dashboard not loading','After login the dashboard is blank.','Closed','2026-01-19 21:34:08',3),
(6,'Profile update error','Error appears while saving profile.','Open','2026-01-24 15:34:08',3),
(7,'Ticket submission failed','500 error while submitting ticket.','Open','2026-01-20 21:34:08',4),
(8,'Slow system performance','Pages take too long to load.','In Progress','2026-01-24 09:34:08',4),
(9,'Email notifications missing','No email when ticket status changes.','Closed','2026-01-17 21:34:08',5),
(10,'Incorrect ticket status','Ticket marked closed without reply.','Open','2026-01-23 21:34:08',5),
(11,'Unable to change password','Password update fails silently.','Open','2026-01-21 21:34:08',6),
(12,'UI layout broken on mobile','Buttons overlap on phone.','In Progress','2026-01-24 13:34:08',6),
(13,'Account locked unexpectedly','Account locked after one attempt.','Closed','2026-01-14 21:34:08',7),
(14,'Session expires too fast','Logged out after few minutes.','Open','2026-01-24 16:34:08',7),
(15,'Error while uploading attachment','File upload fails.','Open','2026-01-22 21:34:08',8),
(16,'Attachment size unclear','No limit shown for uploads.','In Progress','2026-01-23 21:34:08',8),
(17,'Cannot delete ticket','Delete option not working.','Closed','2026-01-18 21:34:08',9),
(18,'Ticket list not refreshing','New tickets don’t appear immediately.','Open','2026-01-24 17:34:08',9),
(19,'Logout button missing','Cannot find logout option.','Open','2026-01-21 21:34:08',10),
(20,'Security concern','Session stays active after logout.','Closed','2026-01-23 21:34:08',10),
(21,'Incorrect timestamps','Message time seems wrong.','Closed','2026-01-15 21:34:08',11),
(22,'Time zone issue','Times don’t match my location.','Open','2026-01-24 19:34:08',11),
(23,'Cannot view admin reply','Reply not visible after refresh.','Open','2026-01-23 21:34:08',12),
(24,'Message ordering issue','Messages appear out of order.','In Progress','2026-01-24 15:34:08',12),
(25,'Broken link in email','Ticket link leads to error page.','Closed','2026-01-16 21:34:08',13),
(26,'Link expired too soon','Link expired within minutes.','Open','2026-01-24 18:34:08',13),
(27,'Unread messages not highlighted','Hard to see new replies.','Open','2026-01-22 21:34:08',14),
(28,'Notification delay','Emails arrive very late.','In Progress','2026-01-24 11:34:08',14),
(29,'Cannot close ticket','No close option available.','Closed','2026-01-13 21:34:08',15),
(30,'Status stuck on Open','Admin changed but UI did not.','Open','2026-01-23 21:34:08',15),
(31,'Form validation unclear','No error messages shown.','Open','2026-01-22 21:34:08',16),
(32,'Textarea cuts text','Long text gets cut off.','In Progress','2026-01-24 16:34:08',16),
(33,'Search not working','Searching tickets returns nothing.','Closed','2026-01-12 21:34:08',17),
(34,'Filter resets automatically','Filters reset on refresh.','Open','2026-01-24 18:34:08',17),
(35,'Cannot update email','Email change fails.','Open','2026-01-23 21:34:08',18),
(36,'Duplicate tickets created','One click creates two tickets.','In Progress','2026-01-24 15:34:08',18),
(37,'UI text too small','Hard to read text.','Closed','2026-01-11 21:34:08',19),
(39,'Broken pagination','Next page shows same tickets.','Open','2026-01-22 21:34:08',20),
(40,'Ticket count incorrect','Count does not match list.','In Progress','2026-01-24 14:34:08',20),
(41,'Admin reply delayed','Reply came after many hours.','Closed','2026-01-10 21:34:08',21),
(42,'No typing indicator','Unsure if admin is responding.','Open','2026-01-24 19:34:08',21),
(43,'Messages disappear','Old messages vanished.','Open','2026-01-23 21:34:08',22),
(44,'Conversation resets','Chat resets on refresh.','In Progress','2026-01-24 13:34:08',22),
(45,'Cannot reopen ticket','Closed ticket cannot be reopened.','Closed','2026-01-09 21:34:08',23),
(46,'Wrong ticket assigned','Ticket shows another user.','Open','2026-01-24 18:34:08',23),
(47,'Unexpected logout','Logged out without action.','Open','2026-01-22 21:34:08',24),
(48,'Session timeout unclear','No warning before logout.','In Progress','2026-01-24 15:34:08',24),
(49,'Admin status unclear','Hard to know if admin replied.','Closed','2026-01-08 21:34:08',25),
(50,'No read receipt','Cannot tell if message read.','Open','2026-01-24 19:34:08',25),
(51,'Broken CSS on Safari','Layout breaks in Safari.','Open','2026-01-23 21:34:08',26),
(52,'Buttons not clickable','Buttons don’t respond.','In Progress','2026-01-24 16:34:08',26),
(53,'Error 403 on submit','Permission error shown.','Closed','2026-01-07 21:34:08',27),
(54,'Role confusion','UI shows admin options.','Open','2026-01-24 18:34:08',27),
(55,'Missing confirmation message','No confirmation after submit.','Open','2026-01-22 21:34:08',28),
(56,'Success message unclear','Hard to see success.','In Progress','2026-01-24 15:34:08',28),
(57,'Cannot edit ticket','Edit button missing.','Closed','2026-01-06 21:34:08',29),
(58,'Edit saves wrong data','Old data reappears.','Open','2026-01-24 19:34:08',29),
(59,'Attachment preview broken','Preview does not load.','Open','2026-01-23 21:34:08',30),
(60,'File type restriction unclear','No allowed types listed.','In Progress','2026-01-24 17:34:08',30),
(61,'Login page slow','Login page loads slowly.','Closed','2026-01-05 21:34:08',31),
(62,'Captcha missing','No captcha for security.','In Progress','2026-01-24 20:34:08',31),
(63,'this is the issue, that ive been facing bbout.','this is bad.','Closed','2026-01-25 06:58:56',34),
(65,'Wifi.','since today morning, the wifi isnt working.','Closed','2026-01-28 16:02:01',35),
(66,'File Upload','cant upload.','Closed','2026-01-28 16:40:31',34),
(67,'Cannot login to account','Login fails even with correct credentials.','Open','2026-01-26 16:54:08',2),
(68,'Password reset email not received','Tried multiple times, no email arrived.','In Progress','2026-01-27 16:54:08',2),
(69,'Dashboard not loading','After login the dashboard is blank.','Closed','2026-01-23 16:54:08',3),
(70,'Profile update error','Error appears while saving profile.','Open','2026-01-28 10:54:08',3),
(71,'Ticket submission failed','500 error while submitting ticket.','Open','2026-01-24 16:54:08',4),
(72,'Slow system performance','Pages take too long to load.','In Progress','2026-01-28 04:54:08',4),
(73,'Email notifications missing','No email when ticket status changes.','Closed','2026-01-21 16:54:08',5),
(74,'Incorrect ticket status','Ticket marked closed without reply.','Open','2026-01-27 16:54:08',5),
(75,'Unable to change password','Password update fails silently.','Open','2026-01-25 16:54:08',6),
(76,'UI layout broken on mobile','Buttons overlap on phone.','In Progress','2026-01-28 08:54:08',6),
(77,'Account locked unexpectedly','Account locked after one attempt.','Closed','2026-01-18 16:54:08',7),
(78,'Session expires too fast','Logged out after few minutes.','Open','2026-01-28 11:54:08',7),
(79,'Error while uploading attachment','File upload fails.','Open','2026-01-26 16:54:08',8),
(80,'Attachment size unclear','No limit shown for uploads.','In Progress','2026-01-27 16:54:08',8),
(81,'Cannot delete ticket','Delete option not working.','Closed','2026-01-22 16:54:08',9),
(82,'Ticket list not refreshing','New tickets don’t appear immediately.','Open','2026-01-28 12:54:08',9),
(83,'Logout button missing','Cannot find logout option.','Open','2026-01-25 16:54:08',10),
(84,'Security concern','Session stays active after logout.','In Progress','2026-01-27 16:54:08',10),
(85,'Incorrect timestamps','Message time seems wrong.','Closed','2026-01-19 16:54:08',11),
(86,'Time zone issue','Times don’t match my location.','Open','2026-01-28 14:54:08',11),
(87,'Cannot view admin reply','Reply not visible after refresh.','Open','2026-01-27 16:54:08',12),
(88,'Message ordering issue','Messages appear out of order.','In Progress','2026-01-28 10:54:08',12),
(89,'Broken link in email','Ticket link leads to error page.','Closed','2026-01-20 16:54:08',13),
(90,'Link expired too soon','Link expired within minutes.','Open','2026-01-28 13:54:08',13),
(91,'Unread messages not highlighted','Hard to see new replies.','Open','2026-01-26 16:54:08',14),
(92,'Notification delay','Emails arrive very late.','In Progress','2026-01-28 06:54:08',14),
(93,'Cannot close ticket','No close option available.','Closed','2026-01-17 16:54:08',15),
(94,'Status stuck on Open','Admin changed but UI did not.','Open','2026-01-27 16:54:08',15),
(95,'Form validation unclear','No error messages shown.','Open','2026-01-26 16:54:08',16),
(96,'Textarea cuts text','Long text gets cut off.','In Progress','2026-01-28 11:54:08',16),
(97,'Search not working','Searching tickets returns nothing.','Closed','2026-01-16 16:54:08',17),
(98,'Filter resets automatically','Filters reset on refresh.','Open','2026-01-28 13:54:08',17),
(99,'Cannot update email','Email change fails.','Open','2026-01-27 16:54:08',18),
(100,'Duplicate tickets created','One click creates two tickets.','In Progress','2026-01-28 10:54:08',18),
(101,'UI text too small','Hard to read text.','Closed','2026-01-15 16:54:08',19),
(102,'Dark mode missing','No dark mode available.','Open','2026-01-28 12:54:08',19),
(103,'Broken pagination','Next page shows same tickets.','Open','2026-01-26 16:54:08',20),
(104,'Ticket count incorrect','Count does not match list.','In Progress','2026-01-28 09:54:08',20),
(105,'Admin reply delayed','Reply came after many hours.','Closed','2026-01-14 16:54:08',21),
(106,'No typing indicator','Unsure if admin is responding.','Open','2026-01-28 14:54:08',21),
(107,'Messages disappear','Old messages vanished.','Open','2026-01-27 16:54:08',22),
(108,'Conversation resets','Chat resets on refresh.','In Progress','2026-01-28 08:54:08',22),
(109,'Cannot reopen ticket','Closed ticket cannot be reopened.','Closed','2026-01-13 16:54:08',23),
(110,'Wrong ticket assigned','Ticket shows another user.','Open','2026-01-28 13:54:08',23),
(111,'Unexpected logout','Logged out without action.','Open','2026-01-26 16:54:08',24),
(112,'Session timeout unclear','No warning before logout.','In Progress','2026-01-28 10:54:08',24),
(113,'Admin status unclear','Hard to know if admin replied.','Closed','2026-01-12 16:54:08',25),
(114,'No read receipt','Cannot tell if message read.','Open','2026-01-28 14:54:08',25),
(115,'Broken CSS on Safari','Layout breaks in Safari.','Open','2026-01-27 16:54:08',26),
(116,'Buttons not clickable','Buttons don’t respond.','In Progress','2026-01-28 11:54:08',26),
(117,'Error 403 on submit','Permission error shown.','Closed','2026-01-11 16:54:08',27),
(118,'Role confusion','UI shows admin options.','Open','2026-01-28 13:54:08',27),
(119,'Missing confirmation message','No confirmation after submit.','Open','2026-01-26 16:54:08',28),
(120,'Success message unclear','Hard to see success.','In Progress','2026-01-28 10:54:08',28),
(121,'Cannot edit ticket','Edit button missing.','Closed','2026-01-10 16:54:08',29),
(122,'Edit saves wrong data','Old data reappears.','Open','2026-01-28 14:54:08',29),
(123,'Attachment preview broken','Preview does not load.','Open','2026-01-27 16:54:08',30),
(124,'File type restriction unclear','No allowed types listed.','In Progress','2026-01-28 12:54:08',30),
(125,'Login page slow','Login page loads slowly.','Closed','2026-01-09 16:54:08',31),
(126,'Captcha missing','No captcha for security.','Open','2026-01-28 15:54:08',31);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `users` VALUES
(1,'dipdarpan','dip@example.com','$2y$12$8krG9trPzWs0f1OKzmIx7.mKCKzIBwkyhS9zdxNQvTsw6HKJd14LG','admin'),
(2,'abcd','ok@gmail.com','$2y$12$UuRlN68MLVBn6Lx66DyNq.r634O0NfRWxuq/Vri6JpQIyYP0OCm7C','user'),
(3,'Check','check@example.com','$2y$12$.aCgap.T/rHWlWA6R8xmaOipt3R1qMs634UVPBOLrKHDFhCK9uWg.','user'),
(4,'User 01','user01@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(5,'User 02','user02@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(6,'User 03','user03@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(7,'User 04','user04@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(8,'User 05','user05@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(9,'User 06','user06@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(10,'User 07','user07@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(11,'User 08','user08@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(12,'User 09','user09@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(13,'User 10','user10@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(14,'User 11','user11@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(15,'User 12','user12@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(16,'User 13','user13@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(17,'User 14','user14@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(18,'User 15','user15@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(19,'User 16','user16@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(20,'User 17','user17@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(21,'User 18','user18@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(22,'User 19','user19@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(23,'User 20','user20@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(24,'User 21','user21@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(25,'User 22','user22@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(26,'User 23','user23@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(27,'User 24','user24@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(28,'User 25','user25@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(29,'User 26','user26@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(30,'User 27','user27@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(31,'User 28','user28@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(32,'User 29','user29@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(33,'User 30','user30@example.com','$2y$10$e0NRJ8zE2zN1r0V7kYhEwOj1OQYqSg6VqG0zXv8H2yV0sDg2GxZ5C','user'),
(34,'anon','anon@example.com','$2y$12$WteH6eG40J0AkrinZqy4X.0dUdtX8lYtUABM17jjPrd2aHrdzXCU6','user'),
(35,'106','106@example.com','$2y$12$gj1gZwpoY9HS5UgdyfTABufhWJNmOoASzvipTNkqOuK6umOYChr2W','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping events for database 'ticketing_system'
--

--
-- Dumping routines for database 'ticketing_system'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-01-28 17:08:33
