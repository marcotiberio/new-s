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
// $(document).ready(function () {
//   $(window).scroll(function () {
//     if ($(this).scrollTop() >= 250) {
//       $('.wrapper--menu').addClass('scrolled')
//     } else {
//       $('.wrapper--menu').removeClass('scrolled')
//     }
//   })
// })
