-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 13.67.68.175
-- Thời gian đã tạo: Th4 17, 2021 lúc 05:07 PM
-- Phiên bản máy phục vụ: 5.7.33-0ubuntu0.18.04.1
-- Phiên bản PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `SportShop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `contribution_id` int(3) NOT NULL,
  `userId` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `date`, `contribution_id`, `userId`) VALUES
(69, 'k,j,km', '2021-04-17 17:50:40', 36, 36),
(70, '3333', '2021-04-17 17:56:25', 36, 36),
(71, 'Oke', '2021-04-17 17:57:55', 36, 40);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contributions`
--

CREATE TABLE `contributions` (
  `contribution_id` int(3) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` text NOT NULL,
  `file` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `upload_date` datetime NOT NULL,
  `student_id` int(3) NOT NULL,
  `faculty_id` int(3) NOT NULL,
  `notes` text NOT NULL,
  `topicId` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `contributions`
--

INSERT INTO `contributions` (`contribution_id`, `name`, `image`, `file`, `status`, `upload_date`, `student_id`, `faculty_id`, `notes`, `topicId`) VALUES
(36, 'SÃ­iss', '1618674964-pexels-aleksandar-ljubicic-4809149.jpg', '1618674964-64_-converted.docx', 'Accepted', '2021-04-17 17:39:15', 36, 3, 'sssss', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faculties`
--

CREATE TABLE `faculties` (
  `faculty_id` int(3) NOT NULL,
  `faculty_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `faculties`
--

INSERT INTO `faculties` (`faculty_id`, `faculty_name`, `description`) VALUES
(0, 'No Faculty', 'No Faculty'),
(3, 'Cinemama', 'Cinemama'),
(4, 'Chemistry', 'Chemistry'),
(40, 'iG Theshy', 'TheShy'),
(46, 'Math', 'Math'),
(55, 'Mefo2', 'Mefo2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `role_id` int(3) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'Admin', 'Administrator'),
(2, 'Manager', 'Marketing Manager'),
(3, 'Coordinator', 'Marketing Coordinator'),
(4, 'Student', 'Student'),
(5, 'Guest', 'Guest');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(3) NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `deadline_1` datetime NOT NULL,
  `deadline_2` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `description`, `start`, `deadline_1`, `deadline_2`) VALUES
(3, 'Sensei', 'Senseissss', '2021-03-24 00:00:00', '2021-04-29 07:00:00', '2021-05-25 00:00:00'),
(4, 'tinn it', 'tinn it', '2021-03-04 00:00:00', '2021-03-23 22:00:00', '2021-04-01 16:00:00'),
(5, 'alo alo', 'alo alo ahihi', '2021-03-10 00:00:00', '2021-04-25 02:00:00', '2021-03-07 00:00:00'),
(15, 'email', 'email', '2021-04-11 00:11:00', '2021-05-20 00:11:00', '2021-07-31 00:11:00'),
(16, 'Tesst1111', 'Tesst1111', '2021-04-01 16:02:00', '2021-04-16 16:02:00', '2021-04-30 16:02:00'),
(17, 'Tesst12', 'Chu cÃ  mo', '2021-04-30 23:03:00', '2021-05-20 23:03:00', '2021-06-20 23:03:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text,
  `user_role` int(3) NOT NULL,
  `user_faculty_id` int(3) NOT NULL,
  `randSalt` varchar(255) DEFAULT '$2y$10$iusesomescrazystrings22',
  `createdAt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `user_email`, `user_image`, `user_role`, `user_faculty_id`, `randSalt`, `createdAt`) VALUES
(20, 'thientam', '$2y$12$hBP1f4.bKuRSMslRKsCW7uLX26qqQE9Par/dZ8hi64in83tr.ao.O', 'Thien Tam', 'thientam@gmail.com', '/images/default-avatar.png', 2, 0, '$2y$10$iusesomescrazystrings22', '2021-02-23'),
(23, 'khanhduy', '$2y$12$WyVcXdsfTha6rS7KcJcfseCdIDlf8fP5B1kmnU/tUKZLRtvSGR23u', 'Khanh Duy 123', 'khanhduy@gmail.com', '/images/default-avatar.png', 3, 32, '$2y$10$iusesomescrazystrings22', '2021-02-23'),
(24, 'kentran', '$2y$12$ot0rKxju1TYziIdwCxvdHeckoM6tbey2yHlM7WxvEIxa7GJyZL5u.', 'Ken Tran', 'kentran@gmail.com', '/images/default-avatar.png', 3, 4, '$2y$10$iusesomescrazystrings22', '2021-02-23'),
(25, 'anhduc', '$2y$12$IO7VRSegJmMSXWbvAIS/YuCkGZlfZELgUE9hl73pQm9jkDpxQDp96', 'Anh Duc', 'anhduc@gmail.com', '/images/default-avatar.png', 3, 3, '$2y$10$iusesomescrazystrings22', '2021-02-23'),
(26, 'minhtuan', '$2y$12$2WUacFG6FpWBzjM7.Md64.E/t4fJGkMluVG8TgrvEGi6Rp6Ella.S', 'Minh Tuan', 'minhtuan@gmail.com', '/images/default-avatar.png', 4, 32, '$2y$10$iusesomescrazystrings22', '2021-02-23'),
(31, 'Admin', '$2y$10$ULxj8oKa4dlMa.kVPKSYLuD5EsvESSsMoWoToi/eh4p.f9OLe7PXC', 'Admin', 'Admin@gmail.com', '/images/default-avatar.png', 1, 0, '$2y$10$iusesomescrazystrings22', '2021-03-21'),
(32, 'huytpk741', '$2y$10$Bt89fzblJtembababzoKQOhOxULSj7TzjvHXSTYVdFvdMx07etlpS', 'Harrisonburg', 'huytpk741@gmail.com', '/images/default-avatar.png', 4, 3, '$2y$10$iusesomescrazystrings22', '2021-03-22'),
(33, 'manager', '$2y$10$n8Q4x3CJf4aQ3RvQvKkfYe7TYvlSWgZ/3pRE1KF/WsaqxAc.yzMHG', 'Harrisonburg', 'manager@gmail.com', '/images/default-avatar.png', 2, 0, '$2y$10$iusesomescrazystrings22', '2021-03-23'),
(36, 'student1', '$2y$10$LMvjJES7fzIPjXSL8y9y7eJmR6zDjcrd6SIpc5JCQu6CycU7O7Kh2', 'student1', 'thanhphat19@gmail.com', '/images/default-avatar.png', 4, 3, '$2y$10$iusesomescrazystrings22', '2021-03-23'),
(37, 'student2', '$2y$10$ABlpUCAekXHdVRP/4NuqPO7D6G41wAePHCogptzETea5qGfsBKcRG', 'student2', 'student2@gmail.com', '/images/default-avatar.png', 4, 4, '$2y$10$iusesomescrazystrings22', '2021-03-23'),
(38, 'guest1', '$2y$10$vB.w5g7w7Lkz9yy9YQK7a.BpOdUVdIKFcOl55DLgH6gi5ZbqCR5U6', 'guest1', 'guest1@gmail.com', '/images/default-avatar.png', 5, 3, '$2y$10$iusesomescrazystrings22', '2021-03-23'),
(39, 'guest2', '$2y$10$OCZlBXOvHps6z9IsPYDrieSqYmO3mpmaGr1vnPcCLhdOQ9pafLeRG', 'guest2', 'guest2@gmail.com', '/images/default-avatar.png', 5, 4, '$2y$10$iusesomescrazystrings22', '2021-03-23'),
(40, 'coordinator1', '$2y$10$OM3EFdqXMCfbO9Mn3W6FFulLTRoFVKOPzC8COtxOJCdadsDP1pM.e', 'coordinator1', 'coordinator1@gmail.com', '/images/default-avatar.png', 3, 3, '$2y$10$iusesomescrazystrings22', '2021-03-24'),
(41, 'coordinator2', '$2y$10$FH491PNd8Zdu6IveWuEdr.ttCEQX1L0dquJD/pMTox9V8595fWDVG', 'coordinator2', 'coordinator2@gmail.com', '/images/default-avatar.png', 3, 4, '$2y$10$iusesomescrazystrings22', '2021-03-24'),
(46, 'Admin1222', '$2y$10$YktpjX6x1vtEgieaoxatFOb4nrBmC5gCNK38XA6gjD2ha0yGZwCC2', 'LÃª Nguyá»…n Anh Äá»©c', 'lenguyenthanhduc0206@gmail.com', '/images/default-avatar.png', 3, 3, '$2y$10$iusesomescrazystrings22', '2021-03-27'),
(48, '11111', '$2y$10$OB3YZYD1cdMD28tpGHkZQeOL60x73Nut4M3Pa1Ht3kReU1T3NYKGi', 'LÃª Nguyá»…n Anh Äá»©c', 'lenguyenthanhduc20206@gmail.com', '/images/default-avatar.png', 4, 54, '$2y$10$iusesomescrazystrings22', '2021-03-27'),
(50, 'student12', '$2y$10$2m8E0AjDls/b3.3zNGZ0MuEKQ17LGSdpboMDL74e5d0zn4EUfrUba', 'LÃª Nguyá»…n Anh Äá»©c', 'duclnagcs17126@fpt.edu.vn', 'images/default-avatar.png', 4, 3, '$2y$10$iusesomescrazystrings22', '2021-04-07'),
(51, 'thanhphat', '$2y$10$6ztTXB/oB0I0sPrAh8Dc4eeDB.AXdpXGZ2KaBtKk5zzpw6xhDIHKK', 'ThÃ nh PhÃ¡t', 'thanhphat19@gmail.com', '../images/default-avatar.png', 3, 3, '$2y$10$iusesomescrazystrings22', '2021-04-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, '106gs7a3vb6e5bilmtdk8j41h3', 1616396537),
(2, 'auq089pd9p948tf87o9274kq75', 1618679207),
(3, '2c81udi6j5chbb38t0r6rf3s9j', 1618677928),
(4, 'ge5v2pbnb13lggdeult1uolr9r', 1616504352),
(5, 'ghjiqgpg9ondq63mgv7lr5o3av', 1616644172),
(6, 'q7iabhr3be2vasg7if4nsijj96', 1616818841),
(7, 'r7g250mvmuq7l757kb7igknv54', 1618160974),
(8, 'd2e54v9jbue8formrkj5gta44v', 1617766784),
(9, 'mdb36ofb9ujvece5jgud9o7ffk', 1617771103),
(10, 'ptbnm6006l4gitd7mntnhoeqg4', 1617771169),
(11, 'lft1rh391u20t853pas2hlqvlj', 1618161114),
(12, 'j350vg220ts6445n3nebkagpi0', 1618249146),
(13, 'efqhfjh5297ar344gdat4l057t', 1618304920),
(14, 'm6ebfcu9elmon1oif63qlqiig3', 1618389500),
(15, '45btvirdu17eo7s4spfp4un7ci', 1618400529),
(16, '1gtfoemg2ft6o3oucu4idi0q0p', 1618437640),
(17, 'tc1r3n0ps0f2clset2d9tqat49', 1618438512),
(18, 'eieume39mesnlj3u7qug46ktkd', 1618438952),
(19, 'd93fekcs9o2ibujpm17sk4pqbr', 1618679266);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_comments_contribution_id_idx` (`contribution_id`),
  ADD KEY `fk_comments_user_id_idx` (`userId`);

--
-- Chỉ mục cho bảng `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`contribution_id`),
  ADD KEY `fk_contributions_student_id_idx` (`student_id`),
  ADD KEY `fk_contributions_facultyt_id_idx` (`faculty_id`),
  ADD KEY `fk_contributions_topic_id_idx` (`topicId`);

--
-- Chỉ mục cho bảng `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Chỉ mục cho bảng `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_users_faculty_id_idx` (`user_faculty_id`),
  ADD KEY `fk_users_role_id_idx` (`user_role`);

--
-- Chỉ mục cho bảng `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `contributions`
--
ALTER TABLE `contributions`
  MODIFY `contribution_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `faculties`
--
ALTER TABLE `faculties`
  MODIFY `faculty_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_contribution_id` FOREIGN KEY (`contribution_id`) REFERENCES `contributions` (`contribution_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `contributions`
--
ALTER TABLE `contributions`
  ADD CONSTRAINT `fk_contributions_faculty_id` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contributions_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contributions_topic_id` FOREIGN KEY (`topicId`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
