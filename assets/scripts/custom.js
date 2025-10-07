import $ from 'jquery'
import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

// Fade-in Animation
gsap.registerPlugin(ScrollTrigger)

// responsive
const mm = gsap.matchMedia()

window.onload = () => {
  // scroll to element id on load
  setTimeout(() => {
    const url = window.location.href
    const hash = url.substring(url.indexOf('#') + 1)
    if (hash) {
      const element = document.getElementById(hash)
      if (element) {
        element.scrollIntoView()
      }
    }
  }, 200)
}

mm.add('(min-width: 1280px)', () => {
  gsap.set('.fade-in', { opacity: 0 })
  gsap.set('.move-up', { y: 200 })
})

ScrollTrigger.batch('.fade-in', {
  onEnter: (elements) =>
    gsap.to(elements, { opacity: 1, stagger: 0.1, duration: 0.5 }),
  start: '1vh bottom',
  end: 'top top',
})

ScrollTrigger.batch('.move-up', {
  onEnter: (elements) =>
    gsap.to(elements, { y: 0, stagger: 0.1, duration: 0.3 }),
  start: '1vh bottom',
  end: 'top top',
})

// Page Load Animation
class PageLoadAnimation {
  constructor() {
    this.init()
  }

  init() {
    // Only run animation on desktop devices
    if (this.isDesktop()) {
      this.startAnimation()
    } else {
      // On mobile, immediately remove loading state
      this.skipAnimation()
    }
  }

  isDesktop() {
    // Check if screen width is desktop size (typically 1024px and above)
    return window.innerWidth >= 1024
  }

  skipAnimation() {
    // Remove loading state immediately on mobile
    const $animation = $('#pageLoadAnimation')
    if ($animation.length) {
      $animation.remove()
    }
    $('body').removeClass('page-loading')
  }

  startAnimation() {
    // Wait for page to be fully loaded
    $(window).on('load', () => {
      // Add a small delay for better UX
      setTimeout(() => {
        this.hideAnimation()
      }, 1000)
    })
    
    // Fallback in case window load doesn't fire
    setTimeout(() => {
      this.hideAnimation()
    }, 4000)
  }

  hideAnimation() {
    const $animation = $('#pageLoadAnimation')
    
    // Add fade-out class
    $animation.addClass('fade-out')
    
    // Remove from DOM after animation completes and restore body scroll
    setTimeout(() => {
      $animation.remove()
      $('body').removeClass('page-loading')
    }, 800)
  }
}

// Initialize the page load animation
$(document).ready(function () {
  new PageLoadAnimation()
})

var menu = $('.mainMenu');

$(document).scroll(function () {
    if ($(this).scrollTop() >= $(window).height() - menu.height()) {
        menu.removeClass('bottom').addClass('top');
    }
    else {
        menu.removeClass('top').addClass('bottom');
    }
});

// Menu items color change
// $(document).ready(function () {
//   let lastScrollTop = 0;
//   $(window).scroll(function () {
//     let currentScrollTop = $(this).scrollTop();
    
//     if (currentScrollTop > lastScrollTop) {
//       // Scrolling down
//       $('flynt-component[name="NavigationBurger"]').addClass('scrolled')
//     } else {
//       // Scrolling up
//       $('flynt-component[name="NavigationBurger"]').removeClass('scrolled')
//     }
    
//     lastScrollTop = currentScrollTop;
//   })
// })