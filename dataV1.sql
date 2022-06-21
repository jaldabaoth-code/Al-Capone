/* Create table for Bribe */
DROP TABLE IF EXISTS `bribe`;
CREATE TABLE `bribe` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `payment` int NOT NULL,
    PRIMARY KEY (`id`)
);
