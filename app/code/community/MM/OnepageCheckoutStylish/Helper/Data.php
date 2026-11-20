<?php

/**
 * SPDX-FileCopyrightText: 2026 Empiricompany
 * SPDX-License-Identifier: OSL-3.0
 * @package MM_OnepageCheckoutStylish
 */

declare(strict_types=1);

final class MM_OnepageCheckoutStylish_Helper_Data extends Mage_Core_Helper_Abstract
{
    public const XML_PATH_ENABLED = 'design/onepagecheckoutstylish/enabled';
    public const XML_PATH_STYLE = 'design/onepagecheckoutstylish/style';
    public const XML_PATH_STEP_MARKER = 'design/onepagecheckoutstylish/step_marker';
    public const XML_PATH_LABEL_STYLE = 'design/onepagecheckoutstylish/label_style';
    public const XML_PATH_STREET_LAYOUT = 'design/onepagecheckoutstylish/street_layout';
    public const XML_PATH_PRODUCT_IMAGES = 'design/onepagecheckoutstylish/product_images';
    public const XML_PATH_PRODUCT_QTY_BADGE = 'design/onepagecheckoutstylish/product_qty_badge';
    public const XML_PATH_HIDE_TITLE_LINES = 'design/onepagecheckoutstylish/hide_title_lines';

    /** Body class the stylesheet uses to drop the line under the step titles */
    public const NO_TITLE_LINES_CLASS = 'onepagecheckoutstylish-no-title-lines';

    /** Body class the stylesheet uses to move the quantity onto the thumbnail */
    public const REVIEW_COUNT_BADGE_CLASS = 'onepagecheckoutstylish-review-count-badge';

    public function isEnabled(): bool
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED);
    }

    /**
     * A code the model does not know (a value saved by an older release, a typo in the
     * database) falls back to the default preset: without it the checkout would lose
     * its stylesheet and the page would break.
     */
    public function getStyle(): string
    {
        $style = (string) Mage::getStoreConfig(self::XML_PATH_STYLE);

        return isset($this->getStyleModel()->getPresets()[$style])
            ? $style
            : $this->getStyleModel()->getDefaultStyle();
    }

    /**
     * Skin-relative path of the stylesheet of the active preset. Empty when the
     * preset is disabled for the store view or the style ships no stylesheet.
     */
    public function getStylesheet(): string
    {
        return $this->isEnabled() ? $this->getStyleModel()->getStylesheet($this->getStyle()) : '';
    }

    public function getStyleModel(): MM_OnepageCheckoutStylish_Model_Style
    {
        /** @var MM_OnepageCheckoutStylish_Model_Style $model */
        $model = Mage::getSingleton('onepagecheckoutstylish/style');

        return $model;
    }

    public function getStepMarker(): string
    {
        $marker = (string) Mage::getStoreConfig(self::XML_PATH_STEP_MARKER);

        return $marker !== '' ? $marker : $this->getMarkerModel()->getDefaultMarker();
    }

    /**
     * Body class of the configured step marker, empty for the default (icons).
     */
    public function getStepMarkerClass(): string
    {
        return $this->getMarkerModel()->getBodyClass($this->getStepMarker());
    }

    public function getMarkerModel(): MM_OnepageCheckoutStylish_Model_Marker
    {
        /** @var MM_OnepageCheckoutStylish_Model_Marker $model */
        $model = Mage::getSingleton('onepagecheckoutstylish/marker');

        return $model;
    }

    public function getLabelStyle(): string
    {
        $labelStyle = (string) Mage::getStoreConfig(self::XML_PATH_LABEL_STYLE);

        return $labelStyle !== '' ? $labelStyle : $this->getLabelModel()->getDefaultLabelStyle();
    }

    /**
     * True when the labels have to sit inside the fields, as their placeholders.
     */
    public function areLabelsAsPlaceholders(): bool
    {
        return $this->isEnabled() && $this->getLabelStyle() === MM_OnepageCheckoutStylish_Model_Label::PLACEHOLDERS;
    }

    public function getLabelModel(): MM_OnepageCheckoutStylish_Model_Label
    {
        /** @var MM_OnepageCheckoutStylish_Model_Label $model */
        $model = Mage::getSingleton('onepagecheckoutstylish/label');

        return $model;
    }

    public function getStreetLayout(): string
    {
        $layout = (string) Mage::getStoreConfig(self::XML_PATH_STREET_LAYOUT);

        return $layout !== '' ? $layout : $this->getStreetModel()->getDefaultLayout();
    }

    /**
     * True when the second street line has to become the civic number of the first,
     * on the same row.
     */
    public function isCivicStreetLine(): bool
    {
        return $this->isEnabled() && $this->getStreetLayout() === MM_OnepageCheckoutStylish_Model_Street::CIVIC;
    }

    public function getStreetModel(): MM_OnepageCheckoutStylish_Model_Street
    {
        /** @var MM_OnepageCheckoutStylish_Model_Street $model */
        $model = Mage::getSingleton('onepagecheckoutstylish/street');

        return $model;
    }

    /**
     * True when the summary row shows the thumbnail: the layout registers the item
     * template of the module through the same flag.
     */
    public function areProductImagesShown(): bool
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_PRODUCT_IMAGES);
    }

    /**
     * True when the quantity leaves its column and sits on the thumbnail. It comes
     * with the image: without it there would be nothing to put the badge on.
     */
    public function isProductQtyBadgeShown(): bool
    {
        return $this->areProductImagesShown() && Mage::getStoreConfigFlag(self::XML_PATH_PRODUCT_QTY_BADGE);
    }

    public function areTitleLinesHidden(): bool
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_HIDE_TITLE_LINES);
    }
}
