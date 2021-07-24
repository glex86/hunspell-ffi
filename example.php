<?php

require __DIR__ . '/hunspellFFI.php';
require __DIR__ . '/hunspell.php';

$aff = '/usr/share/hunspell/hu_HU.aff';
$dic = '/usr/share/hunspell/hu_HU.dic';

$hs = new glex\hunspell($aff, $dic);

echo "\n";
echo "+=================================\n";
echo "| SPELL\n";
echo "+---------------------------------\n";
$spellWords = ['menu', 'menü', 'lábnyom', 'gyalogosan'];
foreach ($spellWords as $word) {
    $r = $hs->spell($word);
    printf("| %s: %d\n", $word, $r);
}
echo "+---------------------------------\n";

echo "\n";
echo "+=================================\n";
echo "| SUGGEST\n";
echo "+---------------------------------\n";
$word = "korcsoly";
$r = $hs->suggest($word);
printf("| %s: %d item\n", $word, count($r));
for ($i = 0; $i < count($r); $i++) {
    printf("| %d. %s\n", $i+1, $r[$i]);
}
echo "+---------------------------------\n";

echo "\n";
echo "+=================================\n";
echo "| ANALYZE\n";
echo "+---------------------------------\n";
$word = "szavak";
$r = $hs->analyze($word);
printf("| %s: %d item\n", $word, count($r));
for ($i = 0; $i < count($r); $i++) {
    printf("| %d. %s\n", $i+1, $r[$i]);
}
echo "+---------------------------------\n";


echo "\n";
echo "+=================================\n";
echo "| STEM\n";
echo "+---------------------------------\n";
$spellWords = ['menüvel', 'karácsonyi', 'volt', 'gyalogosan'];
foreach ($spellWords as $word) {
    $r = $hs->stem($word);
    printf("| %s: %d\n", $word, count($r));
    for ($i = 0; $i < count($r); $i++) {
        printf("| - %d. %s\n", $i+1, $r[$i]);
    }
}
echo "+---------------------------------\n";



echo "\n";
echo "+=================================\n";
echo "| GENERATE\n";
echo "+---------------------------------\n";
$spellWords = ['menüvel', 'karácsonyi', 'volt', 'gyalogosan'];
foreach ($spellWords as $word) {
    $r = $hs->generate('kéz', $word);
    printf("| %s: %d\n", $word, count($r));
    for ($i = 0; $i < count($r); $i++) {
        printf("| - %d. %s\n", $i+1, $r[$i]);
    }
}
echo "+---------------------------------\n";


echo "\n";
echo "+=================================\n";
echo "| Add\n";
echo "+---------------------------------\n";
$spellWords = ['glex', 'glexster', 'g-lex'];
foreach ($spellWords as $word) {
    $r = $hs->spell($word);
    printf("| %s: %d\n", $word, $r);
}
echo "+---------------------------------\n";

$hs->add('glex');
$hs->add('g-lex');


echo "+---------------------------------\n";
$spellWords = ['glex', 'glexster', 'g-lex'];
foreach ($spellWords as $word) {
    $r = $hs->spell($word);
    printf("| %s: %d\n", $word, $r);
}
echo "+---------------------------------\n";

echo "\n";
echo "+=================================\n";
echo "| Remove\n";
echo "+---------------------------------\n";
$hs->remove('glex');
$spellWords = ['glex', 'glexster', 'g-lex'];
foreach ($spellWords as $word) {
    $r = $hs->spell($word);
    printf("| %s: %d\n", $word, $r);
}
echo "+---------------------------------\n";


echo "\n";