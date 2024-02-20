<?php
// Cette fonction vous permet de parser des données markdown" supplémentaires.
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
    $footnotes = array(); // variable pour stocker les notes de bas de page

	$markdown = preg_replace_callback('/\[\^(\w+)\]: (.+)/', function($matches) use (&$footnotes) {
		$footnoteId = $matches[1];
		$footnoteContent = $matches[2];
		$footnotes[$footnoteId] = $footnoteContent; // ajoute la note de bas de page à la variable
	}, $markdown);

	$markdown = preg_replace('/\[\^(\w+)\]/', '<sup><a href="#ref$1" id="fn$1">$1</a></sup>', $markdown);
	
	$markdown .= '<hr><div id="footnotes"><ol>'; // début de la section des notes de bas de page
	foreach ($footnotes as $footnoteId => $footnoteContent) {
		$markdown .= '<li id="ref' . $footnoteId . '"><a href="#fn' . $footnoteId . '">' . $footnoteId . '</a> : ' . $footnoteContent . '</li>';
	}
	$markdown .= '</ol></div>'; // fin de la section des notes de bas de page

    // Exposent et indice
    $markdown = preg_replace('/\^(\w+)\^/', '<sup>$1</sup>', $markdown);
    $markdown = preg_replace('/\~(\w+)\~/', '<sub>$1</sub>', $markdown);

    // On rajoute des ancres au trois premier niveau de titre 
	$markdown = preg_replace_callback('/<h1>(.*?)<\/h1>/i', 
	function ($matches) {$content = $matches[1]; $id = str_replace(' ', '_', $content); return "<h1 id=\"$id\">$content</h1>";}, 
	$markdown);
	
	$markdown = preg_replace_callback('/<h2>(.*?)<\/h2>/i', 
	function ($matches) {$content = $matches[1]; $id = str_replace(' ', '_', $content); return "<h2 id=\"$id\">$content</h2>";}, 
	$markdown);

	$markdown = preg_replace_callback('/<h3>(.*?)<\/h3>/i', 
	function ($matches) {$content = $matches[1]; $id = str_replace(' ', '_', $content); return "<h3 id=\"$id\">$content</h3>";},
	$markdown);

    // On met entre les balise mark ce qui se trouve entre == ==
    $markdown = preg_replace('/==([^=]+)==/', '<mark>$1</mark>', $markdown);


	// Ajoute de fonction Gallery
			// Regex pour rechercher la balise
			$regex = '/{{Gallery ([^=]+)}}/';
			function remplacerBalise($matches) {
				// Récupérer le chemin de l'emplacement des images
				$emplacementImages = $matches[1];
				
				// Lister les fichiers d'images dans l'emplacement
				$images = glob($emplacementImages . '/*.{jpg,png,gif,svg,jpeg,webp}', GLOB_BRACE);

				// Créer la galerie d'images
				$galerie = '<div id="gallery">';
				foreach ($images as $image) {
					// Vérifier si une miniature existe dans un sous-répertoire
					$thumbnail = $emplacementImages . '/miniature/' . basename($image);
					$src = file_exists($thumbnail) ? $thumbnail : $image;
					$imageName = pathinfo($image, PATHINFO_FILENAME);
					$galerie .= '<a href="' . $image . '" class="gallery"><img src="' . $src . '" class="gallery" alt="' . $imageName .'"></a>';
				}
				$galerie .= '</div>';
				return $galerie;
			}
			// Effectuer le remplacement de la balise
			$markdown = preg_replace_callback($regex, 'remplacerBalise', $markdown);

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
