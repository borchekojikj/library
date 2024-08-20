-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 07:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_2_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `biography` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `firstname`, `lastname`, `biography`, `deleted`) VALUES
(1, 'Dan', 'Brown', 'Daniel Gerhard Brown (born June 22, 1964) is an American author best known for his thriller novels, including the Robert Langdon novels Angels & Demons (2000), The Da Vinci Code (2003), The Lost Symbol (2009), Inferno (2013), and Origin (2017). His novels', 0),
(2, 'Nora', 'Ephron', 'Perhaps better known for her screenwriting (Silkwood, When Harry Met Sally, Heartburn), Ephron’s brand of smart theatrical humour is on best display in her essays. Confiding and self-deprecating, she has a way of always managing to sound like your best fr', 0),
(3, 'F. Scott', 'Fitzgerald', 'F. Scott Fitzgerald (born September 24, 1896, St. Paul, Minnesota, U.S.—died December 21, 1940, Hollywood, California) was an American short-story writer and novelist famous for his depictions of the Jazz Age (the 1920s), his most brilliant novel being Th', 0),
(4, 'Margarett', 'Stone', 'Crafting spine-chilling tales that will haunt your dreams. Embrace the darkness and dive into the twisted worlds of horror fiction. #HorrorAuthor #NightmaresInk', 0),
(5, 'Helene', 'Sours', 'Known for their immersive world-building and thought-provoking narratives, [Author\'s Name] seamlessly blends cutting-edge scientific concepts with compelling characters and gripping plots. Their writing style is characterized by its blend of hard science', 0),
(6, 'Iron', 'Maiden', 'Iron Maiden are an English heavy metal band formed in Leyton, East London, in 1975 by bassist and primary songwriter Steve Harris. Although fluid in the early years of the band, the line-up for most of the band\'s history has consisted of Harris, lead voca', 0),
(7, 'Deliver', 'Alivo', 'Daniel Gerhard Brown (born June 22, 1964) is an American author best known for his thriller novels, including the Robert Langdon novels Angels & Demons (2000), The Da Vinci Code (2003), The Lost Symbol (2009), Inferno (2013), and Origin (2017). His novelh', 1),
(8, 'Daniel', 'Dormer', 'LOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOREM IPSU?MLOR', 1),
(9, 'Elene', 'Tellor', 'Elene is a poem in Old English, that is sometimes known as Saint Helena Finds the True Cross. It was translated from a Latin text and is the longest of Cynewulf\'s four signed poems. It is the last of six', 1);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `publication_year` date NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `summary` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `publication_year`, `number_of_pages`, `photo`, `author_id`, `category_id`, `summary`) VALUES
(1, 'The Da Vinci Code', '2004-07-10', 689, 'https://images.pexels.com/photos/355915/pexels-photo-355915.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 1, 1, 'The Da Vinci Code is a 2003 mystery thriller novel by Dan Brown. The novel is about symbologist Robert Langdon, who is drawn into a investigation of a murder that took place in the Louvre Museum in Paris. Langdon discovers that the murder is linked to a secret society called the Priory of Sion and the Holy Grail. Langdon and French cryptologist Sophie Neveu must follow a trail of clues to find the Holy Grail and the truth about the Priory of Sion.'),
(2, ' Angels and Demons', '2000-02-29', 480, 'https://images.pexels.com/photos/820735/pexels-photo-820735.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 1, 1, 'Robert Langdon, a renowned Harvard symbologist, is summoned to Rome after the kidnapping of the four cardinals who are the candidates to become the next Pope. The kidnapper, a mysterious Illuminati member, demands the cardinals’ release in exchange for an age-old antimatter bomb that could destroy the Vatican. Langdon and Vittoria Vetra, a beautiful Italian scientist he meets on the scene, must decipher the Illuminati’s ancient clues to save the cardinals and the Vatican itself. The story is set against the backdrop of Rome’s most alluring locales, including the Vatican, the Pantheon, St. Peter’s Square, and the Trevi Fountain.'),
(3, 'I Feel Bad About My Neck', '2006-02-10', 139, 'https://ecx.images-amazon.com/images/I/412XRtVOPnL.jpg', 2, 3, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?'),
(4, 'The Great Gatsby', '2024-03-11', 180, 'https://images.pexels.com/photos/1874636/pexels-photo-1874636.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 3, 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(5, 'Holy Test', '2024-03-11', 364, 'https://images.pexels.com/photos/1988681/pexels-photo-1988681.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 4, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(6, 'Time Chambe', '2024-03-11', 532, 'https://images.pexels.com/photos/277458/pexels-photo-277458.jpeg?auto=compress&cs=tinysrgb&w=600', 4, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(7, 'Origin', '2024-03-11', 332, 'https://images.pexels.com/photos/7004739/pexels-photo-7004739.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 5, 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?'),
(8, 'Boundaries', '2024-03-11', 540, 'https://images.pexels.com/photos/7671962/pexels-photo-7671962.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 5, 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(9, 'Number of the Beast ', '1982-03-22', 666, 'https://images.pexels.com/photos/3639873/pexels-photo-3639873.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 6, 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(13, 'The first River', '2024-02-27', 423, 'https://images.pexels.com/photos/20578835/pexels-photo-20578835/free-photo-of-bird-cage.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 1, 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(14, 'Last Breath', '2024-03-01', 213, 'https://images.pexels.com/photos/1028225/pexels-photo-1028225.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 2, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(18, 'New Book', '2024-03-11', 123, 'https://images.pexels.com/photos/355508/pexels-photo-355508.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 2, 1, 'New Book is a book written by author about inspirations for new books. In the book, author shares their thoughts on where they get their ideas for new books, how they develop those ideas into stories, and what keeps them motivated to write. Author also provides tips and advice for other writers who are looking to find their own inspiration and write great books.'),
(19, 'The perfect sound', '2024-03-11', 123, 'https://images.pexels.com/photos/1762973/pexels-photo-1762973.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 2, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate iste eius delectus amet qui consequatur non quasi excepturi id a aliquid modi, dolor eum ea dolorem tempore pariatur reiciendis quaerat repellendus adipisci. Similique sunt assumenda facere quo, veniam, id fugit dolor consectetur, amet ut itaque neque modi quia facilis?\r\n'),
(20, 'Dawn of the new World', '2024-03-12', 232, 'https://images.pexels.com/photos/1368382/pexels-photo-1368382.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 2, 1, 'Pale Fire is a 1962 novel by Vladimir Nabokov. The novel is presented as a 999-line poem titled \"Pale Fire\", written by the fictional poet John Shade, with a foreword, lengthy commentary and index wrote Pale Fire in 1960–61, after the success of Lolita had made him financially independent, allowing him to retire from teaching and return to Europe.[1][2] It was commenced in Nice and completed in Montreux, Switzerland.[3]');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `deleted`) VALUES
(1, 'Thriller', 0),
(2, 'Horror', 0),
(3, 'Humor', 1),
(4, 'Romance', 0),
(5, 'Sci-fi', 0),
(6, 'Anime', 1),
(7, 'Drama', 0),
(8, 'Comedy', 0),
(9, 'Anime', 1),
(10, '21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `comment_text`, `status`, `user_id`, `book_id`, `date`) VALUES
(88, 'Admin First Comment!', 1, 1, 1, '2024-03-13'),
(91, 'User Comment!', 1, 2, 2, '2024-03-13'),
(92, 'User pending Comment!', 1, 2, 8, '2024-03-13'),
(94, 'Test Comment', 2, 22, 1, '2024-03-13'),
(95, 'New Momment!', 1, 24, 1, '2024-03-13'),
(107, 'Comment!', 1, 24, 9, '2024-03-13'),
(108, 'Comment user 7', 0, 1, 7, '2024-03-13'),
(109, 'Comment user 13', 0, 1, 13, '2024-03-13'),
(110, 'It\'s a Comment.', 2, 1, 6, '2024-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `note`, `user_id`, `book_id`) VALUES
(73, 'User Note 1.', 2, 4),
(74, 'User Note Edit', 2, 4),
(76, 'Test Note!', 22, 1),
(77, 'Test Note Edited!', 22, 1),
(79, 'User Note for Book.', 1, 5),
(80, 'Note To Save!', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'BorcheKojikj', '$2y$10$nvyCUITEHj0LjGv2vcuAoeKppvh/h6A/WyEfO268CsKrVAsPcja0i', 1),
(2, 'Jana.Jana', '$2y$10$DLhHTTv90nq231JY2BXUaeP73eCZB6G.RHxzl1jdw.ntkwYhgTSwK', 0),
(19, 'testUser', '$2y$10$vO2hPG.fU41gNeXRoJjPr.F1rhRL.lbT0UPePRcKX.8br.fxxzUMq', 0),
(22, 'FinalTest', '$2y$10$O703kuMYN3XT5NG9zYmyz.TcZZoJ5MtFhREahkpNz.gFAcKFTDB32', 0),
(23, 'Test123!', '$2y$10$vtozntqr6zLAfjThzDEGYuNG1SEz.gsHX54JPUsrsd/4.jlXpZ4mS', 0),
(24, 'GitUpdate', '$2y$10$UnKQxbssmE52lguXDGU9YeHFYlC3FRK4PPAcLkzBco6lt8aBPi9jS', 0),
(25, 'GitUpdate2', '$2y$10$VszXGJosuPDskEe0eu1QVO/zOp5kICKhVNYlgWxUlT0EUZW6SioJC', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id_note` (`book_id`),
  ADD KEY `user_id_note` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `book_id` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `book_id_note` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_note` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
