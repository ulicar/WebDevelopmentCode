<?php

require_once 'validate.php';


function assertEquals($left, $right, $msg = "Provjera nije uspjela\n") {
    if($left !== $right) {
        echo $msg;
    }
}


function assertHandler($file, $line, $code, $desc = null) {
    echo sprintf(
        "Provjera nije uspjela: datoteka=%s, linija=%s, kod=%s, opis=%s\n",
        $file, $line, $code, $desc === null ? 'N/A' : $desc
    );
}


// Nedopusta PHP-u da javi WARNING
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

// Sami odredjujemo sto se dogadja u slucaju da assert vrati false
assert_options(ASSERT_CALLBACK, 'assertHandler');


// Test email
assert("isEmail('oipa@php.fer.hr')");
assert("isEmail('josip.domsic@fer.hr')");
assert("isEmail('osoba.x@test.com')");
assert("isEmail('netko+nesto@test.com')");
//assert("isEmail('@lose.com')", 'Nepotpuna adresa');

// Test max length
assert("isMaxLength('test', 4)");
assert("isMaxLength('šđčć', 4)");
assert("isMaxLength('abc', 4)");
//assert("isMaxLength('dugačko', 4)", 'Vise od 4 znaka');

// Test min length 
assert("isMinLength('abc', 3)");
assert("isMinLength('abcde', 3)");
//assert("isMinLength('a', 3)", 'Prekratak niz znakova');

// Test number
assert("isNumber('16')");
assert("isNumber('32.75')");
assert("isNumber('-256')");
assert("isNumber('-256.88')");
assert("isNumber('8.128e+512')");
assert("isNumber('-8.128e-512')");
//assert("isNumber('105b')", 'Sadrzi slovo b');

// Test provided
assert("isProvided('abc')");
assert("isProvided('Š')");
//assert("isProvided('')", 'Prazan niz znakova');

// Test URL
assert("isUrl('http://php.fer.hr')");
assert("isUrl('https://paypal.com')");
assert("isUrl('http://php.fer.hr/~hg45399/test.php?a=10')");
assert("isUrl('www.google.com')");
//assert("isUrl('http://.com')", 'Nedostaje dio URL-a');

// Custom testiranje
assertEquals(getRuleError('email'), EMAIL_ERROR);
assertEquals(getRuleError('url'), URL_ERROR);
assertEquals(getRuleError('number'), NUMBER_ERROR);
assertEquals(getRuleError('required'), REQUIRED_ERROR);
assertEquals(getRuleError('max_length'), MAX_LEN_ERROR);
assertEquals(getRuleError('min_length[0]'), MIN_LEN_ERROR);


assertEquals(getRuleHandler('email'), array('isEmail', array()));
assertEquals(getRuleHandler('number'), array('isNumber', array()));
assertEquals(getRuleHandler('url'), array('isUrl', array()));
assertEquals(getRuleHandler('required'), array('isProvided', array()));
assertEquals(getRuleHandler('min_length[11]'), array('isMinLength', array('11')));
assertEquals(getRuleHandler('max_length[10]'), array('isMaxLength', array('10')));


assertEquals(
    getRuleHandlers(array('email', 'max_length[10]')), 
    array(
        array('isEmail', array()), 
        array('isMaxLength', array('10'))
    )
);
assertEquals(
    getRuleHandlers(array('url', 'min_length[10]', 'max_length[100]', 'required')), 
    array(
        array('isUrl', array()), 
        array('isMinLength', array('10')),
        array('isMaxLength', array('100')),
        array('isProvided', array())
    )
);


echo "in";
assertEquals(
    validate(
        array(
            'username' => '',
            'password' => 'lozinka',
            'age' => '32',
            'rating' => '20'
        ),
        array(
            'username' => 'required|min_length[5]',
            'password' => 'required',
            'age' => 'equals[32]',
            'rating' => 'in_range[16,64]'
        ),
        array(
            'equals' => function ($value) {
                // to be implemented
            },
            'in_range' => function ($bottom, $top) {
                // to be implemented
            }
        )
    ), array(
        'username' => array(REQUIRED_ERROR, MIN_LEN_ERROR)
    )
);
echo "out"; 