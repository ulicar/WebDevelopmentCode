<?php

interface Tax {

    /**
     * Racuna novi iznos nakon dodavanja poreza.
     *
     * @param number $price iznos na koji se dodaje porez
     * @return number osnovni iznos uvecan za porez
     */
    public function applyTax($price);
}
