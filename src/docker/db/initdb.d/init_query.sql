-- 初期DBを作成
CREATE DATABASE IF NOT EXISTS `db_local`;
CREATE USER 'db_local'@'%' IDENTIFIED BY 'db_local';
GRANT ALL ON db_local.* TO 'db_local'@'%';

CREATE DATABASE IF NOT EXISTS `db_testing`;
CREATE USER 'db_testing'@'%' IDENTIFIED BY 'db_testing';
GRANT ALL ON db_testing.* TO 'db_testing'@'%';
