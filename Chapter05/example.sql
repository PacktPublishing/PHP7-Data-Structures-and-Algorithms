/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `packt`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(100) NOT NULL,
  `parentCategory` int(11) DEFAULT '0',
  `sortInd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categoryName`, `parentCategory`, `sortInd`) VALUES
(1, 'First', 0, 0),
(2, 'Second', 1, 0),
(3, 'Third', 1, 0),
(4, 'Fourth', 3, 0),
(5, 'fifth', 4, 0),
(6, 'Sixth', 5, 0),
(7, 'seventh', 6, 0),
(8, 'Eighth', 7, 0),
(9, 'Nineth', 1, 0),
(10, 'Tenth', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `username` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `parentID` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `username`, `datetime`, `parentID`, `postID`) VALUES
(1, 'First comment', 'Mizan', '2016-10-01 15:10:20', 0, 1),
(2, 'First reply', 'Adiyan', '2016-10-02 04:09:10', 1, 1),
(3, 'Reply of first reply', 'Mikhael', '2016-10-03 11:10:47', 2, 1),
(4, 'Reply of reply of first reply ', 'Arshad', '2016-10-04 21:22:45', 3, 1),
(5, 'Reply of reply of reply of first reply', 'Anam', '2016-10-05 12:01:29', 4, 1),
(6, 'Second comment', 'Keith', '2016-10-01 15:10:20', 0, 1),
(7, 'First comment of second post', 'Milon', '2016-10-02 04:09:10', 0, 2),
(8, 'Third comment', 'Ikrum', '2016-10-03 11:10:47', 0, 1),
(9, 'Second comment of second post', 'Ahmed', '2016-10-04 21:22:45', 0, 2),
(10, 'Reply of second comment of second post', 'Afsar', '2016-10-18 05:18:24', 9, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
