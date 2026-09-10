# Phase 4: Design System & Vue Components

## Overview

Phase 4 establishes the visual foundation for the entire application. This includes:

- **Tailwind CSS 4** configuration with brand colors and typography
- **10 reusable Vue 3 components** with full Tailwind styling
- **GSAP animations** utilities for smooth transitions and scroll effects
- **Responsive design** mobile-first approach

**Status**: ✅ Complete (11 components, animation utilities, full documentation)

---

## Color Palette

### Primary Colors
- **Orange**: `#F57C00` — Used for CTAs, links, active states
- **Dark Gray**: `#424242` — Primary text, headings

### Secondary Colors
- **Light Gray**: `#F5F5F5` — Backgrounds
- **White**: `#FFFFFF` — Main background
- **Gray Shades**: 50-900 scale for flexibility

### Semantic Colors
- **Success**: `#4CAF50`
- **Warning**: `#FFC107`
- **Error**: `#F44336`
- **Info**: `#2196F3`

**File**: `frontend/tailwind.config.js`

---

## Typography System

### Fonts
- **Primary Font**: Poppins (Google Fonts)
- **Fallback**: Inter, System UI
- **Monospace**: UI Monospace, Consolas

### Heading Sizes
| Class | Size | Font Weight | Usage |
|-------|------|-------------|-------|
| h1 | 56px (64px on desktop) | 700 | Page titles |
| h2 | 40px (48px on desktop) | 600 | Section titles |
| h3 | 32px (40px on desktop) | 600 | Subsection titles |
| h4 | 24px | 600 | Card titles |
| h5 | 20px | 600 | List items |
| h6 | 16px | 600 | Labels |

### Body Text
| Class | Size | Line Height |
|-------|------|-------------|
| body-lg | 18px | 1.6 |
| body-base | 16px | 1.6 |
| body-sm | 14px | 1.6 |
| body-xs | 12px | 1.5 |

**File**: `frontend/src/styles/tailwind.css`

---

## Core Components

### 1. **Button**
Versatile button with multiple variants and sizes.

**Props:**
- `variant`: 'primary', 'secondary', 'outline', 'ghost', 'danger' (default: 'primary')
- `size`: 'sm', 'md', 'lg' (default: 'md')
- `label`: Text content
- `icon`: Icon emoji or symbol
- `disabled`: Boolean
- `fullWidth`: Boolean

**Example:**
```vue
<Button 
  variant="primary" 
  size="lg" 
  label="Get Started"
  icon="🚀"
  @click="handleClick"
/>
```

**File**: `frontend/src/components/Button.vue`

---

### 2. **Card**
Container component with optional image, title, and description.

**Props:**
- `variant`: 'default', 'elevated', 'outlined', 'filled'
- `title`: String
- `description`: String
- `image`: Image URL
- `badge`: Badge text
- `hoverable`: Enable hover lift effect
- `clickable`: Cursor pointer

**Slots:**
- `image`: Custom image content
- `default`: Card body
- `footer`: Card footer

**Example:**
```vue
<Card 
  title="Program Name"
  description="Description here"
  image="/image.jpg"
  badge="New"
  :hoverable="true"
>
  <p>Additional content</p>
  <template #footer>
    <Button label="Learn More" variant="primary" />
  </template>
</Card>
```

**File**: `frontend/src/components/Card.vue`

---

### 3. **Input**
Form input with validation states, hints, and prefixes/suffixes.

**Props:**
- `modelValue`: String/Number
- `type`: 'text', 'email', 'password', etc. (default: 'text')
- `label`: Label text
- `placeholder`: Placeholder text
- `hint`: Helper text
- `error`: Error message (shows error state when present)
- `success`: Boolean (shows success state)
- `disabled`: Boolean
- `required`: Boolean (adds asterisk to label)
- `prefix`: Icon/symbol before input
- `suffix`: Icon/symbol after input
- `variant`: 'default', 'filled', 'outlined'

**Example:**
```vue
<Input 
  v-model="email"
  type="email"
  label="Email Address"
  placeholder="student@nouvelle.school"
  prefix="📧"
  hint="We'll never share your email"
  required
/>
```

**File**: `frontend/src/components/Input.vue`

---

### 4. **Hero**
Full-screen hero section with background, overlay, and animations.

**Props:**
- `title`: Main heading
- `subtitle`: Secondary heading
- `description`: Description text
- `logo`: Logo URL
- `backgroundImage`: Background image URL
- `showScrollIndicator`: Show scroll indicator (default: true)
- `parallaxSpeed`: Parallax effect speed (default: 0.5)

**Slots:**
- `logo`: Custom logo element
- `actions`: Action buttons

**Animations:**
- Slide up entrance
- Parallax background movement
- Bounce scroll indicator

**Example:**
```vue
<Hero 
  title="La nouvelle institution"
  subtitle="Depuis 1997"
  description="Excellence in Education"
  backgroundImage="/hero-bg.jpg"
  :showScrollIndicator="true"
>
  <template #actions>
    <Button label="Découvrir" size="lg" @click="scrollTo('#about')" />
  </template>
</Hero>
```

