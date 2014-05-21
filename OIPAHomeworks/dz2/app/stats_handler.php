<?php

    require_once 'helpers/libchart/classes/libchart.php';
/**
 * Generira statistiku rijesenosti kviza.
 *
 * @param integer ukupan broj pitanja
 * @param integer broj tocnih odgovora
 * @param integer broj netocnih odgovora
 * @return string putanja do slike koja prikazuje statistiku
 */

function generate_stats($total, $correct, $wrong) {
        
        
        $width = 300 ;
        $heigth = 120 ;
        $start = 50;
        $name = "file.png";
        $padding = 20;
        
        //Stvori objekt
	$img = imagecreatetruecolor($width, $heigth);
        
        // Stvori boje
        $pozdina = "0xffffaa";
        $green    = "0x00ff00";
        $red   = "0xff0000";
        $black = "0x000000";

        //Pozadina, zuta
        imagefill($img, 0, 0, $pozdina);
        
        // Provjera ispravnosti
        if ($total !== ($correct + $wrong)){
            $total = 100;
            imagestring($img, 5, $start, $heigth/4  ,'NEISPRAVNO! ', $black);
        }
        if ($total === 0){
            $total = 1;
        }
        
        // Pravokutnici
        imagefilledrectangle($img, $start , $heigth - $padding , $heigth - $padding,
               $heigth - $padding - ($correct/$total) * 100, $green); 
        imagefilledrectangle($img, $start + 150,$heigth - $padding, $width - $start,
                $heigth - $padding - ($wrong/$total) * 100, $red); 
         
        // Linije
        for ($index = 0; $index < 5; $index++) {
            
            imagestring($img,1, 10, $index * 25, $total * (1 - $index*0.25), $black);
            imageline($img, 30, $index * 25,
                    $width - 30, $index * 25, $black);
        }
        
        // Tekst
        imagestring($img, 1, $start + 5, $heigth - $padding + 10,'Ispravno', $black);
        imagestring($img, 1, $start + 150 + 5, $heigth - $padding + 10,'Krivo', $black);
       
        // Save the image to file.png 
        imagepng($img, $name); 
        //echo $img;
        // Destroy image 
        imagedestroy($img); 
        //var_dump($img);
        return $name;
}