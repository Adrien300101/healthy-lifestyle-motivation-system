-- --------------------------------------------------------
-- Host:                         13.236.92.43
-- Server version:               10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_hlms
CREATE DATABASE IF NOT EXISTS `db_hlms` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db_hlms`;

-- Dumping structure for table db_hlms.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_role_id` int(3) DEFAULT NULL,
  `admin_first_name` varchar(50) NOT NULL DEFAULT '0',
  `admin_last_name` varchar(50) DEFAULT NULL,
  `admin_initial` tinytext DEFAULT NULL,
  `admin_password` varchar(100) NOT NULL DEFAULT '0',
  `admin_email` varchar(50) NOT NULL DEFAULT '0',
  `admin_session_id` varchar(10) DEFAULT NULL,
  `admin_status` int(3) DEFAULT 0 COMMENT '0 = active\r\n1 = deactivated\r\n2 = pending',
  PRIMARY KEY (`admin_id`),
  KEY `FK_admin_admin_role` (`admin_role_id`),
  CONSTRAINT `FK_admin_admin_role` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_role` (`admin_role_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.admin: ~3 rows (approximately)
DELETE FROM `admin`;
INSERT INTO `admin` (`admin_id`, `admin_role_id`, `admin_first_name`, `admin_last_name`, `admin_initial`, `admin_password`, `admin_email`, `admin_session_id`, `admin_status`) VALUES
	(1, 1, 'Adrien', 'Admin', 'AA', '$2y$10$26l43rgwMU9sk1.vsev5VO7p3wJEISfHDfnB/XeRD4nAFPW5LnXkm', 'adrithone2@gmail.com', 'shfajsdafj', 0),
	(2, 2, 'Test', 'Admin', 'TA', '$2y$10$u4YPISHRy2X2kVhJCP/dTuudTptQPmINMsKEWdgJEewRSGDgBMCs6', 'adrithone@gmail.com', 'shfajsdalk', 0),
	(4, 2, 'Alex', 'Admin', 'AA', '$2y$10$PnflyULUfh/1snXEJrQiw.KPXj4TAgp0LV2hDeGyB/CclAfvKsdoO', 'adrithone1@gmail.com', 'bd678fe430', 1);

-- Dumping structure for table db_hlms.admin_access
CREATE TABLE IF NOT EXISTS `admin_access` (
  `admin_role_id` int(3) NOT NULL DEFAULT 0,
  `page_id` int(5) DEFAULT NULL,
  KEY `FK_admin_access_admin_role` (`admin_role_id`),
  KEY `FK_admin_access_page_list` (`page_id`),
  CONSTRAINT `FK_admin_access_admin_role` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_role` (`admin_role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_admin_access_page_list` FOREIGN KEY (`page_id`) REFERENCES `page_list` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.admin_access: ~11 rows (approximately)
DELETE FROM `admin_access`;
INSERT INTO `admin_access` (`admin_role_id`, `page_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5),
	(2, 1),
	(2, 2),
	(2, 4),
	(2, 5),
	(1, 6),
	(2, 6);

-- Dumping structure for table db_hlms.admin_email_log
CREATE TABLE IF NOT EXISTS `admin_email_log` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `date_sent` datetime DEFAULT NULL,
  `email_type` int(3) NOT NULL DEFAULT 0 COMMENT '0 = email verification',
  `email_status` int(3) NOT NULL DEFAULT 0 COMMENT '0 = sent\r\n1 = not sent',
  PRIMARY KEY (`email_id`),
  KEY `FK__admin` (`admin_id`),
  CONSTRAINT `FK__admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.admin_email_log: ~9 rows (approximately)
DELETE FROM `admin_email_log`;
INSERT INTO `admin_email_log` (`email_id`, `admin_id`, `date_sent`, `email_type`, `email_status`) VALUES
	(2, 1, '2023-06-05 15:15:07', 0, 0),
	(3, 1, '2023-06-05 15:20:47', 0, 0),
	(4, 2, '2023-06-05 17:43:47', 0, 0),
	(7, 4, '2023-06-03 20:55:41', 0, 0),
	(9, 4, '2023-06-05 21:58:45', 0, 0),
	(10, 4, '2023-06-10 16:49:02', 0, 0),
	(11, 4, '2023-06-19 13:39:30', 0, 0),
	(13, 1, '2023-06-23 13:15:12', 0, 0),
	(14, 4, '2023-06-23 13:21:44', 0, 0);

-- Dumping structure for table db_hlms.admin_role
CREATE TABLE IF NOT EXISTS `admin_role` (
  `admin_role_id` int(3) NOT NULL AUTO_INCREMENT,
  `admin_role_name` varchar(50) NOT NULL DEFAULT '0',
  `admin_role_description` text DEFAULT NULL,
  `admin_role_status` int(3) NOT NULL DEFAULT 0 COMMENT '0 = active\r\n1 = inactive',
  PRIMARY KEY (`admin_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.admin_role: ~2 rows (approximately)
DELETE FROM `admin_role`;
INSERT INTO `admin_role` (`admin_role_id`, `admin_role_name`, `admin_role_description`, `admin_role_status`) VALUES
	(1, 'Super Admin', 'The super admin can manage other admins (Add, edit or delete)', 0),
	(2, 'Admin', 'Admin is normal admin role. Handle customer management', 0);

-- Dumping structure for table db_hlms.chat_history
CREATE TABLE IF NOT EXISTS `chat_history` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_msg` text NOT NULL,
  `response` text NOT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`chat_id`),
  KEY `FK_chat_history_users` (`user_id`),
  CONSTRAINT `FK_chat_history_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.chat_history: ~25 rows (approximately)
