<?php
function moyenne($notes) {
    $somme = array_sum($notes);
    $nombre_de_notes = count($notes);
    return $somme / $nombre_de_notes;
}
?>
