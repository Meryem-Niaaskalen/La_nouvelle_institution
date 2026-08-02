<template>
  <section class="hero-section" @pointermove="handlePointerMove" @pointerleave="resetPointer">
    <div class="hero-shell">
      <div class="hero-copy">
        <h1 class="hero-title">
          <span>La nouvelle</span>
          <span class="hero-title-accent">institution</span>
        </h1>

        <div class="hero-date-row">
          <span class="hero-date">Depuis 1997</span>
        </div>

        <p class="hero-description">
          Maternelle, Primaire, Collège et Lycée — une école moderne, bienveillante et tournée vers l'excellence.
        </p>

        <div class="hero-levels" aria-label="Niveaux scolaires">
          <span class="hero-level-pill">Maternelle</span>
          <span class="hero-level-pill">Primaire</span>
          <span class="hero-level-pill">Collège</span>
          <span class="hero-level-pill">Lycée</span>
        </div>

        <div class="hero-ctas">
          <a href="#programs" class="hero-button hero-button-primary">
            <span>Découvrir nos programmes</span>
            <ArrowRight :size="18" stroke-width="2.5" />
          </a>
          <a href="#contact" class="hero-button hero-button-secondary">
            <span>Nous contacter</span>
            <ArrowRight :size="18" stroke-width="2.5" />
          </a>
        </div>
      </div>

      <div class="hero-image-wrap">
        <img
          class="hero-photo"
          :src="backgroundImage"
          alt="Façade principale de La nouvelle institution"
          :style="imageStyle"
        />
      </div>
    </div>

    <div class="hero-feature-grid">
      <article class="feature-card">
        <div class="feature-icon">
          <GraduationCap :size="30" stroke-width="2.1" />
        </div>
        <div class="feature-content">
          <h3>Une éducation complète</h3>
          <p>De la maternelle au lycée,<br />un parcours d'excellence.</p>
        </div>
      </article>

      <article class="feature-card">
        <div class="feature-icon">
          <Trophy :size="30" stroke-width="2.1" />
        </div>
        <div class="feature-content">
          <h3>Excellence &amp; Réussite</h3>
          <p>Des valeurs fortes pour des<br />réussites durables.</p>
        </div>
      </article>

      <article class="feature-card">
        <div class="feature-icon">
          <Users :size="30" stroke-width="2.1" />
        </div>
        <div class="feature-content">
          <h3>Bienveillance &amp; Engagement</h3>
          <p>Une communauté éducative<br />à l'écoute et engagée.</p>
        </div>
      </article>
    </div>

    <div class="hero-wave" aria-hidden="true"></div>
  </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import gsap from 'gsap'
import { ArrowRight, GraduationCap, Trophy, Users } from 'lucide-vue-next'
import { useGSAP } from '../useGSAP'

const props = defineProps({
  backgroundImage: {
    type: String,
    default: '/images/school-facade.png',
  },
})

const imgOffset = ref({ x: 0, y: 0 })
const prefersReduce = typeof window !== 'undefined' && window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches

const imageStyle = computed(() => ({
  transform: `translate3d(${imgOffset.value.x}px, ${imgOffset.value.y}px, 0) scale(1)`,
}))

const { fadeIn, slideUp, stagger } = useGSAP()

const handlePointerMove = (event) => {
  if (prefersReduce) return
  const rect = event.currentTarget.getBoundingClientRect()
  const x = ((event.clientX - rect.left) / rect.width - 0.5) * 8
  const y = ((event.clientY - rect.top) / rect.height - 0.5) * 6
  imgOffset.value = { x: x * 0.6, y: y * 0.6 }
}

const resetPointer = () => {
  if (prefersReduce) return
  imgOffset.value = { x: 0, y: 0 }
}

