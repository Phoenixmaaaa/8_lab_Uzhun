<?php
require_once 'MySqlAdsRepository.php';
require_once '../Lab4/AdsBoard.php';

$repository = new \Lab5\MySqlAdsRepository();
$board = new \Lab4\AdsBoard('/Lab5/page.php', $repository);
$board->handleRequest();