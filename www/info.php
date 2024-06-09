<?php

require_once 'config.php';
require_once BASE_PATH . '/src/database/database.php';

$db = new Database();
$db->getConnection();
