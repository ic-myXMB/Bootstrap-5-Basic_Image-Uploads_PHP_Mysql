CREATE TABLE IF NOT EXISTS `slides` (
`slide_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
`slide_image` TEXT NOT NULL,
`slide_status` INT NOT NULL
);

INSERT INTO `slides` VALUES('1', '1666766964.jpg', '1');
INSERT INTO `slides` VALUES('2', '1666767091.jpg', '0');
INSERT INTO `slides` VALUES('3', '1666767152.jpg', '0');

