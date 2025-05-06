$(() => {
  $('.people__nav div:first-child a[data-filter]').addClass('active');
  const teamFilterFirst = $('.people__nav div:first-child a[data-filter]').attr('data-filter');
  $('[data-teams]').hide();
  $(`[data-teams~="${teamFilterFirst}"]`).show();

  // Apply flex order fix
  fixPeopleFlexOrder();

  $('a[data-filter]').on('click', function() {
    // Close any stray open person dropdowns
    $('.people .collapse').collapse('hide');

    // Hide everything
    $('[data-teams]').hide();

    // Remove active class to link if it has one
    $('a[data-filter]').removeClass('active');

    // Add active class to link
    $(this).addClass('active');

    // Show according to filters
    const teamFilter = $(this).attr('data-filter');
    $(`[data-teams~="${teamFilter}"]`).show();

    // Re-apply flex order fix
    fixPeopleFlexOrder();
  })
});

const SNAP_LG = 992;
const SNAP_SM = 767;

/**
 * Fixes the flex order so the people dropdown appears in the right place.
 */
const fixPeopleFlexOrder = () => {
  $('.people').each(function() {
    let j = 0;
    $(this).find('.js-flex-reorder>.js-flex-panel').each((i, el) => {
      const $panel = $(el);
      const $dropdown = $(el).next();
      const windowWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
      const divisor = windowWidth > SNAP_LG ? 3 : windowWidth < SNAP_SM ? 1 : 2;
      const rowOrder = Math.ceil((j + 1) / divisor);
      if($panel.is(':visible')) {
        // Fix flex
        $panel.css('order', rowOrder).addClass('is-number-' + (j+1));
        $dropdown.css('order', rowOrder + 1);
        j++;
      }else {
        // Reset everything else to zero
        $panel.css('order', 0);
        $dropdown.css('order', 0);
      }
    });
  });
};
