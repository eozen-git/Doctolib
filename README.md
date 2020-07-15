# Doctolib

## Description

Ce projet est un chatbot réalisé durant un hackathon de 48h en partenariat avec Doctolib, dont le thème était l'e-santé. Le chatbot est destiné à fournir un appui aux médecins clients de Doctolib Pro en leur fournissant des informations de base sur les médicaments, à la manière de ce que pourrait être un croisement entre un Vidal de poche et une base de données de la Sécurité Sociale concernant leurs prix/taux de remboursement. L'idée aurait été idéalement d'en faire une appli mobile pour les médecins en déplacement.

Chaque traitement comprend les informations suivantes :
* Description
* Molécule
* Prix
* Taux de remboursement

Son principal atout réside dans la possibilité de lister les génériques à partir de la molécule active d'un médicament donné. Le second atout est la possibilité de trouver une liste de médicaments pour telle ou telle maladie. Il reste possible de faire une recherche directement avec le nom du médicament.

## Installation

```terminal
composer install
```

```terminal
composer require symfony/webpack-encore-bundle
```

```terminal
yarn install
```

```terminal
yarn add @symfony/webpack-encore --dev
```

```terminal
symfony server:start
```