**File**: `frontend/src/components/Hero.vue`

---

### 5. **Section**
Wrapper component for consistent section styling.

**Props:**
- `title`: Section title
- `subtitle`: Section subtitle
- `variant`: 'default', 'wide', 'contained'
- `dark`: Dark background (default: false)
- `noPadding`: Remove padding

**Slots:**
- `header`: Custom header content

**Example:**
```vue
<Section 
  title="Academic Programs"
  subtitle="Explore our comprehensive curriculum"
  variant="default"
>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Content here -->
  </div>
</Section>
```

**File**: `frontend/src/components/Section.vue`

---

### 6. **Modal**
Dialog component with overlay and keyboard navigation.

**Props:**
- `modelValue`: Boolean (v-model)
- `title`: Modal title
- `closeOnEscape`: Close on Escape key (default: true)
- `closeOnClickOutside`: Close when clicking overlay (default: true)

**Slots:**
- `default`: Modal body
- `footer`: Modal footer

**Example:**
```vue
<Modal v-model="isOpen" title="Confirm Action">
  <p>Are you sure you want to proceed?</p>
  <template #footer>
    <Button variant="ghost" label="Cancel" @click="isOpen = false" />
    <Button variant="primary" label="Confirm" @click="handleConfirm" />
  </template>
</Modal>
```

**File**: `frontend/src/components/Modal.vue`

---

### 7. **Badge**
Small label component for status, tags, or counts.

**Props:**
- `label`: Badge text
- `variant`: 'primary', 'secondary', 'success', 'warning', 'error', 'info'
- `size`: 'sm', 'md', 'lg'

**Example:**
```vue
<Badge label="Featured" variant="primary" size="md" />
<Badge label="New" variant="success" size="sm" />
<Badge label="Sale" variant="warning" size="lg" />
```

**File**: `frontend/src/components/Badge.vue`

---

### 8. **StatsCounter**
Animated counter cards with GSAP animations.

**Props:**
- `stats`: Array of objects with `id`, `icon`, `value`, `label`, `suffix`

**Example:**
```vue
<StatsCounter 
  :stats="[
    { id: 1, icon: '👥', value: 500, label: 'Étudiants', suffix: '+' },
    { id: 2, icon: '👨‍🏫', value: 25, label: 'Enseignants' },
    { id: 3, icon: '🎓', value: 1200, label: 'Diplômés', suffix: '+' },
    { id: 4, icon: '📚', value: 25, label: 'Années', suffix: '+' },
  ]"
/>
```

**Animations:**
- Fade in on scroll
- Animated counter (0 → target)
- Stagger effect

**File**: `frontend/src/components/StatsCounter.vue`

---

### 9. **Navigation**
Responsive navbar with mobile menu toggle.

**Props:**
- `navLinks`: Array of navigation links (auto-generated from router)

**Slots:**
- `logo`: Custom logo element
- `actions`: Action buttons (login, etc.)

**Features:**
- Fixed positioning
- Responsive hamburger menu
- Active link highlighting
- Scroll shadow effect

**Example:**
```vue
<Navigation>
  <template #actions>
    <Button variant="primary" size="sm" label="Connexion" />
  </template>
</Navigation>
```

**File**: `frontend/src/components/Navigation.vue`

---

### 10. **GalleryGrid**
Masonry gallery with lightbox and category filtering.

**Props:**
- `items`: Array of gallery items with `id`, `image`, `title`, `date`, `category`
- `categories`: Array of category names for filtering
- `categoryField`: Property name for category (default: 'category')

**Slots:**
- `header`: Custom filter header

**Features:**
- Masonry layout
- Responsive columns
- Category filtering
- Lightbox preview
- Image zoom on hover

**Example:**
```vue
<GalleryGrid 
  :items="galleryItems"
  :categories="['Graduation', 'Sports', 'Science', 'Culture']"
/>
```

**File**: `frontend/src/components/GalleryGrid.vue`

---

### 11. **Timeline**
Animated timeline component for school history.

**Props:**
- `timelineItems`: Array with `id`, `year`, `title`, `description`, `icon`, `items`

**Features:**
- Vertical timeline with connecting line
- Alternating left/right layout
- Icon markers
- Stagger animations
- Responsive mobile layout

**Example:**
```vue
<Timeline 
  :timelineItems="[
    {
      id: 1,
      year: '1997',
      icon: '🏫',
      title: 'Création de l\'établissement',
      description: 'Fondation de La nouvelle institution',
      items: ['5 classes', '50 étudiants', 'Équipe initiale']
    },
    // ...
  ]"
/>
```

**File**: `frontend/src/components/Timeline.vue`

---

## GSAP Animation Utilities

Composable with reusable animation functions.

**File**: `frontend/src/useGSAP.js`

### Available Animations

