<?php
// Cette fonction perment de séparé l'entet  YAML du Contenu markdown
// Vous pouvé utilié la variable $yaml pour le fichier complet en entrée
// Vous pouvé utilié la variable $content et $data en sortie
//
// GNU GPL par Lahminewski
//--------------------------------------------------------------------------//

function parseYAML($yaml_string) {
    $lines = explode("\n", $yaml_string);
    $data = array();
    $nested_level = 0;

    foreach ($lines as $line) {
        $line = trim($line);

        // Skip empty lines and comments
        if (empty($line) || $line[0] == '#') {
            continue;
        }

        // Check if the line is at a higher nested level
        $current_nested_level = strlen($line) - strlen(ltrim($line));
        if ($current_nested_level > $nested_level) {
            throw new Exception("Invalid indentation in YAML");
        }

        // Remove indentation and split key-value pairs
        $line = ltrim($line);
        $pair = explode(':', $line, 2);

        // Process key-value pairs
        $key = trim($pair[0]);
        $value = isset($pair[1]) ? trim($pair[1]) : '';

        // Check for nested elements
        if ($current_nested_level < $nested_level) {
            $data = array_pop($data);
        }

        // Add key-value pair to the data array
        if (empty($key)) {
            $data[] = $value; // Numeric array
        } else {
            $data[$key] = $value; // Associative array
        }

        $nested_level = $current_nested_level;
    }

    return $data;
}

// Example d'utilisation
// $yaml_string = '
// person:
//     name: John Doe
//     age: 30
//     address:
//         street: 123 Main St
//         city: New York
// ';

// $data = parseYAML($yaml_string);

// echo $data['name']; // Output: John Doe
// echo $data['age']; // Output: 30
// echo $data['city']; // New York
// echo $data['street']; // 123 Main St

?>