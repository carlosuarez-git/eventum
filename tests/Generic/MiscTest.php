<?php

/*
 * This file is part of the Eventum (Issue Tracking System) package.
 *
 * @copyright (c) Eventum Team
 * @license GNU General Public License, version 2 or later (GPL-2+)
 *
 * For the full copyright and license information,
 * please see the COPYING and AUTHORS files
 * that were distributed with this source code.
 */

namespace Eventum\Test\Generic;

use Eventum\Test\TestCase;
use Misc;

/**
 * Test class for Misc.
 */
class MiscTest extends TestCase
{
    /**
     * @dataProvider caseData
     */
    public function testLowercase($str, $exp): void
    {
        $res = Misc::lowercase($str);
        $this->assertSame($exp, $res);
    }

    /**
     * Method used to strip HTML from a string or array
     *
     * @param   string $str The original string or array
     * @return  string The escaped (or not) string
     * @dataProvider StripHTMLData
     */
    public function testStripHTML($str, $exp): void
    {
        $this->assertEquals($exp, Misc::stripHTML($str));
    }

    /**
     * @param   string $str The original string or array
     * @return  string The escaped (or not) string
     * @dataProvider StripInputData
     */
    public function testStripInput($str, $exp): void
    {
        Misc::stripInput($str);
        $this->assertEquals($exp, $str);
    }

    public function StripHTMLData(): array
    {
        return [
            ['plain', 'plain'],
            ['<b>bold</b>', '&#60;b&#62;bold&#60;/b&#62;'],
            [['<b>bold</b>'], ['&#60;b&#62;bold&#60;/b&#62;']],
        ];
    }

    public function StripInputData(): array
    {
        return [
            ['plain', 'plain'],
            // nothing bad happens with empty array
            [[], []],
            // ctrl char: \r
            [
                ['a' => "a\r\nb"],
                ['a' => "a\nb"],
            ],
            // some emoji
            [
                ['a' => $this->unichr(0x1F6B2) . $this->unichr(0x1F4A8)],
                ['a' => ''],
            ],
        ];
    }

    public function caseData(): array
    {
        return [
            [null, null],
            [[], []],
            ['', ''],

            ['A', 'a'],

            [['AA', 'B'], ['aa', 'b']],
            [['z' => 'AA', 3 => 'B'], ['z' => 'aa', 3 => 'b']],
        ];
    }

    /**
     * Return unicode char by its code
     *
     * @see http://php.net/manual/en/function.chr.php#88611
     * @param int $u
     * @return string
     */
    private function unichr(int $u): string
    {
        return mb_convert_encoding('&#' . $u . ';', 'UTF-8', 'HTML-ENTITIES');
    }
}
