<?php

/**
 * SPDX-FileCopyrightText: 2026 Empiricompany
 * SPDX-License-Identifier: OSL-3.0
 * @package MM_OnepageCheckoutStylish
 */

declare(strict_types=1);

/**
 * Where the label of an input sits: above the field, where the engine draws it
 * (default), or inside the field as its placeholder, with the label left in the
 * markup for screen readers and validation.
 */
final class MM_OnepageCheckoutStylish_Model_Label
{
    public const LABELS = 'labels';
    public const PLACEHOLDERS = 'placeholders';

    /**
     * Label style code => label shown in the admin select.
     *
     * @return array<string, string>
     */
    public function getLabelStyles(): array
    {
        return [
            self::PLACEHOLDERS => 'Label inside the field, as its placeholder',
            self::LABELS => 'Label above the field',
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->getLabelStyles() as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }

    public function getDefaultLabelStyle(): string
    {
        return self::PLACEHOLDERS;
    }
}
