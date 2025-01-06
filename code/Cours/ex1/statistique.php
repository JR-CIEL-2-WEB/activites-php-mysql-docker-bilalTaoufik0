<?php
include 'main.php';

$tab = [
    'note_maths' => 15,
    'note_francais' => 12,
    'note_histoire_geo' => 9
];

$moyenne = moyenne($tab);

echo 'La moyenne est de ' . $moyenne . ' / 20.';
?>
