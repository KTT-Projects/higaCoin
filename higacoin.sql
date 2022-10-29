-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 10 月 25 日 14:07
-- サーバのバージョン： 10.4.19-MariaDB
-- PHP のバージョン: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `higacoin`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bitcoin`
--

CREATE TABLE `bitcoin` (
  `id` int(11) NOT NULL,
  `bitcoin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bitcoin`
--

INSERT INTO `bitcoin` (`id`, `bitcoin`) VALUES
(1912, 6724959),
(1913, 6722055),
(1914, 6718477),
(1915, 6720847),
(1916, 6717473),
(1917, 6717945),
(1918, 6717945),
(1919, 6718700),
(1920, 6716916),
(1921, 6718672),
(1922, 6715805),
(1923, 6718499),
(1924, 6716649),
(1925, 6716067),
(1926, 6716067),
(1927, 6715418),
(1928, 6715674),
(1929, 6716659),
(1930, 6715980),
(1931, 6718119),
(1932, 6718269),
(1933, 6718627),
(1934, 6715233),
(1935, 6717839),
(1936, 6717636),
(1937, 6717636),
(1938, 6719760),
(1939, 6719131),
(1940, 6723230),
(1941, 6724978),
(1942, 6725553),
(1943, 6724556),
(1944, 6726635),
(1945, 6724805),
(1946, 6719755),
(1947, 6719074),
(1948, 6719396),
(1949, 6719936),
(1950, 6719936),
(1951, 6721863),
(1952, 6715024),
(1953, 6717073),
(1954, 6713144),
(1955, 6712981),
(1956, 6712973),
(1957, 6714842),
(1958, 6712783),
(1959, 6709520),
(1960, 6715014),
(1961, 6714193),
(1962, 6713477),
(1963, 6714551),
(1964, 6711681),
(1965, 6711682),
(1966, 6710559),
(1967, 6710037),
(1968, 6710672),
(1969, 6709092),
(1970, 6710601),
(1971, 6704189),
(1972, 6704189),
(1973, 6705844),
(1974, 6704804),
(1975, 6705783),
(1976, 6704312),
(1977, 6707073),
(1978, 6703837),
(1979, 6706178),
(1980, 6710695),
(1981, 6719054),
(1982, 6723222),
(1983, 6724461),
(1984, 6717301),
(1985, 6716795),
(1986, 6717120),
(1987, 6715349),
(1988, 6710104),
(1989, 6708362),
(1990, 6706338),
(1991, 6701864),
(1992, 6703047),
(1993, 6698699),
(1994, 6698675),
(1995, 6694709),
(1996, 6697266),
(1997, 6694083),
(1998, 6699099),
(1999, 6696404),
(2000, 6698998),
(2001, 6699524),
(2002, 6696424),
(2003, 6694617),
(2004, 6694047),
(2005, 6694047),
(2006, 6695928),
(2007, 6697768),
(2008, 6696314),
(2009, 6694964),
(2010, 6693842),
(2011, 7201022),
(2012, 5201022),
(2013, 7201022),
(2014, 10285140),
(2015, 5201022),
(2016, 100201022),
(2017, 7201022),
(2018, 5201022),
(2019, 1),
(2020, 5200000),
(2021, 1490000);

-- --------------------------------------------------------

--
-- テーブルの構造 `mes`
--

CREATE TABLE `mes` (
  `id` int(11) NOT NULL,
  `send_from` text NOT NULL,
  `send_to` text NOT NULL,
  `amount` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `what_kind` int(11) NOT NULL,
  `when_post` datetime NOT NULL,
  `agree` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `mes`
--

INSERT INTO `mes` (`id`, `send_from`, `send_to`, `amount`, `percentage`, `what_kind`, `when_post`, `agree`) VALUES
(56, 'TEST', 'ADMIN', 1000, 0, 1, '2021-11-24 20:18:37', 1),
(57, 'ADMIN', 'TEST', 200, 0, 1, '2021-11-24 20:19:41', 0),
(58, 'TEST', 'ADMIN', 500, 0, 1, '2021-11-24 20:19:45', 3),
(59, 'TEST', 'ADMIN', 100, 0, 1, '2021-11-24 20:20:10', 1),
(60, 'ADMIN', '中島', 10595, 0, 1, '2021-11-25 03:27:52', 1),
(61, '米村', 'ADMIN', 10000, 0, 1, '2021-12-04 17:19:21', 1),
(62, 'マーシュ', '中谷', 200, 0, 1, '2022-03-17 20:00:26', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `userData`
--

CREATE TABLE `userData` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `higacoin` int(11) NOT NULL,
  `trade_amount` int(11) NOT NULL DEFAULT 0,
  `trade_bitcoin` int(11) NOT NULL DEFAULT 0,
  `lend_amount` int(11) NOT NULL DEFAULT 0,
  `percentage` int(11) NOT NULL DEFAULT 0,
  `past_date` int(11) NOT NULL DEFAULT 0,
  `lend_from_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `userData`
--

INSERT INTO `userData` (`id`, `user_name`, `password`, `higacoin`, `trade_amount`, `trade_bitcoin`, `lend_amount`, `percentage`, `past_date`, `lend_from_id`) VALUES
(4, '中谷', '$2y$10$hhql5sEUa8JB9DmfQoh4fOIZrb3XptoTV.i62aGjkzrWyD9HyqLwa', 13500, 0, 0, 0, 0, 0, 0),
(6, '中島', '$2y$10$qmDF1SAh60DntZjuNvPRVu1f72XIsm62kJDCO2UoJQSXXEY.hEulm', 20295, 0, 0, 0, 0, 0, 0),
(7, 'マーシュ', '$2y$10$JoCHxDTTmg/rDRTdu0w3QO6LaQ4/acoTFcbs711wYGmS78/o/QlIO', 5408, 0, 0, 0, 0, 0, 0),
(8, '米村', '$2y$10$1FUHBzHMFWGUu8uykyJr1ObutUBLRaNi11s3nC0StCjr1NM/oV72O', 10000, 0, 0, 0, 0, 0, 0),
(9, '梶谷', '$2y$10$mqSYm6ffOBsbxXIjCFHJhehqz6tyVSg6wg6w/7YmA5KcYLj4QRndm', 10000, 0, 0, 0, 0, 0, 0),
(24, 'ADMIN', '$2y$10$2.RJlLnNuwZ6qyAjFGBr..hfHzrJX25F86Q0DYNY7Bnmc7YVPUn7.', 10500, 0, 0, 0, 0, 0, 0),
(33, 'TEST', '$2y$10$HR2dub2WGApu8vyJ1rN55eEuS.wZN1do2xR/DoWJNfbfcZ69.8EzW', 8800, 0, 0, 0, 0, 0, 0),
(34, '中野', '$2y$10$50IpkfZPmu1KSTbyowCsjOxT84Zna8ErEaoMQEMev2kFrWwMdroM6', 10000, 0, 0, 0, 0, 0, 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `bitcoin`
--
ALTER TABLE `bitcoin`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `mes`
--
ALTER TABLE `mes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `userData`
--
ALTER TABLE `userData`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `bitcoin`
--
ALTER TABLE `bitcoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `mes`
--
ALTER TABLE `mes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `userData`
--
ALTER TABLE `userData`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
