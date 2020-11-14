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
        let gridJsObject = window[config.gridJsObjectName];

        $('in_price_customers').value = jQuery.isEmptyObject(config.selectedCustomer) ? '' : config.selectedCustomer;

        function registerCustomer(grid, element, checked) {
            if (typeof element === 'undefined') {
                return;
            }

            let selectedValue = element.value;
            if (!checked) {
                selectedValue = '';
            }

            $('in_price_customers').value = selectedValue;

            grid.reloadParams = {
                'selected_customers[]': selectedValue
            };
        }

        function customerRowClick(grid, event) {
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
                    gridJsObject.setCheckboxChecked(checkbox[0], checked);
                }
            }
        }

        gridJsObject.rowClickCallback = customerRowClick;
        gridJsObject.checkboxCheckCallback = registerCustomer;
    };
});
