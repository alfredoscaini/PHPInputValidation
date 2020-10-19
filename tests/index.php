<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true); 

$path = str_replace('tests', 'src', __DIR__) . '/Validation.php';
require_once($path);

use WC\Validation;

$checks = [
   '3 is an integer? ' . ( (Validation::check(3, Validation::NUMBER)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'A is an integer? ' . ( (Validation::check('A', Validation::NUMBER)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'A is a string? ' . ( (Validation::check('A', Validation::TEXT)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   '3 is a string? ' . ( (Validation::check(3, Validation::TEXT)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'example.com is an email? ' . ( (Validation::check('example.com', Validation::EMAIL)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'fred@example.com is an email? ' . ( (Validation::check('fred@example.com', Validation::EMAIL)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   '613-559-9955 is a phone number? ' . ( (Validation::check('613-559-9955', Validation::PHONE)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   '6135599955 is a phone number? ' . ( (Validation::check('6135599955', Validation::PHONE)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   '613 559 9955 is a phone number? ' . ( (Validation::check('613 559 9955', Validation::PHONE)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   '559-9955 is a phone number? ' . ( (Validation::check('559-9955', Validation::PHONE)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'example.com is a url? ' . ( (Validation::check('example.com', Validation::URL)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'http://example.com is a url? ' . ( (Validation::check('http://example.com', Validation::URL)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'http://www.example.com is a url? ' . ( (Validation::check('http://www.example.com', Validation::URL)) ? 'true' : '<span style="color:#f00;">false</span>' . '.'),
   'fred@example.com is a url? ' . ( (Validation::check('fred@example.com', Validation::URL)) ? 'true' : '<span style="color:#f00;">false</span>' . '.')
   
];

print '<h1>Validation Checking</h1>';
print '<ul>';
foreach($checks as $check) {
  print '<li>' . $check . '</li>';
}
print '</ul>';