; (function ($, window, undefined) {
    'use strict';

    $.fn.betterDropdown = function (options) {
        var settings = $.extend({}, $.fn.betterDropdown.defaults, options);
        if (settings.destroy) {
            destoryDropdown(this);
        } else {
            buildDropdown(this);
        }

        /**
        * Replace a native select element with a custom, searchable, keyboard-navigable dropdown and keep the original select synchronized.
        * @example
        * buildDropdown($('#mySelect'))
        * undefined
        * @param {{jQuery}} {{originalDropdown}} - jQuery-wrapped select element to be replaced by the enhanced dropdown.
        * @returns {{void}} Returns nothing; the function mutates the DOM and binds event handlers to create the custom dropdown.
        **/
        function buildDropdown(originalDropdown) {
            var itemName = settings.itemName;
            var id = originalDropdown[0].id;
            originalDropdown.hide();
            var parentContainer = originalDropdown.parent();
            //var className = itemName
            //    .toLowerCase()
            //    .replace(/\s/g, '-');

            // generate a random-ish identifier
            var className = Math.floor((Math.random() * 26) + Date.now());

            // if a better dropdown already exists for this item, remove it
            //$('.' + className + '-dropdown-box-wrapper').remove();
            //$('.' + className + '-filter-wrapper').remove();

            var $dropdownBox =
                $('<div class="' + className + '-dropdown-box-wrapper dropdown-box-wrapper ' + id + '">\
                        <span class="' + className + '-dropdown-box-text dropdown-box-text">-Select ' + itemName + '-</span>\
                    </div>');

            var $downArrow = $('<div class="down-arrow ' + className + '-dropdown-icon dropdown-icon"></div>');

            $downArrow.appendTo($dropdownBox);

            $dropdownBox
                .appendTo(parentContainer)
                .click(function () {
                    toggleDropdown();
                });

            var $filterWrapper = $('<div class="' + className + '-filter-wrapper filter-wrapper"></div>');

            var $filterBox = $('<input type="text" placeholder="Search ' + itemName + 's..." class="' + className + '-filter-box filter-box"/>');
            $filterBox.appendTo($filterWrapper);

            var $filterResultsWrapper = $('<div class="' + className + '-filter-results-wrapper filter-results-wrapper"></div>');

            $.each($('#' + id).children(), function (i, option) {

                var $resultTextContainer = $('<span></span>');
                var $resultFirstText = $('<span>' + option.text + '</span>');
                //var $line = $('<hr style = \"margin: 0; height: 1.25px;\">');
                $resultFirstText.addClass('first-text');

                $resultTextContainer.append($resultFirstText);

                if (settings.displayTextBelow) {
                    var displayBelowText = $(option).data('display-below-text');
                    var $lineBreak = $('</br>');
                    var $resultLastText = $('<span style = \"color: lightgray\"> </span');

                    $resultLastText.text(displayBelowText);

                    $resultTextContainer
                        .append($lineBreak)
                        .append($resultLastText);
                }

                //$resultTextContainer.append($line);

                if (option.value !== '') {
                    var $filterResult = $('<div class="' + className + '-result result"></div>');
                    $filterResult
                        .data('value', option.value)
                        //.data('below-text', displayBelowText)
                        .data('filter-value', option.value.toUpperCase())
                        .data('filter-text', option.text.toUpperCase())
                        .appendTo($filterResultsWrapper)
                        .click(function () {
                            selectItem($filterResult);
                        })
                        .mouseover(function () {
                            hoverItem($filterResult);
                        })
                        .append($resultTextContainer);

                    if ($(option).data('displayBelowText')) {
                        $filterResult.data('filter-below-text', $(option).data('displayBelowText').toUpperCase());
                    }
                }
            });

            $filterResultsWrapper.appendTo($filterWrapper);
            $filterWrapper.appendTo(parentContainer);

            resizeDropdown();

            $('.' + className + '-filter-box').keyup(function (e) {

                // only filter the items if the key pressed isn't enter, up, down, left, or right arrow
                if (e.keyCode !== 13 &&
                    e.keyCode !== 37 &&
                    e.keyCode !== 38 &&
                    e.keyCode !== 39 &&
                    e.keyCode !== 40) {
                    filterItems($('.' + className + '-filter-box').val().toUpperCase());
                }
            });

            $('.' + className + '-filter-wrapper').keydown(function (e) {
                arrowKeyNavigate(e);
                $filterBox[0].selectionStart = $filterBox.val().length;
            });

            // if something was selected in the old dropdown, select it in the new one too
            if ($('#' + id).val() && $('#' + id).val() !== '') {
                selectItem($('.' + className + '-result').filter(function () {
                    return $(originalDropdown).data().value === $('#' + id).val();
                }));
            }

            $(window).resize(function () {
                resizeDropdown();
            });

            /**
            * Selects a given dropdown item in the custom BetterDropdown UI, updates the visible label, syncs the original <select> element, clears any filter, and closes the dropdown.
            * @example
            * selectItem($('#myDropdownItem'))
            * undefined
            * @param {{jQuery}} {{$item}} - The jQuery element representing the dropdown item to select.
            * @returns {{void}} No value is returned; the function updates DOM state and triggers events.
            **/
            function selectItem($item) {
                $item.parent().children().removeClass('selected');
                $item.addClass('selected');
                hoverItem($item);

                $('.' + className + '-dropdown-box-text').text($item.children().first().children().first().text());

                // select the item in the original dropdown too
                $('#' + id + ' option[value="' + $item.data().value + '"]').prop("selected", true);
                $('#' + id).trigger("change");

                $('.' + className + '-filter-box').val('');
                $('.' + className + '-filter-box').keyup();

                closeDropdown();
            }

            function hoverItem($item) {
                $item.parent().children().removeClass('hovered');
                $item.addClass('hovered');
            }

            /**
            * Filters dropdown items by the given text, hiding non-matching items and showing a "no results" message when none match.
            * @example
            * filterItems('searchTerm')
            * undefined
            * @param {{string}} {{filterText}} - Text to filter the dropdown items by.
            * @returns {{void}} No return value.
            **/
            function filterItems(filterText) {
                // hide 'no items found' message
                $('.' + className + '-no-result-message').remove();

                var t0 = performance.now();

                // hide all items that don't contain filterText
                $.each($('.' + className + '-filter-results-wrapper').children(), function (i, option) {
                    var $option = $(option);

                    //don't change, css performs better than show/hide and addClass/removeClass
                    $option.css({ 'display': 'block' });

                    //https://www.learningjquery.com/2010/05/now-you-see-me-showhide-performance
                    var inDisplayName = $option.data('filter-text').indexOf(filterText) !== -1;
                    var inValue = $option.data('filter-value').indexOf(filterText) !== 1;

                    var inBelowText = false;

                    if ($(option).data('displayBelowText') &&
                        $(option).data('displayBelowText').indexOf(filterText !== -1)) {
                        inBelowText = true;
                    }

                    //if (!inDisplayName && !inValue) {
                    //    $option.hide();
                    //}

                    if (!inDisplayName && !inBelowText) {
                        $option.css({ 'display': 'none' });
                    }
                });

                var t1 = performance.now();
                console.log("first loop took " + (t1 - t0) + " milliseconds.");

                // if no items match the filter text, show message
                if ($('.' + className + '-filter-results-wrapper').children().filter(':visible').length === 0) {
                    var $itemNotFoundMessageContainer = $('<div class="' + className + '-no-result-message"></div>');

                    $('<i></i>')
                        .text('No ' + itemName.toLowerCase() + 's found.')
                        .appendTo($itemNotFoundMessageContainer.appendTo($filterResultsWrapper));
                }
            }

            /**
            * Toggle the filter dropdown for the current BetterDropdown instance: open it (closing other dropdowns), focus and scroll to the selected result, re-highlight the selected item and flip the arrow, or close it if already open.
            * @example
            * toggleDropdown()
            * undefined
            * @returns {void} No return value.
            **/
            function toggleDropdown() {
                var $filterWrapper = $('.' + className + '-filter-wrapper');
                var $filterBox = $('.' + className + '-filter-box');
                var $selectedItem = $('.' + className + '-result.selected');

                if ($filterWrapper.css('display') === 'none') {

                    // close all dropdowns before opening the current one
                    closeDropdowns();

                    $filterWrapper
                        .show()
                        .css('z-index', 1);

                    // if an item is selected, scroll the results wrapper to it
                    if ($selectedItem.length > 0) {
                        scrollFilterResultsWrapper($selectedItem);
                    }

                    $filterBox.focus();

                    // re-highlight the previously selected item
                    if ($selectedItem.length > 0) {
                        hoverItem($selectedItem);
                    }

                    flipDropdownArrow();
                }
                else {
                    closeDropdown();
                }
            }

            function closeDropdown() {
                $filterWrapper
                    .hide()
                    .css('z-index', 'auto');

                if ($('.' + className + '-dropdown-icon').hasClass('up-arrow')) {
                    flipDropdownArrow();
                }
            }

            /**
            * Toggle the dropdown arrow icon for the current dropdown by switching the element's classes between 'down-arrow' and 'up-arrow'.
            * @example
            * flipDropdownArrow()
            * // undefined — toggles the icon classes on elements with '.' + className + '-dropdown-icon'
            * @returns {void} Does not return a value; mutates DOM classes to reflect the toggled arrow state.
            */
            function flipDropdownArrow() {
                var $dropdownIcon = $('.' + className + '-dropdown-icon');

                if ($dropdownIcon.hasClass('down-arrow')) {
                    $dropdownIcon
                        .addClass('up-arrow')
                        .removeClass('down-arrow');
                }
                else {
                    $dropdownIcon
                        .addClass('down-arrow')
                        .removeClass('up-arrow');
                }
            }

            function closeDropdowns() {
                $('.filter-wrapper').hide();
                $('.glyphicon-arrow-up')
                    .removeClass('up-arrow')
                    .addClass('down-arrow');
            }

            /**
            * Handles arrow-up, arrow-down and enter keys to move the hovered selection within visible dropdown results and optionally select an item.
            * @example
            * arrowKeyNavigate(event)
            * undefined
            * @param {{Event}} {{e}} - Keydown event object (KeyboardEvent or jQuery.Event) representing the user's key press.
            * @returns {{void}} No return value.
            **/
            function arrowKeyNavigate(e) {
                var $hoveredItem = $('.' + className + '-result.hovered');
                var $nextItem = $hoveredItem.nextAll().filter(':visible').first(),
                    $prevItem = $hoveredItem.prevAll().filter(':visible').first(),
                    $firstItem = $filterResultsWrapper.children().filter(':visible').first(),
                    $lastItem = $filterResultsWrapper.children().filter(':visible').last();

                switch (e.which) {
                    case 40:
                        upOrDown($hoveredItem, $nextItem, $firstItem);
                        break;
                    case 38:
                        upOrDown($hoveredItem, $prevItem, $lastItem);
                        break;
                    case 13:
                        e.preventDefault();

                        if ($hoveredItem.length > 0) {
                            selectItem($hoveredItem);
                        }
                        break;
                }

                /**
                * Move hover/focus to the given sibling or wrap target and ensure it is scrolled into view.
                * @example
                * upOrDown($item, $sibling, $wrapToItem)
                * undefined
                * @param {{jQuery}} {{$item}} - jQuery element(s) representing the currently targeted item.
                * @param {{jQuery}} {{$sibling}} - jQuery element(s) representing the adjacent sibling to move to.
                * @param {{jQuery}} {{$wrapToItem}} - jQuery element(s) to wrap to when no sibling is present.
                * @returns {{void}} No return value; updates hover state and scrolls the results wrapper.
                **/
                function upOrDown($item, $sibling, $wrapToItem) {
                    if ($item.length > 0) {
                        if ($sibling.length > 0) {
                            hoverItem($sibling);
                            scrollFilterResultsWrapper($sibling);
                        } else {
                            hoverItem($wrapToItem);
                            scrollFilterResultsWrapper($wrapToItem);
                        }
                    } else {
                        hoverItem($firstItem);
                        scrollFilterResultsWrapper($firstItem);
                    }
                }
            }

            /**
            * Ensure the hovered result item is visible by scrolling the filter results wrapper if necessary.
            * @example
            * scrollFilterResultsWrapper($hoveredItem)
            * undefined
            * @param {{jQuery}} {{$hoveredItem}} - The jQuery-wrapped DOM element for the currently hovered result item.
            * @returns {{void}} No return value.
            **/
            function scrollFilterResultsWrapper($hoveredItem) {
                var hoverItemTop = $hoveredItem.offset().top;
                var hoverItemBottom = $hoveredItem.height() + hoverItemTop;
                var resultsWrapperTop = $('.' + className + '-filter-results-wrapper').offset().top;
                var resultsWrapperBottom = resultsWrapperTop + $('.' + className + '-filter-results-wrapper').height();
                var itemOffscreenBottomValue = hoverItemBottom - resultsWrapperBottom;
                var itemOffscreenTopValue = resultsWrapperTop - hoverItemTop;

                // if the hovered item is below the current scroll window
                if (itemOffscreenBottomValue > 0) {
                    $filterResultsWrapper.scrollTop($filterResultsWrapper.scrollTop() + itemOffscreenBottomValue);
                }

                // if the hovered item is above the current scroll window
                if (itemOffscreenTopValue > 0) {
                    $filterResultsWrapper.scrollTop($filterResultsWrapper.scrollTop() - itemOffscreenTopValue);
                }
            }

            function resizeDropdown() {
                var width = $('.dropdown-box-wrapper').width();

                $('.dropdown-box-text').width(width - 37);
                $('.filter-wrapper').width(width);
                $('.filter-box').width(width - 6);
                $('.dropdown-icon').css('padding-left', width - 28);
            }
        }

        function destoryDropdown(originalDropdown) {
            var id = originalDropdown[0].id;

            $('.' + id).remove();
        }
    }

    $.fn.betterDropdown.defaults = {
        itemName: 'Item',
        displayTextBelow: false,
        destroy: false
    };

})(jQuery, window);