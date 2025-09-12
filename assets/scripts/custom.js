import $ from 'jquery'
import gsap from 'gsap'

// Page Load Animation - Similar to Justified Studio
class PageLoadAnimation {
  constructor() {
    this.init()
  }

  init() {
    // Create the animation overlay
    this.createAnimationOverlay()
    
    // Start the animation sequence
    this.startAnimation()
  }

  createAnimationOverlay() {
    // Add loading class to body
    $('body').addClass('animation-loading')
    
    // Create the animation HTML
    const animationHTML = `
      <div class="page-load-animation" id="pageLoadAnimation">
        <div class="animation-content">
          <img src="${window.location.origin}/wp-content/themes/new-s/assets/images/logo.svg" alt="Logo" class="logo" />
        </div>
      </div>
    `
    
    // Add to body
    $('body').prepend(animationHTML)
  }

  startAnimation() {
    const tl = gsap.timeline()
    
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
    
    // Remove from DOM after animation completes
    setTimeout(() => {
      $animation.remove()
      $('body').removeClass('animation-loading')
    }, 800)
  }
}

// Initialize the page load animation
$(document).ready(function () {
  new PageLoadAnimation()
})

$(document).ready(function () {
  $('#showMyCalendar').click(function () {
    $('#myCalendarWrapper').toggle()
  })
  $('#hideMyCalendar').click(function () {
    $('#myCalendarWrapper').hide()
  })
})

$(document).ready(function () {
  $('#showFilters').click(function () {
    $('.filterSection--inner').slideToggle('fast')
  })
})

// Footer toggle functionality
$(document).ready(function () {
  $('.openFooter').click(function () {
    $('.mainFooter').toggleClass('show')
  })
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
