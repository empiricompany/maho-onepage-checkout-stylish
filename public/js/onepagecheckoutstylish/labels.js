/*
 * One-step checkout: the label of a field inside the field itself.
 *
 * Loaded only when "Input labels" is set to "Label inside the field". The work
 * is done per field container, the way FireCheckout's compact form does it: a
 * label and the fields it describes share a wrapper (the row for a wide field,
 * the `.field` for one half of a row), so one label can describe more than one
 * field - the region pair is a select and a text input in the same wrapper.
 *
 * The label stays in the markup, visually hidden and not removed, so screen
 * readers and the engine's validation keep finding it. Text fields get the
 * label text as their placeholder; a select has nowhere to show a placeholder,
 * so the text of its empty option becomes the label, and it keeps its label
 * when the list has no empty option to write into.
 */

(function () {
    'use strict';

    var HIDDEN = 'onepagecheckoutstylish-label-hidden';
    var FIELDS = 'input, select, textarea';
    // Everything that cannot carry a placeholder or a caption
    var NO_PLACEHOLDER = /^(hidden|radio|checkbox|submit|button|reset|file|image|color|range)$/;

    function isField(element) {
        if (element.tagName === 'SELECT' || element.tagName === 'TEXTAREA') {
            return !element.disabled;
        }

        return element.tagName === 'INPUT'
            && !NO_PLACEHOLDER.test((element.type || 'text').toLowerCase())
            && !element.disabled;
    }

    function labelText(label) {
        var clone = label.cloneNode(true);
        Array.prototype.forEach.call(clone.querySelectorAll('em'), function (element) {
            element.remove();
        });

        return clone.textContent.replace(/\s+/g, ' ').trim();
    }

    function emptyOption(select) {
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].value === '') {
                return select.options[i];
            }
        }

        return null;
    }

    function applyLabel(label) {
        if (!label.htmlFor || label.classList.contains(HIDDEN)) {
            return;
        }

        var wrapper = label.parentElement;
        if (!wrapper) {
            return;
        }

        var text = labelText(label);
        if (text === '') {
            return;
        }

        if (label.querySelector('em')) {
            text += ' *';
        }

        var fields = Array.prototype.filter.call(wrapper.querySelectorAll(FIELDS), isField);
        if (!fields.length) {
            return;
        }

        var written = false;
        fields.forEach(function (field) {
            if (field.tagName !== 'SELECT') {
                field.setAttribute('placeholder', text);
                written = true;
                return;
            }

            var option = emptyOption(field);
            if (option) {
                option.textContent = text;
                written = true;
            }
        });

        if (written) {
            label.classList.add(HIDDEN);
        }
    }

    function applyAll(root) {
        if (!root || root.nodeType !== 1) {
            return;
        }

        if (root.matches('label[for]')) {
            applyLabel(root);
        }
        Array.prototype.forEach.call(root.querySelectorAll('label[for]'), applyLabel);
    }

    function start() {
        var checkout = document.querySelector('.onestep-checkout');
        if (!checkout) {
            return;
        }

        applyAll(checkout);

        // The one-step script swaps whole sections (billing, shipping, payment)
        // while the customer walks through it: the labels it injects need the
        // same pass, and a changed country rewrites the region field entirely.
        new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                Array.prototype.forEach.call(mutation.addedNodes, applyAll);
            });
        }).observe(checkout, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();
