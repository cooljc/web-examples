--
-- Database: examples
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS addresses (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  phone_number varchar(15) NOT NULL,
  email varchar(100) NOT NULL,
  address varchar(255) NOT NULL,
  date_created int(14) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
