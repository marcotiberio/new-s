import Swiper, { Autoplay } from 'swiper'
import 'swiper/css/bundle'
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
    spaceBetween: 200,
    loop: true,
    speed: 60000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      pauseOnMouseEnter: false,
    },
    allowTouchMove: false,
    freeMode: {
      enabled: true,
      momentum: false,
    },
  }

  return new Swiper(refs.marquee, config)
}
