<?php
// Cette fonction perment de séparé l'entet  YAML du Contenu markdown
// Vous pouvé utilié la variable $yaml pour le fichier complet en entrée
// Vous pouvé utilié la variable $content et $data en sortie
//
// GNU GPL par Lahminewski
//--------------------------------------------------------------------------//
  
function rss_feed($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    
    $dom = new DOMDocument();
    $dom->loadXML($data);
    $items = $dom->getElementsByTagName('item');

    foreach ($items as $item) {
        $title = '';
        $link = '';
        $media = '';
        $date = '';
        $description = '';

        $titleElement = $item->getElementsByTagName('title')->item(0);
        $linkElement = $item->getElementsByTagName('link')->item(0);
        $dateElement = $item->getElementsByTagName('pubDate')->item(0);
        $descriptionElement = $item->getElementsByTagName('description')->item(0);
        $mediaElement = $item->getElementsByTagNameNS('http://search.yahoo.com/mrss/','content')->item(0);

        if ($titleElement) {
            $title = $titleElement->textContent;
        }
        if ($linkElement) {
            $link = $linkElement->textContent;
        }
        if ($dateElement) {
            $date = $dateElement->textContent;
        }
        if ($descriptionElement) {
            $description = $descriptionElement->textContent;
        }
        if ($mediaElement) {
            $media = $mediaElement->getAttribute('url');
        }
        // changment de la date
        $timestamp = strtotime($date);
        $date = date("Y.m.d H:i", $timestamp);

        // On écrit tout ca 
        echo '<div class="rss-box"><h2><a href="'.$link.'">'.$title.'</a></h2>';
        echo '<p>'.$description.'</p>';
        if (!empty($media)) {
            echo '<img src="'.$media.'" alt="'.$title.'">';
        }

        echo '<br><small>'.$date.'</small></div>';
    }
}


?>
