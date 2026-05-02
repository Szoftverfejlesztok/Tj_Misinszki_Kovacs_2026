-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Máj 02. 15:32
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `laravel_teszt`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `inspection`
--

CREATE TABLE `inspection` (
  `id` int(11) NOT NULL,
  `roomid` int(11) NOT NULL,
  `user_presence` enum('0','1') NOT NULL,
  `recorderid` bigint(20) UNSIGNED NOT NULL,
  `recordedid` bigint(20) UNSIGNED NOT NULL,
  `record` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `inspection`
--

INSERT INTO `inspection` (`id`, `roomid`, `user_presence`, `recorderid`, `recordedid`, `record`, `date`) VALUES
(1, 5, '0', 1, 29, 'Rendetlen a szekrény és nem mosogatott el', '2026-01-16 10:37:39'),
(2, 5, '0', 1, 29, 'Rendetlen a szekrény és nem mosogatott el', '2026-01-16 10:42:10'),
(4, 6, '1', 29, 31, 'Rendetlen a szekrény és nem mosogatott el', '2026-01-16 11:07:56'),
(5, 6, '1', 1, 30, '9 óra után nem volt a szobába', '2026-01-29 17:39:56'),
(15, 6, '1', 1, 29, 'Helll Yeaaaa', '2026-02-03 20:15:15'),
(16, 6, '1', 1, 29, 'Szijaaaa Geriiii 44', '2026-02-04 18:03:37'),
(18, 6, '1', 1, 30, 'teszt', '2026-03-05 13:37:58'),
(19, 6, '1', 1, 30, 'teszt', '2026-03-05 13:38:14'),
(20, 6, '1', 1, 30, 'teszt', '2026-03-05 13:38:32'),
(25, 5, '1', 1, 1, 'a', '2026-03-05 14:00:36'),
(26, 5, '1', 1, 1, 'aa', '2026-03-05 14:00:42'),
(27, 5, '1', 1, 1, 'aaaa', '2026-03-05 14:00:46'),
(28, 5, '1', 1, 1, 'aa', '2026-03-05 14:00:56'),
(29, 5, '1', 1, 1, 'aaa', '2026-03-05 14:01:26'),
(30, 5, '1', 1, 1, 'aaa', '2026-03-05 14:15:47'),
(31, 5, '1', 1, 1, 'aaaaa', '2026-03-05 14:15:51'),
(32, 5, '1', 1, 1, 'aaaaaa', '2026-03-05 14:15:56'),
(33, 6, '1', 1, 30, 'aaa', '2026-03-05 14:20:34'),
(34, 5, '1', 1, 1, 'na most jóuuu vagy nem?', '2026-03-05 15:05:00'),
(35, 6, '1', 1, 29, 'asas', '2026-03-06 07:15:17'),
(36, 6, '1', 1, 29, 'asasasa', '2026-03-06 07:15:22'),
(37, 6, '1', 1, 29, 'asasasa', '2026-03-06 07:15:27'),
(38, 6, '1', 1, 29, 'asasasasas', '2026-03-06 07:15:33'),
(39, 6, '1', 1, 29, 'aa', '2026-03-06 14:58:24'),
(40, 6, '1', 1, 29, 'aaa', '2026-03-06 14:58:42'),
(41, 6, '1', 1, 29, 'Na ezt most megérdemelted', '2026-03-08 19:07:43'),
(42, 6, '1', 1, 29, 'na de aztán ezt is..', '2026-03-08 19:07:55'),
(43, 5, '1', 29, 1, '5', '2026-03-09 17:48:37'),
(44, 5, '1', 1, 1, 'teszt', '2026-03-16 20:38:43'),
(45, 5, '1', 1, 1, 'teszt', '2026-03-16 20:38:49'),
(46, 6, '1', 1, 29, 'Teszt', '2026-03-19 15:11:01'),
(47, 6, '1', 1, 29, 'teszt', '2026-04-04 09:18:42'),
(48, 6, '1', 1, 29, 'teszt', '2026-04-04 09:18:55'),
(49, 6, '1', 1, 29, 'teszt', '2026-04-04 09:19:00'),
(50, 5, '1', 1, 1, 'Rendetlen szoba', '2026-04-04 10:09:13'),
(51, 5, '1', 1, 1, 'Nincs kint 9 órakkor', '2026-04-04 10:09:22'),
(52, 5, '1', 1, 1, '9 óra utáni mászkálás', '2026-04-04 10:09:40'),
(53, 5, '1', 1, 1, '1', '2026-04-04 10:09:45'),
(54, 5, '1', 1, 1, 'Rendetlen szekrény', '2026-04-04 10:10:01'),
(55, 6, '1', 1, 29, 'Rendetlen ágy', '2026-04-04 10:10:20'),
(56, 6, '1', 1, 29, 'Szemetest nem vitte ki', '2026-04-04 10:10:35'),
(57, 6, '1', 1, 29, '9 óra utáni séta', '2026-04-04 10:10:57'),
(58, 5, '1', 1, 1, 'teszt', '2026-04-04 10:22:32'),
(59, 6, '1', 1, 29, '67', '2026-04-05 19:18:01'),
(60, 5, '1', 1, 1, '67', '2026-04-05 19:57:51'),
(61, 6, '1', 1, 30, '67', '2026-04-05 19:59:11'),
(62, 5, '1', 1, 1, '78787', '2026-04-05 20:02:55'),
(63, 5, '1', 1, 28, '67', '2026-04-05 20:06:28'),
(64, 6, '1', 1, 29, '67', '2026-04-07 09:00:24'),
(65, 6, '1', 1, 29, 'nem', '2026-04-07 09:00:51'),
(66, 6, '1', 1, 29, 'Teszt', '2026-04-07 11:03:11'),
(67, 6, '1', 1, 29, 'aaa', '2026-04-23 14:35:26'),
(68, 6, '1', 1, 29, 'Rendetlen szekrény', '2026-04-23 14:36:17'),
(69, 6, '1', 1, 29, 'Nem jelent meg este 9-kor létszámellenőrzésre', '2026-04-23 14:36:39');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('misinszkimark216@gmail.com', '$2y$12$OkfbnZ1TpB93bR8wz/rbcuqGHBFXe27UKvzln03KzP6H/IMpFOLpW', '2026-03-10 14:08:20'),
('misinszkimark53@gmail.com', '$2y$12$WWQn.3saxBFr77g0rsNREO8hOIy0adcTNOEa.B6AHUocxjxLeJEYu', '2026-03-15 19:07:38');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `penalties`
--

CREATE TABLE `penalties` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `penalty_date` date NOT NULL,
  `group_leader_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `penalties`
--

INSERT INTO `penalties` (`id`, `user_id`, `penalty_date`, `group_leader_id`, `status`) VALUES
(10, 29, '2026-02-04', 1, 1),
(11, 30, '2026-03-05', 1, 1),
(13, 1, '2026-03-05', 1, 1),
(14, 1, '2026-03-05', 1, 1),
(15, 29, '2026-03-06', 1, 1),
(16, 29, '2026-03-08', 1, 1),
(17, 1, '2026-03-16', 1, 1),
(18, 29, '2026-04-04', 1, 0),
(19, 1, '2026-04-04', 1, 1),
(20, 29, '2026-04-05', 1, 0),
(21, 1, '2026-04-05', 1, 1),
(22, 29, '2026-04-23', 1, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `roles`
--

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `roles`
--

INSERT INTO `roles` (`roleid`, `name`) VALUES
(1, 'adminisztrátor'),
(2, 'csoportvezető'),
(5, 'diák'),
(3, 'nevelő'),
(4, 'szobanéző');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rooms`
--

CREATE TABLE `rooms` (
  `roomid` int(11) NOT NULL,
  `floor` enum('0','1','2') NOT NULL,
  `room_number` varchar(3) NOT NULL,
  `gender` enum('Férfi','Nő') NOT NULL,
  `capacity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `rooms`
--

INSERT INTO `rooms` (`roomid`, `floor`, `room_number`, `gender`, `capacity`) VALUES
(5, '0', '101', 'Férfi', 4),
(6, '1', '155', 'Férfi', 4),
(7, '2', '58', 'Nő', 4),
(8, '1', '485', 'Férfi', 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CRkhaOOy7O9bdhbIWbanTm6CMEoz7Y3xmXPqEzuy', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXp3bTNub3dLOEFKakVSZ3h6MktibVNuNVZLMEkya0hTbGY0RklOWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776971578),
('feVDBqjnT9hac9BCmnWE4pZS8IQAWvawq89m4iQi', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOHlWbld5QlVPOHJyWjRkalZOQ09ST3VNMHUyMEN1N3JIa2N4azZwMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4udXNlcnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1776950962),
('TxIHjbeTJQRARiSPSLzKRxFcFtKIqhq5hZ4bpzjJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2pMcTIyQWVRMTV0ZlFqdjExbThjSlhXd1ZVQmJmZlhPQkFDbnY3ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1777728623),
('XGfaATkx6obQPWuk8DT74AhCbrRordqTRbJ5E5kC', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQzhsUDI2eGlrVWRieUg1ZlFUZFhPYnBON2Q1ZGt6UW1OaktlS1NuaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1777016067);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Férfi','Nő') NOT NULL,
  `roomid` int(11) DEFAULT NULL,
  `group_leaderid` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `roomid`, `group_leaderid`, `remember_token`, `created_at`, `updated_at`, `account_status`) VALUES
(1, 'Misinszki Márk', 'misinszkimark53@gmail.com', '$2y$12$Qk1Fx9Jl.eXSekiRf.WvZOzU2s7dKJJrrnLyJogLgobS3z00z3/h6', 'Férfi', 5, NULL, 'KXuojKj9VQTK7m2L9Ieo3TlP25oGYKu0yrckEZPRlqz6TXi6iAbL9WTB0HPk', '2025-12-09 12:02:51', '2026-04-11 14:24:57', 1),
(28, 'Piri Kristóf', 'kristofpiri@gmail.com', '$2y$12$XByix2zcgq8eOhBz4h2kwewmKOBXvCBqaYnxEGpup57X53j59cI6u', 'Nő', 5, NULL, NULL, '2026-01-08 16:16:04', '2026-01-08 16:16:04', 1),
(29, 'Kovács Gergely', 'kovager@gmail.com', '$2y$12$8t2Wiq/yzSHb/PyzLA/odeQmUDwxmo4gsNovgqYIEHMKXatnjcfoO', 'Férfi', 6, NULL, NULL, '2026-01-09 09:41:02', '2026-03-19 14:56:07', 1),
(30, 'Molnár Petra', 'ptruskaaa@gmail.com', '$2y$12$K.C1RoOq6SAQ8jmZoISQ3upshiJerlh0FyP6X5JtIEpDX0icV0bFu', 'Nő', 6, 37, NULL, '2026-01-10 11:09:02', '2026-03-10 18:41:56', 1),
(31, 'Horvát Ádám', 'adika@gmail.com', '$2y$12$dgxERVyLmHg5im9RisqYEuPv8psfZaK87E3R.lhUlG3ImTXi101V.', 'Férfi', NULL, NULL, NULL, '2026-01-13 14:33:34', '2026-01-13 14:33:34', 1),
(35, 'Már teszteli', 'misinszkimark216@gmail.com', '$2y$12$pX2ArdvPG/w.HG/dOHDLYuhrj0LTBc8cIcJb3jCOynqyAqRv8wPty', 'Férfi', NULL, NULL, NULL, '2026-03-10 12:41:30', '2026-03-10 17:07:36', 0),
(36, 'Fitala Marcell', 'fitala@gmail.com', '$2y$12$9cX7sUWOF0Gm9fIkHoK56eG/kUcYcCtAd7TXUsJhyDgA6nwYxvFvK', 'Férfi', NULL, NULL, NULL, '2026-03-10 14:21:49', '2026-03-10 17:29:25', 1),
(37, 'Csoporvezetői fiók', 'csoportvezeto@gmail.com', '$2y$12$gZ4/glnT4y8yjMQ09es91ed1VIRV5LSrlDJZKf2C0jWciYwHNdXCe', 'Férfi', NULL, NULL, NULL, '2026-03-10 18:12:28', '2026-03-10 18:15:03', 1),
(38, 'Aladinnnn', 'aladinnnn@gmail.com', '$2y$12$71f44fpz5GDfpkTsoRYt3.5ZapmFmlShVejlzZkXPjREqg4Z49tDO', 'Férfi', NULL, NULL, NULL, '2026-03-11 16:59:42', '2026-03-11 17:05:13', 1),
(39, 'Csoportvezető Feri', 'feri@gmail.com', '$2y$12$edSdWbn0kHZISLuWC6zdQeOlXpNLir2sPT5ypMb8Ig/gZii5KesDO', 'Férfi', NULL, NULL, NULL, '2026-03-12 13:36:34', '2026-03-12 13:36:34', 1),
(40, 'Diák Márk', 'mark@gmail.com', '$2y$12$JGH0kRrSmG2mtBhNtmLtJu9kV.J/ifrZv/R6Lu0F8B3CNmnsxLuAy', 'Férfi', NULL, NULL, NULL, '2026-03-12 13:39:25', '2026-03-12 13:39:25', 1),
(41, 'Szobanéző Pityu', 'pityu@gmail.com', '$2y$12$SRQpFUOOz.84A/9Tm1fAKOlHK7Q0aAZkeH2/nPd1ecFPtr6y1XOd6', 'Férfi', NULL, NULL, NULL, '2026-03-12 13:41:31', '2026-03-12 13:41:31', 1),
(42, 'Nevelő Sándor', 'sanyi@gmail.com', '$2y$12$j5oyrZOy22To5OgzvK9VneM5W3s6LUGSK00MWcHdL.S11pW1SKJP.', 'Férfi', NULL, NULL, NULL, '2026-03-12 13:43:16', '2026-03-12 13:43:16', 1),
(43, 'Diák Ferkó', 'ferko@gmail.com', '$2y$12$noC1ET.JaW7GGQRb1vVQReVUIQtEdLJ8aGn07/WlMq9CkF0kXfFtS', 'Férfi', NULL, NULL, NULL, '2026-03-14 14:59:31', '2026-03-14 14:59:31', 1),
(44, 'teszt', 'teszt@gmail.com', '$2y$12$RQfnnOQ1xUV9j8oei20rve6S8eaTP5jNAQf52z5lCGKHcbhXysrHa', 'Férfi', NULL, NULL, NULL, '2026-03-14 16:20:20', '2026-03-15 08:41:21', 1),
(45, 'Vizsga_felhasználó', 'tjvizsga@gmail.com', '$2y$12$65vMbWidTCU8AFBkInBBZed8wNtvdzyWhWxqKmPua6BvPfh6CoVka', 'Férfi', NULL, NULL, NULL, '2026-04-04 07:16:03', '2026-04-04 07:20:33', 1),
(46, 'Aladin Termi', 'aladinnn53@gmail.com', '$2y$12$VELleRbExfVZd3G9JL4E5OQ9bgVMj5QEGSyxMQBA1hAVXbB7xGN4i', 'Férfi', NULL, NULL, NULL, '2026-04-04 07:19:37', '2026-04-04 07:19:37', 1),
(47, 'Szentpéteri Adél', 'adel@gmail.com', '$2y$12$1JZ5WZIljdSLwBj2e9Z0Z.vsvpO/6k4kaBB9hF0FOU4vUOwStrrN2', 'Nő', NULL, NULL, NULL, '2026-04-05 17:54:19', '2026-04-05 17:54:19', 1),
(48, 'Tokai Máté', 'mate@gmail.com', '$2y$12$U8pAqIap9IvFy0W9eauiQOV9R0kWlSsRFgkU3kcnwhII7EMo4T6Q.', 'Férfi', NULL, NULL, NULL, '2026-04-05 18:00:06', '2026-04-05 18:00:06', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `userid` bigint(20) UNSIGNED NOT NULL,
  `roleid` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user_role`
--

INSERT INTO `user_role` (`id`, `userid`, `roleid`, `create_date`) VALUES
(27, 28, 5, '2026-01-08 17:16:04'),
(29, 30, 5, '2026-01-10 12:09:02'),
(30, 31, 5, '2026-01-13 15:33:34'),
(46, 29, 5, '2026-03-09 17:40:45'),
(48, 1, 1, '2026-03-09 17:49:34'),
(50, 1, 5, '2026-03-09 17:49:34'),
(52, 1, 3, '2026-03-09 17:53:47'),
(53, 35, 5, '2026-03-10 13:41:30'),
(54, 36, 5, '2026-03-10 15:21:49'),
(56, 37, 5, '2026-03-10 19:12:28'),
(58, 37, 2, '2026-03-10 19:38:25'),
(67, 39, 2, '2026-03-12 14:37:54'),
(68, 40, 5, '2026-03-12 14:39:25'),
(69, 41, 5, '2026-03-12 14:41:31'),
(70, 42, 5, '2026-03-12 14:43:16'),
(71, 43, 5, '2026-03-14 15:59:31'),
(72, 44, 5, '2026-03-14 17:20:20'),
(75, 30, 4, '2026-03-24 14:45:54'),
(76, 38, 5, '2026-03-24 14:46:13'),
(77, 38, 4, '2026-03-24 14:46:13'),
(78, 44, 4, '2026-03-24 14:46:45'),
(79, 28, 4, '2026-03-24 14:47:21'),
(80, 28, 3, '2026-03-24 16:40:52'),
(81, 29, 4, '2026-03-31 19:42:45'),
(82, 45, 5, '2026-04-04 09:16:03'),
(83, 46, 5, '2026-04-04 09:19:37'),
(84, 45, 1, '2026-04-04 09:21:32'),
(85, 45, 2, '2026-04-04 09:21:32'),
(86, 45, 3, '2026-04-04 09:21:32'),
(87, 45, 4, '2026-04-04 09:21:32'),
(88, 47, 5, '2026-04-05 19:54:19'),
(89, 47, 4, '2026-04-05 19:54:44'),
(90, 48, 5, '2026-04-05 20:00:06'),
(93, 48, 4, '2026-04-05 20:01:40'),
(95, 36, 4, '2026-04-23 13:19:26'),
(96, 1, 2, '2026-04-23 13:29:21');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `weekly_assignments`
--

CREATE TABLE `weekly_assignments` (
  `id` int(11) NOT NULL,
  `assigned_user_id_1` bigint(20) UNSIGNED NOT NULL,
  `assigned_user_id_2` bigint(20) UNSIGNED NOT NULL,
  `assignment_date` date NOT NULL,
  `assigned_level` enum('0','1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `weekly_assignments`
--

INSERT INTO `weekly_assignments` (`id`, `assigned_user_id_1`, `assigned_user_id_2`, `assignment_date`, `assigned_level`) VALUES
(1, 1, 29, '2026-02-06', '1'),
(2, 29, 36, '2026-03-19', '0'),
(3, 28, 30, '2026-03-19', '2'),
(8, 38, 44, '2026-03-24', '0'),
(9, 30, 28, '2026-03-24', '1'),
(10, 38, 29, '2026-03-25', '0'),
(11, 30, 28, '2026-03-25', '1'),
(14, 38, 29, '2026-03-26', '1'),
(15, 30, 28, '2026-03-26', '2'),
(16, 38, 29, '2026-03-29', '1'),
(17, 30, 28, '2026-03-29', '2'),
(18, 29, 44, '2026-04-07', '1'),
(19, 30, 47, '2026-04-07', '2'),
(20, 29, 44, '2026-04-25', '1'),
(21, 30, 47, '2026-04-25', '2'),
(22, 29, 44, '2026-04-30', '1'),
(23, 30, 47, '2026-04-30', '2'),
(26, 36, 48, '2026-04-23', '1'),
(27, 30, 47, '2026-04-23', '2');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- A tábla indexei `inspection`
--
ALTER TABLE `inspection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inspection_roomid_idx` (`roomid`),
  ADD KEY `inspection_recorderid_idx` (`recorderid`),
  ADD KEY `inspection_recordedid_idx` (`recordedid`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_leader_id` (`group_leader_id`);

--
-- A tábla indexei `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- A tábla indexei `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomid`),
  ADD UNIQUE KEY `floor_roomnumber_unique` (`floor`,`room_number`);

--
-- A tábla indexei `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_roomid_fk` (`roomid`),
  ADD KEY `users_group_leaderid_fk` (`group_leaderid`);

--
-- A tábla indexei `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_role2_unique` (`userid`,`roleid`),
  ADD KEY `user_role2_role_fk` (`roleid`);

--
-- A tábla indexei `weekly_assignments`
--
ALTER TABLE `weekly_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_assignments_user1_idx` (`assigned_user_id_1`),
  ADD KEY `weekly_assignments_user2_idx` (`assigned_user_id_2`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `inspection`
--
ALTER TABLE `inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT a táblához `roles`
--
ALTER TABLE `roles`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT a táblához `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT a táblához `weekly_assignments`
--
ALTER TABLE `weekly_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `inspection`
--
ALTER TABLE `inspection`
  ADD CONSTRAINT `fk_inspection_recorded` FOREIGN KEY (`recordedid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_inspection_recorder` FOREIGN KEY (`recorderid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_inspection_room` FOREIGN KEY (`roomid`) REFERENCES `rooms` (`roomid`);

--
-- Megkötések a táblához `penalties`
--
ALTER TABLE `penalties`
  ADD CONSTRAINT `penalties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `penalties_ibfk_2` FOREIGN KEY (`group_leader_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_group_leader` FOREIGN KEY (`group_leaderid`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_roomid_fk` FOREIGN KEY (`roomid`) REFERENCES `rooms` (`roomid`) ON DELETE SET NULL;

--
-- Megkötések a táblához `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role2_role_fk` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_role2_user_fk` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `weekly_assignments`
--
ALTER TABLE `weekly_assignments`
  ADD CONSTRAINT `fk_weekly_assignments_user1` FOREIGN KEY (`assigned_user_id_1`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_weekly_assignments_user2` FOREIGN KEY (`assigned_user_id_2`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
