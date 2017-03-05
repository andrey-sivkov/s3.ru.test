-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 05 2017 г., 22:11
-- Версия сервера: 10.1.21-MariaDB
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `s3_ru_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_address` text,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` datetime DEFAULT NULL,
  `total_sum` decimal(15,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_quantity` smallint(6) NOT NULL DEFAULT '1',
  `product_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders_statuses`
--

CREATE TABLE `orders_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sort_order` smallint(6) NOT NULL DEFAULT '0',
  `is_default` smallint(6) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders_statuses`
--

INSERT INTO `orders_statuses` (`id`, `name`, `sort_order`, `is_default`, `date_added`) VALUES
(1, 'Принят', 10, 1, '2017-03-05 20:34:53'),
(2, 'В обработке', 20, 0, '2017-03-05 20:34:53'),
(3, 'Ожидает доставки', 30, 0, '2017-03-05 20:36:12'),
(4, 'На доставке', 40, 0, '2017-03-05 20:36:12'),
(5, 'Доставлен', 50, 0, '2017-03-05 20:36:12'),
(6, 'Выполнен', 60, 0, '2017-03-05 20:36:12'),
(7, 'Отказ', 70, 0, '2017-03-05 20:36:12');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_statuses_history`
--

CREATE TABLE `orders_statuses_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `order_status_id` int(11) NOT NULL DEFAULT '0',
  `comments` text,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `date_added`, `last_modified`) VALUES
(1, 'Товар 01', '15.00', '2017-03-05 15:51:40', NULL),
(2, 'Товар 02', '25.50', '2017-03-05 15:51:40', NULL),
(3, 'Товар 03', '45.00', '2017-03-05 15:51:40', NULL),
(4, 'Товар 04', '99.90', '2017-03-05 15:51:40', NULL),
(5, 'Товар 05', '72.30', '2017-03-05 15:51:40', NULL),
(6, 'Товар 06', '32.45', '2017-03-05 15:51:40', NULL),
(7, 'Товар 07', '5.65', '2017-03-05 15:51:40', NULL),
(8, 'Товар 08', '44.80', '2017-03-05 15:51:40', NULL),
(9, 'Товар 09', '9.99', '2017-03-05 15:51:40', NULL),
(10, 'Товар 10', '11.20', '2017-03-05 15:51:40', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `orders_statuses`
--
ALTER TABLE `orders_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_statuses_history`
--
ALTER TABLE `orders_statuses_history`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
