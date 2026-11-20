<?php

/**
 * SPDX-FileCopyrightText: 2026 Empiricompany
 * SPDX-License-Identifier: OSL-3.0
 * @package MM_OnepageCheckoutStylish
 */

declare(strict_types=1);

/**
 * How the street lines of an address are laid out: one line each, the way the
 * engine draws them (default), or the second line turned into the civic number of
 * the first, on the same row.
 *
 * The second layout needs at least two street lines configured on the address: the
 * script works on the inputs the form renders, and it leaves the form alone when
 * the second line is not there.
 */
final class MM_OnepageCheckoutStylish_Model_Street
{
    public const STANDARD = 'standard';
    public const CIVIC = 'civic';

    /**
     * Layout code => label shown in the admin select.
     *
     * @return array<string, string>
     */
    public function getLayouts(): array
    {
        return [
            self::STANDARD => 'One line per field, as configured on the address',
            self::CIVIC => 'Second line as the civic number, on the row of the first',
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->getLayouts() as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }

    public function getDefaultLayout(): string
    {
        return self::STANDARD;
    }
}
