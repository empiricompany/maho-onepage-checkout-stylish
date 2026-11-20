<?php

/**
 * SPDX-FileCopyrightText: 2026 Empiricompany
 * SPDX-License-Identifier: OSL-3.0
 * @package MM_OnepageCheckoutStylish
 */

declare(strict_types=1);

/**
 * Adds the stylesheet of the active preset to the page head, plus the body classes
 * the stylesheet uses for the options that have no template of their own (step
 * marker, line under the titles, quantity on the thumbnail). It renders no markup:
 * the head runs the module only on the handles its layout declares, and it adds
 * nothing when the preset is disabled.
 */
final class MM_OnepageCheckoutStylish_Block_Stylesheet extends Mage_Core_Block_Abstract
{
    #[\Override]
    protected function _prepareLayout()
    {
        /** @var MM_OnepageCheckoutStylish_Helper_Data $helper */
        $helper = Mage::helper('onepagecheckoutstylish');

        if ($helper->isEnabled()) {
            $this->addStylesheet($helper->getStylesheet());
            $this->addBodyClass($helper->getStepMarkerClass());

            if ($helper->areTitleLinesHidden()) {
                $this->addBodyClass(MM_OnepageCheckoutStylish_Helper_Data::NO_TITLE_LINES_CLASS);
            }

            if ($helper->isProductQtyBadgeShown()) {
                $this->addBodyClass(MM_OnepageCheckoutStylish_Helper_Data::REVIEW_COUNT_BADGE_CLASS);
            }

            // Before the labels script: it rewrites the label of the second street
            // line, and the labels script copies that text into the field
            if ($helper->isCivicStreetLine()) {
                $this->addScript('onepagecheckoutstylish/street.js');
            }

            if ($helper->areLabelsAsPlaceholders()) {
                $this->addScript('onepagecheckoutstylish/labels.js');
            }
        }

        return parent::_prepareLayout();
    }

    #[\Override]
    protected function _toHtml(): string
    {
        return '';
    }

    private function addStylesheet(string $stylesheet): void
    {
        if ($stylesheet === '') {
            return;
        }

        $head = $this->getLayout()->getBlock('head');
        if ($head instanceof Mage_Page_Block_Html_Head) {
            $head->addCss($stylesheet);
        }
    }

    private function addScript(string $script): void
    {
        $head = $this->getLayout()->getBlock('head');
        if ($head instanceof Mage_Page_Block_Html_Head) {
            $head->addJs($script);
        }
    }

    private function addBodyClass(string $className): void
    {
        if ($className === '') {
            return;
        }

        $root = $this->getLayout()->getBlock('root');
        if ($root instanceof Mage_Page_Block_Html) {
            $root->addBodyClass($className);
        }
    }
}
