<?php 


//Other
define('HASH_SALT', '2011');
define('USERS_TYPES', ['1' => 'Администратор', '2' => 'Пользователь', '3' => 'Персонал технического обслуживания']);

//Database 
define('DB_TABLE_USERS_TYPE', 'users_type');
define('DB_TABLE_USERS', 'users');
define('DB_TABLE_STATIONS', 'stations');
define('DB_TABLE_STATIONS_SETIINGS_TYPE', 'stations_settings_type');
define('DB_TABLE_STATIONS_SETIINGS', 'stations_settings');
define('DB_TABLE_LOGS', 'log');
define('DB_TABLE_DIAGNOSTIC', 'dignostic');


//Pages
define('AUTH','index.php');
define('INDEX','admin/index.php');



//Settings
define('SETTING_PAPER', '2');
define('SETTING_GLASS', '1');
define('SETTING_PLASTIC', '3');
define('SETTING_TECH_PERSONAL', '4');
define('ALL_SETTINGS', [SETTING_GLASS, SETTING_PAPER, SETTING_PLASTIC, SETTING_TECH_PERSONAL]);


//

?>