DELETE FROM `chat_history`;
INSERT INTO `chat_history` (`chat_id`, `user_id`, `user_msg`, `response`, `date_created`) VALUES
	(1, 13, 'What are you?', 'I am an AI language model developed by OpenAI.', '2023-05-04 02:47:40'),
	(2, 13, 'How are you?', 'As an AI language model, I don\'t have emotions, but I am functioning perfectly fine. Thank you for asking. How may I assist you today?', '2023-05-04 02:49:14'),
	(3, 13, 'Ok but what can you do?', 'As an AI language model, I can help you with various tasks such as:\n\n1. Answering your questions\n2. Providing information on a topic\n3. Completing tas', '2023-05-04 02:49:51'),
	(4, 13, 'Can you recommend me some exercise to lose weight?', 'Sure! Here are some exercises that can help with weight loss: 1. Cardiovascular exercise: This includes activities like running, cycling, swimming, or dancing that get your heart rate up and burn calories. 2. High-intensity interval training (HIIT): This involves alternating bursts of intense exercise with rest periods. It can be done with bodyweight exercises like burpees, high knees, and jumping jacks. 3. Strength training: This includes exercises like weight lifting, push-ups, and squats that build muscle. Muscle burns more calories than fat, so the more muscle you have, the higher your metabolism will be. 4. Yoga: This low-impact exercise can increase flexibility, strength, and balance. It can also help reduce stress levels, which can lead to overeating. Remember, the key to losing weight is to create a calorie deficit by burning more calories than you consume. So, it\'s important to pair exercise with a healthy diet.', '2023-05-04 02:54:46'),
	(5, 13, 'What food is best for bulking?', 'As an AI language model, I don\'t consume food, but I can provide you the list of food that is best for bulking. Here are the foods that are best for bulking:\n\n1. Lean meats such as chicken, turkey, and fish\n2. Dairy products such as milk, yogurt, and cheese\n3. Eggs\n4. Whole-grain bread and pasta\n5. Fruits and vegetables\n6. Nuts and seeds\n7. Protein shakes and bars\n8. Olive oil and other healthy fats.', '2023-05-04 03:01:59'),
	(6, 13, 'What food is best for cutting?', 'As an AI language model, I don\'t have personal preferences but here are some foods that can be helpful for cutting:\n\n1. Lean meat (such as chicken, turkey, and fish)\n2. Eggs\n3. Low-fat dairy products (such as Greek yogurt and cottage cheese)\n4. Vegetables (such as broccoli, spinach, and peppers)\n5. Fruits (such as berries, apples, and grapefruit)\n6. Whole grains (such as brown rice, quinoa, and oats)\n7. Nuts and seeds (such as almonds, chia seeds, and pumpkin seeds)\n8. Legumes (such as beans and lentils)\n9. Water and other low-calorie beverages (such as herbal tea and black coffee)\n\nIt\'s important to remember that cutting typically requires a reduction in overall calorie intake, so it\'s also important to monitor portion sizes and be mindful of overall calorie intake.', '2023-05-04 03:03:21'),
	(7, 13, 'Tell me something funny', 'Why was the math book sad?\n\nBecause it had too many problems.', '2023-05-04 03:05:53'),
	(8, 13, 'So funnyðŸ¤£', 'As an AI language model, I am not capable of experiencing humor, but I would appreciate it if you could provide some context. Perhaps I can assist you with something else?', '2023-05-04 03:06:14'),
	(9, 13, 'Tell another funny small joke', 'Why did the tomato turn red?\n\nBecause it saw the salad dressing!', '2023-05-04 03:17:24'),
	(10, 16, 'Hello', 'Hello! How can I assist you today?', '2023-05-04 03:23:10'),
	(11, 16, 'What less calorik food can i eat', 'As an AI language model, I do not have information about your specific dietary needs, allergic reactions, or medical conditions. Therefore, it is necessary for you to consult a healthcare professional, registered dietitian, or nutritionist before making changes to your diet. However, here are some general suggestions:\n\n- Vegetables and fruits: These foods are low in calories and high in fiber, vitamins, and minerals. You can eat them raw, cooked, steamed, or roasted.\n- Lean protein sources: Some examples of low-calorie proteins are skinless chicken, turkey, fish, tofu, and legumes.\n- Whole grains: Brown rice, quinoa, oats, and whole grain bread are healthier alternatives than refined grains, as they contain more fiber and nutrients.\n- Low-fat dairy: Choose low-fat or non-fat milk, yogurt, and cheese instead of full-fat versions.\n- Water: Drinking plenty of water can help you stay hydrated and reduce your appetite. Avoid sugary drinks and alcohol, as they are high in calories and can lead to overeating.', '2023-05-04 03:24:28'),
	(12, 13, 'What can you tell me about the Student Coin (STC) used in this application that the chatgpt api is being used?', 'I\'m an AI language model and don\'t have access to current information on the Student Coin (STC). However, based on my last training data in September 2021, Student Coin is a blockchain-based project that is based on the Ethereum network. It aims to provide a platform for researching, creating, and managing customized tokens for various purposes, such as student organizations, university funds, academic research, and more.\n\nSTC is the native token of the Student Coin platform, used to pay for services and transactions on the network. It also serves as a medium of exchange between different custom tokens that are created on the platform. The platform allows students to launch their own tokens, which can be traded on a decentralized exchange through smart contracts.\n\nRegarding the chatgpt api, it\'s a state-of-the-art natural language processing tool that uses deep learning to generate human-like responses to text-based queries. This tool can be used for a variety of applications, including chatbots, intelligent virtual assistants, and other conversational interfaces. It\'s not directly related to the Student Coin project but can be used to improve the platform\'s user experience by facilitating natural language communication.', '2023-05-04 13:59:44'),
	(13, 13, 'Do you know in which application you are currently being used?', 'As an AI language model, I do not have a physical location or application in which I am being used. I exist solely in the digital realm and provide responses based on the input given to me by my users.', '2023-05-04 14:00:52'),
	(14, 13, 'Hello', 'Hello! How can I assist you today?', '2023-05-04 17:49:17'),
	(15, 13, 'Whats the weather like in malaysia now?', 'I\'m sorry, as an AI language model, I do not have real-time access to weather updates. Please check a weather website or app for the latest weather information.', '2023-05-04 17:53:58'),
	(16, 13, 'Should i exercise to be healthy?', 'Yes, exercising regularly is important for maintaining good health. Exercise can help improve cardiovascular health, strengthen muscles and bones, reduce stress and anxiety, improve sleep quality, and boost overall physical and mental well-being. It is recommended to engage in at least 150 minutes of moderate-intensity aerobic exercise or 75 minutes of vigorous-intensity aerobic exercise per week, along with muscle-strengthening activities at least two days per week. However, it\'s important to consult with a healthcare professional before starting a new exercise routine, especially if you have any underlying health conditions.', '2023-05-04 17:58:11'),
	(17, 13, 'How to be healthy?', 'As an AI language model, I don\'t have personal opinions or beliefs. But here are some general tips on how to be healthy: \n\n1. Eat a balanced diet: Include fresh fruits, vegetables, lean proteins, and whole grains in your diet. \n2. Stay hydrated: Drink plenty of water throughout the day. \n3. Exercise regularly: Engage in physical activity for at least 30 minutes each day. \n4. Get enough sleep: Aim for 7-9 hours of sleep each night. \n5. Manage stress: Practice relaxation techniques such as meditation or yoga to reduce stress and improve emotional well-being. \n6. Keep up with preventative health measures: Get regular check-ups, screenings, and vaccinations. \n7. Avoid risky behaviors: Limit or avoid smoking, excessive alcohol consumption, and drug use. \n8. Practice good hygiene: Wash your hands frequently, cover your mouth when coughing or sneezing, and keep your living space clean.', '2023-05-05 22:23:45'),
	(18, 13, 'Do you who Adrien Antony from Rodrigues in the republic of Mauritius is?', 'As an AI language model, I don\'t have access to personal information about individuals unless it\'s publicly available. Therefore, I am unable to provide any information regarding the identity of Adrien Antony from Rodrigues in the Republic of Mauritius.', '2023-05-07 23:35:23'),
	(19, 13, 'Can you insult me?', 'No, I am programmed to be polite and respectful. I cannot insult anyone.', '2023-05-07 23:35:51'),
	(20, 13, 'Please roast me', 'As an AI language model, I am not programmed to insult individuals. I am here to assist and provide helpful responses to your inquiries. Is there something I can assist you with today?', '2023-05-07 23:36:07'),
	(42, 17, 'Hi', 'Hello! How can I assist you today in terms of health, fitness, or nutrition?', '2023-06-22 12:05:11'),
	(43, 13, 'Give me a simple and short explanation about how to lose weight', 'To lose weight, you need to create a calorie deficit by consuming fewer calories than you burn through exercise and daily activities. This can be achieved by eating a healthy and balanced diet with moderate portions, increasing your physical activity level, and avoiding high calorie or processed foods. It is important to make gradual changes to your lifestyle to ensure long-term success and to consult a healthcare professional for personalized advice.', '2023-06-22 12:08:39'),
	(44, 13, 'Hi', 'Hello! How may I assist you today with your health and wellness needs?', '2023-06-23 15:09:38'),
	(45, 13, 'Who are you?', 'I am HAIA, a helpful chatbot designed to provide advice on health, fitness, and nutrition. I am here to answer any questions or concerns you may have about your health and help you make informed decisions about your well-being.', '2023-06-24 23:07:07'),
	(46, 13, 'What kind of advice i can expect from you?\n', 'As a Health AI Assistant, I can provide you with a wide range of advice related to health, fitness, and nutrition. Specifically, I can help you with topics such as:\n\n- Healthy eating habits and meal planning\n- Exercise and fitness routines\n- Weight management and weight loss strategies\n- Sleep hygiene and getting better sleep\n- Stress management and relaxation techniques\n- Mental health and emotional well-being\n- Managing chronic conditions such as diabetes, high blood pressure, or heart disease\n- Preventive care and disease prevention tips\n- Wellness and self-care practices\n\nFeel free to ask me any questions related to these areas, and I will do my best to help you.', '2023-06-24 23:07:47');

