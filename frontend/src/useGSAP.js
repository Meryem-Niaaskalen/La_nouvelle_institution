import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

// Respect user preference for reduced motion and provide graceful fallbacks
const prefersReducedMotion = () => {
  try {
    return typeof window !== 'undefined' && window.matchMedia('(prefers-reduced-motion: reduce)').matches
  } catch (e) {
    return false
  }
}

export const useGSAP = () => {
  const reduced = prefersReducedMotion()

  const defaultEase = 'expo.out'
  const defaultDuration = 0.9

  const applyOrSet = (element, props) => {
    // If reduced motion is requested, instantly apply final styles
    if (reduced) {
      try {
        gsap.set(element, props)
      } catch (e) {
        // ignore
      }
      return null
    }

    // Normal flow: caller will animate
    return null
  }

  const fadeIn = (element, duration = defaultDuration, delay = 0) => {
    if (reduced) return applyOrSet(element, { opacity: 1 })

    return gsap.fromTo(
      element,
      { opacity: 0 },
      { opacity: 1, duration, delay, ease: defaultEase }
    )
  }

  const slideUp = (element, duration = defaultDuration, delay = 0) => {
    if (reduced) return applyOrSet(element, { opacity: 1, y: 0 })

    return gsap.fromTo(
      element,
      { opacity: 0, y: 28 },
      { opacity: 1, y: 0, duration, delay, ease: defaultEase }
    )
  }

  const slideDown = (element, duration = defaultDuration, delay = 0) => {
    if (reduced) return applyOrSet(element, { opacity: 1, y: 0 })

    return gsap.fromTo(
      element,
      { opacity: 0, y: -28 },
      { opacity: 1, y: 0, duration, delay, ease: defaultEase }
    )
  }

  const scaleIn = (element, duration = defaultDuration, delay = 0) => {
    if (reduced) return applyOrSet(element, { opacity: 1, scale: 1 })

    return gsap.fromTo(
      element,
      { opacity: 0, scale: 0.97 },
      { opacity: 1, scale: 1, duration, delay, ease: 'back.out(1.2)' }
    )
  }

  const parallax = (element, speed = 0.5) => {
    if (reduced) return // avoid motion if user prefers reduced motion

    gsap.to(element, {
      y: () => window.innerHeight * speed,
      scrollTrigger: {
        trigger: element,
        start: 'top bottom',
        end: 'bottom top',
        scrub: true,
        markers: false,
      },
    })
  }

  const stagger = (elements, duration = defaultDuration, delay = 0.12) => {
    if (reduced) return applyOrSet(elements, { opacity: 1, y: 0 })

    return gsap.fromTo(
      elements,
      { opacity: 0, y: 20 },
      {
        opacity: 1,
        y: 0,
        duration,
        stagger: delay,
        ease: defaultEase,
      }
    )
  }

  const counter = (element, target, duration = 2.2) => {
    if (reduced) {
      try {
        element.textContent = target.toLocaleString('fr-FR')
      } catch (e) {}
      return null
    }

    const obj = { value: 0 }
    return gsap.to(obj, {
      value: target,
      duration,
      ease: defaultEase,
      onUpdate() {
        element.textContent = Math.ceil(obj.value).toLocaleString('fr-FR')
      },
    })
  }

  const scrollTriggerFadeIn = (element, duration = defaultDuration) => {
    if (reduced) return applyOrSet(element, { opacity: 1, y: 0 })

    gsap.fromTo(
      element,
      { opacity: 0, y: 30 },
      {
        opacity: 1,
        y: 0,
        duration,
        ease: defaultEase,
        scrollTrigger: {
          trigger: element,
          start: 'top 80%',
          end: 'top 50%',
          scrub: false,
          markers: false,
        },
      }
    )
  }

  const createTimeline = () => gsap.timeline()

  const hoverPulse = (element) => {
    // For reduced motion, skip hover animations
    if (reduced) return null

    const timeline = gsap.timeline({ paused: true })
    timeline.to(element, {
      scale: 1.04,
      duration: 0.28,
      ease: 'power2.out',
    })

    element.addEventListener('mouseenter', () => timeline.play())
    element.addEventListener('mouseleave', () => timeline.reverse())

    return timeline
  }

  const revealText = (element, duration = 1) => {
    if (reduced) return applyOrSet(element, { opacity: 1 })

    const text = element.textContent
    element.textContent = ''

    return gsap.to(element, {
      duration,
      text: text,
      ease: 'none',
    })
  }

  const blurIn = (element, duration = defaultDuration, delay = 0) => {
    if (reduced) return applyOrSet(element, { opacity: 1, filter: 'none' })

    return gsap.fromTo(
      element,
      { opacity: 0, filter: 'blur(10px)' },
      { opacity: 1, filter: 'blur(0px)', duration, delay, ease: defaultEase }
    )
  }

  const rotate = (element, duration = 1, rotation = 360) => {
    if (reduced) return null

    return gsap.to(element, {
      rotation,
      duration,
      ease: 'none',
      repeat: -1,
    })
  }

  return {
    fadeIn,
    slideUp,
    slideDown,
    scaleIn,
    parallax,
    stagger,
    counter,
    scrollTriggerFadeIn,
    createTimeline,
    hoverPulse,
    revealText,
    blurIn,
    rotate,
  }
}
