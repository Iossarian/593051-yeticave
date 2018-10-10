CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;
-- База данных: `yeticave`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bet`
--

CREATE TABLE `bet` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `lot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `lots`
--

CREATE TABLE `lots` (
  `id` int(11) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `name` char(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` char(120) DEFAULT NULL,
  `start_price` int(11) DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `bet_step` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `winner_id` int(11) NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `reg_date` datetime DEFAULT NULL,
  `email` char(128) DEFAULT NULL,
  `name` char(64) DEFAULT NULL,
  `password` char(64) DEFAULT NULL,
  `profile_img` char(120) DEFAULT NULL,
  `contacts` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bet`
--
ALTER TABLE `bet`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact` (`contacts`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bet`
--
ALTER TABLE `bet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bet`
--
ALTER TABLE `bet`
  ADD CONSTRAINT `lot_key` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`),
  ADD CONSTRAINT `user_key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `author_key` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `winner_key` FOREIGN KEY (`winner_id`) REFERENCES `users` (`id`);
