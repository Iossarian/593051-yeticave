USE yeticave;
-- Заполнение таблицы "category"
INSERT INTO `category` (`id`, `category_name`) VALUES
(3, 'Ботинки'),
(1, 'Доски и лыжи'),
(5, 'Инструменты'),
(2, 'Крепления'),
(4, 'Одежда'),
(6, 'Разное');

-- Заполнение таблицы "users"
INSERT INTO `users` (`id`, `reg_date`, `email`, `name`, `password`, `profile_img`, `contacts`) VALUES
(1, NULL, 'AndreyPetrov@yandex.ru', NULL, 'PetRov92', NULL, NULL),
(5, NULL, 'IvanIvanov@yandex.ru', NULL, 'IvanIvan', NULL, NULL),
(6, NULL, 'Vladimir91@yandex.ru', NULL, 'VovaKras', NULL, NULL);


-- Заполнение таблицы "lots"
INSERT INTO `lots` (`id`, `create_date`, `name`, `description`, `image`, `start_price`, `end_time`, `bet_step`, `author_id`, `winner_id`, `category_id`) VALUES
(13, '2018-09-25 16:44:00', '2014 Rossignol District Snowboard', NULL, 'img/lot-1.jpg', 10999, '2018-09-29 16:44:00', NULL, 1, NULL, 1),
(14, '2018-09-26 18:43:00', 'DC Ply Mens 2016/2017 Snowboard', NULL, 'img/lot-2.jpg', 159999, '2018-09-29 12:44:00', NULL, 5, NULL, 1),
(15, '2018-09-25 12:03:00', 'Крепления Union Contact Pro 2015 года размер L/XL', NULL, 'img/lot-3.jpg', 8000, '2018-09-29 17:44:00', NULL, 5, NULL, 2),
(16, '2018-09-24 17:04:00', 'Ботинки для сноуборда DC Mutiny Charocal', NULL, 'img/lot-4.jpg', 10999, '2018-09-27 16:44:00', NULL, 6, NULL, 3),
(17, '2018-09-25 09:42:00', 'Куртка для сноуборда DC Mutiny Charocal', NULL, 'img/lot-5.jpg', 7500, '2018-09-29 20:44:00', NULL, 5, NULL, 4),
(18, '2018-09-24 20:32:00', 'Маска Oakley Canopy', NULL, 'img/lot-6.jpg', 5400, '2018-09-28 21:42:00', NULL, 6, NULL, 6);

-- Заполнение таблицы "bet"
INSERT INTO `bet` (`id`, `date`, `price`, `lot_id`, `user_id`) VALUES
(1, NULL, 8300, 15, 1),
(2, NULL, 8000, 17, 5),
(3, NULL, 8500, 15, 5);

-- Получение категорий
SELECT * FROM category;

-- Получение данных из таблицы 'lots'
SELECT l.name, l.start_price, l.image, c.category_name, l.create_date, MAX(b.price), COUNT(b.id)
FROM 
lots l 
LEFT JOIN 
category c ON c.id = l.category_id 
LEFT JOIN 
bet b ON b.lot_id = l.id 
WHERE l.end_time > NOW() 
GROUP BY 
l.id 
ORDER BY l.create_date
DESC;

-- Показ лота по его Id и получение названия категории
SELECT l.id, l.name, c.category_name AS category_name FROM lots AS l 
JOIN category AS c ON l.category_id = c.id 
WHERE l.id = 15;

-- Обновление названия лота по его id
UPDATE lots SET name = '2015 Rossignol District Snowboard'
WHERE id = 13;

-- Сортировка ставок лота по id
SELECT * FROM bet ORDER BY lot_id DESC;


