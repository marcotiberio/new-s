export default function init () {
  // WooCommerce fires `added_to_cart` as a jQuery event on document.body
  // after a successful AJAX add. Bridge it to a native CustomEvent so the
  // Alpine drawer (listening via @cart:added.window) can react.
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', () => {
      window.dispatchEvent(new CustomEvent('cart:added'))
    })

    // After WC swaps fragments, surface the count change as a global event too.
    window.jQuery(document.body).on('wc_fragments_refreshed wc_fragments_loaded', () => {
      window.dispatchEvent(new CustomEvent('cart:updated'))
    })
  }
}
