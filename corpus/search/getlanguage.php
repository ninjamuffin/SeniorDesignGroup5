<?php
// Array with names

include '../../base.php';
$languages = [];

$languages[] = "Afrikaans";
$languages[] = "Akkadian";
$languages[] = "Albanian";
$languages[] = "American Sign Language (ASL)";
$languages[] = "Arabic";
$languages[] = "Aramaic";
$languages[] = "Armenian";
$languages[] = "Assyrian";
$languages[] = "Aymara";
$languages[] = "Bahasa Malaysia (Malay)";
$languages[] = "Bangala";
$languages[] = "Basque";
$languages[] = "Bavarian";
$languages[] = "Belorusian (Byelorussian)";
$languages[] = "Bengali";
$languages[] = "Berber (Tamazight)";
$languages[] = "Braille";
$languages[] = "Breton";
$languages[] = "Bulgarian";
$languages[] = "Burmese";
$languages[] = "Cambodian";
$languages[] = "Cantonese";
$languages[] = "Catalan";
$languages[] = "Cherokee (Tsalagi)";
$languages[] = "Croatian";
$languages[] = "Czech";
$languages[] = "Dakota";
$languages[] = "Danish";
$languages[] = "Dauphinois";
$languages[] = "Dutch";
$languages[] = "Egyptian- Ancient";
$languages[] = "Egyptian- Middle";
$languages[] = "English- Middle";
$languages[] = "English- Modern";
$languages[] = "English- Old";
$languages[] = "English Sign Language (ESL)";
$languages[] = "Esperanto (designed)";
$languages[] = "Estonian";
$languages[] = "Finnish";
$languages[] = "Flemish";
$languages[] = "French";
$languages[] = "French Sign Language";
$languages[] = "Frisian";
$languages[] = "Fukienese";
$languages[] = "Gaelic";
$languages[] = "Galician";
$languages[] = "Georgian";
$languages[] = "German";
$languages[] = "Greek, Ancient";
$languages[] = "Greek- Koine (Biblical)";
$languages[] = "Greek- Modern";
$languages[] = "Guarani";
$languages[] = "Gujarati";
$languages[] = "Hakka";
$languages[] = "Halaka";
$languages[] = "Hausa";
$languages[] = "Hawaiian";
$languages[] = "Hebrew- Biblical";
$languages[] = "Hebrew- Modern";
$languages[] = "Hundustani (Hindi)";
$languages[] = "Hungarian";
$languages[] = "Icelandic";
$languages[] = "Indonesian";
$languages[] = "Interlingua (designed)";
$languages[] = "Italian";
$languages[] = "Japanese";
$languages[] = "Javanese";
$languages[] = "Kamilaroi";
$languages[] = "Klingon (designed)";
$languages[] = "Korean";
$languages[] = "Kurdish";
$languages[] = "Ladino";
$languages[] = "Latin";
$languages[] = "Latin- Church";
$languages[] = "Latvian";
$languages[] = "Lithuanian";
$languages[] = "Lojban";
$languages[] = "Low German";
$languages[] = "Luganda";
$languages[] = "Macedonian";
$languages[] = "Malayalam";
$languages[] = "Maltese";
$languages[] = "Mandarin (Chinese)";
$languages[] = "Manx";
$languages[] = "Maori";
$languages[] = "Maya";
$languages[] = "Mohawk";
$languages[] = "Mon";
$languages[] = "Mongolian";
$languages[] = "Morse Code (designed)";
$languages[] = "Myanmar";
$languages[] = "Nahuatl";
$languages[] = "Navajo";
$languages[] = "Nepalese";
$languages[] = "Norman";
$languages[] = "Norwegian";
$languages[] = "Occitan";
$languages[] = "Ojibwe";
$languages[] = "Oneida";
$languages[] = "Papiamentu";
$languages[] = "Persian";
$languages[] = "Phoenician";
$languages[] = "Pidgin";
$languages[] = "Pitcairn";
$languages[] = "Polish";
$languages[] = "Portuguese";
$languages[] = "Punjabi";
$languages[] = "Quechua (Kechwa)";
$languages[] = "Rasta (Patois)";
$languages[] = "Romanian";
$languages[] = "Romansch";
$languages[] = "Romany";
$languages[] = "Russian";
$languages[] = "Sanskrit";
$languages[] = "Sardinian";
$languages[] = "Saxon";
$languages[] = "Scots";
$languages[] = "Serbian";
$languages[] = "Sinhalese";
$languages[] = "Slovak";
$languages[] = "Slovenian";
$languages[] = "Spanish";
$languages[] = "Sranan";
$languages[] = "Sudanese";
$languages[] = "Swabian";
$languages[] = "Swahili";
$languages[] = "Swedish";
$languages[] = "Tagalog";
$languages[] = "Talossan (designed)";
$languages[] = "Tamil";
$languages[] = "Telugu";
$languages[] = "Thai";
$languages[] = "Tlingit";
$languages[] = "Turkish";
$languages[] = "Ukranian";
$languages[] = "Urdu";
$languages[] = "Viennese";
$languages[] = "Vietnamese";
$languages[] = "Welsh";
$languages[] = "Wu";
$languages[] = "Yiddish";
$languages[] = "Amharic";
$languages[] = "Laos";
$languages[] = "Philippines";
$languages[] = "Hindi";
$languages[] = "Farsi";
$languages[] = "Swiss German";
$languages[] = "Bambara";
$languages[] = "Chinese";
$languages[] = "English";
$languages[] = "Somali";
$languages[] = "Tajik";
$languages[] = "Portuguese- Spanish";
$languages[] = "Italian- Spanish";
$languages[] = "Spanish- French- Portuguese";
$languages[] = "French- Portuguese";
$languages[] = "Taiwanese";
$languages[] = "Tigrinya";
$languages[] = "Bosnian";
$languages[] = "Marathi";

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    //$q = strtolower($q);
    $len=strlen($q);
    foreach($languages as $language) {
        if (stristr($q, substr($language, 0, $len))) {
            if ($hint === "") {
                $hint = $language;
            } else {
                $hint .= ", $language";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
?>