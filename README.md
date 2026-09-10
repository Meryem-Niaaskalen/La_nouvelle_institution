# La nouvelle institution

Projet web d’une école / établissement scolaire développé en monorepo avec un backend Laravel et un frontend Vue 3. Le dépôt contient actuellement une base fonctionnelle pour un site public et un espace d’administration.

## Vue d’ensemble

Ce projet est structuré en deux parties principales :

- `api/` : backend Laravel, API REST, authentification, gestion des données
- `frontend/` : application Vue 3 avec pages publiques et espace admin

Le code présent dans le dépôt montre un site d’école avec :

- accueil public
- pages publiques sur l’établissement, les programmes, les admissions, la galerie et le contact
- gestion des contenus via une API protégée
- espace admin pour lecture et gestion des messages / galerie / contacts
- base de données PostgreSQL
- API protégée avec Laravel Sanctum

## Stack technique réelle

### Backend

- PHP 8.3+
- Laravel 13.8
- Laravel Sanctum 4.3
- Spatie Laravel Permission 8.3
- PostgreSQL
- PHPUnit pour les tests

### Frontend

- Vue 3.5
- Vite
- Vue Router 4
- Pinia
- Axios
- GSAP
- Tailwind CSS 4
- Lucide Vue Next

## Structure du dépôt

```text
.
├── README.md
├── API_REFERENCE.md
├── docs/
│   ├── API.md
│   ├── ARCHITECTURE.md
│   ├── DATABASE.md
│   ├── DESIGN.md
│   ├── FOLDER_STRUCTURE.md
│   ├── PHASE2_DATABASE.md
│   ├── PHASE3_API.md
│   ├── ROADMAP.md
│   └── WIREFRAMES.md
├── api/
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   ├── Models/
│   │   └── Providers/
│   ├── config/
│   ├── database/
│   │   ├── factories/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   │   └── api.php
│   ├── tests/
│   ├── composer.json
│   ├── phpunit.xml
│   └── vite.config.js
├── frontend/
│   ├── public/
│   ├── scripts/
│   ├── src/
│   │   ├── assets/
│   │   ├── components/
│   │   ├── data/
│   │   ├── layouts/
│   │   ├── pages/
│   │   ├── router/
│   │   ├── services/
│   │   ├── stores/
│   │   ├── App.vue
│   │   ├── main.js
│   │   ├── style.css
│   │   └── useGSAP.js
│   ├── index.html
│   ├── package.json
│   ├── tailwind.config.js
│   └── vite.config.js
└── scripts/
    └── process_hero.py
```

## Ce qui existe réellement dans le projet

### Backend

Les contrôleurs présents dans `api/app/Http/Controllers` sont :

- `AuthController`
- `ActivityController`
- `GalleryController`
- `ProgramController`
- `TeacherController`
- `TestimonialController`
- `ContactController`
- `DashboardController`
- `SettingController`

Les modèles principaux présents dans `api/app/Models` incluent :

- `User`
- `Teacher`
- `Program`
- `Activity`
- `GalleryCategory`
- `GalleryImage`
- `Testimonial`
- `ContactMessage`
- `Setting`
- `SiteSetting`
- `HomepageSection`
- `BlogPost`
- `Document`
- `Statistic`
- `TimelineEvent`
- `SchoolClass`
- `Subject`

Les migrations documentent bien le système de l’établissement :

- rôles et permissions
- utilisateurs
- enseignants
- matières
- classes
- galerie
- activités
- programmes
- témoignages
- messages de contact
- documents
- paramètres
- blog

### Frontend

Les pages publiques réellement présentes dans `frontend/src/pages/public` sont :

- `AccueilPage.vue`
- `AProposPage.vue`
- `ProgrammesPage.vue`
- `AdmissionsPage.vue`
- `GaleriePage.vue`
- `ContactPage.vue`

Les pages admin présentes dans `frontend/src/pages/admin` sont :

- `ConnexionPage.vue`
- `DashboardPage.vue`
- `MessagesPage.vue`
- `GaleriePage.vue`
- `ContactsPage.vue`

La routeur principal contient bien ces routes :

- `/` → page d’accueil publique
- `/a-propos`
- `/programmes`
- `/admissions`
- `/galerie`
- `/contact`
- `/admin/connexion`
- `/admin` → dashboard admin
- `/admin/messages`
- `/admin/galerie`
- `/admin/contacts`

### API réelle

Le fichier `api/routes/api.php` montre une API organisée comme suit :

#### Endpoints publics

- `GET /api/v1/health`
- `GET /api/v1/programs`
- `GET /api/v1/programs/{program}`
- `GET /api/v1/programs/level/{level}`
- `GET /api/v1/teachers`
- `GET /api/v1/teachers/{teacher}`
- `GET /api/v1/teachers/specialization/{specialization}`
- `GET /api/v1/activities`
- `GET /api/v1/activities/featured`
- `GET /api/v1/activities/{activity}`
- `GET /api/v1/activities/category/{categorySlug}`
- `GET /api/v1/gallery/categories`
- `GET /api/v1/gallery/{category}`
- `GET /api/v1/gallery/{category}/images`
- `GET /api/v1/testimonials`
- `GET /api/v1/testimonials/featured`
- `GET /api/v1/testimonials/type/{type}`
- `GET /api/v1/settings/public`
- `GET /api/v1/contact/info`
- `POST /api/v1/contact/send`

