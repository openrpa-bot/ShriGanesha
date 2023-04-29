/**
 * @file
 * Defines the behavior of tooltip_ckeditor.
 */

(function($, Drupal, drupalSettings) {
  Drupal.behaviors.tooltipCkeditor = {
    attach: function (context, settings) {
      if (drupalSettings.data.hasOwnProperty('tooltip_ckeditor')) {
        var tooltipCkeditorSelector = drupalSettings.data.tooltip_ckeditor.tooltipCkeditorSelector;
        $(tooltipCkeditorSelector).tooltip();
        $(tooltipCkeditorSelector).on('click', function (e) {
          e.preventDefault();
        });
        $(tooltipCkeditorSelector).on('touchstart', function (e) {
          e.preventDefault();
          if ($(this).attr('aria-describedby')) {
            $(this).tooltip('close');
          }
          else {
            $(this).tooltip('open');
          }
        });
      }
      else {
        $(document).tooltip();
      }
    }
  }
})(jQuery, Drupal, drupalSettings);
