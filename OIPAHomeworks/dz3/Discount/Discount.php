<?php

$d = dirname(__FILE__);

require_once $d . '/../Cart/Item.php';


abstract class Discount {


    /**
     * @var number iznos popusta
     */
    protected $amount;


    /**
     * @param number $amount iznos popusta
     */
    public function __construct($amount) {
        $this->amount = $amount;
    }


    /**
     * Izracunava iznos za placanje nakon primjene popusta.
     *
     * Funkcija racuna novi iznos primjenom popusta, ali ne mijenja originalni
     * artikl, nego vraca novi iznos.
     *
     * @param Item $item artikl ciju je cijenu potrebno korigirati
     * @return number cijena artikla korigirana popustom
     */
    abstract function applyDiscount(Item $item);
}
