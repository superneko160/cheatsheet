--
-- テーブルの構造 `users`
--
CREATE TABLE `users` (
  `id` int NOT NULL PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--  `users` ダミーデータ
INSERT INTO `users` (`id`, `name`, `tel`, `address`, `password`) VALUES (1, 'テスト太郎', '123-456-7890', '東京都千代田区xxx', 'password123');
INSERT INTO `users` (`id`, `name`, `tel`, `address`, `password`) VALUES (2, 'テスト花子', '987-654-3210', '東京都渋谷区yyy', 'password456');
INSERT INTO `users` (`id`, `name`, `tel`, `address`, `password`) VALUES (3, 'ジョン・スミス', '555-555-5555', 'カリフォルニア州ロサンゼルス', 'password789');
INSERT INTO `users` (`id`, `name`, `tel`, `address`, `password`) VALUES (4, '伊藤博文', '111-222-3333', '東京都永田町aaa', 'passwd');
INSERT INTO `users` (`id`, `name`, `tel`, `address`, `password`) VALUES (5, 'カエサル', '999-888-7777', 'ローマ', 'qxc0_zw');
