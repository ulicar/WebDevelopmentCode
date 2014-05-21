<?php

$d = dirname(__FILE__);

require_once $d . '/Tax.php';


class ProgressiveTax implements Tax {


    /**
     * Uvecava osnovni iznos primjenom progresivne porezne stope.
     *
     * @param number $price iznos na koji se primijenjuje porez
     * @return number cijena nakon primjene poreza
     */
    public function applyTax($price) {
        return $price * (1 + $this->getRate($price));
    }


    /**
     * Racuna poreznu stopu za zadani iznos.
     *
     * Za iznose od 0 do 10000 koristi se porezna stopa od maksimalno 
     * 20%, proporcionalno primljenom iznosu. Primjerice, za iznos 5000
     * koristi se porezna stopa od 10%, a za 10000 od 20%. Za sve iznose
     * iznad 10000 primijenjuje se porezna stopa od 25%.
     *
     * @param number $price cijena za koju treba odrediti poreznu stupu
     * @return number porezna stopa
     */
    private function getRate($price) {
        if($price > 10000){
            return 0.25;
        }
        else
            return  0.2 * ($price / 10000);
    }
}
