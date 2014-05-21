<?php

$d = dirname(__FILE__);

require_once $d . '/Discount.php';
require_once $d . '/../Cart/Item.php';


class FixedDiscount extends Discount {

    public function applyDiscount(Item $item) {
        return $item->getPrice() - $this->amount;
    }
}
