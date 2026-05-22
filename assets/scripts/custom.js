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

// Checkout: move the sticky sidebar (totals + Pay Now) inside the main fields
// block so it can sit as the rightmost column alongside the address/payment
// columns instead of in WC's default 2-col sidebar layout.
if (document.body.classList.contains('woocommerce-checkout')) {
  const moveCheckoutSidebar = () => {
    const sidebar = document.querySelector('.wc-block-components-sidebar.wc-block-checkout__sidebar')
    const fields = document.querySelector('.wc-block-components-main.wc-block-checkout__main .wp-block-woocommerce-checkout-fields-block')
      || document.querySelector('.wp-block-woocommerce-checkout-fields-block')
    if (sidebar && fields && !fields.contains(sidebar)) {
      fields.appendChild(sidebar)
      return true
    }
    return false
  }

  if (!moveCheckoutSidebar()) {
    const observer = new MutationObserver(() => {
      if (moveCheckoutSidebar()) observer.disconnect()
    })
    observer.observe(document.body, { childList: true, subtree: true })
  }

  // Wrap the shipping-method / payment / order-notes / terms / actions blocks
  // in a single container so they can be styled as one grouped column.
  // The blocks mount across multiple React render passes, so this runs on every
  // mutation and is idempotent — newly-arrived blocks get pulled into the
  // existing wrapper.
  const GROUP_SELECTORS = [
    '.wp-block-woocommerce-checkout-shipping-methods-block',
    '.wp-block-woocommerce-checkout-payment-block',
    '.wp-block-woocommerce-checkout-order-note-block',
    '.wp-block-woocommerce-checkout-terms-block',
    '.wp-block-woocommerce-checkout-actions-block',
  ]
  const groupCheckoutBlocks = () => {
    const nodes = GROUP_SELECTORS
      .map((sel) => document.querySelector(sel))
      .filter(Boolean)
    if (!nodes.length) return
    let wrapper = document.querySelector('.flyntCheckoutGroup')
    if (!wrapper) {
      wrapper = Object.assign(document.createElement('div'), { className: 'flyntCheckoutGroup' })
      nodes[0].parentNode.insertBefore(wrapper, nodes[0])
    }
    nodes.forEach((n) => {
      if (n.parentNode !== wrapper) wrapper.appendChild(n)
    })
  }

  groupCheckoutBlocks()
  new MutationObserver(groupCheckoutBlocks).observe(document.body, { childList: true, subtree: true })

  // Stamp placeholders onto block-checkout inputs. WC Blocks doesn't render
  // the PHP-side `placeholder` config as an HTML attribute (it uses floating
  // labels), so we apply them client-side. Re-runs on DOM mutations because
  // React may re-render and strip the attribute.
  const placeholders = (window.FlyntCheckoutFields && window.FlyntCheckoutFields.placeholders) || {}
  const placeholderKeys = Object.keys(placeholders)
  if (placeholderKeys.length) {
    const applyPlaceholders = () => {
      placeholderKeys.forEach((key) => {
        const value = placeholders[key]
        document.querySelectorAll(`#shipping-${key}, #billing-${key}`).forEach((input) => {
          if (input.getAttribute('placeholder') !== value) {
            input.setAttribute('placeholder', value)
          }
        })
      })
    }
    applyPlaceholders()
    const phObserver = new MutationObserver(applyPlaceholders)
    phObserver.observe(document.body, { childList: true, subtree: true })
  }
}

// Reload page on viewport resize
let resizeTimer;
let currentWidth = window.innerWidth;
let currentHeight = window.innerHeight;

$(window).on('resize', function() {
  // Clear the previous timer
  clearTimeout(resizeTimer);
  
  // Set a new timer to reload the page after resize stops for 500ms
  resizeTimer = setTimeout(function() {
    const newWidth = window.innerWidth;
    const newHeight = window.innerHeight;
    
    // Only reload if the width changed significantly (more than 100px)
    // This avoids reloading on mobile when address bar shows/hides
    const widthDiff = Math.abs(newWidth - currentWidth);
    
    if (widthDiff > 100) {
      location.reload();
    } else {
      // Update stored dimensions if no reload happened
      currentWidth = newWidth;
      currentHeight = newHeight;
    }
  }, 500);
});