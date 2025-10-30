import Swiper, { Navigation, A11y, Autoplay, Pagination } from 'swiper'
import 'swiper/css/bundle'
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
    spaceBetween: 25,
    loop: true,
    loopAdditionalSlides: 3,
    allowTouchMove: true,
    simulateTouch: false,
    freeMode: {
      enabled: true,
      momentum: false,
    },
    navigation: {
      nextEl: refs.next,
      prevEl: refs.prev,
    },
    pagination: {
      el: refs.dots,
      type: 'bullets',
      clickable: true,
    },
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
    on: {
      afterInit: () => {
        ScrollTrigger.refresh()
      },
    },
    loop: options.autoplayDelay,
    speed: options.autoplaySpeed,
  }
  if (options.autoplay && options.autoplayDelay) {
    config.autoplay = {
      delay: options.autoplayDelay,
    }
  }

  return new Swiper(refs.slider, config)
}
