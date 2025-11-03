import Swiper from 'swiper'
import { Autoplay } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
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
    speed: 8000,
    autoplay: {
      delay: 1,
      disableOnInteraction: false,
      pauseOnMouseEnter: false,
    },
    loopAdditionalSlides: 3,
    allowTouchMove: false,
    simulateTouch: false,
  }

  return new Swiper(refs.marquee, config)
}