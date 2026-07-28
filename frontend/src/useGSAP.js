import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

export const useGSAP = () => {
  const fadeIn = (element, duration = 0.6, delay = 0) => {
    return gsap.fromTo(
      element,
      { opacity: 0 },
      { opacity: 1, duration, delay, ease: 'power2.out' }
    )
  }

  const slideUp = (element, duration = 0.6, delay = 0) => {
    return gsap.fromTo(
      element,
      { opacity: 0, y: 30 },
      { opacity: 1, y: 0, duration, delay, ease: 'power2.out' }
    )
  }

  const slideDown = (element, duration = 0.6, delay = 0) => {
    return gsap.fromTo(
      element,
      { opacity: 0, y: -30 },
      { opacity: 1, y: 0, duration, delay, ease: 'power2.out' }
    )
  }

  const scaleIn = (element, duration = 0.6, delay = 0) => {
    return gsap.fromTo(
      element,
      { opacity: 0, scale: 0.95 },
      { opacity: 1, scale: 1, duration, delay, ease: 'back.out' }
    )
  }

  const parallax = (element, speed = 0.5) => {
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

  const stagger = (elements, duration = 0.6, delay = 0.1) => {
    return gsap.fromTo(
      elements,
      { opacity: 0, y: 20 },
      {
        opacity: 1,
        y: 0,
        duration,
        stagger: delay,
        ease: 'power2.out',
      }
    )
  }

  const counter = (element, target, duration = 2) => {
    const obj = { value: 0 }
    return gsap.to(obj, {
      value: target,
      duration,
      ease: 'power2.out',
      onUpdate() {
        element.textContent = Math.ceil(obj.value).toLocaleString('fr-FR')
      },
    })
  }

  const scrollTriggerFadeIn = (element, duration = 0.6) => {
    gsap.fromTo(
      element,
      { opacity: 0, y: 30 },
      {
        opacity: 1,
        y: 0,
        duration,
        ease: 'power2.out',
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
    const timeline = gsap.timeline({ paused: true })
    timeline.to(element, {
      scale: 1.05,
      duration: 0.3,
      ease: 'power2.out',
    })

    element.addEventListener('mouseenter', () => timeline.play())
    element.addEventListener('mouseleave', () => timeline.reverse())

    return timeline
  }

  const revealText = (element, duration = 1) => {
    const text = element.textContent
    element.textContent = ''

    return gsap.to(element, {
      duration,
      text: text,
      ease: 'none',
    })
  }

  const blurIn = (element, duration = 0.6, delay = 0) => {
    return gsap.fromTo(
      element,
      { opacity: 0, filter: 'blur(10px)' },
      { opacity: 1, filter: 'blur(0px)', duration, delay, ease: 'power2.out' }
    )
  }

  const rotate = (element, duration = 1, rotation = 360) => {
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
