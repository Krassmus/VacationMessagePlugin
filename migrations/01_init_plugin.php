<?php

class InitPlugin extends Migration {
    
    public function up() {
        DBManager::get()->exec("
            CREATE TABLE `vacation_messages` (
                `user_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                `message` text COLLATE utf8mb4_unicode_ci,
                `start` int(11) DEFAULT NULL,
                `end` int(11) DEFAULT NULL,
                `chdate` int(11) DEFAULT NULL,
                `mkdate` int(11) DEFAULT NULL,
                PRIMARY KEY (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    public function down() {
        DBManager::get()->exec("DROP TABLE `vacation_messages` ");
    }

}