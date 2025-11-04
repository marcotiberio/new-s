import Swiper from 'swiper'
import { Navigation, A11y, Autoplay, Pagination } from 'swiper/modules'
import 'swiper/swiper-bundle.css'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { gsap } from 'gsap'

gsap.registerPlugin(ScrollTrigger)

export default (sliderLogos) => {
  const refs = buildRefs(sliderLogos)
  const data = getJSON(sliderLogos)
  const swiper = initSlider(refs, data)
  return () => swiper.destroy()
}

function initSlider(refs, data) {
  const { options } = data
  const config = {
    modules: [Navigation, A11y, Autoplay, Pagination],
    a11y: options.a11y,
    slidesPerView: 2.5,
    breakpoints: {
      640: {
        slidesPerView: 3,
        spaceBetween: 35,
      },
      1181: {
        slidesPerView: 6,
        spaceBetween: 30,
      },
    },
    loop: true,
    freeMode: true,
    spaceBetween: 25,
    speed: options.autoplaySpeed,
    autoplay: {
      delay: options.autoplayDelay,
      pauseOnMouseEnter: true,
      disableOnInteraction: false,
    }
  }

  return new Swiper(refs.slider, config)
}
