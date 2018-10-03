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
(13, '2018-09-25 16:44:00', '2014 Rossignol District Snowboard', 'Ростовка: 155. Назначение: freestyle/all mountain. Геометрия: True Twin. Жесткость: 5/10. Прогиб: AmpTek Auto Turn - 80% rocker, 20% camber. Скользяк: Extruded 1320. Закладные: 4х4', 'img/lot-1.jpg', 10999, '2018-09-29 16:44:00', 2000, 1, NULL, 1),
(14, '2018-09-26 18:43:00', 'DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-2.jpg', 159999, '2018-09-29 12:44:00', 12000, 5, NULL, 1),
(15, '2018-09-25 12:03:00', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Универсальные крепления для любого стиля и уровня катания. Размер: М. Цвет: Ashbury. Хорошее состояние, катаны 2 сезона. В комплекте запасные оригинальные стрепы.', 'img/lot-3.jpg', 8000, '2018-09-29 17:44:00', 600, 5, NULL, 2),
(16, '2018-09-24 17:04:00', 'Ботинки для сноуборда DC Mutiny Charocal', 'Размер: 27.5 см (российский - 42). Жесткость: средняя. Быстрая шнуровка POWER LACE + Внутренник CUSTOMFIT PERF', 'img/lot-4.jpg', 10999, '2018-09-27 16:44:00', 1500, 6, NULL, 3),
(17, '2018-09-25 09:42:00', 'Куртка для сноуборда DC Mutiny Charocal', 'Горнолыжная куртка выполнена из текстиля с водонепроницаемой мембраной свыше 10 000 мм. Средний слой утеплителя сохраняет тепло и обеспечивает оптимальную терморегуляцию. Детали: капюшон, застежка на молнию и липучки, капюшон, регулируемые манжеты, карман на молнии для скипасса, снегозащитная юбка с креплениями для брюк.', 'img/lot-5.jpg', 7500, '2018-09-29 20:44:00', 500, 5, NULL, 4),
(18, '2018-09-24 20:32:00', 'Маска Oakley Canopy', 'Маска Oakley Line Miner обеспечивает отличный периферийный и вертикальный обзор благодаря линзе цилиндрической формы расположенной на максимально близком расстоянии от глаз. Оптически корректная двойная цилиндрическая линза с технологией Prizm™ и антизапотевающим покрытием F3 Anti-Fog обеспечит полную защиту глаз от ультрафиолетового и жёсткого голубого излучения.', 'img/lot-6.jpg', 5400, '2018-09-28 21:42:00', 400, 6, NULL, 6);

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


