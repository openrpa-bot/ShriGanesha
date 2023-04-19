/**
 * @file
 * Attaches behaviors for the Clientside Validation jQuery module.
 */
(function ($, Drupal, once, drupalSettings) {
  'use strict';

  if (typeof drupalSettings.cvJqueryValidateOptions === 'undefined') {
    drupalSettings.cvJqueryValidateOptions = {};
  }

  if (drupalSettings.clientside_validation_jquery.force_validate_on_blur) {
    drupalSettings.cvJqueryValidateOptions.onfocusout = function (element) {
      // "eager" validation
      this.element(element);
    };
  }

  // Add messages with translations from backend.
  $.extend($.validator.messages, drupalSettings.clientside_validation_jquery.messages);

  /**
   * Attaches jQuery validate behavior to forms.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *  Attaches the outline behavior to the right context.
   */
  Drupal.behaviors.cvJqueryValidate = {
    attach: function (context) {
      if (typeof Drupal.Ajax !== 'undefined') {
        // Update Drupal.Ajax.prototype.beforeSend only once.
        if (typeof Drupal.Ajax.prototype.beforeSubmitCVOriginal === 'undefined') {
          var validateAll = 2;
          try {
            validateAll = drupalSettings.clientside_validation_jquery.validate_all_ajax_forms;
          }
          catch(e) {
            // Do nothing if we do not have settings or value in settings.
          }

          Drupal.Ajax.prototype.beforeSubmitCVOriginal = Drupal.Ajax.prototype.beforeSubmit;
          Drupal.Ajax.prototype.beforeSubmit = function (form_values, element_settings, options) {
            if (typeof this.$form !== 'undefined' && (validateAll === 1 || $(this.element).hasClass('cv-validate-before-ajax')) && $(this.element).attr("formnovalidate") == undefined) {
              $(this.$form).removeClass('ajax-submit-prevented');

              $(this.$form).validate();
              if (!($(this.$form).valid())) {
                this.ajaxing = false;
                $(this.$form).addClass('ajax-submit-prevented');
                return false;
              }
            }

            return this.beforeSubmitCVOriginal.apply(this, arguments);
          };
        }
      }

      // Allow all modules to update the validate options.
      // Example of how to do this is shown below.
      $(document).trigger('cv-jquery-validate-options-update', drupalSettings.cvJqueryValidateOptions);

      // Process for all the forms on the page everytime,
      // we already use once so we should be good.
      once('cvJqueryValidate', 'body form').forEach(function(element) {
        $(element).validate(drupalSettings.cvJqueryValidateOptions);
      });
    }
  };
})(jQuery, Drupal, once, drupalSettings);
;
/**
 * @file
 * Attaches behaviors for the Clientside Validation jQuery module.
 */
(function ($, Drupal, debounce, CKEDITOR) {
  /**
   * Attaches jQuery validate behavoir to forms.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *  Attaches the outline behavior to the right context.
   */
  Drupal.behaviors.cvJqueryValidateCKEditor = {
    attach: function (context) {
      if (typeof CKEDITOR === 'undefined') {
        return;
      }
      var ignore = ':hidden';
      var not = [];
      for (var instance in CKEDITOR.instances) {
        if (CKEDITOR.instances.hasOwnProperty(instance)) {
          not.push('#' + instance);
        }
      }
      ignore += not.length ? ':not(' + not.join(', ') + ')' : '';
      $('form').each(function () {
        var validator = $(this).data('validator');
        if (!validator) {
          return;
        }
        validator.settings.ignore = ignore;
        validator.settings.errorPlacement = function(place, $element) {
          var id = $element.attr('id');
          var afterElement = $element[0];
          if (CKEDITOR.instances.hasOwnProperty(id)) {
            afterElement = CKEDITOR.instances[id].container.$;
          }
          place.insertAfter(afterElement);
        };
      });
      var updateText = function (instance) {
        return debounce(function (e) {
          instance.updateElement();
          var event = $.extend(true, {}, e.data.$);
          delete event.target;
          delete event.explicitOriginalTarget;
          delete event.originalTarget;
          delete event.currentTarget;
          $(instance.element.$).trigger(new $.Event(e.name, event));
        }, 250);
      };
      CKEDITOR.on('instanceReady', function () {
        for (var instance in CKEDITOR.instances) {
          if (CKEDITOR.instances.hasOwnProperty(instance)) {
            CKEDITOR.instances[instance].document.on("keyup", updateText(CKEDITOR.instances[instance]));
            CKEDITOR.instances[instance].document.on("paste", updateText(CKEDITOR.instances[instance]));
            CKEDITOR.instances[instance].document.on("keypress", updateText(CKEDITOR.instances[instance]));
            CKEDITOR.instances[instance].document.on("blur", updateText(CKEDITOR.instances[instance]));
            CKEDITOR.instances[instance].document.on("change", updateText(CKEDITOR.instances[instance]));
          }
        }
      });
    }
  };
})(jQuery, Drupal, Drupal.debounce, (typeof CKEDITOR === 'undefined') ? undefined : CKEDITOR);
;
/**
 * @file
 * Attaches behaviors for the Clientside Validation jQuery module.
 */
