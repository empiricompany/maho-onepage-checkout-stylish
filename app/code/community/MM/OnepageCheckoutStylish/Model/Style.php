<?php

/**
 * SPDX-FileCopyrightText: 2026 Empiricompany
 * SPDX-License-Identifier: OSL-3.0
 * @package MM_OnepageCheckoutStylish
 */

declare(strict_types=1);

/**
 * Registry of the style presets the module ships: each key is the value saved in
 * design/onepagecheckoutstylish/style and the name of its stylesheet under
 * skin/frontend/<package>/<theme>/css/onepagecheckoutstylish/.
 */
final class MM_OnepageCheckoutStylish_Model_Style
{
    public const DIVIDER = 'divider';
    public const PLAIN = 'plain';
    public const BOXED = 'boxed';

    /**
     * Preset code => label shown in the admin select.
     *
     * @return array<string, string>
     */
    public function getPresets(): array
    {
        return [
            self::DIVIDER => 'Divider: the right half of the page painted as a panel, the summary at its top',
            self::PLAIN => 'Plain: steps free on a tinted page, only the summary in a white card',
            self::BOXED => 'Boxed: every step in a white box on a tinted page, the order button full width',
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->getPresets() as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }

    public function getDefaultStyle(): string
    {
        return self::DIVIDER;
    }

    public function getStylesheet(string $style): string
    {
        if (!isset($this->getPresets()[$style])) {
            return '';
        }

        return 'css/onepagecheckoutstylish/' . $style . '.css';
    }
}
