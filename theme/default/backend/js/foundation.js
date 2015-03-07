;(function ($, window, undefined) {
    'use strict';

    $.fn.foundationMediaQueryViewer = function (options) {
        var settings = $.extend(options,{toggleKey:77}), // Press 'M'
            $doc = $(document);

        $doc.on("keyup.mediaQueryViewer", ":input", function (e){
            if (e.which === settings.toggleKey) {
                e.stopPropagation();
            }
        });
        $doc.on("keyup.mediaQueryViewer", function (e) {
            var $mqViewer = $('#fqv');

            if (e.which === settings.toggleKey) {
                if ($mqViewer.length > 0) {
                    $mqViewer.remove();
                } else {
                    $('body').prepend('<div id="fqv" style="position:fixed;top:4px;left:4px;z-index:999;color:#fff;"><p style="font-size:12px;background:rgba(0,0,0,0.75);padding:5px;margin-bottom:1px;line-height:1.2;"><span class="left">Media:</span> <span style="font-weight:bold;" class="show-for-xlarge">Extra Large</span><span style="font-weight:bold;" class="show-for-large">Large</span><span style="font-weight:bold;" class="show-for-medium">Medium</span><span style="font-weight:bold;" class="show-for-small">Small</span><span style="font-weight:bold;" class="show-for-landscape">Landscape</span><span style="font-weight:bold;" class="show-for-portrait">Portrait</span><span style="font-weight:bold;" class="show-for-touch">Touch</span></p></div>');
                }
            }
        });

    };

})(jQuery, this);

;(function ($, window, undefined) {
    'use strict';

    $.fn.foundationNavigation = function (options) {

        var lockNavBar = false;
        // Windows Phone, sadly, does not register touch events :(
        if (Modernizr.touch || navigator.userAgent.match(/Windows Phone/i)) {
            $(document).on('click.fndtn touchstart.fndtn', '.nav-bar a.flyout-toggle', function (e) {
                e.preventDefault();
                var flyout = $(this).siblings('.flyout').first();
                if (lockNavBar === false) {
                    $('.nav-bar .flyout').not(flyout).slideUp(500);
                    flyout.slideToggle(500, function () {
                        lockNavBar = false;
                    });
                }
                lockNavBar = true;
            });
            $('.nav-bar>li.has-flyout', this).addClass('is-touch');
        } else {
            $('.nav-bar>li.has-flyout', this).on('mouseenter mouseleave', function (e) {
                if (e.type == 'mouseenter') {
                    $('.nav-bar').find('.flyout').hide();
                    $(this).children('.flyout').show();
                }

                if (e.type == 'mouseleave') {
                    var flyout = $(this).children('.flyout'),
                        inputs = flyout.find('input'),
                        hasFocus = function (inputs) {
                            var focus;
                            if (inputs.length > 0) {
                                inputs.each(function () {
                                    if ($(this).is(":focus")) {
                                        focus = true;
                                    }
                                });
                                return focus;
                            }

                            return false;
                        };

                    if (!hasFocus(inputs)) {
                        $(this).children('.flyout').hide();
                    }
                }

            });
        }

    };

})(jQuery, this);