(function ($, once) {
  // Override clientside validation jquery validation options.
  // We do this to display the error markup same as in inline_form_errors.
  // Using once can not use `window` or `document` directly.
  if (!once('cvjquery', 'html').length) {
    // Early return avoid changing the indentation
    // for the rest of the code.
    return;
  }

  $(document).on('cv-jquery-validate-options-update', function (event, options) {
    options.errorElement = 'strong';
    options.showErrors = function(errorMap, errorList) {
      // First remove all errors.
      for (var i in errorList) {
        $(errorList[i].element).parent().find('.form-item--error-message').remove();
      }

      // Show errors using defaultShowErrors().
      this.defaultShowErrors();

      // Wrap all errors with div.form-item--error-message.
      $(this.currentForm).find('strong.error').each(function () {
        if (!$(this).parent().hasClass('form-item--error-message')) {
          $(this).wrap('<div class="form-item--error-message" role="alert"/>');
        }
      });
    };
  });
})(jQuery, once);
;
/**
 * @file
 * JavaScript behaviors for element #states.
 */

(function ($, Drupal, drupalSettings, once) {

  'use strict';

  /**
   * Element #states builder.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.webformElementStates = {
    attach: function (context) {
      $(once('webform-element-states-condition', '.webform-states-table--condition', context)).each(function () {
        var $condition = $(this);
        var $selector = $condition.find('.webform-states-table--selector select');
        var $value = $condition.find('.webform-states-table--value input');
        var $trigger = $condition.find('.webform-states-table--trigger select');

        // Initialize autocompletion.
        $value.autocomplete({minLength: 0}).on('focus', function () {
          $value.autocomplete('search', '');
        });

        // Initialize trigger and selector.
        $trigger.on('change', function () {$selector.trigger('change');});

        $selector.on('change', function () {
          var selector = $selector.val();
          var sourceKey = drupalSettings.webformElementStates.selectors[selector];
          var source = drupalSettings.webformElementStates.sources[sourceKey];
          var notPattern = ($trigger.val().indexOf('pattern') === -1);
          if (source && notPattern) {
            // Enable autocompletion.
            $value
              .autocomplete('option', 'source', source)
              .addClass('form-autocomplete');
          }
          else {
            // Disable autocompletion.
            $value
              .autocomplete('option', 'source', [])
              .removeClass('form-autocomplete');
          }
          // Always disable browser auto completion.
          $value.attr('autocomplete', 'off');
        }).trigger('change');
      });

      // If the states:state is required or optional the required checkbox
      // should be checked and disabled.
      var $state = $(context).find('.webform-states-table--state select');
      if ($state.length) {
        $(once('webform-element-states-state', $state))
          .on('change', toggleRequiredCheckbox);
        toggleRequiredCheckbox();
      }
    }
  };

  /**
   * Track required checked state.
   *
   * @type {null|boolean}
   */
  var requiredChecked = null;

  /**
   * Toggle the required checkbox when states:state is required or optional.
   */
  function toggleRequiredCheckbox() {
    var $input = $('input[name="properties[required]"]');
    if (!$input.length) {
      return;
    }

    // Determine if any states:state is required or optional.
    var required = false;
    $('.webform-states-table--state select').each(function () {
      var value = $(this).val();
      if (value === 'required' || value === 'optional') {
        required = true;
      }
    });

    if (required) {
      requiredChecked = $input.prop('checked');
      $input.attr('disabled', true);
      $input.prop('checked', true);
    }
    else {
      $input.attr('disabled', false);
      if (requiredChecked !== null) {
        $input.prop('checked', requiredChecked);
        requiredChecked = null;
      }
    }
    $input.trigger('change');
  }

})(jQuery, Drupal, drupalSettings, once);
;
/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/
(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.machineName = {
    attach: function attach(context, settings) {
      var self = this;
      var $context = $(context);
      var timeout = null;
      var xhr = null;
      function clickEditHandler(e) {
        var data = e.data;
        data.$wrapper.removeClass('visually-hidden');
        data.$target.trigger('focus');
        data.$suffix.hide();
        data.$source.off('.machineName');
      }
      function machineNameHandler(e) {
        var data = e.data;
        var options = data.options;
        var baseValue = e.target.value;
        var rx = new RegExp(options.replace_pattern, 'g');
        var expected = baseValue.toLowerCase().replace(rx, options.replace).substr(0, options.maxlength);
        if (xhr && xhr.readystate !== 4) {
          xhr.abort();
          xhr = null;
        }
        if (timeout) {
          clearTimeout(timeout);
          timeout = null;
        }
        if (baseValue.toLowerCase() !== expected) {
          timeout = setTimeout(function () {
            xhr = self.transliterate(baseValue, options).done(function (machine) {
              self.showMachineName(machine.substr(0, options.maxlength), data);
            });
          }, 300);
        } else {
          self.showMachineName(expected, data);
        }
      }
      Object.keys(settings.machineName).forEach(function (sourceId) {
        var options = settings.machineName[sourceId];
        var $source = $(once('machine-name', $context.find(sourceId).addClass('machine-name-source')));
        var $target = $context.find(options.target).addClass('machine-name-target');
        var $suffix = $context.find(options.suffix);
        var $wrapper = $target.closest('.js-form-item');
        if (!$source.length || !$target.length || !$suffix.length || !$wrapper.length) {
          return;
        }
        if ($target.hasClass('error')) {
          return;
        }
        options.maxlength = $target.attr('maxlength');
        $wrapper.addClass('visually-hidden');
        var machine = $target[0].value;
        var $preview = $("<span class=\"machine-name-value\">".concat(options.field_prefix).concat(Drupal.checkPlain(machine)).concat(options.field_suffix, "</span>"));
        $suffix.empty();
        if (options.label) {
          $suffix.append("<span class=\"machine-name-label\">".concat(options.label, ": </span>"));
        }
        $suffix.append($preview);
        if ($target.is(':disabled')) {
          return;
        }
        var eventData = {
          $source: $source,
          $target: $target,
          $suffix: $suffix,
          $wrapper: $wrapper,
          $preview: $preview,
          options: options
        };
        if (machine === '' && $source[0].value !== '') {
          self.transliterate($source[0].value, options).done(function (machineName) {
            self.showMachineName(machineName.substr(0, options.maxlength), eventData);
          });
        }
        var $link = $("<span class=\"admin-link\"><button type=\"button\" class=\"link\">".concat(Drupal.t('Edit'), "</button></span>")).on('click', eventData, clickEditHandler);
        $suffix.append($link);
        if ($target[0].value === '') {
          $source.on('formUpdated.machineName', eventData, machineNameHandler).trigger('formUpdated.machineName');
        }
        $target.on('invalid', eventData, clickEditHandler);
      });
    },
    showMachineName: function showMachineName(machine, data) {
      var settings = data.options;
      if (machine !== '') {
        if (machine !== settings.replace) {
          data.$target[0].value = machine;
          data.$preview.html(settings.field_prefix + Drupal.checkPlain(machine) + settings.field_suffix);
        }
        data.$suffix.show();
      } else {
        data.$suffix.hide();
        data.$target[0].value = machine;
        data.$preview.empty();
      }
    },
    transliterate: function transliterate(source, settings) {
      return $.get(Drupal.url('machine_name/transliterate'), {
        text: source,
        langcode: drupalSettings.langcode,
        replace_pattern: settings.replace_pattern,
        replace_token: settings.replace_token,
        replace: settings.replace,
        lowercase: true
      });
    }
  };
})(jQuery, Drupal, drupalSettings);;
