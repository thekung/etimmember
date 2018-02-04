<?php
require_once 'config.php';
require_once 'ez_sql_core.php';
require_once 'ez_sql_pdo.php';
require_once 'functions_require.php';

$db = new ezSQL_pdo('mysql:host='.$cfg_db->host.';port='.$cfg_db->port.';dbname='.$cfg_db->db, $cfg_db->user,$cfg_db->password);
$db->query("SET NAMES 'utf8'");
$db->query("SET CHARACTER SET 'utf8'");
#$db = new Database;
