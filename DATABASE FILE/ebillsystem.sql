
--
-- Database: `ebillsystem`
--
-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(14) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `pass`) VALUES
(1, 'Administrator One', 'vandy@gmail.com', '$2y$10$4qr3Zy9jsjXRLxfrwjRCMOY/cSqVCpOP/Ioxzo61hh07YM2lGx4Yy'),
(2, 'Administrator Two', 'admin@gmail.com', '$2y$10$4qr3Zy9jsjXRLxfrwjRCMOY/cSqVCpOP/Ioxzo61hh07YM2lGx4Yy');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(14) NOT NULL,
  `aid` int(14) NOT NULL,
  `uid` int(14) NOT NULL,
  `units` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `bdate` date NOT NULL,
  `ddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `aid`, `uid`, `units`, `amount`, `status`, `bdate`, `ddate`) VALUES
(17, 1, 8, 210, '450.00', 'PROCESSED', '2021-07-06', '2021-08-05'),
(18, 1, 1, 61, '122.00', 'PROCESSED', '2021-07-10', '2021-08-09'),
(19, 1, 2, 78, '156.00', 'PENDING', '2021-07-10', '2021-08-09'),
(20, 1, 3, 70, '140.00', 'PROCESSED', '2021-07-10', '2021-08-09'),
(21, 1, 4, 98, '196.00', 'PENDING', '2021-07-10', '2021-08-09'),
(22, 1, 9, 55, '110.00', 'PROCESSED', '2021-07-10', '2021-08-09'),
(23, 1, 11, 89, '178.00', 'PROCESSED', '2021-07-10', '2021-08-09'),
(24, 1, 7, 103, '206.00', 'PENDING', '2021-07-10', '2021-08-09');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `id` int(14) NOT NULL,
  `uid` int(14) NOT NULL,
  `aid` int(14) NOT NULL,
  `complaint` varchar(140) NOT NULL,
  `status` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`id`, `uid`, `aid`, `complaint`, `status`) VALUES
(1, 1, 1, 'Transaction Not Processed', 'PROCESSED'),
(2, 1, 1, 'Transaction Not Processed', 'PROCESSED'),
(3, 2, 1, 'Previous Complaint Not Processed', 'PROCESSED'),
(4, 2, 1, 'Transaction Not Processed', 'PROCESSED'),
(5, 2, 2, 'Transaction Not Processed', 'PROCESSED'),
(6, 1, 1, 'Bill Not Correct', 'PROCESSED'),
(7, 3, 1, 'Bill Not Correct', 'PROCESSED'),
(8, 3, 2, 'Transaction Not Processed', 'PROCESSED'),
(9, 4, 2, 'Transaction Not Processed', 'PROCESSED'),
(10, 4, 1, 'Bill Not Correct', 'PROCESSED'),
(11, 5, 2, 'Bill Generated Late', 'PROCESSED'),
(12, 1, 2, 'Bill Generated Late', 'NOT PROCESSED'),
(13, 11, 1, 'Bill Generated Late', 'PROCESSED');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(14) NOT NULL,
  `bid` int(14) NOT NULL,
  `payable` decimal(10,2) NOT NULL,
  `pdate` date DEFAULT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `bid`, `payable`, `pdate`, `status`) VALUES
(17, 17, '450.00', '2021-07-06', 'PROCESSED'),
(18, 18, '122.00', '2021-07-10', 'PROCESSED'),
(19, 19, '156.00', NULL, 'PENDING'),
(20, 20, '140.00', '2021-07-10', 'PROCESSED'),
(21, 21, '196.00', NULL, 'PENDING'),
(22, 22, '110.00', '2021-07-10', 'PROCESSED'),
(23, 23, '178.00', '2021-07-10', 'PROCESSED'),
(24, 24, '206.00', NULL, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `unitsrate`
--

CREATE TABLE `unitsrate` (
  `sno` int(1) DEFAULT NULL,
  `twohundred` int(14) NOT NULL,
  `fivehundred` int(14) NOT NULL,
  `thousand` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unitsrate`
--

INSERT INTO `unitsrate` (`sno`, `twohundred`, `fivehundred`, `thousand`) VALUES
(1, 2, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(14) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `pass`, `address`) VALUES
(1, 'Vandy Kamara', 'vandykamara@gmail.com', '077531883', '$2y$10$PYPgwvhOtGI6y4ak5jhQheFcWFhTQK5QeufiEk/RdDxwarP39VasS', 'Teko Barrack Street');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bid` (`bid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `complaint_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaint_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

