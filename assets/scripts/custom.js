import $ from 'jquery'

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
