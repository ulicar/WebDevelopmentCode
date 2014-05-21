<?php

$d = dirname(__FILE__);

require_once $d . '/Tax.php';


class FixedTax implements Tax {


    /**
     * @var number porezna stopa
     */
    private $taxRate;


    /**
     * @param number $taxRate porezna stopa
     */
    public function __construct($taxRate) {
        $this->taxRate = $taxRate;
    }


    /**
     * Racuna iznos nakon primjene fiksne porezne poreza.
     *
     * @param number $price iznos na koji se dodaje porez
     * @return number osnovni iznos uvecan za iznos poreza
     */
    public function applyTax($price) {
        return $price * (1 + $this->taxRate / 100);
    }
}
