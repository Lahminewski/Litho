<?php
// Cette fonction perment de parse du markdown suplementaire
//
// GNU GPL par Lahminewski
//--------------------------------------------------------------------------//


function ParseDownPlus($markdown) {
    
// On ajoute nos propre truc

    // Tâches non cochées
    $markdown = preg_replace('/\[ \]/m', '<input type="checkbox" disabled> ', $markdown);

    // Tâches cochées
    $markdown = preg_replace('/\[(x|X)\]/m', '<input type="checkbox" checked disabled> ', $markdown);

    // Notes de bas de page
    $markdown = preg_replace('/\[\^(\w+)\]: /', '<br><sup><a href="#fn$1" id="ref$1">$1</a></sup> : ', $markdown);
    $markdown = preg_replace('/\[\^(\w+)\]/', '<sup><a href="#ref$1" id="fn$1">$1</a></sup>', $markdown);

    // Exposent et indice
    $markdown = preg_replace('/\^(\w+)\^/', '<sup>$1</sup>', $markdown);
    $markdown = preg_replace('/\~(\w+)\~/', '<sub>$1</sub>', $markdown);

    // On rajoute des ancres au trois premier niveau de titre 
    $markdown = preg_replace('/<h1\b[^>]*>(.*?)<\/h1>/', '<h1 id="$1">$1</h1>', $markdown);
    $markdown = preg_replace('/<h2\b[^>]*>(.*?)<\/h2>/', '<h2 id="$1">$1</h2>', $markdown);
    $markdown = preg_replace('/<h3\b[^>]*>(.*?)<\/h3>/', '<h3 id="$1">$1</h3>', $markdown);


    $html = $markdown;

    return $html;
}

// Example d'éxecution

//$markdown = "
// # A fair pour cette fonction 
//- [x] Tache
//- [x] Note de bas de page [^12]
//- [X] Exposent et indice (H~2~O Lapin^n^)
//- [ ] Galerie [^truc_chose]
//- [ ] ID pour les sections 

//## A fair pour cette fonction 
//### Truc
 
// Ceci est une note de bas de page. [^2] [^truc]

// [^12]: Voici le contenu de la note de bas de page.
// [^truc_chose]: Voici le contenu de la note de bas de page.
// [^truc]: Voila 2
//";

//$text = ParseDownPlus($markdown);
//echo $text;

?>