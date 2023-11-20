<?php
// Cette fonction perment de séparé l'entet  YAML du Contenu markdown
// Vous pouvé utilié la variable $markdown pour le fichier complet en entrée
// Vous pouvé utilié la variable $content et $yaml en sortie
//
// GNU GPL par Lahminewski
//--------------------------------------------------------------------------//


function SplitYamlHeader($markdown) {
    // On initialise les variables.
    $yaml = '';
    $content_md ='';
    
    // Rechercher le délimiteur de l'en-tête YAML
    $delimiter = '---';

    // Vérifier si le délimiteur est présent dans le fichier
    if (strpos($markdown, $delimiter) === 0) {
        // Trouver l'index de la deuxième occurrence du délimiteur
        $endIndex = strpos($markdown, $delimiter, strlen($delimiter));

        // Extraire l'en-tête YAML
        $yaml = substr($markdown, strlen($delimiter), $endIndex - strlen($delimiter));

        // Extraire le reste du contenu Markdown
        $content_md = substr($markdown, $endIndex + strlen($delimiter));
    } 
    else {
        // Si il n'y a pas d'entete le $content est identique a la variabl d'entrée
        $content_md = $markdown;
    }

return array($yaml, $content_md, $markdown);
}


// Example d'éxecution

//$markdown = file_get_contents('../content/example.md');

//list($yaml, $content, $markdown) = SplitYamlHeader($markdown);

//echo "<b>En-tête YAML : </b> \n";
//echo $yaml;
//echo "<br><br>";

//echo "<b>Contenu Markdown : </b>\n";
//echo $content;
//echo "<br><br>";

//echo "<b>Contenu Markdown complet : </b>\n";
//echo $markdown;

?>