```javascript
import { useGSAP } from '@/useGSAP'

const { 
  fadeIn,           // Fade in from transparent
  slideUp,          // Slide up from below
  slideDown,        // Slide down from above
  scaleIn,          // Scale from 0.95
  parallax,         // Parallax scroll effect
  stagger,          // Stagger multiple elements
  counter,          // Animated number counter
  scrollTriggerFadeIn,  // Fade in on scroll
  createTimeline,   // Create GSAP timeline
  hoverPulse,       // Hover scale pulse
  revealText,       // Text reveal animation
  blurIn,           // Blur in effect
  rotate,           // Continuous rotation
} = useGSAP()
```

### Usage Examples

```vue
<script setup>
import { useGSAP } from '@/useGSAP'

const { slideUp, counter, stagger } = useGSAP()

onMounted(() => {
  // Single element
  slideUp(document.querySelector('.hero'), 0.8)
  
  // Counter animation
  counter(counterElement, 1000, 2)
  
  // Multiple elements
  stagger(document.querySelectorAll('.card'), 0.6, 0.1)
})
</script>
```

---

## Spacing System

- `section`: 100px (vertical section padding)
- `section-sm`: 60px (small section padding)
- Standard Tailwind spacing with custom extensions

---

## Shadow System

- `shadow-soft`: Subtle shadow (used for cards)
- `shadow-medium`: Medium shadow (used for hover states)
- `shadow-large`: Large shadow (used for elevated elements)
- `shadow-hover`: Extra large shadow (used for interactive hover)

---

## Border Radius

- `rounded-sm`: 4px
- `rounded-md`: 8px
- `rounded-lg`: 12px
- `rounded-xl`: 16px

---

## Transition System

- `transition-smooth`: All properties, 300ms, ease-out
- `duration-fast`: 150ms
- `duration-normal`: 300ms
- `duration-slow`: 500ms

---

## Responsive Breakpoints

- Mobile: < 640px
- Tablet: 768px
- Desktop: 1024px
- Large Desktop: 1280px

---

## Installation & Setup

### 1. Tailwind CSS
Already configured in `frontend/tailwind.config.js` with brand colors and custom utilities.

### 2. Import Main Stylesheet
```javascript
// In main.js
import './styles/tailwind.css'
```

### 3. Use Components
```vue
<template>
  <Button label="Click me" />
  <Card title="Example Card" />
</template>

<script setup>
import { Button, Card } from '@/components'
</script>
```

---

## Best Practices

### 1. **Animations**
- Use `useGSAP()` composable for consistent animations
- Keep animations under 1 second for subtle effects
- Use `scrollTrigger` for entrance animations

### 2. **Responsive Design**
- Mobile-first approach
- Use `md:`, `lg:`, `xl:` prefixes
- Test on actual devices

### 3. **Accessibility**
- Always use semantic HTML
- Maintain color contrast ratios
- Use `focus-ring` class for keyboard navigation
- Include ARIA labels where necessary

### 4. **Performance**
- Lazy load images with `<img loading="lazy">`
- Use `transition-smooth` for performance
- Defer animations until component mount

---

## Component Tree

```
components/
├── Button.vue           # Action buttons
├── Card.vue             # Content containers
├── Input.vue            # Form inputs
├── Hero.vue             # Hero section
├── Section.vue          # Section wrapper
├── Modal.vue            # Dialog/modal
├── Badge.vue            # Status badges
├── StatsCounter.vue     # Animated stats
├── Navigation.vue       # Navbar
├── GalleryGrid.vue      # Image gallery
├── Timeline.vue         # Timeline display
└── index.js             # Component exports
```

---

## Files Created

- `frontend/tailwind.config.js` — Tailwind configuration with brand colors
- `frontend/src/styles/tailwind.css` — Tailwind directives and custom layers
- `frontend/src/useGSAP.js` — GSAP animation utilities
- `frontend/src/components/Button.vue` — Button component
- `frontend/src/components/Card.vue` — Card component
- `frontend/src/components/Input.vue` — Input component
- `frontend/src/components/Hero.vue` — Hero section
- `frontend/src/components/Section.vue` — Section wrapper
- `frontend/src/components/Modal.vue` — Modal component
- `frontend/src/components/Badge.vue` — Badge component
- `frontend/src/components/StatsCounter.vue` — Stats counter
- `frontend/src/components/Navigation.vue` — Navigation bar
- `frontend/src/components/GalleryGrid.vue` — Gallery grid
- `frontend/src/components/Timeline.vue` — Timeline component
- `frontend/src/components/index.js` — Component exports

---

## Next Phase: Phase 5 - Homepage Implementation

Ready to build the homepage using these components:

1. **Hero Section** with parallax and CTA
2. **About Section** with Timeline
3. **Academic Programs** with Card grid
4. **School Life** with category cards
5. **Latest Activities** with featured items
6. **Gallery** with masonry layout
7. **Statistics** with animated counters
8. **Testimonials** with carousel
9. **Contact Section** with map and form

Estimated time: 4-5 hours

---

## Notes

- All components are fully responsive
- GSAP animations are optional and gracefully degrade
- Tailwind config can be extended for specific needs
- Color palette matches school branding guidelines
- Typography hierarchy ensures readability at all sizes
