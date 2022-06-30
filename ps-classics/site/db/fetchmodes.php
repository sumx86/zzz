<?php
final class FetchModes {

    // I'm using mostly fetch_class and assoc, so I'm not putting all of them here
    public static $modes = [
        'class' => PDO::FETCH_CLASS,
        'assoc' => PDO::FETCH_ASSOC,
        'lazy'  => PDO::FETCH_LAZY,
        'group' => PDO::FETCH_GROUP
    ];
}
?>