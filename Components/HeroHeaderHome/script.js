import Swiper, { Autoplay } from 'swiper'
import 'swiper/css/bundle'
import { buildRefs } from '@/assets/scripts/helpers.js'

export default (heroHeaderHome) => {
  const refs = buildRefs(heroHeaderHome)
  
  // Initialize marquee if it exists
  let swiper = null
  if (refs.marquee) {
    swiper = initMarquee(refs)
  }
  
  return () => {
    if (swiper) {
      swiper.destroy()
    }
  }
}

function initMarquee(refs) {
  const config = {
    modules: [Autoplay],
    slidesPerView: 'auto',
    spaceBetween: 90,
    loop: true,
    speed: 50000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      pauseOnMouseEnter: false,
      waitForTransition: false,
    },
    loopAdditionalSlides: 3,
    allowTouchMove: true,
    simulateTouch: false,
    freeMode: {
      enabled: true,
      momentum: false,
    },
  }

  return new Swiper(refs.marquee, config)
}