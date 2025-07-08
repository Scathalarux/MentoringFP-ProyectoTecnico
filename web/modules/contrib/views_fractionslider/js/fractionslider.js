/**
 * @file
 * Fractionslider js.
 */

(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.fractionslider = {
    attach: function (context) {
      if (drupalSettings.fractionslider && $('.fractionslider-wrapper').length > 0) {
        const settings = drupalSettings.fractionslider;

        $('.fractionslider-wrapper .slider-wrapper .slider', context).fractionSlider({
          'fullWidth': (settings.fractionslider_fullwidth !== 'false'),
          'controls': (settings.fractionslider_controls !== 'false'),
          'pager': (settings.fractionslider_pager !== 'false'),
          'responsive': (settings.fractionslider_responsive !== 'false'),
          'dimensions': settings.fractionslider_dimensions,
          'increase': (settings.fractionslider_increase !== 'false'),
          'pauseOnHover': (settings.pausehover !== 'false'),
          'slideEndAnimation': true,
        });
      }

      if (drupalSettings.view_fs_fractionslider && $('.view .slider-wrapper .slider').length > 0) {
        const views_settings = drupalSettings.view_fs_fractionslider;

        $('.view .slider-wrapper .slider', context).fractionSlider({
          'fullWidth': (drupalSettings.view_fs_fractionslider.fullwidth !== 'false'),
          'controls': (drupalSettings.view_fs_fractionslider.controls !== 'false'),
          'pager': (drupalSettings.view_fs_fractionslider.pager !== 'false'),
          'responsive': (drupalSettings.view_fs_fractionslider.responsive !== 'false'),
          'dimensions': views_settings.dimensions,
          'increase': (drupalSettings.view_fs_fractionslider.increase !== 'false'),
          'pauseOnHover': false,
          'slideEndAnimation': true,
        });
      }

    }
  };
})(jQuery, Drupal, drupalSettings);