onMounted(() => {
  const heroTitles = document.querySelectorAll('.hero-title span')
  const heroDate = document.querySelector('.hero-date-row')
  const heroDescription = document.querySelector('.hero-description')
  const levelPills = document.querySelectorAll('.hero-level-pill')
  const heroButtons = document.querySelectorAll('.hero-button')
  const featureCards = document.querySelectorAll('.feature-card')
  const heroPhoto = document.querySelector('.hero-photo')

  if (heroTitles.length > 0) {
    slideUp(heroTitles, 0.95, 0.06)
  }

  if (heroDate) {
    fadeIn(heroDate, 0.9, 0.12)
  }

  if (heroDescription) {
    fadeIn(heroDescription, 0.9, 0.18)
  }

  if (levelPills.length > 0) {
    stagger(levelPills, 0.9, 0.08)
  }

  if (heroButtons.length > 0) {
    stagger(heroButtons, 0.95, 0.1)
  }

  if (featureCards.length > 0) {
    stagger(featureCards, 0.95, 0.1)
  }

  if (heroPhoto && !prefersReduce) {
    gsap.fromTo(
      heroPhoto,
      { opacity: 0, scale: 1.04 },
      { opacity: 1, scale: 1, duration: 1.25, delay: 0.15, ease: 'expo.out' }
    )
  }
})
</script>

<style scoped>
@reference '../styles/tailwind.css';

.hero-section {
  position: relative;
  min-height: 760px;
  overflow: hidden;
  background: linear-gradient(180deg, #fcfbf9 0%, #f9f7f3 100%);
}

.hero-shell {
  position: relative;
  width: 100%;
  min-height: 700px;
  max-width: 1520px;
  margin: 0 auto;
  padding: 28px 0 72px 82px;
  isolation: isolate;
}

.hero-copy {
  position: relative;
  z-index: 2;
  width: min(100%, 500px);
  margin-top: 52px;
  padding-left: 4px;
}

.hero-title {
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0;
  font-family: 'Poppins', 'Inter', sans-serif;
  font-size: clamp(4rem, 5.8vw, 6.9rem);
  line-height: 0.9;
  letter-spacing: -0.065em;
  font-weight: 800;
  color: #18212f;
  text-align: left;
}

.hero-title span {
  display: block;
}

.hero-title-accent {
  color: #f57c00;
}

.hero-date-row {
  margin-top: 26px;
  width: fit-content;
}

.hero-date {
  display: inline-block;
  font-size: 1.1rem;
  font-weight: 800;
  color: #18212f;
  background: transparent;
}

.hero-date-row::after {
  content: '';
  display: block;
  width: 150px;
  height: 4px;
  margin-top: 8px;
  border-radius: 999px;
  background: #f57c00;
}

.hero-description {
  margin-top: 26px;
  max-width: 520px;
  color: #4b5563;
  font-size: 1.18rem;
  line-height: 1.62;
  font-weight: 500;
}

.hero-levels {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 28px;
}

.hero-level-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 18px;
  border-radius: 999px;
  background: #f57c00;
  color: #fff;
  font-size: 1rem;
  font-weight: 700;
  box-shadow: 0 14px 30px rgba(245, 124, 0, 0.16);
  transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
}

.hero-level-pill:hover {
  transform: translateY(-4px);
  background: #ea7000;
}

.hero-ctas {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  margin-top: 34px;
}

.hero-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  min-width: 192px;
  padding: 14px 20px;
  border-radius: 14px;
  font-size: 1rem;
  font-weight: 700;
  text-decoration: none;
  transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease, color 0.3s ease;
}

.hero-button-primary {
  background: #f57c00;
  color: #fff;
  box-shadow: 0 18px 45px rgba(245, 124, 0, 0.22);
}

.hero-button-primary:hover {
  transform: translateY(-4px);
  background: #ea7000;
  box-shadow: 0 24px 56px rgba(245, 124, 0, 0.28);
}

.hero-button-secondary {
  background: rgba(255, 255, 255, 0.8);
  border: 1px solid #f57c00;
  color: #f57c00;
}

