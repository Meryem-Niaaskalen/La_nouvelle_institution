# Vue Components Usage Guide

Quick reference for using all Phase 4 components.

---

## 🔘 Button

**Variants**: `primary`, `secondary`, `outline`, `ghost`, `danger`  
**Sizes**: `sm`, `md`, `lg`

```vue
<!-- Primary button -->
<Button 
  variant="primary" 
  label="Click Me"
  @click="handleClick"
/>

<!-- Large button with icon -->
<Button 
  variant="primary"
  size="lg"
  icon="🚀"
  label="Get Started"
/>

<!-- Outline button -->
<Button 
  variant="outline"
  label="Learn More"
/>

<!-- Disabled state -->
<Button 
  label="Disabled"
  :disabled="true"
/>

<!-- Full width -->
<Button 
  label="Full Width"
  :fullWidth="true"
/>
```

---

## 🃏 Card

**Variants**: `default`, `elevated`, `outlined`, `filled`

```vue
<!-- Basic card -->
<Card 
  title="Program Name"
  description="Program description here"
/>

<!-- Card with image -->
<Card 
  title="Program Name"
  description="Description"
  image="/program.jpg"
  badge="Featured"
  :hoverable="true"
/>

<!-- Card with footer -->
<Card title="Custom Footer">
  <p>Card content goes here</p>
  <template #footer>
    <Button size="sm" label="Learn More" />
  </template>
</Card>

<!-- Filled variant -->
<Card 
  variant="filled"
  title="Card Title"
/>
```

---

## 📝 Input

**Variants**: `default`, `filled`, `outlined`  
**Types**: Standard HTML input types

```vue
<!-- Basic input -->
<Input 
  v-model="name"
  label="Full Name"
  placeholder="Enter your name"
/>

<!-- Email input with validation -->
<Input 
  v-model="email"
  type="email"
  label="Email Address"
  placeholder="student@nouvelle.school"
  hint="We'll never share your email"
/>

<!-- Input with error state -->
<Input 
  v-model="phone"
  label="Phone"
  :error="phoneError"
/>

<!-- Input with prefix and suffix -->
<Input 
  v-model="search"
  placeholder="Search..."
  prefix="🔍"
/>

<!-- Required field -->
<Input 
  v-model="password"
  type="password"
  label="Password"
  :required="true"
/>

<!-- Filled variant -->
<Input 
  v-model="message"
  variant="filled"
  label="Message"
/>
```

---

## 🏖️ Hero

**Props**: `title`, `subtitle`, `description`, `backgroundImage`, `showScrollIndicator`

```vue
<!-- Basic hero -->
<Hero 
  title="La nouvelle institution"
  subtitle="Depuis 1997"
  backgroundImage="/hero-bg.jpg"
/>

<!-- Hero with description and CTA -->
<Hero 
  title="Welcome to Our School"
  subtitle="Excellence in Education"
  description="Discover a modern learning environment"
  backgroundImage="/hero.jpg"
  :showScrollIndicator="true"
>
  <template #actions>
    <Button size="lg" label="Découvrir" />
    <Button size="lg" variant="outline" label="Nous Contacter" />
  </template>
</Hero>

<!-- Hero with custom logo -->
<Hero title="School Name">
  <template #logo>
    <img src="/logo.png" alt="Logo" />
  </template>
</Hero>
```

---

## 📄 Section

**Variants**: `default`, `wide`, `contained`

```vue
<!-- Basic section -->
<Section 
  title="Academic Programs"
  subtitle="Explore our curriculum"
>
  <!-- Content here -->
</Section>

<!-- Dark section -->
<Section 
  title="Section Title"
  :dark="true"
>
  <!-- Light text content -->
</Section>

<!-- Wide variant -->
<Section 
  title="Full Width Section"
  variant="wide"
>
  <!-- Content -->
</Section>

<!-- No padding -->
<Section 
  title="Custom Padding"
  :noPadding="true"
>
  <!-- Content -->
</Section>
```

---

## 🪟 Modal

**Props**: `modelValue` (v-model), `title`, `closeOnEscape`, `closeOnClickOutside`

