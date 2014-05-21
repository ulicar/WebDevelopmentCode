<?php

// Ukljucivanje svih razreda
$all = dirname(__FILE__);

require_once $all . '/Cart/Cart.php';
require_once $all . '/Discount/FixedDiscount.php';
require_once $all . '/Discount/PercentageDiscount.php';
require_once $all . '/Tax/ProgressiveTax.php';
require_once $all . '/Tax/FixedTax.php';

$cart = new Cart();

$book = new Item(1, 59.99, 'PHP Cookbook');
$album = new Item(2, 20, 'Class inheritance feat. Extends');
$board = new Item(3, 100, 'Whiteboard');

$cart->addItem($book, 10);
$cart->addItem($album);
$cart->addItem($board);

echo sprintf('Cart contains %d items<br>', $cart->getSize());

foreach($cart->getItems() as $item) {
    echo $item->getPrice(), " ", $item->getName(), " ", $cart->getQuantity($item), "<br>";
    echo $item->__toString(), "<br>";
}

$discount = new FixedDiscount(10);
$tax = new FixedTax(10);

echo sprintf('I need to pay %.2f<br>', $cart->getTotal($tax, $discount));
echo 'I have too many books, need to remove some.<br>';

$cart->removeItem($book, 3);

echo sprintf(
    'Now I need to pay %.2f because I only have %d items.<br>', 
    $cart->getTotal($tax, $discount), $cart->getSize()
);

echo 'Books are important, I\'m adding some back anyway.<br>';

$cart->addItem($book, 2);

echo 'Hm, maybe I would be better off with progressive tax.<br>';

$tax = new ProgressiveTax();

echo sprintf('Total price after tax = %.2f<br>', $cart->getTotal($tax, $discount));