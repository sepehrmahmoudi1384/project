<?php

namespace database;

class CreateDB extends Database
{
    private array $createTableQueries = [
        "CREATE TABLE `categories` (
        `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `name` varchar(120) NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

        "CREATE TABLE `users` (
        `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `username` varchar(120) NOT NULL,
        `email` varchar(120) NOT NULL,
        `password` varchar(255) NOT NULL,
        `permission` enum('user','admin') NOT NULL DEFAULT 'user',
        `verify_token` varchar(255) DEFAULT NULL,
        `is_active` tinyint(4) DEFAULT 0 COMMENT '0 means inactive and 1 means active',
        `forgot_token` varchar(255) DEFAULT NULL,
        `forgot_token_expire` varchar(255) DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL,
        UNIQUE KEY `uc_email_users` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

        "CREATE TABLE `settings` (
        `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `title` varchar(120) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `keywords` text DEFAULT NULL,
        `logo` text DEFAULT NULL,
        `icon` text DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

        "CREATE TABLE `menus` (
        `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `name` varchar(120) NOT NULL,
        `url` varchar(255) NOT NULL,
        `parent_id` int(10) UNSIGNED DEFAULT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL,
        CONSTRAINT fk_menus_menus FOREIGN KEY (parent_id) REFERENCES menus(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

        "CREATE TABLE `banners` (
        `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `image` text NOT NULL,
        `url` varchar(255) NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

        "CREATE TABLE `posts` (
        `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `title` varchar(120) NOT NULL,
        `summary` text NOT NULL,
        `body` text NOT NULL,
        `view` int(11) NOT NULL DEFAULT 0,
        `user_id` int(10) UNSIGNED NOT NULL,
        `cat_id` int(10) UNSIGNED NOT NULL,
        `image` text NOT NULL,
        `status` enum('enable','disable') NOT NULL DEFAULT 'disable',
        `selected` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 => no, 2 => yes',
        `breaking_news` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 => no, 2 => yes',
        `published_at` datetime NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL,
        CONSTRAINT `fk_categories_posts` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_users_posts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

        "CREATE TABLE `comments` (
        `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `user_id` int(10) UNSIGNED NOT NULL,
        `post_id` int(10) UNSIGNED NOT NULL,
        `comment` text NOT NULL,
        `status` enum('unseen','seen','approved') NOT NULL DEFAULT 'unseen',
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL,
        CONSTRAINT `fk_posts_comments` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk_users_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
    ];

    public function run()
    {
        foreach ($this->createTableQueries as $query) {
            $this->connection->exec($query);
        }
    }
}
