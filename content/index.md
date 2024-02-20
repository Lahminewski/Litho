---
title: Litho
author: Lahminewski
date: 10.01.2024
template: index
---

# Litho 
## C'est quoi ?
Litho est un petit outil ultra-basique qui vous permet de créer, gérer facilement un site web simple sans utiliser de base de données, de dépendance inutile, ni d'outil lourd et compliqué. Il a été développé avec une approche minimaliste, légère et sobre, dans le cadre du mouvement _Small Web_ et [KISS](https://fr.wikipedia.org/wiki/Principe_KISS).

Avec Litho, vous pouvez rédiger votre contenu en utilisant le langage [Markdown](https://fr.wikipedia.org/wiki/Markdown). 

## C'est fait pour qui ?
Déjà pour moi, en suite… je ne sais pas. 
J'aimerais pouvoir proposer quelque chose d'utilisable pour les petites associations, les bidouilleurs ou les artistes. Si vous avez des idées ou des envies qui correspondent à la démarche, contactez-moi.

## Télechargment
- [Vous pouvez le télécharger ici](https://github.com/Lahminewski/Litho/archive/refs/heads/main.zip)
Je serais intéressé par vos expériences d'utilisation.

## Et ça fonctionne comment ?
Le site fonctionne avec moins de 2 Mo. Ce mini CMS est en alpha, il n'y a donc pas encore de documentation détaillée. 😅

Mais en gros :
    - Il se décompresse sur un serveur avec php.
    - Le contenu est dans le dossier "content", c'est du Markdown avec un entête YAML.
    - Si on ajoute un fichier dans ce dossier, ça crée automatiquement une page avec le thème choisi dans le fichier conf.
Voila

```
├── config
│   └── config.yml              ==<-- la configuration==
├── content                     ==<-- Vos pages sont là.==
│   ├── index.md
│   ├── menu.md
│   ├── roadmap.md
│   └── test.md
├── index.php
├── lib
│   ├── Parsedown.php
│   ├── ParseDownPlus.php
│   ├── ParseYAML.php
│   └── SplitYamlHeader.php
├── LICENSE
├── README.md
└── themes                      ==<-- Vos themes sont là. ==
    └── monolith
        ├── base.html
        ├── header.html
        ├── logo.svg
        └── style.css
```

### Un fichier markdown avec un entête YAML qu'est-ce que c'est ?

```
---
title: Litho
author: Lahminewski
date: 10.01.2024
theme: lab
layout: base
robots: noindex,nofollow
---

# Titre 1
## Titre 2
### Titre 3

**Texte en gras**

*Texte en inatalique*

- liste
- liste
- liste

[Markdown Guide](https://www.markdownguide.org)

![alt text](https://www.markdownguide.org/assets/images/tux.png)
```

## Site statique
Si vous utilisez GNU/Linux, il existe un programme en ligne de commande __wget__ qui vous permet de passer votre site dynamique en site statique.

```
wget --convert-links -r -k -m -trust-server-names --adjust-extension https://Votesite.Sous.Litho/
```

Si vos entêtés YAML ne contiennent pas __robots: noindex,nofollow__ tout devrait bien fonctionner.

## Feuille de route
### Alpha V0.0
 - Menu Markdown                        [x]
 - Page variable                        [x]
 - Lecture de répertoire                [x]
 - page par défaut                      [x]
 - Robot not index                      [x]
 - Thème variable                       [x]
 - Markdown Plus                        [x]
 - Thème
     - Thème : monolith                 [x]
     - linktree                         [x]

### V1.0 Idée pour la suite
 - Amelioration Markdown Plus           [ ]
 - Galerie photos                       [ ]
 - Flux RSS / news                      [ ]
 - multilingue
 - Gestion des .csv pour les datas

