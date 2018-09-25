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
(13, NULL, '2014 Rossignol District Snowboard', NULL, 'img/lot-1.jpg', 10999, NULL, NULL, 1, NULL, 1),
(14, NULL, 'DC Ply Mens 2016/2017 Snowboard', NULL, 'img/lot-2.jpg', 159999, NULL, NULL, 5, NULL, 1),
(15, NULL, 'Крепления Union Contact Pro 2015 года размер L/XL', NULL, 'img/lot-3.jpg', 8000, NULL, NULL, 5, NULL, 2),
(16, NULL, 'Ботинки для сноуборда DC Mutiny Charocal', NULL, 'img/lot-4.jpg', 10999, NULL, NULL, 6, NULL, 3),
(17, NULL, 'Куртка для сноуборда DC Mutiny Charocal', NULL, 'img/lot-5.jpg', 7500, NULL, NULL, 5, NULL, 4),
(18, NULL, 'Маска Oakley Canopy', NULL, 'img/lot-6.jpg', 5400, NULL, NULL, 6, NULL, 6);

-- Заполнение таблицы "bet"
INSERT INTO `bet` (`id`, `date`, `price`, `lot_id`, `user_id`) VALUES
(1, NULL, 8300, 15, 1),
(2, NULL, 8000, 17, 5);

-- Получение категорий
SELECT category_name FROM category;

-- Получение данные из таблицы 'lots'
SELECT name, start_price, image, category_id FROM lots
SELECT price FROM bet WHERE lot_id = 15 ORDER BY price DESC
WHERE end_time > NOW();

-- Показ лота по его Id и получение названия
SELECT * FROM lots
WHERE id = 15;
SELECT name FROM lots
WHERE id = 15;

-- Обновление названия лота по его id
UPDATE lots SET name = '2015 Rossignol District Snowboard'
WHERE id = 13;

-- Сортировка ставок лота по id
SELECT * FROM bet ORDER BY lot_id DESC;


