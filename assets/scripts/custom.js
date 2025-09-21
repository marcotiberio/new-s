import $ from 'jquery'
import gsap from 'gsap'

// Page Load Animation - Similar to Justified Studio
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
$(document).ready(function () {
  let lastScrollTop = 0;
  $(window).scroll(function () {
    let currentScrollTop = $(this).scrollTop();
    
    if (currentScrollTop > lastScrollTop) {
      // Scrolling down
      $('flynt-component[name="NavigationBurger"]').addClass('scrolled')
    } else {
      // Scrolling up
      $('flynt-component[name="NavigationBurger"]').removeClass('scrolled')
    }
    
    lastScrollTop = currentScrollTop;
  })
})