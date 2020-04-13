-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2020 at 05:10 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gogetter_project`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateAfterChallEnd` ()  BEGIN
    DECLARE play1 INTEGER DEFAULT 0;
    DECLARE play2 INTEGER DEFAULT 0;
    DECLARE play3 INTEGER DEFAULT 0;
    DECLARE play4 INTEGER DEFAULT 0;
    DECLARE play5 INTEGER DEFAULT 0;
	 DECLARE finished INTEGER DEFAULT 0;
     DECLARE cchall_id INTEGER DEFAULT 0;
     DECLARE winner_id INTEGER DEFAULT 0;
     -- declare challid for when chall reach due
     DEClARE curChall_ID
     CURSOR FOR 
     	SELECT `chall_id` FROM challenges where `chall_due_date` = CURRENT_DATE
     	AND `winner_fk` = '0';
        
        -- declare NOT FOUND handler
    DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
 
    OPEN curChall_ID;
 
    updateChallDue: LOOP
        FETCH curChall_ID INTO cchall_id;
        IF finished = 1 THEN 
            LEAVE updateChallDue;
        END IF;
        
        SELECT SUM(player1_score) AS play1 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player2_score) AS play2 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player3_score) AS play3 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player4_score) AS play4 FROM challenge_record WHERE fk_challenge_id = cchall_id;
        SELECT SUM(player5_score) AS play5 FROM challenge_record WHERE fk_challenge_id = cchall_id;

        if play1 > play2 AND play1 > play3 AND play1 > play4 AND
        	play1 > play5	THEN 
            SELECT `chall_creator_fk` AS winner_id FROM challenges WHERE chall_id = cchall_id;END IF;
        if play2 > play1 AND play2 > play3 AND play2 > play4 AND
        	play2 > play5	THEN 
            SELECT `chall_invite2` AS winner_id FROM challenges WHERE chall_id = cchall_id;END IF;
        if play3 > play1 AND play3 > play2 AND play3 > play4 AND
        	play3 > play5	THEN 
            SELECT `chall_invite3` AS winner_id FROM challenges WHERE chall_id = cchall_id;END IF;
        if play4 > play1 AND play4 > play2 AND play4 > play3 AND
        	play4 > play5	THEN 
            SELECT `chall_invite4` AS winner_id FROM challenges WHERE chall_id = cchall_id;END IF;
        if play5 > play1 AND play5 > play2 AND play5 > play3 AND
        	play5 > play4	THEN 
            SELECT `chall_invite5` AS winner_id FROM challenges WHERE chall_id = cchall_id;END IF;

        -- SET emailList = CONCAT(emailAddress,";",emailList);
        UPDATE challenges SET winner_fk = winner_id WHERE chall_id = cchall_id;
    END LOOP updateChallDue;
    CLOSE curChall_ID;
    commit;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateChallinviteExp` ()  BEGIN
     DECLARE V_chall_accept1 VARCHAR(1) DEFAULT 'P';
     DECLARE V_chall_accept2 VARCHAR(1) DEFAULT 'P';
     DECLARE V_chall_accept3 VARCHAR(1) DEFAULT 'P';
     DECLARE V_chall_accept4 VARCHAR(1) DEFAULT 'P';
     DECLARE V_chall_accept5 VARCHAR(1) DEFAULT 'P';
	 DECLARE finished INTEGER DEFAULT 0;
     DECLARE cchall_id INTEGER DEFAULT 0;

     -- declare challid for when chall reach invitation expire
     DEClARE curChall_ID
     CURSOR FOR 
     	SELECT `chall_id`,`chall_accept1`,`chall_accept2`,`chall_accept3`,`chall_accept4`,`chall_accept5` FROM `challenges` WHERE `chall_invite_expire` < CURRENT_DATE ;

        
    -- declare NOT FOUND handler
    DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
 
    OPEN curChall_ID;
 	-- update the challenge when participants not accepting challenge
    -- after reach expire for invitation
    updateChallExp: LOOP
        FETCH curChall_ID INTO cchall_id,V_chall_accept1,V_chall_accept2,V_chall_accept3,V_chall_accept4,V_chall_accept5;
        IF finished = 1 THEN 
            LEAVE updateChallExp;
        END IF;

        if V_chall_accept1 = 'P' THEN 
            UPDATE challenges SET chall_accept1 = 'E' WHERE chall_id = cchall_id;END IF;
        if V_chall_accept2 = 'P' THEN 
            UPDATE challenges SET chall_accept2 = 'E' WHERE chall_id = cchall_id;END IF;
        if V_chall_accept3 = 'P' THEN 
            UPDATE challenges SET chall_accept3 = 'E' WHERE chall_id = cchall_id;END IF;
        if V_chall_accept4 = 'P' THEN 
            UPDATE challenges SET chall_accept4 = 'E' WHERE chall_id = cchall_id;END IF;
        if V_chall_accept5 = 'P' THEN 
            UPDATE challenges SET chall_accept5 = 'E' WHERE chall_id = cchall_id;END IF;
        
    END LOOP updateChallExp;
    CLOSE curChall_ID;
    commit;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified_status` tinyint(1) NOT NULL,
  `verifying_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `username`, `email`, `password`, `verified_status`, `verifying_hash`) VALUES
(2, 'admin', 'mvpng99@hotmail.my', '$2y$10$NKualyRrAwzWQ7Ptwu6YJOpqXJxaKjBt1cEzjgO5fPvrAXpXjzpGC', 1, '42e7aaa88b48137a16a1acd04ed91125'),
(3, 'admin2', 'wenjianc@outlook.com', '$2y$10$QSQQAw9q/N/3KI2ZZBKR2./NECChy9M4HVhbM5pT8Il6f/XMykbFG', 1, 'cf67355a3333e6e143439161adc2d82e');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(40) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`, `date_created`) VALUES
(1, 'Healthy', '2020-04-13 00:43:46'),
(2, 'Diet', '2020-04-13 00:43:54'),
(3, 'Beauty', '2020-04-13 00:44:00'),
(4, 'Sport', '2020-04-13 00:44:12'),
(5, 'Study', '2020-04-13 00:44:18'),
(6, 'Education', '2020-04-13 00:44:25'),
(7, 'Family', '2020-04-13 00:44:33'),
(8, 'Pets', '2020-04-13 00:44:40'),
(9, 'Finance', '2020-04-13 00:44:48'),
(10, 'Addiction', '2020-04-13 00:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `chall_id` int(255) NOT NULL,
  `chall_name` varchar(50) NOT NULL,
  `chall_desc` varchar(500) NOT NULL,
  `created_date` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `chall_creator_fk` int(255) NOT NULL,
  `chall_invite2` int(255) NOT NULL,
  `chall_invite3` int(255) NOT NULL,
  `chall_invite4` int(255) NOT NULL,
  `chall_invite5` int(255) NOT NULL,
  `chall_accept1` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'E Expired A Accepted Q Quit P Pending',
  `chall_accept2` varchar(1) NOT NULL DEFAULT 'P' COMMENT 'E Expired A Accepted Q Quit P Pending',
  `chall_accept3` varchar(1) NOT NULL DEFAULT 'P' COMMENT 'E Expired A Accepted Q Quit P Pending',
  `chall_accept4` varchar(1) NOT NULL DEFAULT 'P' COMMENT 'E Expired A Accepted Q Quit P Pending',
  `chall_accept5` varchar(1) NOT NULL DEFAULT 'P' COMMENT 'E Expired A Accepted Q Quit P Pending',
  `chall_start_day` date NOT NULL,
  `chall_invite_expire` date NOT NULL,
  `chall_due_date` date NOT NULL,
  `chall_check_interval` int(10) NOT NULL,
  `chall_picture` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `chall_reward_points` int(11) NOT NULL,
  `reward_accepted` tinyint(1) NOT NULL,
  `winner_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`chall_id`, `chall_name`, `chall_desc`, `created_date`, `chall_creator_fk`, `chall_invite2`, `chall_invite3`, `chall_invite4`, `chall_invite5`, `chall_accept1`, `chall_accept2`, `chall_accept3`, `chall_accept4`, `chall_accept5`, `chall_start_day`, `chall_invite_expire`, `chall_due_date`, `chall_check_interval`, `chall_picture`, `chall_reward_points`, `reward_accepted`, `winner_fk`) VALUES
(3, 'Sprint Meeting', 'Have Sprint meeting with Lecturer', '2020-04-13 02:15:07.147346', 20, 22, 0, 0, 0, 'A', 'E', 'E', 'E', 'E', '2020-02-27', '2020-02-14', '2020-02-18', 0, '', 5, 0, 0),
(4, 'Self Quarantine', 'To get rid of Covid 19', '2020-04-13 02:16:02.214583', 20, 22, 0, 0, 0, 'A', 'E', 'E', 'E', 'E', '2020-02-21', '2020-02-14', '2020-02-29', 0, '', 8, 0, 0),
(17, 'Not to get out', 'Prevent to infect by Covid', '2020-04-13 02:18:33.349761', 20, 22, 0, 0, 0, 'A', 'A', 'E', 'E', 'E', '2020-02-28', '2020-03-12', '2020-03-13', 0, '', 9, 0, 22),
(23, 'Grind for FYP', 'Score well in fyp', '2020-04-13 03:06:23.143776', 20, 22, 0, 0, 0, 'A', 'A', 'E', 'E', 'E', '2020-02-14', '2020-02-07', '2020-05-01', 0, 'default.png', 1, 0, 0),
(24, 'Work Hard for Final', 'Graduate with first class honour', '2020-04-13 03:06:45.434146', 27, 20, 22, 0, 0, 'A', 'A', 'E', 'E', 'E', '2020-02-29', '2020-02-28', '2020-03-31', 0, 'default.jpg', 50, 0, 0),
(25, 'Stop getting lazy in everything', 'To prevent mess thing up', '2020-04-13 03:07:12.110308', 20, 22, 27, 24, 0, 'A', 'A', 'A', 'A', 'P', '2020-03-12', '2020-03-20', '2020-07-09', 0, 'default.jpg', 10, 0, 0),
(26, 'Having good time management', 'So all of us can plan our thing and everything work fine.', '2020-04-13 03:07:51.350336', 20, 22, 27, 24, 0, 'A', 'A', 'E', 'E', 'E', '2020-03-13', '2020-03-13', '2020-04-30', 0, 'default.jpg', 1, 0, 0),
(28, 'Make Program work in first time compiling', 'No basic syntax error were made in development', '2020-04-13 03:09:05.845571', 22, 20, 0, 0, 0, 'Q', 'P', 'P', 'P', 'P', '2020-03-21', '2020-03-20', '2020-04-23', 0, 'default.jpg', 1, 0, 0),
(66, 'KDU House Keeping', 'Help KDU to clean around, not only department but the whole Penang KDU Campus.', '2020-04-13 02:13:41.000000', 20, 24, 0, 0, 0, 'A', 'P', 'P', 'P', 'P', '2020-04-16', '2020-04-15', '2020-04-17', 0, 'default.jpg', 48, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `challenge_record`
--

CREATE TABLE `challenge_record` (
  `rating_id` int(11) NOT NULL,
  `fk_challenge_id` int(11) NOT NULL,
  `fk_rater_id` int(11) NOT NULL,
  `player1_score` int(1) NOT NULL,
  `player2_score` int(1) NOT NULL,
  `player3_score` int(1) NOT NULL,
  `player4_score` int(1) NOT NULL,
  `player5_score` int(1) NOT NULL,
  `recorded_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `challenge_record`
--

INSERT INTO `challenge_record` (`rating_id`, `fk_challenge_id`, `fk_rater_id`, `player1_score`, `player2_score`, `player3_score`, `player4_score`, `player5_score`, `recorded_time`) VALUES
(14, 17, 20, 4, 4, 0, 0, 0, '2020-03-01 21:14:06'),
(15, 17, 20, 1, 5, 0, 0, 0, '2020-03-02 11:08:40'),
(16, 17, 20, 2, 5, 0, 0, 0, '2020-03-05 21:23:46'),
(17, 17, 20, 4, 5, 0, 0, 0, '2020-03-12 22:01:53'),
(18, 25, 20, 3, 4, 2, 5, 0, '2020-03-13 01:13:13'),
(19, 25, 22, 3, 2, 5, 3, 0, '2020-03-14 20:10:30'),
(20, 23, 20, 2, 3, 0, 0, 0, '2020-03-19 18:36:50'),
(21, 24, 20, 4, 2, 3, 0, 0, '2020-03-19 18:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `common_goals`
--

CREATE TABLE `common_goals` (
  `goals_id` int(60) NOT NULL,
  `goals_name` varchar(50) NOT NULL,
  `category` int(11) NOT NULL,
  `goals_desc` varchar(2000) NOT NULL,
  `goals_picture` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `common_goals`
--

INSERT INTO `common_goals` (`goals_id`, `goals_name`, `category`, `goals_desc`, `goals_picture`, `date_created`) VALUES
(1, 'Not To Play facebook', 10, 'Do Something that is more interesting than playing Facebook. For example, chatting with family, exercise etc', 'facebook.jpg', '2020-04-13 00:51:13'),
(2, 'Run in the morning', 4, 'To strengthen your immune system, on the other hand it could also train your stamina.', 'running.jpg', '2020-04-13 01:44:56'),
(3, 'Drink Water', 1, 'Drinking water can help maintain the balance of body fluids, where body fluids are include digestion, absorption, circulation, creation of saliva and maintenance of body temperature.\r\n', 'default.jpg', '2020-04-13 02:06:50'),
(4, 'Apply Mask', 3, 'Applying mask is the best skin care treatment that you can do at home. It can help you with your skin care concerns and if you were chosen the right one for you, it can help you to hydrate skin, remove excess oils and help improve the appearance of your pores.', 'default.jpg', '2020-04-13 02:06:47'),
(5, 'Eating Salad', 2, 'It helps to sharpen your eyesight, preventing your body against high-energy light that may have caused eye damage. Eating salad also can reduce the amount of calories from your body.\r\n', 'default.jpg', '2020-04-13 02:06:43'),
(7, 'Get a study schedule', 5, 'So that you can identify your available time, so you can spent those time on revision about what lecturer or teacher has taught. Having a schedule also can help you to schedule essential action.', 'default.jpg', '2020-04-13 01:50:11'),
(14, 'Be determined', 6, 'Always be determined so that you always can accomplish the tasks assigned despite any disheartening circumstances or remarks. Always ignore those who are invalidating the worth of your life goals and focus on your task.', 'default.jpg', '2020-04-13 01:52:40'),
(15, 'Always Keep in touch with your family', 7, 'Enjoy leisure time as a family. Father and mother are always want to spent time with you because you are the gift from the God for them.', 'default.jpg', '2020-04-13 02:07:19'),
(16, 'Get a pet', 8, 'Get a pet for yourself. Try to be responsible to your pet, treat it as your son or daughter. It would be wonderful if you willing to spent time with them ', 'default.jpg', '2020-04-13 01:56:44'),
(17, 'Save your extra money everyday', 9, 'Get to the habit of saving money everyday. The money you have saved could be used for a vacation or building as an emergency fund. So when there is any emergency case and required money, then it won\'t be a problem.', 'default.jpg', '2020-04-13 01:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `goals_followed`
--

CREATE TABLE `goals_followed` (
  `goal_followed_id` int(255) NOT NULL,
  `goals_fk` int(11) NOT NULL,
  `goals_follower_fk` int(11) NOT NULL,
  `reminder_time` time NOT NULL,
  `sunday` tinyint(1) NOT NULL DEFAULT '0',
  `monday` tinyint(1) NOT NULL DEFAULT '0',
  `tuesday` tinyint(1) NOT NULL DEFAULT '0',
  `wednesday` tinyint(1) NOT NULL DEFAULT '0',
  `thusday` tinyint(1) NOT NULL DEFAULT '0',
  `friday` tinyint(1) NOT NULL DEFAULT '0',
  `saturday` tinyint(1) NOT NULL DEFAULT '0',
  `goal_counts` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `goals_followed`
--

INSERT INTO `goals_followed` (`goal_followed_id`, `goals_fk`, `goals_follower_fk`, `reminder_time`, `sunday`, `monday`, `tuesday`, `wednesday`, `thusday`, `friday`, `saturday`, `goal_counts`) VALUES
(120, 3, 20, '12:30:00', 1, 1, 1, 1, 1, 1, 0, 0),
(121, 2, 20, '06:15:00', 1, 0, 1, 1, 0, 1, 0, 0),
(122, 5, 22, '02:10:00', 1, 0, 0, 1, 0, 1, 1, 0),
(123, 4, 20, '01:40:00', 1, 1, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `goal_record`
--

CREATE TABLE `goal_record` (
  `goal_record_id` int(255) NOT NULL,
  `following_goal_fk` int(11) NOT NULL,
  `checked_date` date NOT NULL,
  `goal_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `goal_record`
--

INSERT INTO `goal_record` (`goal_record_id`, `following_goal_fk`, `checked_date`, `goal_desc`) VALUES
(4, 121, '2020-02-09', 'yaaaay'),
(5, 120, '2020-02-09', 'MieowFuuu'),
(6, 122, '2020-02-20', ''),
(21, 121, '2020-02-22', ''),
(22, 120, '2020-02-23', 'Babi buuu888'),
(23, 120, '2020-02-23', 'Babi buuu7787777'),
(24, 121, '2020-02-24', 'done today friend li'),
(25, 121, '2020-03-02', 'yaaaay'),
(26, 121, '2020-03-12', 'GOOOD'),
(27, 121, '2020-03-13', 'yaaaay34234'),
(28, 123, '2020-03-13', 'asd'),
(29, 121, '2020-03-14', 'mieow'),
(30, 123, '2020-03-15', 'miewooosss'),
(31, 121, '2020-03-15', 'asssssssssssssssssss'),
(32, 122, '2020-03-20', 'coronaa time right n');

-- --------------------------------------------------------

--
-- Table structure for table `goal_target`
--

CREATE TABLE `goal_target` (
  `goal_target_id` int(11) NOT NULL,
  `following_goal_fk` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `expected_times` int(11) NOT NULL,
  `targeted_times` int(11) NOT NULL DEFAULT '0',
  `goal_rewarded` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `goal_target`
--

INSERT INTO `goal_target` (`goal_target_id`, `following_goal_fk`, `start_date`, `end_date`, `expected_times`, `targeted_times`, `goal_rewarded`) VALUES
(2, 121, '2020-03-01', '2020-03-13', 25, 4, 1),
(3, 123, '2020-03-12', '2020-04-24', 43, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `friend_id` int(11) NOT NULL,
  `inviter_fk` int(11) NOT NULL,
  `addperson_fk` int(11) NOT NULL,
  `inviter_status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'Accept A Block B Pending P',
  `acceptbyperson` varchar(1) NOT NULL DEFAULT 'P' COMMENT 'Accept A Block B Pending P	'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`friend_id`, `inviter_fk`, `addperson_fk`, `inviter_status`, `acceptbyperson`) VALUES
(2, 20, 24, 'A', 'A'),
(3, 24, 22, 'A', 'P'),
(6, 27, 22, 'A', 'A'),
(8, 26, 20, 'A', 'P'),
(9, 20, 28, 'A', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `uemail` varchar(60) NOT NULL,
  `upassword` varchar(255) NOT NULL,
  `upoints` int(255) NOT NULL,
  `uprof_pic` varchar(100) NOT NULL DEFAULT 'default.png' COMMENT 'profile picture',
  `bio_data` varchar(3000) NOT NULL,
  `verified_status` tinyint(1) NOT NULL DEFAULT '0',
  `verifying_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `uemail`, `upassword`, `upoints`, `uprof_pic`, `bio_data`, `verified_status`, `verifying_hash`) VALUES
(0, 'None', '', '', 0, 'default.png', '', 0, ''),
(2, 'gyy', 'yikyek@hotmail.com', '123123', 0, '9b6ec50b0cea0f8a2c00cc64b7b4e682.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 'hash'),
(20, 'dasani', 'yikyekgo@gmail.com', '$2y$10$6A7l6QVii.OVJ9N9X4wQAu19y.iGIbMwwfqqeJr8MAa54e4IxTHLm', 0, '3dcda28e2df667c9c3a85d3ccced6c90.jpg', 'zxcxzxzc', 1, ''),
(22, 'dasani1', 'yikyekgo1@gmail.com', '$2y$10$6A7l6QVii.OVJ9N9X4wQAu19y.iGIbMwwfqqeJr8MAa54e4IxTHLm', 49, '7ff3184b0e3d5d549e9bb31e8dcd5ad5.png', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, ''),
(24, 'dasani2', 'yikyekgo2@gmail.com', '$2y$10$6A7l6QVii.OVJ9N9X4wQAu19y.iGIbMwwfqqeJr8MAa54e4IxTHLm', 60, '9b6ec50b0cea0f8a2c00cc64b7b4e682.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, ''),
(25, 'dasani3', 'yikyekgo3@gmail.com', '$2y$10$6A7l6QVii.OVJ9N9X4wQAu19y.iGIbMwwfqqeJr8MAa54e4IxTHLm', 60, '9b6ec50b0cea0f8a2c00cc64b7b4e682.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, ''),
(26, 'dasani4', 'yikyekgo4@gmail.com', '$2y$10$6A7l6QVii.OVJ9N9X4wQAu19y.iGIbMwwfqqeJr8MAa54e4IxTHLm', 60, '9b6ec50b0cea0f8a2c00cc64b7b4e682.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, ''),
(27, 'dasani5', 'yikyekgo5@gmail.com', '$2y$10$6A7l6QVii.OVJ9N9X4wQAu19y.iGIbMwwfqqeJr8MAa54e4IxTHLm', 450, '9b6ec50b0cea0f8a2c00cc64b7b4e682.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, ''),
(28, 'dasani6', 'yikyekgo6@gmail.com', '$2y$10$6A7l6QVii.OVJ9N9X4wQAu19y.iGIbMwwfqqeJr8MAa54e4IxTHLm', 60, '9b6ec50b0cea0f8a2c00cc64b7b4e682.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`chall_id`),
  ADD KEY `chall_creator_fk` (`chall_creator_fk`),
  ADD KEY `chall_invite2` (`chall_invite2`),
  ADD KEY `chall_invite3` (`chall_invite3`),
  ADD KEY `chall_invite4` (`chall_invite4`),
  ADD KEY `chall_invite5` (`chall_invite5`),
  ADD KEY `winner_fk` (`winner_fk`);

--
-- Indexes for table `challenge_record`
--
ALTER TABLE `challenge_record`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `fk_challenge_id` (`fk_challenge_id`),
  ADD KEY `fk_rater_id` (`fk_rater_id`);

--
-- Indexes for table `common_goals`
--
ALTER TABLE `common_goals`
  ADD PRIMARY KEY (`goals_id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `goals_followed`
--
ALTER TABLE `goals_followed`
  ADD PRIMARY KEY (`goal_followed_id`),
  ADD KEY `goals_fk` (`goals_fk`),
  ADD KEY `goals_follower_fk` (`goals_follower_fk`);

--
-- Indexes for table `goal_record`
--
ALTER TABLE `goal_record`
  ADD PRIMARY KEY (`goal_record_id`),
  ADD KEY `following_goal_fk` (`following_goal_fk`);

--
-- Indexes for table `goal_target`
--
ALTER TABLE `goal_target`
  ADD PRIMARY KEY (`goal_target_id`),
  ADD KEY `following_goal_fk` (`following_goal_fk`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`friend_id`),
  ADD KEY `inviter_fk` (`inviter_fk`),
  ADD KEY `addperson_fk` (`addperson_fk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `chall_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `challenge_record`
--
ALTER TABLE `challenge_record`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `common_goals`
--
ALTER TABLE `common_goals`
  MODIFY `goals_id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `goals_followed`
--
ALTER TABLE `goals_followed`
  MODIFY `goal_followed_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `goal_record`
--
ALTER TABLE `goal_record`
  MODIFY `goal_record_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `goal_target`
--
ALTER TABLE `goal_target`
  MODIFY `goal_target_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `relationship`
--
ALTER TABLE `relationship`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_ibfk_1` FOREIGN KEY (`chall_creator_fk`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `challenges_ibfk_2` FOREIGN KEY (`chall_invite2`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `challenges_ibfk_3` FOREIGN KEY (`chall_invite3`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `challenges_ibfk_4` FOREIGN KEY (`chall_invite4`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `challenges_ibfk_5` FOREIGN KEY (`chall_invite5`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `challenges_ibfk_6` FOREIGN KEY (`winner_fk`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `challenge_record`
--
ALTER TABLE `challenge_record`
  ADD CONSTRAINT `challenge_record_ibfk_1` FOREIGN KEY (`fk_challenge_id`) REFERENCES `challenges` (`chall_id`),
  ADD CONSTRAINT `challenge_record_ibfk_2` FOREIGN KEY (`fk_rater_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `common_goals`
--
ALTER TABLE `common_goals`
  ADD CONSTRAINT `common_goals_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `goals_followed`
--
ALTER TABLE `goals_followed`
  ADD CONSTRAINT `goals_followed_ibfk_1` FOREIGN KEY (`goals_fk`) REFERENCES `common_goals` (`goals_id`),
  ADD CONSTRAINT `goals_followed_ibfk_2` FOREIGN KEY (`goals_follower_fk`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `goal_record`
--
ALTER TABLE `goal_record`
  ADD CONSTRAINT `goal_record_ibfk_1` FOREIGN KEY (`following_goal_fk`) REFERENCES `goals_followed` (`goal_followed_id`);

--
-- Constraints for table `goal_target`
--
ALTER TABLE `goal_target`
  ADD CONSTRAINT `goal_target_ibfk_1` FOREIGN KEY (`following_goal_fk`) REFERENCES `goals_followed` (`goal_followed_id`);

--
-- Constraints for table `relationship`
--
ALTER TABLE `relationship`
  ADD CONSTRAINT `relationship_ibfk_1` FOREIGN KEY (`inviter_fk`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `relationship_ibfk_2` FOREIGN KEY (`addperson_fk`) REFERENCES `user` (`user_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `Event_UpdateAfterChallEnd` ON SCHEDULE EVERY 2 MINUTE STARTS '2020-03-14 20:57:37' ON COMPLETION NOT PRESERVE ENABLE DO CALL UpdateAfterChallEnd()$$

CREATE DEFINER=`root`@`localhost` EVENT `Event_UpdateAfterChallExpire` ON SCHEDULE EVERY 2 MINUTE STARTS '2020-03-13 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL updateChallinviteExp()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
