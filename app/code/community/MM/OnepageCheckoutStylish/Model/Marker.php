<?php

/**
 * SPDX-FileCopyrightText: 2026 Empiricompany
 * SPDX-License-Identifier: OSL-3.0
 * @package MM_OnepageCheckoutStylish
 */

declare(strict_types=1);

/**
 * What marks a step heading: the icon of the theme (default), its number, or
 * nothing at all. Each non-default marker maps to the body class the stylesheet
 * uses.
 */
final class MM_OnepageCheckoutStylish_Model_Marker
{
    public const ICONS = 'icons';
    public const STEPS = 'steps';
    public const NONE = 'none';

    public const STEPS_CLASS = 'onepagecheckoutstylish-step-numbers';
    public const NONE_CLASS = 'onepagecheckoutstylish-no-icons';

    /**
     * Marker code => label shown in the admin select.
     *
     * @return array<string, string>
     */
    public function getMarkers(): array
    {
        return [
            self::STEPS => 'Numbered steps',
            self::ICONS => 'Icons',
            self::NONE => 'No marker',
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->getMarkers() as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }

    public function getDefaultMarker(): string
    {
        return self::STEPS;
    }

    /**
     * Body class of the marker, empty for the default one (the icons stay).
     */
    public function getBodyClass(string $marker): string
    {
        return match ($marker) {
            self::STEPS => self::STEPS_CLASS,
            self::NONE => self::NONE_CLASS,
            default => '',
        };
    }
}
