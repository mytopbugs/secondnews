CREATE TABLE IF NOT EXISTS news (
  id int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  create_time DATETIME COMMENT 'Дата создания',
  title VARCHAR(255) COMMENT 'Заголовок новости',
  preview TEXT COMMENT 'Анонс',
  content TEXT COMMENT 'Основной контент',
  preview_img VARCHAR(255) COMMENT 'Фото для анонса',
  content_img VARCHAR(255) COMMENT 'Фото для контента',
  author VARCHAR (255) COMMENT 'Автор',
  recommend_list VARCHAR (125) COMMENT 'id рекомендуемых новостей',
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

INSERT INTO `news`(`create_time`,`title`,`content`,`recommend_list`,`preview`,`preview_img`,`content_img`,`author`) VALUES
('2024-07-13 01:02:00','<strong>Новость №1</strong>','Краткий анонс новости<strong>Z</strong>','[]','Краткий анонс новости <strong>Z</strong>',CONCAT('/img/preview/', UNIX_TIMESTAMP(), '.png'),CONCAT('/img/content/', UNIX_TIMESTAMP(), '.png'),'Тацио Секкьяроли'),
('2024-07-11 00:02:00','<strong>Новость №2</strong>','Краткий анонс новости<strong>Z</strong>','[]','Краткий анонс новости <strong>Z</strong>',CONCAT('/img/preview/', UNIX_TIMESTAMP(), '.png'),CONCAT('/img/content/', UNIX_TIMESTAMP(), '.png'),'Тацио Секкьяроли'),
('2024-07-12 10:02:00','<strong>Новость №3</strong>','Краткий анонс новости<strong>Z</strong>','[]','Краткий анонс новости <strong>Z</strong>',CONCAT('/img/preview/', UNIX_TIMESTAMP(), '.png'),CONCAT('/img/content/', UNIX_TIMESTAMP(), '.png'),'Тацио Секкьяроли'),
('2023-08-10 04:02:00','<strong>Новость №4</strong>','Краткий анонс новости<strong>Z</strong>','[1,2]','Краткий анонс новости <strong>Z</strong>',CONCAT('/img/preview/', UNIX_TIMESTAMP(), '.png'),CONCAT('/img/content/', UNIX_TIMESTAMP(), '.png'),'Тацио Секкьяроли'),
('2024-03-23 07:02:00','<strong>Новость №5</strong>','Краткий анонс новости<strong>Z</strong>','[]','Краткий анонс новости <strong>Z</strong>',CONCAT('/img/preview/', UNIX_TIMESTAMP(), '.png'),CONCAT('/img/content/', UNIX_TIMESTAMP(), '.png'),'Тацио Секкьяроли'),
('2024-02-03 00:02:00','<strong>Новость №6</strong>','Краткий анонс новости<strong>Z</strong>','[4]','Краткий анонс новости <strong>Z</strong>',CONCAT('/img/preview/', UNIX_TIMESTAMP(), '.png'),CONCAT('/img/content/', UNIX_TIMESTAMP(), '.png'),'Тацио Секкьяроли')
;