```vue
<template>
  <button @click="showModal = true">Open Modal</button>

  <Modal 
    v-model="showModal"
    title="Confirm Action"
  >
    <p>Are you sure you want to proceed?</p>
    
    <template #footer>
      <Button 
        variant="ghost" 
        label="Cancel"
        @click="showModal = false"
      />
      <Button 
        variant="primary"
        label="Confirm"
        @click="handleConfirm"
      />
    </template>
  </Modal>
</template>

<script setup>
import { ref } from 'vue'

const showModal = ref(false)
</script>
```

---

## 🏷️ Badge

**Variants**: `primary`, `secondary`, `success`, `warning`, `error`, `info`  
**Sizes**: `sm`, `md`, `lg`

```vue
<!-- Primary badge -->
<Badge label="Featured" variant="primary" />

<!-- Success badge -->
<Badge label="Approved" variant="success" size="md" />

<!-- Large warning badge -->
<Badge label="Pending" variant="warning" size="lg" />

<!-- In a card -->
<Card>
  <template #badge>
    <Badge label="New" variant="success" size="sm" />
  </template>
</Card>
```

---

## 📊 StatsCounter

**Props**: `stats` array with objects containing `id`, `icon`, `value`, `label`, `suffix`

```vue
<StatsCounter 
  :stats="[
    { 
      id: 1, 
      icon: '👥', 
      value: 500, 
      label: 'Étudiants',
      suffix: '+' 
    },
    { 
      id: 2, 
      icon: '👨‍🏫', 
      value: 25, 
      label: 'Enseignants' 
    },
    { 
      id: 3, 
      icon: '🎓', 
      value: 1200, 
      label: 'Diplômés',
      suffix: '+' 
    },
    { 
      id: 4, 
      icon: '📚', 
      value: 25, 
      label: 'Années',
      suffix: '+' 
    },
  ]"
/>

<!-- Script -->
<script setup>
const stats = [
  { id: 1, icon: '👥', value: 500, label: 'Étudiants', suffix: '+' },
  // ... more stats
]
</script>
```

---

## 🧭 Navigation

**Props**: `navLinks` (auto-generated from router if not provided)

```vue
<Navigation>
  <template #actions>
    <Button 
      size="sm"
      variant="primary"
      label="Connexion"
    />
  </template>
</Navigation>

<!-- Custom nav links -->
<Navigation 
  :navLinks="[
    { path: '/', label: 'Accueil' },
    { path: '/about', label: 'À Propos' },
    { path: '/contact', label: 'Contact' },
  ]"
>
  <template #actions>
    <!-- Custom action buttons -->
  </template>
</Navigation>
```

---

## 🖼️ GalleryGrid

**Props**: `items`, `categories`, `categoryField`

```vue
<template>
  <GalleryGrid 
    :items="galleryItems"
    :categories="['Graduation', 'Sports', 'Science', 'Culture']"
  />
</template>

<script setup>
const galleryItems = [
  {
    id: 1,
    image: '/gallery/image1.jpg',
    title: 'Graduation 2024',
    date: 'June 15, 2024',
    category: 'Graduation'
  },
  {
    id: 2,
    image: '/gallery/image2.jpg',
    title: 'Football Tournament',
    date: 'April 20, 2024',
    category: 'Sports'
  },
  // ... more items
]
</script>
```

---

## 📅 Timeline

**Props**: `timelineItems` array with objects containing `id`, `year`, `title`, `description`, `icon`, `items`

```vue
<Timeline 
  :timelineItems="[
    {
      id: 1,
      year: '1997',
      icon: '🏫',
      title: 'Création de l\'établissement',
      description: 'Fondation de La nouvelle institution',
      items: [
        '5 classes',
        '50 étudiants',
        'Équipe initiale'
      ]
    },
    {
      id: 2,
      year: '2000',
      icon: '🎓',
      title: 'Premiers diplômés',
      description: 'Première promotion d\'élèves',
      items: [
        '25 diplômés',
        'Taux de réussite: 100%'
      ]
    },
    {
      id: 3,
      year: '2024',
      icon: '💻',
      title: 'Transformation numérique',
      description: 'Intégration complète des technologies',
      items: [
        'Salles informatiques',
        'Plateforme e-learning',
        '100% connexion internet'
      ]
    }
  ]"
/>
```

---

## ✨ GSAP Animations

