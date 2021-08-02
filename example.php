<?php
// Include the afdian libs
include(__DIR__ . "/afdian.php");

// Define the user id and token
define("USERID", "your user id here");
define("TOKEN", "your token here");

// Init
$afdian = new Afdian(USERID, TOKEN);

// Ping the server
echo sprintf("Ping status: %s\n", $afdian->pingServer() ? "Success" : "Failed");

// Get all orders and cache to local file, expire at 120s
$orders = $afdian->getAllOrders(120, "order_cache.json");
print_r($orders);

// Get order info by order id
$order = $afdian->getOrderById($orders, "your order id here");
print_r($order);

// Get all sponsors and cache to redis server, expire at 600s
$sponsors = $afdian->getAllSponsors(600, "&redis=127.0.0.1:6379");
print_r($sponsors);

// Get sponsor by name
$user = $afdian->getSponsorByName($sponsors, "Lain音酱");
print_r($user);
