import $ from 'jquery'
import gsap from 'gsap'

// Page Load Animation - Similar to Justified Studio
class PageLoadAnimation {
  constructor() {
    this.init()
  }

  init() {
    // Start the animation sequence
    this.startAnimation()
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

// Footer toggle functionality with fade animation
$(document).ready(function () {
  // Function to fade footer out (hide it)
  function fadeFooterOut() {
    const $footer = $('.mainFooter')
    const $body = $('body')
    const $openFooterBtn = $('.openFooter')
    
    $footer.addClass('show')
    $body.addClass('footer-open')
    $openFooterBtn.addClass('active')
  }
  
  // Function to fade footer in (show it)
  function fadeFooterIn() {
    const $footer = $('.mainFooter')
    const $body = $('body')
    const $openFooterBtn = $('.openFooter')
    
    $footer.removeClass('show')
    $body.removeClass('footer-open')
    $openFooterBtn.removeClass('active')
  }
  
  // Open/close footer button
  $('.openFooter').click(function () {
    const $footer = $('.mainFooter')
    
    if ($footer.hasClass('show')) {
      fadeFooterIn()
    } else {
      fadeFooterOut()
    }
  })
  
  // Close footer button
  $('.closeFooter').click(function () {
    fadeFooterIn()
  })
  
  // Close footer when clicking outside (overlay)
  $('.mainFooter').click(function (e) {
    if (e.target === this) {
      fadeFooterIn()
    }
  })
  
  // Close footer on escape key
  $(document).keyup(function (e) {
    if (e.keyCode === 27) { // ESC key
      fadeFooterIn()
    }
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
