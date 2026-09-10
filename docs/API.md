# API REST v1

Base : `/api/v1`

## Public (sans auth)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/home` | Payload agrégé accueil |
| GET | `/about` | Chronologie + contenu à propos |
| GET | `/programs` | Liste programmes publiés |
| GET | `/programs/{slug}` | Détail programme |
| GET | `/activities` | Liste paginée (filtres catégorie) |
| GET | `/activities/{slug}` | Détail activité |
| GET | `/gallery` | Images (+ filtre catégorie) |
| GET | `/admissions` | Textes CMS + documents |
| GET | `/testimonials` | Témoignages publiés |
| GET | `/statistics` | Compteurs |
| GET | `/settings/contact` | Coordonnées publiques |
| POST | `/contact` | Message contact |
| POST | `/admissions/inquiry` | Demande d’admission |

## Auth admin

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| POST | `/admin/login` | Connexion Sanctum |
| POST | `/admin/logout` | Déconnexion |
| GET | `/admin/me` | Utilisateur + rôles/permissions |

## Admin (Sanctum + permissions)

| Domaine | Endpoints CRUD |
|---------|----------------|
| Dashboard | `GET /admin/dashboard` |
| Enseignants | `/admin/teachers` |
| Programmes | `/admin/programs` |
| Activités | `/admin/activities` |
| Galerie | `/admin/gallery` + catégories |
| Témoignages | `/admin/testimonials` |
| Documents | `/admin/documents` |
| Accueil CMS | `/admin/homepage-sections` |
| Stats | `/admin/statistics` |
| Timeline | `/admin/timeline-events` |
| Paramètres | `/admin/settings` |
| Messages | `/admin/contact-messages` |
| Utilisateurs | `/admin/users` |
| Rôles | `/admin/roles` |

Upload images/docs via `multipart/form-data` sur les endpoints create/update concernés.