(function( $ ){

	/**
	 * Helper object used to quickly adjust all hidden parent element's, display and visibility properties.
	 * This is currently used for the custom drop downs. When the dropdowns are contained within a reveal modal
	 * we cannot accurately determine the list-item elements width property, since the modal's display property is set
	 * to 'none'.
	 *
	 * This object will help us work around that problem.
	 *
	 * NOTE: This could also be plugin.
	 *
	 * @function hiddenFix
	 */
	var hiddenFix = function() {

		return {
			/**
			 * Sets all hidden parent elements and self to visibile.
			 *
			 * @method adjust
			 * @param {jQuery Object} $child
			 */

			// We'll use this to temporarily store style properties.
			tmp : [],

			// We'll use this to set hidden parent elements.
			hidden : null,

			adjust : function( $child ) {
				// Internal reference.
				var _self = this;

				// Set all hidden parent elements, including this element.
				_self.hidden = $child.parents().andSelf().filter( ":hidden" );

				// Loop through all hidden elements.
				_self.hidden.each( function() {

					// Cache the element.
					var $elem = $( this );

					// Store the style attribute.
					// Undefined if element doesn't have a style attribute.
					_self.tmp.push( $elem.attr( 'style' ) );

					// Set the element's display property to block,
					// but ensure it's visibility is hidden.
					$elem.css( { 'visibility' : 'hidden', 'display' : 'block' } );
				});

			}, // end adjust

			/**
			 * Resets the elements previous state.
			 *
			 * @method reset
			 */
			reset : function() {
				// Internal reference.
				var _self = this;
				// Loop through our hidden element collection.
				_self.hidden.each( function( i ) {
					// Cache this element.
					var $elem = $( this ),
						_tmp = _self.tmp[ i ]; // Get the stored 'style' value for this element.

					// If the stored value is undefined.
					if( _tmp === undefined )
					// Remove the style attribute.
						$elem.removeAttr( 'style' );
					else
					// Otherwise, reset the element style attribute.
						$elem.attr( 'style', _tmp );

				});
				// Reset the tmp array.
				_self.tmp = [];
				// Reset the hidden elements variable.
				_self.hidden = null;

			} // end reset

		}; // end return

	};

	jQuery.foundation = jQuery.foundation || {};
	jQuery.foundation.customForms = jQuery.foundation.customForms || {};

	$.foundation.customForms.appendCustomMarkup = function ( options ) {

		var defaults = {
			disable_class: "js-disable-custom"
		};

		options = $.extend( defaults, options );

		function appendCustomMarkup(idx, sel) {
			var $this = $(sel).hide(),
				type  = $this.attr('type'),
				$span = $this.next('span.custom.' + type);

			if ($span.length === 0) {
				$span = $('<span class="custom ' + type + '"></span>').insertAfter($this);
			}

			$span.toggleClass('checked', $this.is(':checked'));
			$span.toggleClass('disabled', $this.is(':disabled'));
		}

		function appendCustomSelect(idx, sel) {
			var hiddenFixObj = hiddenFix();
			//
			// jQueryify the <select> element and cache it.
			//
			var $this = $( sel ),
			//
			// Find the custom drop down element.
			//
				$customSelect = $this.next( 'div.custom.dropdown' ),
			//
			// Find the custom select element within the custom drop down.
			//
				$customList = $customSelect.find( 'ul' ),
			//
			// Find the custom a.current element.
			//
				$selectCurrent = $customSelect.find( ".current" ),
			//
			// Find the custom a.selector element (the drop-down icon).
			//
				$selector = $customSelect.find( ".selector" ),
			//
			// Get the <options> from the <select> element.
			//
				$options = $this.find( 'option' ),
			//
			// Filter down the selected options
			//
				$selectedOption = $options.filter( ':selected' ),
			//
			// Initial max width.
			//
				maxWidth = 0,
			//
			// We'll use this variable to create the <li> elements for our custom select.
			//
				liHtml = '',
			//
			// We'll use this to cache the created <li> elements within our custom select.
			//
				$listItems
				;
			var $currentSelect = false;
			//
			// Should we not create a custom list?
			//
			if ( $this.hasClass( 'no-custom' ) ) return;

			//
			// Did we not create a custom select element yet?
			//
			if ( $customSelect.length === 0 ) {
				//
				// Let's create our custom select element!
				//

				//
				// Determine what select size to use.
				//
				var customSelectSize = $this.hasClass( 'small' )   ? 'small'   :
						$this.hasClass( 'medium' )  ? 'medium'  :
							$this.hasClass( 'large' )   ? 'large'   :
								$this.hasClass( 'expand' )  ? 'expand'  : ''
					;
				//
				// Build our custom list.
				//
				$customSelect = $('<div class="' + ['custom', 'dropdown', customSelectSize ].join( ' ' ) + '"><a href="#" class="selector"></a><ul /></div>"');
				//
				// Grab the selector element
				//
				$selector = $customSelect.find( ".selector" );
				//
				// Grab the unordered list element from the custom list.
				//
				$customList = $customSelect.find( "ul" );
				//
				// Build our <li> elements.
				//
				liHtml = $options.map( function() { return "<li>" + $( this ).html() + "</li>"; } ).get().join( '' );
				//
				// Append our <li> elements to the custom list (<ul>).
				//
				$customList.append( liHtml );
				//
				// Insert the the currently selected list item before all other elements.
				// Then, find the element and assign it to $currentSelect.
				//

				$currentSelect = $customSelect.prepend( '<a href="#" class="current">' + $selectedOption.html() + '</a>' ).find( ".current" );
				//
				// Add the custom select element after the <select> element.
				//
				$this.after( $customSelect )
					//
					//then hide the <select> element.
					//
					.hide();

			} else {
				//
				// Create our list item <li> elements.
				//
				liHtml = $options.map( function() { return "<li>" + $( this ).html() + "</li>"; } ).get().join( '' );
				//
				// Refresh the ul with options from the select in case the supplied markup doesn't match.
				// Clear what's currently in the <ul> element.
				//
				$customList.html( '' )
					//
					// Populate the list item <li> elements.
					//
					.append( liHtml );

			} // endif $customSelect.length === 0

			//
			// Determine whether or not the custom select element should be disabled.
			//
			$customSelect.toggleClass( 'disabled', $this.is( ':disabled' ) );
			//
			// Cache our List item elements.
			//
			$listItems = $customList.find( 'li' );

			//
			// Determine which elements to select in our custom list.
			//
			$options.each( function ( index ) {

				if ( this.selected ) {
					//
					// Add the selected class to the current li element
					//
					$listItems.eq( index ).addClass( 'selected' );
					//
					// Update the current element with the option value.
					//
					if ($currentSelect) {
						$currentSelect.html( $( this ).html() );
					}

				}

			});

			//
			// Update the custom <ul> list width property.
			//
			$customList.css( 'width', 'inherit' );
			//
			// Set the custom select width property.
			//
			$customSelect.css( 'width', 'inherit' );

			//
			// If we're not specifying a predetermined form size.
			//
			if ( !$customSelect.is( '.small, .medium, .large, .expand' ) ) {

				// ------------------------------------------------------------------------------------
				// This is a work-around for when elements are contained within hidden parents.
				// For example, when custom-form elements are inside of a hidden reveal modal.
				//
				// We need to display the current custom list element as well as hidden parent elements
				// in order to properly calculate the list item element's width property.
				// -------------------------------------------------------------------------------------

				//
				// Show the drop down.
				// This should ensure that the list item's width values are properly calculated.
				//
				$customSelect.addClass( 'open' );
				//
				// Quickly, display all parent elements.
				// This should help us calcualate the width of the list item's within the drop down.
				//
				hiddenFixObj.adjust( $customList );
				//
				// Grab the largest list item width.
				//
				maxWidth = ( $listItems.outerWidth() > maxWidth ) ? $listItems.outerWidth() : maxWidth;
				//
				// Okay, now reset the parent elements.
				// This will hide them again.
				//
				hiddenFixObj.reset();
				//
				// Finally, hide the drop down.
				//
				$customSelect.removeClass( 'open' );
				//
				// Set the custom list width.
				//
				$customSelect.width( maxWidth + 18);
				//
				// Set the custom list element (<ul />) width.
				//
				$customList.width(  maxWidth + 16 );

			} // endif

		}

		$('form.custom input:radio[data-customforms!=disabled]').each(appendCustomMarkup);
		$('form.custom input:checkbox[data-customforms!=disabled]').each(appendCustomMarkup);
		$('form.custom select[data-customforms!=disabled]').each(appendCustomSelect);
	};

	var refreshCustomSelect = function($select) {
		var maxWidth = 0,
			$customSelect = $select.next();
		$options = $select.find('option');
		$customSelect.find('ul').html('');

		$options.each(function () {
			$li = $('<li>' + $(this).html() + '</li>');
			$customSelect.find('ul').append($li);
		});

		// re-populate
		$options.each(function (index) {
			if (this.selected) {
				$customSelect.find('li').eq(index).addClass('selected');
				$customSelect.find('.current').html($(this).html());
			}
		});

		// fix width
		$customSelect.removeAttr('style')
			.find('ul').removeAttr('style');
		$customSelect.find('li').each(function () {
			$customSelect.addClass('open');
			if ($(this).outerWidth() > maxWidth) {
				maxWidth = $(this).outerWidth();
			}
			$customSelect.removeClass('open');
		});
		$customSelect.css('width', maxWidth + 18 + 'px');
		$customSelect.find('ul').css('width', maxWidth + 16 + 'px');

	};

	var toggleCheckbox = function($element) {
		var $input = $element.prev(),
			input = $input[0];

		if (false === $input.is(':disabled')) {
			input.checked = ((input.checked) ? false : true);
			$element.toggleClass('checked');

			$input.trigger('change');
		}
	};

	var toggleRadio = function($element) {
		var $input = $element.prev(),
			$form = $input.closest('form.custom'),
			input = $input[0];

		if (false === $input.is(':disabled')) {
			$form.find('input:radio[name="' + $input.attr('name') + '"]').next().not($element).removeClass('checked');
			if ( !$element.hasClass('checked') ) {
				$element.toggleClass('checked');
			}
			input.checked = $element.hasClass('checked');

			$input.trigger('change');
		}
	};

	$(document).on('click', 'form.custom span.custom.checkbox', function (event) {
		event.preventDefault();
		event.stopPropagation();

		toggleCheckbox($(this));
	});

	$(document).on('click', 'form.custom span.custom.radio', function (event) {
		event.preventDefault();
		event.stopPropagation();

		toggleRadio($(this));
	});

	$(document).on('change', 'form.custom select[data-customforms!=disabled]', function (event) {
		refreshCustomSelect($(this));
	});

	$(document).on('click', 'form.custom label', function (event) {
		var $associatedElement = $('#' + $(this).attr('for') + '[data-customforms!=disabled]'),
			$customCheckbox,
			$customRadio;
		if ($associatedElement.length !== 0) {
			if ($associatedElement.attr('type') === 'checkbox') {
				event.preventDefault();
				$customCheckbox = $(this).find('span.custom.checkbox');
				toggleCheckbox($customCheckbox);
			} else if ($associatedElement.attr('type') === 'radio') {
				event.preventDefault();
				$customRadio = $(this).find('span.custom.radio');
				toggleRadio($customRadio);
			}
		}
	});

	$(document).on('click', 'form.custom div.custom.dropdown a.current, form.custom div.custom.dropdown a.selector', function (event) {
		var $this = $(this),
			$dropdown = $this.closest('div.custom.dropdown'),
			$select = $dropdown.prev();

		event.preventDefault();
		$('div.dropdown').removeClass('open');

		if (false === $select.is(':disabled')) {
			$dropdown.toggleClass('open');

			if ($dropdown.hasClass('open')) {
				$(document).bind('click.customdropdown', function (event) {
					$dropdown.removeClass('open');
					$(document).unbind('.customdropdown');
				});
			} else {
				$(document).unbind('.customdropdown');
			}
			return false;
		}
	});

	$(document).on('click', 'form.custom div.custom.dropdown li', function (event) {
		var $this = $(this),
			$customDropdown = $this.closest('div.custom.dropdown'),
			$select = $customDropdown.prev(),
			selectedIndex = 0;

		event.preventDefault();
		event.stopPropagation();
		$('div.dropdown').removeClass('open');

		$this
			.closest('ul')
			.find('li')
			.removeClass('selected');
		$this.addClass('selected');

		$customDropdown
			.removeClass('open')
			.find('a.current')
			.html($this.html());

		$this.closest('ul').find('li').each(function (index) {
			if ($this[0] == this) {
				selectedIndex = index;
			}

		});
		$select[0].selectedIndex = selectedIndex;

		$select.trigger('change');
	});


	$.fn.foundationCustomForms = $.foundation.customForms.appendCustomMarkup;

})( jQuery );