```vue
<template>
  <div 
    ref="heroSection"
    class="hero"
  >
    Hero content
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useGSAP } from '@/useGSAP'

const heroSection = ref(null)
const { slideUp, parallax, stagger } = useGSAP()

onMounted(() => {
  // Single element animations
  slideUp(heroSection.value, 0.8)
  parallax(heroSection.value, 0.3)

  // Multiple elements
  const cards = document.querySelectorAll('.card')
  stagger(cards, 0.6, 0.1)
})
</script>
```

### Available GSAP Functions

```javascript
import { useGSAP } from '@/useGSAP'

const {
  fadeIn,               // (element, duration, delay)
  slideUp,              // (element, duration, delay)
  slideDown,            // (element, duration, delay)
  scaleIn,              // (element, duration, delay)
  parallax,             // (element, speed)
  stagger,              // (elements, duration, delay)
  counter,              // (element, target, duration)
  scrollTriggerFadeIn,  // (element, duration)
  createTimeline,       // () → timeline
  hoverPulse,           // (element)
  revealText,           // (element, duration)
  blurIn,               // (element, duration, delay)
  rotate,               // (element, duration, rotation)
} = useGSAP()
```

---

## 🎨 Tailwind Utilities

### Spacing Classes
```html
<!-- Section padding -->
<div class="py-section px-6">Full section padding (100px vertical)</div>
<div class="py-section-sm px-6">Small section padding (60px vertical)</div>
```

### Hover Effects
```html
<!-- Lift effect on hover -->
<div class="hover-lift">Hovers up with shadow</div>

<!-- Scale effect on hover -->
<div class="hover-scale">Scales up on hover</div>
```

### Responsive Grid
```html
<!-- 1 column on mobile, 2 on tablet, 3 on desktop -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
  <!-- Items here -->
</div>
```

### Focus Ring
```html
<!-- Keyboard focus ring -->
<button class="focus-ring">Accessible focus state</button>
```

### Transitions
```html
<!-- Smooth transitions -->
<div class="transition-smooth hover:shadow-large">
  Smooth transition on hover
</div>
```

---

## 📱 Responsive Design Pattern

```vue
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <Card 
    v-for="item in items"
    :key="item.id"
    :title="item.title"
    :hoverable="true"
  />
</div>

<!-- Classes breakdown -->
<!-- grid-cols-1      : 1 column on mobile -->
<!-- md:grid-cols-2   : 2 columns on tablets (768px+) -->
<!-- lg:grid-cols-3   : 3 columns on desktop (1024px+) -->
<!-- gap-6            : 24px spacing between items -->
```

---

## 🚀 Full Page Example

```vue
<template>
  <Navigation />
  
  <Hero 
    title="Welcome"
    backgroundImage="/hero.jpg"
  >
    <template #actions>
      <Button label="Get Started" size="lg" />
    </template>
  </Hero>

  <Section title="Our Programs">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <Card 
        v-for="program in programs"
        :key="program.id"
        :title="program.name"
        :description="program.description"
        :hoverable="true"
      />
    </div>
  </Section>

  <Section title="Our Impact" :dark="true">
    <StatsCounter :stats="stats" />
  </Section>
</template>

<script setup>
import { Navigation, Hero, Section, Card, StatsCounter, Button } from '@/components'
import { useGSAP } from '@/useGSAP'

// Data
const programs = []
const stats = []

// Animations
const { slideUp } = useGSAP()
</script>
```

---

## 🎯 Best Practices

1. **Always use v-model for two-way binding**
   ```vue
   <Input v-model="email" />
   ```

2. **Keep animations under 1 second for UX**
   ```javascript
   slideUp(element, 0.6)  // 600ms - perfect
   ```

3. **Use semantic HTML with components**
   ```vue
   <Section>  <!-- Uses <section> tag -->
     <Card>   <!-- Uses <div> with article semantics -->
   </Section>
   ```

4. **Test responsive behavior on actual devices**

5. **Use focus-ring class for keyboard navigation**
   ```html
   <button class="focus-ring">Accessible button</button>
   ```

---

## 📚 Next Steps

Phase 5 will combine these components into:
- ✅ Homepage with all sections
- ✅ Public pages (About, Programs, Gallery, Contact)
- ✅ Admin dashboard for content management

**Ready to build?** All components are production-ready! 🚀