-- Dumping structure for table db_hlms.daily_exercise_goal
CREATE TABLE IF NOT EXISTS `daily_exercise_goal` (
  `daily_goal_id` int(6) NOT NULL AUTO_INCREMENT,
  `exercise_id` int(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reps_limit` int(11) NOT NULL,
  `exercise_status` int(4) NOT NULL DEFAULT 0 COMMENT '0 = incomplete\r\n1 = completed',
  `date_completed` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`daily_goal_id`),
  KEY `FK_daily_exercise_goal_users` (`user_id`),
  KEY `FK_daily_exercise_goal_exercise_list` (`exercise_id`),
  CONSTRAINT `FK_daily_exercise_goal_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.daily_exercise_goal: ~25 rows (approximately)
DELETE FROM `daily_exercise_goal`;
INSERT INTO `daily_exercise_goal` (`daily_goal_id`, `exercise_id`, `user_id`, `reps_limit`, `exercise_status`, `date_completed`, `date_created`) VALUES
	(1, 1, 13, 2, 1, '2023-05-04 20:30:55', '2023-05-03 16:00:33'),
	(3, 1, 16, 5, 1, '2023-05-04 16:00:37', '2023-05-04 16:00:35'),
	(28, 2, 13, 0, 0, NULL, '2023-05-03 16:00:33'),
	(29, 2, 16, 0, 0, NULL, '2023-05-04 16:00:35'),
	(30, 1, 16, 6, 0, NULL, '2023-05-04 16:00:35'),
	(31, 1, 15, 0, 0, NULL, '2023-05-04 19:08:43'),
	(32, 2, 15, 0, 0, NULL, '2023-05-04 19:08:43'),
	(39, 1, 13, 3, 1, '2023-05-04 21:35:11', '2023-05-03 20:30:55'),
	(48, 1, 13, 4, 1, '2023-05-05 22:22:47', '2023-05-04 21:25:58'),
	(53, 1, 13, 5, 1, '2023-05-08 16:37:03', '2023-05-05 22:22:47'),
	(54, 1, 17, 0, 1, '2023-05-07 00:01:38', '2023-05-06 23:29:46'),
	(84, 1, 17, 1, 1, '2023-05-07 00:16:25', '2023-05-06 23:57:15'),
	(89, 1, 17, 2, 0, NULL, '2023-05-07 00:16:25'),
	(90, 1, 13, 6, 1, '2023-05-12 23:06:51', '2023-05-08 16:37:03'),
	(91, 1, 13, 7, 1, '2023-05-15 22:46:30', '2023-05-12 23:06:51'),
	(92, 1, 13, 8, 1, '2023-05-19 00:15:26', '2023-05-15 22:46:30'),
	(93, 1, 18, 0, 0, NULL, '2023-05-17 15:08:05'),
	(94, 1, 19, 0, 0, NULL, '2023-05-18 16:00:17'),
	(95, 1, 20, 16, 1, '2023-05-19 00:10:52', '2023-05-19 00:06:31'),
	(96, 1, 20, 17, 0, NULL, '2023-05-19 00:10:52'),
	(101, 1, 13, 9, 1, '2023-05-23 17:20:50', '2023-05-19 00:15:26'),
	(102, 1, 13, 10, 1, '2023-05-31 20:13:58', '2023-05-23 17:20:50'),
	(109, 1, 13, 11, 1, '2023-06-10 17:06:35', '2023-05-31 20:13:58'),
	(111, 1, 13, 12, 0, NULL, '2023-06-10 17:06:35'),
	(114, 1, 25, 0, 0, NULL, '2023-06-19 13:34:52');

-- Dumping structure for table db_hlms.email_logs
CREATE TABLE IF NOT EXISTS `email_logs` (
  `user_id` int(11) DEFAULT NULL,
  `email_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_sent` datetime DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '0 = email verification\r\n1 = send otp\r\n2 = forget password',
  `status` int(4) DEFAULT NULL COMMENT '0 = sent\r\n1 = not sent',
  PRIMARY KEY (`email_log_id`),
  KEY `FK_email_logs_users` (`user_id`),
  CONSTRAINT `FK_email_logs_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.email_logs: ~110 rows (approximately)
DELETE FROM `email_logs`;
INSERT INTO `email_logs` (`user_id`, `email_log_id`, `date_sent`, `type`, `status`) VALUES
	(13, 6, '2023-04-12 16:59:10', 0, 0),
	(15, 8, '2023-04-21 07:00:40', 0, 0),
	(16, 9, '2023-05-01 17:03:02', 0, 0),
	(17, 10, '2023-05-06 23:29:51', 0, 0),
	(13, 11, '2023-05-09 00:14:44', 1, 0),
	(13, 12, '2023-05-09 12:34:13', 1, 0),
	(13, 13, '2023-05-09 12:39:22', 1, 0),
	(13, 14, '2023-05-09 15:47:44', 1, 0),
	(13, 15, '2023-05-09 15:52:39', 1, 0),
	(13, 16, '2023-05-09 15:58:14', 1, 0),
	(13, 17, '2023-05-09 16:02:10', 1, 0),
	(13, 18, '2023-05-09 16:04:38', 1, 0),
	(13, 19, '2023-05-09 16:05:24', 1, 0),
	(13, 20, '2023-05-09 19:38:04', 1, 0),
	(13, 21, '2023-05-09 19:40:31', 1, 0),
	(13, 22, '2023-05-09 19:46:29', 1, 0),
	(13, 23, '2023-05-09 19:47:55', 1, 0),
	(15, 24, '2023-05-09 20:21:01', 1, 0),
	(15, 25, '2023-05-09 20:24:18', 1, 0),
	(15, 26, '2023-05-09 20:26:41', 1, 0),
	(15, 27, '2023-05-09 20:31:41', 1, 0),
	(15, 28, '2023-05-09 20:35:38', 1, 0),
	(15, 29, '2023-05-09 20:39:57', 1, 0),
	(17, 30, '2023-05-09 21:14:23', 1, 0),
	(17, 31, '2023-05-09 21:17:35', 1, 0),
	(17, 32, '2023-05-09 21:19:02', 1, 0),
	(17, 33, '2023-05-09 21:20:41', 1, 0),
	(17, 34, '2023-05-09 21:24:38', 1, 0),
	(17, 35, '2023-05-09 21:27:36', 1, 0),
	(17, 36, '2023-05-09 21:28:39', 1, 0),
	(17, 37, '2023-05-09 21:35:20', 1, 0),
	(17, 38, '2023-05-09 21:38:18', 1, 0),
	(17, 39, '2023-05-09 21:41:57', 1, 0),
	(17, 40, '2023-05-09 21:43:45', 1, 0),
	(17, 41, '2023-05-09 21:49:19', 1, 0),
	(17, 42, '2023-05-09 21:52:20', 1, 0),
	(17, 43, '2023-05-09 21:54:59', 1, 0),
	(17, 44, '2023-05-09 21:57:48', 1, 0),
	(17, 45, '2023-05-09 21:59:15', 1, 0),
	(17, 46, '2023-05-09 22:00:47', 1, 0),
	(17, 47, '2023-05-09 22:01:39', 1, 0),
	(17, 48, '2023-05-09 22:05:32', 1, 0),
	(15, 49, '2023-05-17 14:33:58', 2, 0),
	(15, 50, '2023-05-17 14:38:05', 2, 0),
	(13, 51, '2023-05-17 15:03:32', 2, 0),
	(18, 52, '2023-05-17 15:08:09', 0, 0),
	(13, 53, '2023-05-17 15:13:09', 2, 0),
	(19, 54, '2023-05-18 16:00:22', 0, 0),
	(20, 55, '2023-05-19 00:06:36', 0, 0),
	(13, 56, '2023-05-21 20:37:41', 1, 0),
	(13, 57, '2023-05-21 21:05:15', 1, 0),
	(13, 58, '2023-05-21 21:06:00', 1, 0),
	(13, 59, '2023-05-21 21:08:26', 1, 0),
	(13, 60, '2023-05-21 21:10:21', 1, 0),
	(13, 61, '2023-05-21 21:18:55', 2, 0),
	(13, 62, '2023-05-22 13:57:38', 1, 0),
	(13, 63, '2023-05-22 13:59:28', 1, 0),
	(13, 64, '2023-05-22 14:01:08', 1, 0),
	(13, 65, '2023-05-22 14:04:09', 1, 0),
	(13, 66, '2023-05-22 14:09:10', 1, 0),
	(13, 67, '2023-05-22 14:36:49', 1, 0),
	(13, 68, '2023-05-22 15:24:31', 1, 0),
	(13, 69, '2023-05-22 15:27:44', 1, 0),
	(13, 70, '2023-05-22 15:33:37', 1, 0),
	(13, 71, '2023-05-22 15:47:29', 1, 0),
	(13, 72, '2023-05-22 15:48:47', 1, 0),
	(13, 73, '2023-05-22 15:50:21', 1, 0),
	(13, 74, '2023-05-22 15:51:04', 1, 0),
	(13, 75, '2023-05-22 16:04:41', 1, 0),
	(13, 76, '2023-05-22 16:11:55', 1, 0),
	(13, 77, '2023-05-22 16:21:38', 1, 0),
	(13, 78, '2023-05-22 16:23:13', 1, 0),
	(13, 79, '2023-05-22 16:23:56', 1, 0),
	(13, 80, '2023-05-22 16:24:26', 1, 0),
	(13, 81, '2023-05-22 16:27:53', 1, 0),
	(13, 82, '2023-05-22 16:30:29', 1, 0),
	(13, 83, '2023-05-22 16:33:45', 1, 0),
	(13, 84, '2023-05-22 16:37:19', 1, 0),
	(19, 85, '2023-05-24 16:53:35', 2, 0),
	(13, 86, '2023-05-27 14:43:49', 1, 0),
	(13, 87, '2023-05-27 15:18:10', 1, 0),
	(13, 88, '2023-05-27 15:22:16', 1, 0),
	(13, 89, '2023-05-27 15:24:08', 1, 0),
	(13, 90, '2023-05-27 15:27:12', 1, 0),
	(13, 91, '2023-05-27 15:31:33', 1, 0),
	(13, 92, '2023-05-27 15:32:59', 1, 0),
	(13, 93, '2023-05-27 15:35:18', 1, 0),
	(13, 94, '2023-05-27 15:36:57', 1, 0),
	(13, 95, '2023-05-27 15:38:18', 1, 0),
	(13, 96, '2023-05-27 15:38:23', 1, 0),
	(13, 97, '2023-05-27 15:38:51', 1, 0),
	(13, 98, '2023-05-27 15:39:00', 1, 0),
	(13, 99, '2023-05-27 16:03:38', 1, 0),
	(13, 100, '2023-05-27 16:06:08', 1, 0),
	(13, 101, '2023-05-27 16:06:58', 1, 0),
	(13, 102, '2023-05-27 16:17:47', 1, 0),
	(13, 103, '2023-05-27 16:19:58', 1, 0),
	(13, 104, '2023-05-27 16:26:18', 1, 0),
	(13, 105, '2023-05-27 16:29:13', 1, 0),
	(13, 106, '2023-06-04 01:03:56', 1, 0),
	(13, 109, '2023-06-02 23:01:38', 0, 0),
	(13, 110, '2023-06-03 23:51:07', 0, 0),
	(13, 117, '2023-06-05 21:53:29', 0, 0),
	(19, 118, '2023-06-06 14:13:24', 2, 0),
	(18, 119, '2023-06-10 16:59:26', 2, 0),
	(13, 120, '2023-06-16 15:22:04', 2, 0),
	(25, 121, '2023-06-19 13:34:56', 0, 0),
	(25, 122, '2023-06-19 13:38:46', 0, 0),
	(13, 123, '2023-06-21 13:15:05', 1, 0),
	(13, 124, '2023-06-22 11:35:05', 1, 0),
	(13, 125, '2023-06-23 12:26:20', 0, 0),
	(13, 126, '2023-06-23 12:37:19', 0, 0);

-- Dumping structure for table db_hlms.exercise_list
CREATE TABLE IF NOT EXISTS `exercise_list` (
  `exercise_id` int(6) NOT NULL AUTO_INCREMENT,
  `exercise_name` varchar(50) NOT NULL DEFAULT '',
  `exercise_description` text NOT NULL,
  `exercise_image` varchar(100) DEFAULT NULL,
  `embedded_video` text DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT 0 COMMENT '0 = active\r\n1 = not active',
  PRIMARY KEY (`exercise_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.exercise_list: ~2 rows (approximately)
DELETE FROM `exercise_list`;
INSERT INTO `exercise_list` (`exercise_id`, `exercise_name`, `exercise_description`, `exercise_image`, `embedded_video`, `status`) VALUES
	(1, 'Squats', 'Going down and up in squat position', 'squat.png', '<iframe width="560" height="315" src="https://www.youtube.com/embed/k4s7oCaFURs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>', 0),
	(2, 'Push Ups', 'Goind down and up in push up position', 'push-up.png', '<iframe width="560" height="315" src="https://www.youtube.com/embed/IODxDxX7oi4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>', 1);

-- Dumping structure for table db_hlms.leaderboard_images
CREATE TABLE IF NOT EXISTS `leaderboard_images` (
  `img_id` int(3) NOT NULL AUTO_INCREMENT,
  `img_description` text NOT NULL,
  `img_url` varchar(50) NOT NULL DEFAULT '',
  `img_status` int(2) DEFAULT 0 COMMENT '0 = enable\r\n1 = disable',
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.leaderboard_images: ~3 rows (approximately)
DELETE FROM `leaderboard_images`;
INSERT INTO `leaderboard_images` (`img_id`, `img_description`, `img_url`, `img_status`) VALUES
	(1, 'Image for first place', 'first.png', 0),
	(2, 'Image for second place', 'second.png', 0),
	(3, 'Image for third place', 'third.png', 0);

-- Dumping structure for table db_hlms.page_list
CREATE TABLE IF NOT EXISTS `page_list` (
  `page_id` int(5) NOT NULL AUTO_INCREMENT,
  `url` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.page_list: ~6 rows (approximately)
DELETE FROM `page_list`;
INSERT INTO `page_list` (`page_id`, `url`) VALUES
	(1, 'user-management.php'),
	(2, 'admin-login.php'),
	(3, 'admin-management.php'),
	(4, 'coupon-management.php'),
	(5, 'signout.php'),
	(6, 'access-denied.php');

-- Dumping structure for table db_hlms.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(3) DEFAULT NULL,
  `product_description` text NOT NULL,
  `product_name` varchar(50) NOT NULL DEFAULT '',
  `product_status` int(2) NOT NULL DEFAULT 0 COMMENT '0 = enabled\r\n1 = disabled',
  `product_price` double(8,2) DEFAULT 0.00,
  `product_img_url` varchar(50) DEFAULT NULL,
  `coupon_code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `FK_product_product_category` (`product_category_id`),
  CONSTRAINT `FK_product_product_category` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`product_category_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.product: ~6 rows (approximately)
DELETE FROM `product`;
INSERT INTO `product` (`product_id`, `product_category_id`, `product_description`, `product_name`, `product_status`, `product_price`, `product_img_url`, `coupon_code`) VALUES
	(1, 0, 'Coupon for boost juice:\r\nYou can try other extra fruits too! Drop by our stores and get special coupons for 50% off on any Extra Fruit you want to add to your Berryliciosu Choc Mint, Cookies & Cream or King William Chocolate smoothies! ', 'Boost Juice Coupon', 0, 1.10, 'boost-juice-coupon.jpg', '1KJAOT94'),
	(2, 1, 'Join now to enjoy:\r\n\r\n- 4 weeks FREE\r\n- 2 FREE Personal Training sessions\r\n\r\n\r\nOffer ends 28 Feb 2021.\r\nTerms and conditions apply.', 'Celebrity Fitness Coupon', 0, 2.55, 'celebrity-coupon.jpg', 'GJFI938NCAF'),
	(7, 2, 'Use coupon to get 10% discount on our new dish', 'Salad Atelier Coupon', 0, 1.56, 'salad-atelier-coupon.jpg', 'Q499GUANRI3F'),
	(8, 0, 'This is another test for coupon management add coupon operation only', 'New test coupon', 0, 1.55, '20230607161017000000.png', 'JNSF944NS'),
	(9, 0, 'gefgdsgdafgdgdsfd', 'Test Coupon', 0, 1.55, '20230607161748000000.png', 'sdagdss'),
	(10, 1, 'This is a test to help him get the kind girl', 'Elden Test Coupon', 0, 1.55, '20230623142416000000.jpeg', 'dfgdsgfsa');

-- Dumping structure for table db_hlms.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `product_category_id` int(3) NOT NULL,
  `product_category_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`product_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.product_category: ~3 rows (approximately)
DELETE FROM `product_category`;
INSERT INTO `product_category` (`product_category_id`, `product_category_name`) VALUES
	(0, 'NEW'),
	(1, 'HOT'),
	(2, 'NORMAL');

-- Dumping structure for table db_hlms.product_user_bridge
CREATE TABLE IF NOT EXISTS `product_user_bridge` (
  `product_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `date_purchased` datetime DEFAULT NULL,
  `status` int(3) DEFAULT 0 COMMENT '0 = valid\r\n1 = mo longer valid',
  PRIMARY KEY (`product_user_id`),
  KEY `FK__product` (`product_id`),
  KEY `FK_product_user_bridge_users` (`user_id`),
  CONSTRAINT `FK__product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_product_user_bridge_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.product_user_bridge: ~3 rows (approximately)
DELETE FROM `product_user_bridge`;
INSERT INTO `product_user_bridge` (`product_user_id`, `user_id`, `product_id`, `date_purchased`, `status`) VALUES
	(2, 13, 1, '2023-05-27 16:27:33', 0),
	(3, 13, 2, '2023-05-27 16:30:34', 0),
	(4, 13, 8, '2023-06-22 11:36:42', 0);

-- Dumping structure for table db_hlms.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `initial` tinytext DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `session_id` varchar(10) DEFAULT NULL,
  `user_status` int(3) DEFAULT 0 COMMENT '0 = inactive\r\n1 = active\r\n2 = deactivated',
  `otp` varchar(50) DEFAULT NULL,
  `otp_date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.users: ~9 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `initial`, `password`, `email`, `session_id`, `user_status`, `otp`, `otp_date_created`) VALUES
	(1, 'Adrien', 'Antony', 'AA', '$2y$10$hfPFVYeESgM69dXkg9uh9OfFL4/0dGFb0rQmyUy/6iS', 'adrithone3@gmail.com', 'shfajsdafj', 1, NULL, NULL),
	(13, 'Adrien', 'Antony', 'AA', '$2y$10$S78MA.IrwFTjg/xhxOewq.rzch0cCELzbPOYCaShi56Ch/3P4uk5e', 'adrithone2@gmail.com', '54e7179659', 1, '717647', '2023-06-22 11:35:05'),
	(15, 'Alex', 'Antony', 'AA', '$2y$10$mtXVyplY8018gdD8gpkf6.h2J2KOrdHKdZ9LUeDiiIq', 'adrithone@gmail.com', '2069f17fc9', 1, '627904', '2023-05-09 20:39:57'),
	(16, 'Perry', 'Antony', 'PA', '$2y$10$XNqOeaLEUGFI5hR.aemoM.EMd8W6f/RL3QJA/P1Aljm', 'adrithone4@gmail.com', 'f3805587a8', 1, NULL, NULL),
	(17, 'MARIE CHARLINE', 'Anthony', 'MA', '$2y$10$SjxrcrQY74.NpZv0u1C7jupUe2CC96dXNeqzPbvdVKBVtcR0NNGUK', 'charlthony@gmail.com', '4a5d99efb7', 1, '313745', '2023-05-09 22:05:32'),
	(18, 'Test', 'Antony', 'TA', '$2y$10$42f047BcJiNjG0LSTzxGdObANHt37XRXpA/L1ZMo8U.swqvAXPISa', 'adrithone1@gmail.com', '08ff8d1898', 1, NULL, NULL),
	(19, 'Abhishek', 'Askoolum', 'AA', '$2y$10$yGczNetH92r34VtplxMaSeq9mdHDWEuHW/iL1eBBS6pHFPJSE0mI.', 'abhishekaskoolum@gmail.com', 'a81ab224ed', 1, NULL, NULL),
	(20, 'Dylan', 'Chow', 'DC', '$2y$10$3EqOjLIfZ7D681OSDPzrzOo9mUKw1VWI2SkxPdC7LAI', 'dylanchow32@gmail.com', '436607b739', 1, NULL, NULL),
	(25, 'Test', 'Test', 'TT', '$2y$10$3G.JutTVAY0Q9mRv80H5z.hBt6WJK4Qmn66c.7NKfbxiScFHErlgK', 'adrienantony30@gmail.com', '4de9b22929', 1, NULL, NULL);

-- Dumping structure for table db_hlms.user_reset_password_requests
CREATE TABLE IF NOT EXISTS `user_reset_password_requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_log_id` int(11) NOT NULL,
  `hash_key` varchar(10) NOT NULL DEFAULT '',
  `status` int(2) DEFAULT 0 COMMENT '0 = request not completed\r\n1 = request completed',
  PRIMARY KEY (`request_id`),
  KEY `FK_user_reset_password_requests_email_logs` (`email_log_id`) USING BTREE,
  CONSTRAINT `FK_user_reset_password_requests_email_logs` FOREIGN KEY (`email_log_id`) REFERENCES `email_logs` (`email_log_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.user_reset_password_requests: ~9 rows (approximately)
DELETE FROM `user_reset_password_requests`;
INSERT INTO `user_reset_password_requests` (`request_id`, `email_log_id`, `hash_key`, `status`) VALUES
	(1, 49, 'e502e', 0),
	(2, 50, '878c9f167d', 1),
	(3, 51, '66bd53c008', 1),
	(4, 53, 'cdf69158c8', 1),
	(5, 61, '652f56518a', 0),
	(6, 85, 'e980d9582c', 1),
	(7, 118, '47b02f43ea', 1),
	(8, 119, 'fa629dbfc4', 1),
	(9, 120, 'e05a4ac507', 0);

-- Dumping structure for table db_hlms.user_signin_sessions
CREATE TABLE IF NOT EXISTS `user_signin_sessions` (
  `signin_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(15) NOT NULL DEFAULT '0',
  `signin_date` datetime DEFAULT NULL,
  `token` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`signin_session_id`),
  KEY `FK_user_signin_sessions_users` (`user_id`),
  CONSTRAINT `FK_user_signin_sessions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.user_signin_sessions: ~51 rows (approximately)
DELETE FROM `user_signin_sessions`;
INSERT INTO `user_signin_sessions` (`signin_session_id`, `user_id`, `ip_address`, `signin_date`, `token`) VALUES
	(1, 13, '161.142.154.152', '2023-05-21 00:10:29', '7bd10d'),
	(2, 13, '161.142.154.152', '2023-05-21 00:10:30', 'c0be85'),
	(3, 13, '161.142.154.152', '2023-05-21 00:10:32', '034448'),
	(4, 13, '161.142.154.152', '2023-05-21 00:27:20', 'f94441'),
	(5, 13, '161.142.154.152', '2023-05-21 00:28:50', 'acff39'),
	(6, 13, '161.142.154.152', '2023-05-21 00:29:35', '276bfb'),
	(7, 17, '161.142.154.152', '2023-05-21 20:36:49', 'dd2292'),
	(8, 13, '161.142.154.152', '2023-05-21 20:37:20', 'dfd44d'),
	(9, 13, '161.142.154.152', '2023-05-21 20:42:56', '53a391'),
	(10, 17, '183.171.65.162', '2023-05-22 16:36:34', 'e810dd'),
	(11, 13, '183.171.65.162', '2023-05-22 16:36:57', 'fb514a'),
	(12, 13, '219.93.16.130', '2023-05-23 16:15:53', 'fcdace'),
	(13, 13, '210.19.13.180', '2023-05-23 17:19:17', '22afb0'),
	(14, 13, '161.142.154.152', '2023-05-24 00:41:26', 'debfff'),
	(15, 19, '183.171.31.124', '2023-05-24 16:54:24', 'd27dcb'),
	(16, 13, '161.142.154.152', '2023-05-25 23:27:23', '4cc73c'),
	(17, 13, '183.171.69.224', '2023-05-26 23:15:38', '9f0f00'),
	(18, 17, '102.119.131.246', '2023-05-26 23:17:42', 'd9067e'),
	(19, 13, '161.142.154.152', '2023-05-27 14:49:20', 'dc6700'),
	(20, 13, '161.142.154.152', '2023-05-27 17:08:02', '277f96'),
	(21, 13, '161.142.154.152', '2023-05-27 17:09:06', '700d83'),
	(22, 13, '161.142.154.175', '2023-05-28 20:31:28', '85d4c2'),
	(23, 13, '161.142.154.175', '2023-05-28 21:31:39', '3ad901'),
	(24, 13, '161.142.154.175', '2023-05-28 21:44:41', '310c1e'),
	(25, 13, '210.19.13.180', '2023-05-29 14:24:31', 'dcccc7'),
	(26, 13, '219.93.16.130', '2023-05-29 14:27:10', '133fc1'),
	(27, 13, '210.19.13.180', '2023-05-29 14:38:15', 'bdbe1b'),
	(28, 13, '161.142.154.175', '2023-05-29 17:19:38', '15e089'),
	(29, 13, '219.93.16.130', '2023-05-31 13:12:27', '122ac2'),
	(30, 13, '161.142.154.175', '2023-06-01 23:36:51', '35166e'),
	(31, 13, '115.133.109.76', '2023-06-02 12:06:01', '13231d'),
	(32, 13, '183.171.96.26', '2023-06-02 12:49:16', '1d26de'),
	(33, 17, '161.142.154.175', '2023-06-04 01:03:13', '3dff35'),
	(34, 13, '161.142.154.175', '2023-06-04 01:03:36', 'b9f400'),
	(35, 13, '161.142.154.175', '2023-06-04 23:12:07', '2ebdfb'),
	(36, 13, '161.142.154.175', '2023-06-04 23:12:13', '2854a7'),
	(37, 13, '161.142.154.175', '2023-06-04 23:12:58', '11ac36'),
	(38, 13, '161.142.154.175', '2023-06-04 23:29:39', '39c6fc'),
	(39, 13, '161.142.154.175', '2023-06-04 23:31:30', 'fe3365'),
	(40, 13, '161.142.154.175', '2023-06-04 23:33:04', '7cf668'),
	(41, 13, '183.171.65.66', '2023-06-05 12:59:20', '690ae4'),
	(42, 13, '183.171.107.49', '2023-06-06 13:55:08', '566792'),
	(43, 17, '183.171.107.49', '2023-06-06 14:54:13', '7b3433'),
	(44, 13, '210.19.13.180', '2023-06-07 14:13:32', 'e0cbed'),
	(45, 13, '183.171.107.86', '2023-06-07 14:17:07', '2370f7'),
	(46, 13, '219.93.16.130', '2023-06-07 17:24:57', '1b52d0'),
	(47, 13, '89.38.99.16', '2023-06-10 16:19:53', '09a2d3'),
	(48, 13, '161.142.154.175', '2023-06-10 16:53:28', '2e11da'),
	(49, 13, '161.142.154.175', '2023-06-10 16:59:01', 'c0a66c'),
	(80, 13, '183.171.75.112', '2023-06-28 13:45:29', '90f35a'),
	(81, 13, '183.171.70.204', '2023-06-30 18:22:17', '47c61a');

-- Dumping structure for table db_hlms.value_config
CREATE TABLE IF NOT EXISTS `value_config` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `value_name` varchar(50) NOT NULL DEFAULT '0',
  `value_description` varchar(100) NOT NULL DEFAULT '0',
  `value` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`value_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.value_config: ~0 rows (approximately)
DELETE FROM `value_config`;
INSERT INTO `value_config` (`value_id`, `value_name`, `value_description`, `value`) VALUES
	(1, 'rate_per_reps', 'Represents how much STC that one repetition provides', 0.01);

-- Dumping structure for table db_hlms.wallet_info
CREATE TABLE IF NOT EXISTS `wallet_info` (
  `wallet_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `tron_wallet_address` varchar(100) NOT NULL DEFAULT '0',
  `public_key` varchar(100) NOT NULL DEFAULT '0',
  `private_key` varchar(100) NOT NULL DEFAULT '0',
  `wallet_status` varchar(100) NOT NULL DEFAULT '0' COMMENT '0 = inactive\r\n1 = active',
  PRIMARY KEY (`wallet_id`),
  KEY `FK__users` (`user_id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.wallet_info: ~9 rows (approximately)
DELETE FROM `wallet_info`;
INSERT INTO `wallet_info` (`wallet_id`, `user_id`, `tron_wallet_address`, `public_key`, `private_key`, `wallet_status`) VALUES
	(1, 15, 'TDbw26AxjgT8Y4ThxLwccxvHENc17EzwvK', '04D8C1B71CDD6DF706EE0C617E746A495AE730474809A9DA4C3F923186F1E1C4A94EC0634BE26E6E5F528BAC2CE9295FBEA8', '5847219100CC07E16862C76A7ACD5DAAFDF1888C32CC9AD94EA07E30F1367492', '1'),
	(2, 13, 'TWadmBLdDwcmQqeh2XHK8a8GRqae52RY9z', '0', '6e6fbe3db645141c9f5f330c9df07bc60f1d6f4e8a1f5a750722a9b5b5e073f5', '1'),
	(3, 1, 'TVrcfoJFMhAif32ywcmtcU3huMCYvoXgj3', '0', '944a9be77c7cfd93d6829b61d1f78a5ff4b51b76529bb2502f0bf342e2b98e02', '1'),
	(7, 16, 'TLqz9wPHgng1fyxsT8qjqwc3nYJY64YGUm', '04BFE606CEB96B4D0BB081D80566F1152D9131C49C0EED4006679BA55618C801A2F451B234848C872A080E149FEEE4B99507', '914BECF166D48F5EE80EA55A6C4A9A6955AFFBD00256E9A82A49F77FD049AD4A', '1'),
	(8, 17, 'TU61hWLqVgoMd1hvp89XkCGDHegxu1vLNX', '0485CB10BF2ABE8A871F6AFE7BB51E1C9668A424A81EC0AE81173F45C04E4014BFFA1901FE3B6A496C43A6E7FC48F6D10ABF', 'EE6213C5EEFAE9AB593BEC1AB8374BDFAFCEDD5ED9E391BA62846F9EDD6CC90A', '1'),
	(10, 18, 'TF6eHBRLetnbPdyuK6xbVvsCZwG1RSusbi', '0472232B7A9949D74227742D6DC7F25F1D18BE89F19F3DC0A797AD82573736A9ECACB3EDB32A10C5B7F7E3E598CF94046ABA', 'F6C745DFA6F9F86041DB55B9F1DA370932488251834D1940B0A8B4FA8887E373', '1'),
	(11, 19, 'TWu7KdbiUbfegDZbKtfW3LFzNAeZ5rdMmt', '0487A6B944F503378DCB4A1903B7CEB6750A8C61FB02F3848E2ED5433497A436AA27B7A8D6E306C72077476E22B092CFD316', '6270630C6B709D5B974FF25A4B45466F9EEDDA1E38888366DA01E00BDAA1B2A0', '0'),
	(12, 20, 'TJuBZVprPXTxTXCSz7S1bcrC8aSHF2si2T', '0463AA34679CF2F9ECB40CDDC19754E4A2B54DD7EFCBE6F6534855A38D062F7412EA75FB1718BA4480A632FE02F646B91E95', '1F888FB8C8068EA92253D0DB5FD019F4F0223C5D4C799C8156B59EF1BB2409AF', '1'),
	(14, 25, 'TLfbTQr3RmW5gm9zk294rjiD3g5xYT2ci1', '04537A37420E1C1A376E5170195E6306B5BA65F81D38E0599A8D34B9C05423BD0C497E6A26DC8BA3D7AA94ABD3C7395E6F0A', 'B38C510E5B3493F6D0BB0245E7C87507A848B6867156C6BB5812A26AB068646C', '1');

-- Dumping structure for table db_hlms.wallet_transactions
CREATE TABLE IF NOT EXISTS `wallet_transactions` (
  `wallet_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` int(4) DEFAULT 0 COMMENT '1 = receive from / transfer to other user\r\n2 = receive from exercise achievements\r\n3 = coupon payment',
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT 0,
  `stc_amount` double DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `status` int(4) DEFAULT 0 COMMENT '0 = pending\r\n1 = success\r\n2 = failure',
  PRIMARY KEY (`wallet_transaction_id`) USING BTREE,
  KEY `FK_wallet_history_users` (`sender_id`),
  KEY `FK_wallet_history_users_2` (`receiver_id`),
  CONSTRAINT `FK_wallet_history_users` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `FK_wallet_history_users_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_hlms.wallet_transactions: ~41 rows (approximately)
DELETE FROM `wallet_transactions`;
INSERT INTO `wallet_transactions` (`wallet_transaction_id`, `transaction_type`, `sender_id`, `receiver_id`, `stc_amount`, `date_created`, `status`) VALUES
	(9, 2, NULL, 13, 0.02, '2023-05-04 20:30:55', 1),
	(14, 2, NULL, 13, 0.03, '2023-05-04 21:35:11', 1),
	(15, 2, NULL, 13, 0.04, '2023-05-05 22:22:47', 1),
	(16, 2, NULL, 13, 0.05, '2023-05-08 16:37:03', 1),
	(17, 1, 17, 1, 1, '2023-05-09 22:01:51', 1),
	(18, 2, NULL, 13, 0.06, '2023-05-12 23:06:51', 1),
	(19, 2, NULL, 13, 0.07, '2023-05-15 22:46:30', 1),
	(20, 2, NULL, 20, 0.16, '2023-05-19 00:10:52', 1),
	(21, 2, NULL, 20, 0, '2023-05-19 00:11:12', 1),
	(22, 2, NULL, 20, 0, '2023-05-19 00:11:14', 1),
	(23, 2, NULL, 20, 0, '2023-05-19 00:11:27', 1),
	(24, 2, NULL, 20, 0, '2023-05-19 00:11:36', 1),
	(25, 2, NULL, 13, 0.08, '2023-05-19 00:15:26', 1),
	(26, 1, 13, 17, 10, '2023-05-21 20:38:23', 1),
	(27, 1, 13, 17, 10, '2023-05-21 21:05:43', 1),
	(28, 1, 13, 1, 5, '2023-05-21 21:06:21', 1),
	(29, 1, 13, 17, 5, '2023-05-21 21:08:46', 1),
	(30, 1, 13, 17, 5, '2023-05-21 21:10:43', 1),
	(31, 1, 13, 17, 2, '2023-05-22 13:58:13', 1),
	(32, 1, 13, 17, 2, '2023-05-22 13:59:57', 1),
	(33, 1, 13, 17, 1, '2023-05-22 14:01:26', 1),
	(34, 1, 13, 17, 1, '2023-05-22 14:04:37', 1),
	(35, 1, 13, 17, 1, '2023-05-22 14:09:30', 1),
	(36, 1, 13, 17, 1, '2023-05-22 14:37:08', 1),
	(37, 1, 13, 17, 1, '2023-05-22 15:25:26', 1),
	(38, 1, 13, 17, 1, '2023-05-22 15:30:58', 1),
	(39, 1, 13, 17, 1, '2023-05-22 15:34:07', 1),
	(40, 1, 13, 17, 1, '2023-05-22 15:47:51', 1),
	(41, 1, 13, 17, 1, '2023-05-22 15:49:21', 1),
	(42, 1, 13, 17, 1, '2023-05-22 15:51:26', 1),
	(43, 1, 13, 17, 1, '2023-05-22 16:05:59', 1),
	(44, 1, 13, 17, 1, '2023-05-22 16:13:46', 1),
	(45, 1, 13, 17, 1, '2023-05-22 16:25:50', 1),
	(46, 1, 13, 17, 1, '2023-05-22 16:31:53', 1),
	(47, 1, 13, 17, 1, '2023-05-22 16:35:05', 1),
	(48, 2, NULL, 13, 0.09, '2023-05-23 17:20:50', 1),
	(50, 3, 13, NULL, 1.1, '2023-05-27 16:27:33', 1),
	(51, 3, 13, NULL, 2.55, '2023-05-27 16:30:34', 1),
	(53, 2, NULL, 13, 0.1, '2023-05-31 20:13:58', 1),
	(55, 1, 13, 17, 1, '2023-06-04 01:05:32', 1),
	(56, 2, NULL, 13, 0.11, '2023-06-10 17:06:35', 1),
	(57, 3, 13, NULL, 1.55, '2023-06-22 11:36:42', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
