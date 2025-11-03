import Swiper from 'swiper'
import { Autoplay } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
import { buildRefs } from '@/assets/scripts/helpers.js'

export default (navigationFooter) => {
  const refs = buildRefs(navigationFooter)
  const swiper = initMarquee(refs)
  return () => swiper.destroy()
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
