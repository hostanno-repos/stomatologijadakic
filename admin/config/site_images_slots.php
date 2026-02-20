<?php
/**
 * Registry of replaceable site images (slots).
 * Key = identifier, value = [label, default path from site root].
 * Add new slots here and use getSiteImage('key') on frontend.
 */
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

return [
    // Logotipi
    'logo_header'   => ['label' => 'Logo (header)', 'default' => 'images/logo-horizontal.svg'],
    'logo_footer'   => ['label' => 'Logo (footer)', 'default' => 'images/logo-vertical.svg'],
    'logo_sidemenu' => ['label' => 'Logo (side menu)', 'default' => 'images/logo-horizontal.svg'],

    // Slider na početnoj
    'slider_1_left'  => ['label' => 'Slider 1 – lijeva pozadina', 'default' => 'img/demos/dentist/slides/slide-dentist-1-1.jpg'],
    'slider_1_right' => ['label' => 'Slider 1 – desna pozadina', 'default' => 'img/demos/dentist/slides/slide-dentist-1-2.jpg'],
    'slider_2_bg'    => ['label' => 'Slider 2 – pozadina', 'default' => 'img/demos/dentist/slides/slide-dentist-2-1.jpg'],
    'slider_decor_1' => ['label' => 'Slider – dekorativna slika 1', 'default' => 'img/demos/dentist/generic/generic-3.svg'],
    'slider_decor_2' => ['label' => 'Slider – dekorativna slika 2', 'default' => 'img/demos/dentist/generic/generic-4.svg'],

    // Početna – hero i kutije
    'index_hero'     => ['label' => 'Početna – hero slika', 'default' => 'img/demos/dentist/generic/generic-5.jpg'],
    'index_box_icon1' => ['label' => 'Početna – ikona 1 (Super lokacija)', 'default' => 'img/demos/dentist/icons/icon-1.svg'],
    'index_box_icon2' => ['label' => 'Početna – ikona 2 (Moderna oprema)', 'default' => 'img/demos/dentist/icons/icon-2.svg'],
    'index_box_icon3' => ['label' => 'Početna – ikona 3 (Iskustvo)', 'default' => 'img/demos/dentist/icons/icon-3.svg'],

    // Usluge – velike slike (početna + stranice usluga)
    'usluge_ortodoncija'   => ['label' => 'Usluga – Ortodoncija', 'default' => 'img/usluge-slider/ortodoncija.jpg'],
    'usluge_protetika'     => ['label' => 'Usluga – Protetika', 'default' => 'img/usluge-slider/protetika.jpg'],
    'usluge_estetika'      => ['label' => 'Usluga – Estetika', 'default' => 'img/usluge-slider/estetika.jpg'],
    'usluge_endodoncija'   => ['label' => 'Usluga – Endodoncija', 'default' => 'img/usluge-slider/endodoncija.jpg'],
    'usluge_implantologija'=> ['label' => 'Usluga – Implantologija', 'default' => 'img/usluge-slider/implantologija.jpg'],
    'usluge_radiologija'   => ['label' => 'Usluga – Radiologija', 'default' => 'img/usluge-slider/radiologija.jpg'],
    'usluge_hirurgija'     => ['label' => 'Usluga – Oralna hirurgija', 'default' => 'img/usluge-slider/hirurgija.jpg'],
    'usluge_izbjeljivanje'=> ['label' => 'Usluga – Izbjeljivanje', 'default' => 'img/usluge-slider/izbjeljivanje.jpg'],
    'usluge_laser'        => ['label' => 'Usluga – Laseroterapija', 'default' => 'img/usluge-slider/laser.png'],
    'usluge_djecija'      => ['label' => 'Dječija stomatologija (slika)', 'default' => 'img/djecija-stomatologija.jpg'],

    // Usluge – male ikone na početnoj
    'usluge_icon1' => ['label' => 'Usluge – ikona 1', 'default' => 'img/usluge-slider/icon1.png'],
    'usluge_icon2' => ['label' => 'Usluge – ikona 2', 'default' => 'img/usluge-slider/icon2.png'],
    'usluge_icon3' => ['label' => 'Usluge – ikona 3', 'default' => 'img/usluge-slider/icon3.png'],
    'usluge_icon4' => ['label' => 'Usluge – ikona 4', 'default' => 'img/usluge-slider/icon4.png'],
    'usluge_icon5' => ['label' => 'Usluge – ikona 5', 'default' => 'img/usluge-slider/icon5.png'],
    'usluge_icon6' => ['label' => 'Usluge – ikona 6', 'default' => 'img/usluge-slider/icon6.png'],
    'usluge_icon7' => ['label' => 'Usluge – ikona 7', 'default' => 'img/usluge-slider/icon7.png'],

    // O nama
    'onama_hero'       => ['label' => 'O nama – glavna slika', 'default' => 'img/demos/dentist/generic/generic-5.jpg'],
    'onama_service_1'  => ['label' => 'O nama – usluga 1', 'default' => 'img/demos/dentist/services/service-1.jpg'],
    'onama_service_2'  => ['label' => 'O nama – usluga 2', 'default' => 'img/demos/dentist/services/service-2.jpg'],
    'onama_service_3'  => ['label' => 'O nama – usluga 3', 'default' => 'img/demos/dentist/services/service-3.jpg'],
    'onama_service_4'  => ['label' => 'O nama – usluga 4', 'default' => 'img/demos/dentist/services/service-4.jpg'],
];
