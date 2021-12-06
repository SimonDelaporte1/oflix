# Routes de l'application

| URL               | Méthode HTTP | Contrôleur       | Méthode        | Titre HTML                        | Commentaire                       |
| ----------------- | ------------ | ---------------- | -------------- | --------------------------------- | --------------------------------- |
| `/`               | `GET`        | `MainController` | `home`         | Bienvenue sur O'flix              | Page d'accueil                    |
| `/movie/{id}`     | `GET`        | `MainController` | `movieShow`    | Titre du film/série               | Titre du film/série               |
| `/favorites.html` | `GET`        | `MainController` | `movieFavoris` | films et séries favoris           | films et séries favorites         |
| `/list.html`      | `GET`        | `MainController` | `movieList`    | Liste des films et séries favoris | Liste des films et séries favoris |