.hero-button-secondary:hover {
  transform: translateY(-4px);
  background: #f57c00;
  color: #fff;
}

.hero-image-wrap {
  position: absolute;
  top: 10px;
  right: -6px;
  width: 63%;
  height: calc(100% - 20px);
  min-height: 700px;
  overflow: hidden;
  border-radius: 0;
  background: transparent;
}

.hero-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center 46%;
  filter: saturate(1) contrast(1.02) brightness(1.01);
  opacity: 0;
  transition: transform 0.25s ease-out;
}

.hero-image-wrap::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to right,
    rgba(252, 251, 249, 0.98) 0%,
    rgba(252, 251, 249, 0.88) 8%,
    rgba(252, 251, 249, 0.52) 18%,
    rgba(252, 251, 249, 0.2) 28%,
    rgba(252, 251, 249, 0) 40%
  );
  pointer-events: none;
  z-index: 1;
}

.hero-feature-grid {
  position: relative;
  z-index: 3;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 18px;
  width: min(1180px, calc(100% - 48px));
  margin: -34px auto 0;
  padding: 0 12px;
}

.feature-card {
  display: flex;
  align-items: center;
  gap: 16px;
  min-height: 120px;
  padding: 20px 22px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.94);
  border: 1px solid rgba(15, 23, 42, 0.06);
  box-shadow: 0 16px 38px rgba(15, 23, 42, 0.09);
  backdrop-filter: blur(10px);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 18px 42px rgba(15, 23, 42, 0.14);
}

.feature-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 66px;
  height: 66px;
  border-radius: 999px;
  flex-shrink: 0;
  background: #f57c00;
  color: #fff;
}

.feature-content h3 {
  margin: 0 0 6px;
  font-size: 1.16rem;
  line-height: 1.3;
  color: #18212f;
  font-weight: 700;
}

.feature-content p {
  margin: 0;
  color: #4b5563;
  font-size: 0.98rem;
  line-height: 1.45;
}

.hero-wave {
  position: absolute;
  left: 0;
  right: 0;
  bottom: -120px;
  height: 240px;
  overflow: hidden;
  pointer-events: none;
}

.hero-wave::before {
  content: '';
  position: absolute;
  left: 50%;
  bottom: 0;
  width: 140%;
  height: 220px;
  transform: translateX(-50%);
  border-radius: 50% 50% 0 0 / 100% 100% 0 0;
  background: #f57c00;
}

.hero-wave::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: 72px;
  width: 130%;
  height: 28px;
  transform: translateX(-50%);
  border-top: 2px solid rgba(255, 255, 255, 0.62);
  border-radius: 50%;
  opacity: 0.72;
}

@media (max-width: 1100px) {
  .hero-shell {
    padding: 70px 20px 180px;
  }

  .hero-image-wrap {
    position: relative;
    width: 100%;
    height: 520px;
    min-height: 520px;
    margin-top: 28px;
    border-radius: 0;
  }

  .hero-image-wrap::before {
    background: linear-gradient(180deg, rgba(250, 250, 249, 0.36), rgba(250, 250, 249, 0.02));
  }

  .hero-copy {
    width: min(100%, 680px);
    margin-top: 0;
  }

  .hero-feature-grid {
    grid-template-columns: 1fr;
    width: calc(100% - 32px);
    margin-top: -20px;
  }
}

@media (max-width: 768px) {
  .hero-section {
    min-height: auto;
  }

  .hero-shell {
    min-height: auto;
    padding: 60px 18px 124px;
  }

  .hero-title {
    font-size: clamp(3rem, 14vw, 4.2rem);
  }

  .hero-description {
    font-size: 1.05rem;
  }

  .hero-button {
    width: 100%;
  }

  .hero-image-wrap {
    height: 400px;
  }

  .hero-photo {
    object-position: center 44%;
  }

  .feature-card {
    padding: 18px 20px;
  }

  .hero-wave {
    bottom: -90px;
    height: 180px;
  }
}
</style>
