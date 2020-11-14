/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* global $, $H */

define([
    'jquery',
    'mage/adminhtml/grid'
], function () {
    'use strict';

    return function (config) {
        let gridJsObject = window[config.gridJsObjectName],
            updateElement = $(config.updateElement),
            reloadParam = config.reloadParam;

        updateElement.value = jQuery.isEmptyObject(config.selectedElement) ? '' : config.selectedElement;

        function registerEventClick(grid, element, checked) {
            if (typeof element === 'undefined') {
                return;
            }

            let selectedValue = element.value;
            if (!checked) {
                selectedValue = '';
            }

            updateElement.value = selectedValue;

            if (reloadParam === 'customer') {
                grid.reloadParams = {
                    'selected_customers[]': selectedValue
                };
            } else if (reloadParam === 'product') {
                grid.reloadParams = {
                    'selected_products[]': selectedValue
                };
            }
        }

        function rowEventClick(grid, event) {
            let trElement = Event.findElement(event, 'tr'),
                eventElement = Event.element(event),
                isInputRadio = eventElement.tagName === 'INPUT' && eventElement.type === 'radio',
                checked = false,
                checkbox = null;

            if (eventElement.tagName === 'LABEL' &&
                trElement.querySelector('#' + eventElement.htmlFor) &&
                trElement.querySelector('#' + eventElement.htmlFor).type === 'radio'
            ) {
                event.stopPropagation();
                trElement.querySelector('#' + eventElement.htmlFor).trigger('click');

                return;
            }

            if (trElement) {
                checkbox = Element.getElementsBySelector(trElement, 'input');

                if (checkbox[0]) {
                    checked = isInputRadio ? checkbox[0].checked : !checkbox[0].checked;

                    if (checked === true) {
                        gridJsObject.setCheckboxChecked(checkbox[0], checked);
                    }
                }
            }
        }

        gridJsObject.rowClickCallback = rowEventClick;
        gridJsObject.checkboxCheckCallback = registerEventClick;
    };
});
