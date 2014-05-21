<?php

$d = dirname(__FILE__);

require_once $d . '/CartException.php';
require_once $d . '/Item.php';
require_once $d . '/../Tax/Tax.php';
require_once $d . '/../Discount/Discount.php';



class Cart {

    /**
     * @var Item[] polje artikala
     */
    private $items = array();


    /**
     * @var array polje u kojem se za svaki artikl (id) pamti koliko ga ima
     */
    private $quantities = array();


    /**
     * Stvara novu kosaricu s mogucnoscu da se odmah dodaju neki artikli.
     *
     * @param Item[] $item polje artikala koji se odmah dodaju u kosaricu
     */
    public function __construct($items = array()) {
        foreach ($items as $item) {
            $this->addItem($item);      
        }
    }


    /**
     * U kosaricu dodaje novi artikl. Vise poziva za isti artikl povecava
     * kolicinu tog artikla u kosarici. Dodaje se $quantity elemenata u kosaricu.
     *
     * @param Item $item artikl koji je potrebno dodati u kosaricu
     * @param int $quantity Kolicina koja se dodaje
     */
    public function addItem(Item $item, $quantity = 1) {
        if(array_key_exists($item->getId(), $this->quantities)){
                $this->quantities[$item->getId()] += $quantity;
        }else{
                $this->quantities[$item->getId()] = $quantity;
                $this->items[] = $item;
        }
     }
    
     /**
     * Vraca polje sa svim artiklima kosarice. Ako ima vise artikala istog tipa
     * svi se vracaju. (Primjerice moze biti array(p1, p1, p2) ako su dodana 
     * dva proizovda p1 i jedan p2
     *
     * @return Item[] polje svih artikala ili prazno polje
     */
    public function getItems() {
        return $this->items;
    }
              

    /**
     * Dohvaca kolicinu artikala u kosarice.
     *
     * @return integer kolicinu trazenog artikla u kosarici
     */
    public function getQuantity(Item $item) {
        if(array_key_exists($item->getId(), $this->quantities)){
            return($this->quantities[$item->getId()]);
        }
        return 0;
    }

    /**
     * Dohvaca broj artikala iz kosarice.
     *
     * @return integer broj artikala kosarice
     */
    public function getSize() {
        return array_sum($this->quantities);
    }
    

    /**
     * Racuna ukupnu cijenu kosarice.
     *
     * Popust se racuna za svaki artikl zasebno, a na zbroj cijena umanjenih za
     * popust dodaje se porez.
     *
     * @param Tax $tax porez koji se koristi prilikom izracuna ukupne cijene
     * @param Discount $discount popust kojim se smanjuje cijena artikla prije poreza
     * @return number ukupna cijena kosarice nakon primjene popusta i poreza
     */
    public function getTotal(Tax $tax, Discount $discount) {
        $total = 0;
        foreach ($this->items as $item) {
            $total += ($discount->applyDiscount($item) * $this->getQuantity($item));
        }
        return $tax->applyTax($total);

    }
    

    /**
     * Iz kosarice uklanja zadani artikl. Ako artikala tog tipa ima vise, 
     * uklanja se samo $quantity artikala
     *
     * @param Item $item artikl koji je potrebno ukloniti
     * @param int $quantity kolicina artikala kojih se uklanja
     * @throws CartException ako u kosarici ne postoji zadani artikl ili ih nema dovoljno
     */
    public function removeItem(Item $item, $quantity = 1) {
        if(!in_array($item, $this->items, True)){
            throw new CartException("Item doesn't exist.");
        }
        if(!array_key_exists($item->getId(), $this->quantities)){
            throw new CartException("Cannot find Item ID in quanitites array.");
        }
        if($this->quantities[$item->getId()] < $quantity){
            throw new CartException("Not enough items (in quantity array).");       
        }
        if($this->quantities[$item->getId()] === $quantity){
            unset($this->quantities[$item->getId()]);
            unset($this->items[array_search($item->getId(), $this->items)]);
        }
        else{
            $this->quantities[$item->getId()] -= $quantity;
        } 
    }
    /**
     * Return string representation of an object
     */
    public function __toString() {
        return __CLASS__ . " Class";
    }
        
}
