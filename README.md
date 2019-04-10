# Absinthe 
Projet disponilbe sur http://absinthe.webrush.fr/

![Screen du Site](https://shrinktheweb.snapito.io/v2/webshot/spu-ea68c8-ogi2-3cwn3bmfojjlb56e?size=800x0&screen=1024x768&url=http%3A%2F%2Fabsinthe.webrush.fr)

### Installer le projet en local : 

- Installer les dépendances php : `composer install`

- Installer les dépendances node : `npm install`


### Build le projet en local : 

En utilisant les recettes spécifiés dans le `package.json` :

- Build webpack  client : `npm run dev` (`npm run client` pour 'hot-reload') 

- Build pour Server Side: `npm run server-build`

### Lancer le serveur de développement : 

- `php bin/console server:start` et se rendre à l'adresse `localhost:8000`
