CREATE DATABASE IF NOT EXISTS `pastebin_parody_db` COLLATE 'utf8_general_ci' ;
GRANT ALL ON `pastebin_parody_db`.* TO 'default'@'%' ;

CREATE DATABASE IF NOT EXISTS `pastebin_parody_test_db` COLLATE 'utf8_general_ci' ;
GRANT ALL ON `pastebin_parody_test_db`.* TO 'default'@'%' ;

FLUSH PRIVILEGES ;
