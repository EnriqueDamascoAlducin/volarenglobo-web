<?php

/*======================================================================*\
|| #################################################################### ||
|| # Rhino 1.4                                                        # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright 2012 Rhino All Rights Reserved.                        # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| #   ---------------- Rhino IS NOT FREE SOFTWARE ----------------   # ||
|| #                 http://www.livesupportrhino.com                  # ||
|| #################################################################### ||
\*======================================================================*/

// Database connection and setup
define('DB_HOST', 'localhost'); // Database host ## Datenbank Server
define('DB_PORT', 3306); // Enter the database port for your mysql server
define('DB_USER', 'volareng_admchat'); // Database user ## Datenbank Benutzername
define('DB_PASS', '4dmch4tveg'); // Database password ## Datenbank Passwort
define('DB_NAME', 'volareng_chat'); // Database name ## Datenbank Name
define('DB_PREFIX', 'Chat'); // Database prefix use (a-z) and (_)

// Define a unique key for your site, don't change after, or people can't login anymore for example: 3l2kLOk2so
define('DB_PASS_HASH', '4dmch4tveg');

// Define your site url, for example: www.lscms.com
define('FULL_SITE_DOMAIN', 'www.volarenglobo.com.mx');

// Define cookie path and lifetime
define('LS_COOKIE_PATH', '/');  // Available in the whole domain
define('LS_COOKIE_TIME', 60*60*24*30); // 30 days by default

// MySQL or MySQLi
define('LS_MYSQL_CONNECTION', 1); // Use 1 for MySQLi or 2 for MySQL

// Choose a cache directory to reduce page and server load
define('LS_CACHE_DIRECTORY', 'cache');

// Choose the userfiles directory, rename if you like different location
define('LS_FILES_DIRECTORY', 'files');

// Important Stuff
define('LS_SUPERADMIN', '1'); // Undeletable and SuperADMIN User, more user seperate with comma. e.g. 1,4,5,6 (userid)
define('LS_ADMIN', '1'); // Access to the admin panel, add more user seperate with comma. e.g. 1,3,7,13 (userid)
?>