--
-- Database: examples
--

-- --------------------------------------------------------

--
-- Create user for accessing examples database
--

CREATE USER 'examples'@'localhost' IDENTIFIED BY  'p@ssw0rd';
GRANT USAGE ON * . * TO  'examples'@'localhost' IDENTIFIED BY  '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
GRANT ALL PRIVILEGES ON  `examples` . * TO  'examples'@'localhost';
