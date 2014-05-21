<?php

class Item {

    /**
     * @var int jedinstveni identifikator artikla
     */
    protected $id;

    /**
     * @var double cijena artikla
     */
    protected $price;
    
    /* 
     * @var string Ime artikla
     */
    protected $name;


    /**
     * @param int $id
     * @param double $price
     * @param string $name
     */
    public function __construct($id, $price, $name) {
        $this->id = uniqid($id);
        $this->name = $name;
        $this->price = $price;
    }
    

    /**
     * Dohvaca ID artikla.
     *
     * @return string ID artikla
     */
    public function getId() {
        return $this->id;
    }

    
    /**
     * Dohvaca cijenu artikla.
     *
     * @return double cijena artikla
     */
    public function getPrice() {
        return $this->price;
    }
    
    /**
     * Dohvaca ime artikla.
     *
     * @return double cijena artikla
     */
    public function getName() {
        return $this->name;
    }
    /**
     * Vraca true ako su dva artikla jednaka. Koristite kod usporedbe artikala
     * jer $obj === $obj nekada nece raditi kako ocekujete.
     *
     * @param Item $item drugi artikl s kojim se usporedjuje
     * @return boolean
     */
    public function equals(Item $item) {
        if($this->id === $item->getId()){
            return True;
        }
        return False;
    }
    
    /** 
     * Returns string representation of an object
     */
    public function __toString() {
        return __CLASS__ . " Class. Variables: id='" . $this->id . "' price='" . 
                        $this->price . "' name='" . $this->name . "'" ;
    }
        
}
