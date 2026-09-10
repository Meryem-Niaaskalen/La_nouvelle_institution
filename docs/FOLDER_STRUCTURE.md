# Structure des dossiers (monorepo)

```
/
├── api/                                 # Laravel 12
│   ├── app/
│   │   ├── Enums/
│   │   ├── Http/
│   │   │   ├── Controllers/Api/V1/
│   │   │   │   ├── Public/              # Accueil, À propos, Programmes...
│   │   │   │   └── Admin/               # CRUD dashboard
│   │   │   ├── Middleware/
│   │   │   ├── Requests/
│   │   │   │   ├── Public/
│   │   │   │   └── Admin/
│   │   │   └── Resources/
│   │   ├── Models/
│   │   ├── Policies/
│   │   ├── Repositories/                # Gallery, Activity (si utile)
│   │   └── Services/
│   ├── database/
│   │   ├── migrations/
│   │   ├── seeders/
│   │   └── factories/
│   ├── routes/api.php
│   ├── storage/app/public/
│   └── ...
├── frontend/
│   ├── src/
│   │   ├── assets/
│   │   │   ├── fonts/
│   │   │   └── images/
│   │   ├── components/
│   │   │   ├── ui/                      # Button, Card, Modal, Input, Badge...
│   │   │   ├── layout/                  # PublicHeader, Footer, AdminSidebar
│   │   │   ├── home/                    # Hero, Timeline, Stats, Testimonials...
│   │   │   ├── gallery/
│   │   │   ├── activities/
│   │   │   └── admin/
│   │   ├── composables/                 # useGsap, useScrollReveal, useLightbox
│   │   ├── layouts/                     # PublicLayout, AdminLayout
│   │   ├── pages/
│   │   │   ├── public/                  # Accueil, APropos, Programmes...
│   │   │   └── admin/                   # Dashboard, CRUD
│   │   ├── router/
│   │   │   ├── index.js
│   │   │   ├── public.js
│   │   │   └── admin.js
│   │   ├── stores/                      # auth, siteSettings, gallery...
│   │   ├── services/api/                # modules Axios par ressource
│   │   ├── styles/
│   │   │   ├── main.css
│   │   │   └── tokens.css               # variables CSS
│   │   ├── App.vue
│   │   └── main.js
│   ├── index.html
│   ├── package.json
│   ├── tailwind.config.js
│   └── vite.config.js
├── docs/
│   ├── ARCHITECTURE.md
│   ├── DATABASE.md
│   ├── FOLDER_STRUCTURE.md
│   ├── API.md
│   ├── DESIGN.md
│   └── WIREFRAMES.md
├── .gitignore
└── README.md
```

## Conventions

- Noms de fichiers Vue : PascalCase (`HeroSection.vue`)
- Stores Pinia : `useXStore` dans `stores/x.js`
- Services API : un fichier par domaine (`activities.js`, `auth.js`)
- Routes API groupées `v1/public` et `v1/admin`
- Contenu utilisateur / CMS : toujours en français
