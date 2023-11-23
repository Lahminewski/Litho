<?php
// in inclus les fonction qui sont dans lib
include 'lib/SplitYamlHeader.php'; /*Pour fair Separé le markedown du YAML*/
include 'lib/ParseYAML.php'; /*Pour utiliser les varable dans le YAML*/
include 'lib/Parsedown.php'; /*Parsedown pour fair des modOp en Markedown*/
include 'lib/ParseDownPlus.php'; /*Parsedown pour fair des modOp en Markedown*/

$Parsedown = new Parsedown(); /*declaration de la variable*/

$folder_content = "./content/"; // Chemin vers le dossier contenant les fichiers du contenu Markdown

// Utiliser la fonction parseYAML aller chercher les info dans le fichier de conf
  $conf = file_get_contents('config/config.yml');
  $data_conf = parseYAML($conf);


  // Varible pour les meta
  if  (isset($data_conf['site_title'])) {
    $site_title =$data_conf['site_title'];
  }
  if  (isset($data_conf['description'])) {
    $description =$data_conf['description'];
  } 
  if  (isset($data_conf['keywords'])) {
    $keywords =$data_conf['keywords'];
  }
  if  (isset($data_conf['copyright'])) {
    $copyright =$data_conf['copyright'];
  }
  if  (isset($data_conf['author'])) {
    $author =$data_conf['author'];
  }
  if  (isset($data_conf['language'])) {
    $language =$data_conf['language'];
  }
  if  (isset($data_conf['theme'])) {
    $theme =$data_conf['theme'];
  }
  if  (isset($data_conf['default_page'])) {
    $default_page =$data_conf['default_page'];
  }

// Vérifie si le paramètre GET "page" existe et n'est pas vide
if(isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = $default_page ;
}
    // Chemin complet vers le fichier Markdown avec l'extension .md
    $markdownFile = $folder_content . $page . ".md"; 

    // Vérifie si le fichier Markdown existe
    if(file_exists($markdownFile)) {
        // Lit le contenu du fichier Markdown
        $content = file_get_contents($markdownFile);

        // Affiche le contenu du fichier Markdown
        list($yaml, $content_md, $markdown) = SplitYamlHeader($content);

        // Utiliser la fonction parseYAML pour faire un array 
        $data = parseYAML($yaml);

        // Parsé le contenu du fichier markedown pour avoir de l'HTML
        $contenu_md = $Parsedown->text($content_md);
         // On parse encore les fonction suplementaire de ParseDownPlus
        $contenu_md = ParseDownPlus($contenu_md);
    } else {
        $contenu_md = "Cette page n'existe pas.";
    }

// Variable YAML des page makdown
   if  (isset($data['title']))   {$title_page = $data['title'];}   else {$title_page ="";}
   if  (isset($data['author']))  {$author_page = $data['author'];} else {$author_page = $author;}
   if  (isset($data['date']))    {$date_page = $data['date'];}     else {$date_page ="";}
   if  (isset($data['robots']))  {$robots_page = $data['robots'];} else {$robots_page ="";}

//*Prparation de la page HTML*/
  include 'themes/' . $theme . '/body.html'; 
?>
