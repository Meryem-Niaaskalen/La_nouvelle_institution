# Design system — La nouvelle institution

## Philosophie

Moderne, premium, digne d’une institution universitaire. Confiance, excellence, chaleur. Pas de template scolaire générique.

**Éviter :** Bootstrap générique, boutons enfantins, layouts datés, gradients lourds, interfaces surchargées.  
**Préférer :** grands espaces blancs, typographie soignée, cartes élégantes, scroll fluide, animations sobres, images de qualité.

## Couleurs

| Token | Hex | Usage |
|-------|-----|--------|
| `--color-primary` | `#F57C00` | Boutons, liens, icônes, menu actif, hover |
| `--color-secondary` | `#424242` | Sidebar admin, titres secondaires |
| `--color-bg` | `#FFFFFF` | Fond principal |
| `--color-surface` | `#F5F5F5` | Sections alternées |
| `--color-text` | `#2E2E2E` | Corps de texte |

Le gris domine. L’orange attire l’attention seulement.

## Typographie

- **Police :** Poppins (Google Fonts)
- Titres grands, paragraphes aérés, espacement généreux

## Motion (GSAP)

| Effet | Où |
|-------|-----|
| Fade + léger parallax | Hero |
| Fade / slide au scroll (une fois) | Sections |
| Count-up | Statistiques |
| Reveal progressif | Timeline |
| Scale / ombre CSS | Hover cartes |

Ne jamais sur-animer.

## Hero (budget strict)

Premier viewport uniquement :

1. Logo + nom
2. « Depuis 1997 »
3. Une phrase d’accueil
4. Un groupe CTA
5. Image plein écran (full-bleed)

Pas de stats, pas de cartes, pas de badges flottants sur le hero.

## Admin

- Sidebar sombre (`#424242` / quasi-noir)
- Contenu clair, minimal, professionnel
- Cartes stats + graphiques (Chart.js)
- Tables responsive