;(function ($, window, undefined) {
    'use strict';

    var settings = {
            index : 0,
            initialized : false
        },

        methods = {
            init : function (options) {
                return this.each(function () {
                    settings = $.extend(settings, options);
                    settings.$w = $(window),
                        settings.$topbar = $('div.top-bar'),
                        settings.$section = settings.$topbar.find('div.section'),
                        settings.$titlebar = settings.$topbar.children('ul:first');

                    var breakpoint = $("<div class='top-bar-js-breakpoint'/>").appendTo("body");
                    settings.breakPoint = breakpoint.width();
                    breakpoint.remove();

                    if (!settings.initialized) {
                        methods.assemble();
                        settings.initialized = true;
                    }

                    if (!settings.height) {
                        methods.largestUL();
                    }

                    if (settings.$topbar.parent().hasClass('fixed')) {
                        $('body').css('padding-top',settings.$topbar.outerHeight())
                    }

                    $('.top-bar .toggle-topbar').die('click.fndtn').live('click.fndtn', function (e) {
                        e.preventDefault();

                        if (methods.breakpoint()) {
                            settings.$topbar.toggleClass('expanded');
                            settings.$topbar.css('min-height', '');
                        }

                        if (!settings.$topbar.hasClass('expanded')) {
                            settings.$section.css({left: '0%'});
                            settings.$section.find('>.name').css({left: '100%'});
                            settings.$section.find('li.moved').removeClass('moved');
                            settings.index = 0;
                        }
                    });

                    // Show the Dropdown Levels on Click
                    $('.top-bar .has-dropdown>a').die('click.fndtn').live('click.fndtn', function (e) {
                        if (Modernizr.touch || methods.breakpoint())
                            e.preventDefault();

                        if (methods.breakpoint()) {
                            var $this = $(this),
                                $selectedLi = $this.closest('li');

                            settings.index += 1;
                            $selectedLi.addClass('moved');
                            settings.$section.css({left: -(100 * settings.index) + '%'});
                            settings.$section.find('>.name').css({left: 100 * settings.index + '%'});

                            $this.siblings('ul').height(settings.height + settings.$titlebar.outerHeight(true));
                            settings.$topbar.css('min-height', settings.height + settings.$titlebar.outerHeight(true) * 2)
                        }
                    });

                    $(window).on('resize.fndtn.topbar',function() {
                        if (!methods.breakpoint()) {
                            settings.$topbar.css('min-height', '');
                        }
                    });

                    // Go up a level on Click
                    $('.top-bar .has-dropdown .back').die('click.fndtn').live('click.fndtn', function (e) {
                        e.preventDefault();

                        var $this = $(this),
                            $movedLi = $this.closest('li.moved'),
                            $previousLevelUl = $movedLi.parent();

                        settings.index -= 1;
                        settings.$section.css({left: -(100 * settings.index) + '%'});
                        settings.$section.find('>.name').css({'left': 100 * settings.index + '%'});

                        if (settings.index === 0) {
                            settings.$topbar.css('min-height', 0);
                        }

                        setTimeout(function () {
                            $movedLi.removeClass('moved');
                        }, 300);
                    });
                });
            },

            breakpoint : function () {
                return settings.$w.width() < settings.breakPoint;
            },

            assemble : function () {
                // Pull element out of the DOM for manipulation
                settings.$section.detach();

                settings.$section.find('.has-dropdown>a').each(function () {
                    var $link = $(this),
                        $dropdown = $link.siblings('.dropdown'),
                        $titleLi = $('<li class="title back js-generated"><h5><a href="#"></a></h5></li>');

                    // Copy link to subnav
                    $titleLi.find('h5>a').html($link.html());
                    $dropdown.prepend($titleLi);
                });

                // Put element back in the DOM
                settings.$section.appendTo(settings.$topbar);
            },

            largestUL : function () {
                var uls = settings.$topbar.find('section ul ul'),
                    largest = uls.first(),
                    total = 0;

                uls.each(function () {
                    if ($(this).children('li').length > largest.children('li').length) {
                        largest = $(this);
                    }
                });

                largest.children('li').each(function () { total += $(this).outerHeight(true); });

                settings.height = total;
            }
        };

    $.fn.foundationTopBar = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' +  method + ' does not exist on jQuery.foundationTopBar');
        }
    };

}(jQuery, this));


;(function ($, window, document, undefined) {
	'use strict';

	var settings = {
			callback: $.noop,
			init: false
		},

		methods = {
			init : function (options) {
				settings = $.extend({}, options, settings);

				return this.each(function () {
					if (!settings.init) methods.events();
				});
			},

			events : function () {
				$(document).on('click.fndtn', '.tabs a', function (e) {
					methods.set_tab($(this).parent('dd, li'), e);
				});

				settings.init = true;
			},

			set_tab : function ($tab, e) {
				var $activeTab = $tab.closest('dl, ul').find('.active'),
					target = $tab.children('a').attr("href"),
					hasHash = /^#/.test(target),
					$content = $(target + 'Tab');

				if (hasHash && $content.length > 0) {
					// Show tab content
					e.preventDefault();
					$content.closest('.tabs-content').children('li').removeClass('active').hide();
					$content.css('display', 'block').addClass('active');
				}

				// Make active tab
				$activeTab.removeClass('active');
				$tab.addClass('active');

				settings.callback();
			}
		}

	$.fn.foundationTabs = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.foundationTabs');
		}
	};
}(jQuery, this, this.document));
