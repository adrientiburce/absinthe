
## Architecture

### Front : Twig + ReactJS

 1) Twig 
 
 * `base.html.twig` affiche les catégories de cours récupérs depuis le __Service__ `CategoryGenerator`.
 * La variable `slug_generator` est passée depuis `config/packages/twig.yaml`.
 
 
 2) ReactJs : Utilisation du Bundle `LimeniusReactBundle`
 
 
 -------

### API : Controller

* Les données passés en Json sont spécifiés dans les entités grâce aux fonctions `jsonSerialize`.

------

### Administration : EasyAdmin

 * `AdminController` : 
 Lorsqu'on modifie un cours dans l'admin et qu'on lui supprime sa catégorie.
On supprime alors ce cours dans la table favoris. 
