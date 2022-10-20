Bootstrap 5 Basic Image Upload with PHP and Mysql:


Tools Used for this project:


SublimeText (code editor):

https://www.sublimetext.com

Bitnami MAMP Stack (localhost dev):

https://bitnami.com/stack/mamp/installer



Bootstrap 5 Basic User Avatar Image Upload with PHP and Mysql:

Author - ic-myXMB

Notice: This project is submitted and shared "AS IS" in the hopes that folks may find it of some use and hopefully see it as a starting point to continue on with further and improve upon.

Description: 

Simple 100px by 100px user avatar image upload in php and mysqli with Bootstrap 5 basic examples.


Previews:

https://github.com/ic-myXMB/Bootstrap-5-Basic_Image-Uploads_PHP_Mysql/tree/main/BS5-Basic-User-Image-Upload/Previews


Usage Files:

https://github.com/ic-myXMB/Bootstrap-5-Basic_Image-Uploads_PHP_Mysql/tree/main/BS5-Basic-User-Image-Upload/Upload


Setup:

Simply upload the files contained within the "UPLOAD" directory:

Edit:

db.php

you only need to edit this:

// Database credentials. Edit: db_username, db_password, db_name

At:

	// Connect to server and select database
    // Database connection details

    "localhost"

    "db_user"

    "db_password"

    "db_name"

Where:
   
    $mysqli = mysqli_connect("localhost", "db_user", "db_password", "db_name");



Next step is to install the db tables. Use your sql manager cp for your localhost like PHPMyAdmin

Run sql queries on your test database:
   
    CREATE TABLE IF NOT EXISTS `users` (
    	`user_id` INT(11) PRIMARY KEY AUTO_INCREMENT, 
    	`user_image` TEXT NOT NULL);

    INSERT INTO `users` VALUES('1', '1666010180.gif');

* Such query can also be found in and copied from a file if needed: 

https://github.com/ic-myXMB/Bootstrap-5-Basic_Image-Uploads_PHP_Mysql/blob/main/BS5-Basic-User-Image-Upload/db.sql



Final step is to visit the index.html file for this project on your localhost so as to allow you to visit the example pages link from such and thus begin editing, improving and developing on such project base further.


That is it! Simple enough, right?! Hopefully you may find such of interest or usage.