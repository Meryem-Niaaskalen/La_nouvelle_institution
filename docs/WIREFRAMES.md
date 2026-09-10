# Wireframes UI (français)

## Routes publiques

| Path | Page |
|------|------|
| `/` | Accueil |
| `/a-propos` | À propos |
| `/programmes` | Programmes |
| `/admissions` | Admissions |
| `/galerie` | Galerie |
| `/activites` | Activités |
| `/activites/:slug` | Détail activité |
| `/contact` | Contact |

## Routes admin (`/admin/*`)

| Path | Page |
|------|------|
| `/admin/connexion` | Connexion |
| `/admin` | Tableau de bord |
| `/admin/enseignants` | Enseignants |
| `/admin/galerie` | Galerie |
| `/admin/activites` | Activités |
| `/admin/accueil` | CMS Accueil |
| `/admin/documents` | Documents |
| `/admin/contact` | Messages + infos |
| `/admin/utilisateurs` | Utilisateurs |
| `/admin/roles` | Rôles |

---

## Accueil — premier viewport

```
+---------------------------------------------------------------+
| Logo   Accueil  A propos  Programmes  ...            Contact  |
+---------------------------------------------------------------+
|                                                               |
|                 [ IMAGE HERO PLEIN ECRAN ]                    |
|                                                               |
|              LA NOUVELLE INSTITUTION                          |
|                   Depuis 1997                                 |
|        Phrase d'accueil courte et chaleureuse                 |
|              [ Decouvrir l'ecole ]                             |
|                                                               |
+---------------------------------------------------------------+
```

Enchaînement sous le fold :

1. À propos (extrait) + timeline animée  
2. Programmes (cartes)  
3. Vie scolaire (Sports, Culture, Science, Clubs, Sorties)  
4. Dernières activités (grille) + « Voir plus sur Facebook »  
5. Teaser galerie  
6. Statistiques (compteurs)  
7. Témoignages  
8. Bandeau contact / CTA

---

## À propos

```
+---------------------------+------------------+
| Titre + texte court       | Image etablissement |
+---------------------------+------------------+
| Chronologie verticale (scroll GSAP)          |
| 1997 Creation -> +25 ans -> Aujourd'hui      |
+----------------------------------------------+
| Valeurs / engagement pedagogique             |
+----------------------------------------------+
```

---

## Programmes

```
+----------+  +----------+  +----------+
| Icone    |  | Icone    |  | Icone    |
| Titre    |  | Titre    |  | Titre    |
| Resume   |  | Resume   |  | Resume   |
| En savoir|  | En savoir|  | En savoir|
+----------+  +----------+  +----------+
```

Hover : légère élévation + accent orange.

---

## Admissions (info + formulaire)

```
+----------------------------------------------+
| Conditions, dates, pieces a fournir (CMS)    |
+----------------------------------------------+
| Documents PDF telechargeables                |
+----------------------------------------------+
| Formulaire demande :                         |
| Nom, Email, Telephone, Niveau souhaite, Msg  |
| [ Envoyer ma demande ]                       |
+----------------------------------------------+
```

---

## Galerie

```
[ Tous | Sport | Culture | Evenements | Campus ]
+--------+  +----+----+
| large  |  |    |    |
|        |  +----+----+
+--------+  |         |
            +---------+
Lightbox au clic, zoom au hover.
```

---

## Activités

```
+--------+ +--------+ +--------+
| Image  | | Image  | | Image  |
| Titre  | | Titre  | | Titre  |
| Date   | | Date   | | Date   |
| Extrait| | Extrait| | Extrait|
+--------+ +--------+ +--------+
        [ Voir plus sur Facebook ]
```

---

## Contact

```
+------------------+---------------------------+
| Tel / Email /    |  Google Maps embed        |
| Adresse          |  25 Rue Adawha El Fath 3  |
| Facebook         |  Casablanca               |
+------------------+---------------------------+
| Formulaire de contact                        |
+----------------------------------------------+
```

---

## Admin

```
+----------+-----------------------------------+
| Sidebar  | Top bar + fil d'Ariane            |
| sombre   +-----------------------------------+
| Logo     | Cartes stats + graphiques         |
| Nav FR   | Messages / activites recentes     |
|          | Tables CRUD                       |
+----------+-----------------------------------+
```
