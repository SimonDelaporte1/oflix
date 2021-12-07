# Routes de l'application

| URL           | Méthode HTTP | Contrôleur       | Méthode     | Titre HTML                        | Commentaire                       |
| ------------- | ------------ | ---------------- | ----------- | --------------------------------- | --------------------------------- |
| `/`           | `GET`        | `MainController` | `home`      | Bienvenue sur O'flix              | Page d'accueil                    |
| `/movie/{id}` | `GET`        | `MainController` | `movieShow` | Titre du film/série               | Titre du film/série               |
| `/favorites`  | `GET`        | `favoritesController` | `favorites` | films et séries favoris           | films et séries favorites         |
| `/list`       | `GET`        | `MainController` | `list`      | Liste des films et séries favoris | Liste des films et séries favoris |
| `/api/movies` | `GET`        | `ApiController`  | `movies_get`    | -                                 | Le json de la liste des filmes    |