#### Authentification

- `GET /api/v1/sanctum/csrf-cookie`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout` (protégé)
- `POST /api/v1/auth/refresh` (protégé)
- `GET /api/v1/auth/me` (protégé)

#### Admin / gestion

- `POST /api/v1/admin/teachers`
- `PUT /api/v1/admin/teachers/{teacher}`
- `DELETE /api/v1/admin/teachers/{teacher}`
- `POST /api/v1/admin/programs`
- `PUT /api/v1/admin/programs/{program}`
- `DELETE /api/v1/admin/programs/{program}`
- `POST /api/v1/admin/activities`
- `PUT /api/v1/admin/activities/{activity}`
- `DELETE /api/v1/admin/activities/{activity}`
- `POST /api/v1/admin/gallery/categories`
- `PUT /api/v1/admin/gallery/categories/{category}`
- `DELETE /api/v1/admin/gallery/categories/{category}`
- `POST /api/v1/admin/gallery/images`
- `PUT /api/v1/admin/gallery/images/{image}`
- `DELETE /api/v1/admin/gallery/images/{image}`
- `GET /api/v1/admin/gallery/categories`
- `GET /api/v1/admin/gallery/categories/{category}/images`
- `POST /api/v1/admin/testimonials`
- `PUT /api/v1/admin/testimonials/{testimonial}`
- `DELETE /api/v1/admin/testimonials/{testimonial}`
- `GET /api/v1/admin/contact/messages`
- `PUT /api/v1/admin/contact/messages/{contactMessage}`
- `DELETE /api/v1/admin/contact/messages/{contactMessage}`
- `GET /api/v1/admin/settings`
- `PUT /api/v1/admin/settings/{key}`
- `GET /api/v1/admin/dashboard`

## État actuel du projet

Le dépôt est dans une phase de développement intermédiaire. Les éléments visibles et fonctionnels sont :

- base Laravel installée et configurée
- API REST avec routes publiques et protégées
- authentification Sanctum
- système de rôles/permissions via Spatie
- pages publiques de base
- page d’accueil avec données dynamiques
- espace d’administration avec login et navigation
- composants de design system (cards, buttons, section, timeline, carousel, gallery etc.)

Les éléments qui restent plus partiellement avancés ou à compléter selon l’état réel du dépôt :

- certaines fonctionnalités d’admin peuvent être incomplètes selon les vues et contrôleurs
- la gestion complète du contenu est en cours / non finalisée
- le projet n’est pas encore un produit entièrement terminé et stabilisé

## Installation

### Prérequis

- PHP 8.3+
- Composer
- Node.js 20+
- PostgreSQL
- extension PHP pour PostgreSQL (typiquement `pdo_pgsql` / `pgsql`)

### 1) Base de données

Créer une base PostgreSQL, puis configurer le fichier `api/.env` avec un schéma de type :

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5433
DB_DATABASE=la_nouvelle_institution
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
```

### 2) Backend Laravel

```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Le backend sera disponible sur :

- http://localhost:8000
- health check : http://localhost:8000/api/v1/health

### 3) Frontend Vue

```bash
cd frontend
npm install
npm run dev
```

Le frontend est généralement accessible sur :

- http://localhost:5173

## Commandes utiles

### Backend

```bash
cd api
php artisan migrate
php artisan db:seed
php artisan serve
php artisan test
```

### Frontend

```bash
cd frontend
npm run dev
npm run build
npm run preview
npm run responsive:qa
```

## Points importants

- Le README précédent contenait des promesses de “phase complète” et d’étapes déjà finalisées ; le dépôt réel montre un projet en construction, avec des fondations et certaines fonctionnalités livrées, mais pas un projet entièrement fini.
- Les routes et composants du code sont la source de vérité la plus fiable pour le projet.
- La documentation dans `docs/` et les fichiers de référence est utile, mais le code dans `api/` et `frontend/` reste la référence principale.

## Contribution

Le projet suit une séparation nette entre :

- backend API Laravel
- frontend SPA Vue
- documentation
- scripts utiles

Pour contribuer :

1. travailler dans le bon sous-dossier (`api/` ou `frontend/`)
2. tenir la structure actuelle cohérente avec les routes et contrôleurs existants
3. valider les changements côté API et côté interface

## Résumé rapide

Ce projet est un site web institutionnel d’école basé sur :

- Laravel pour l’API
- Vue 3 pour le frontend
- PostgreSQL pour la base de données
- Sanctum pour l’authentification
- un site public + un espace administrateur

Il est déjà bien avancé techniquement, mais il reste un projet in progress plutôt qu’un produit finalisé.


Voir **PHASE3_SUMMARY.md** pour plus de détails.

