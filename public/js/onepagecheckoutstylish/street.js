/*
 * One-step checkout: the second street line becomes the civic number of the
 * first, on the same row and required.
 *
 * Loaded only when "Street lines" is set to the civic number layout. It works on
 * the inputs the address form renders, so with a single street line configured
 * there is no second input and the form is left alone. The row layout is CSS, on
 * the classes added here: a checkout that does not run this script keeps the
 * rows of the engine.
 *
 * The label keeps the <em> of the required marker: the theme draws the asterisk
 * from it, and the labels script copies it into the placeholder.
 */

(function () {
    'use strict';

    var PREFIX = 'onepagecheckoutstylish-';
    var LIST = PREFIX + 'street-list';
    var FIRST = PREFIX + 'street-first';
    var CIVIC = PREFIX + 'street-civic';
    var REQUIRED = 'required-entry';
    var ADDRESSES = ['billing', 'shipping'];

    function civicText() {
        var text = 'Civic number';
        if (window.Translator && typeof window.Translator.translate === 'function') {
            return window.Translator.translate(text);
        }

        return text;
    }

    // The label that points at this field, by id: the engine pairs two fields per
    // row, so "the" label of the row is not necessarily the one of this field
    function labelFor(field) {
        var scope = field.closest('li') || field.parentElement;
        if (!scope) {
            return null;
        }

        var labels = scope.querySelectorAll('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].htmlFor === field.id) {
                return labels[i];
            }
        }

        return null;
    }

    function rewriteLabel(label, text) {
        var asterisk = label.querySelector('em');
        asterisk = asterisk ? asterisk.cloneNode(true) : document.createElement('em');
        if (!asterisk.textContent) {
            asterisk.textContent = '*';
        }

        label.textContent = '';
        label.appendChild(asterisk);
        label.appendChild(document.createTextNode(text));
        label.classList.add('required');
    }

    function applyAddress(address) {
        var first = document.getElementById(address + ':street1');
        var second = document.getElementById(address + ':street2');
        if (!first || !second) {
            return;
        }

        var firstRow = first.closest('li');
        var secondRow = second.closest('li');
        // One row means the form already stacks what it has: nothing to put beside
        if (!firstRow || !secondRow || firstRow === secondRow) {
            return;
        }
        if (firstRow.parentElement !== secondRow.parentElement) {
            return;
        }
        if (secondRow.classList.contains(CIVIC)) {
            return;
        }

        var text = civicText();

        var label = labelFor(second);
        if (label) {
            rewriteLabel(label, text);
        }

        second.classList.add(REQUIRED);
        second.setAttribute('title', text);
        // The labels script may have run already: keep its placeholder in step
        if (second.hasAttribute('placeholder')) {
            second.setAttribute('placeholder', text + ' *');
        }

        firstRow.classList.add(FIRST);
        secondRow.classList.add(CIVIC);
        firstRow.parentElement.classList.add(LIST);
    }

    function start() {
        var checkout = document.querySelector('.onestep-checkout');
        if (!checkout) {
            return;
        }

        ADDRESSES.forEach(applyAddress);

        // The one-step script swaps the address blocks while the customer walks
        // through it, and a new country rewrites part of the form
        new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.addedNodes.length) {
                    ADDRESSES.forEach(applyAddress);
                }
            });
        }).observe(checkout, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();
