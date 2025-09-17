import gsap from 'gsap'

export default function init() {
  const mainMenu = document.querySelector('.mainMenu')
  
  if (!mainMenu) return

  // Set initial state - hidden
  gsap.set(mainMenu, { opacity: 0 })

  // Wait for page animation to finish (1.8s total: 1s delay + 0.8s fade out)
  // Then wait 1 more second before fading in the menu
  gsap.to(mainMenu, {
    opacity: 1,
    duration: 0.3,
    ease: 'power2.out',
    delay: 2 // 1.8s (page animation) + 1s (additional delay)
  })
}
