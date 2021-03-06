<?php
/**
 * This file is part of mermshaus/Pdf.
 *
 * mermshaus/Pdf is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Affero General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mermshaus/Pdf is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with mermshaus/Pdf. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2013 Marc Ermshaus <http://www.ermshaus.org/>
 */

namespace mermshaus\Stream\Matcher;

use mermshaus\Stream\Matcher\MatcherTestInterface;

class StringTest implements MatcherTestInterface
{
    protected $testString;

    public function __construct($testString)
    {
        $this->testString = $testString;
    }

    public function run($handle, $rolloverChar, $returnMatches = false)
    {
        $buffer = '';

        $count = strlen($this->testString);

        $found = true;

        for ($i = 0; $i < $count; $i++) {
            $char = false;
            if ($rolloverChar !== '') {
                $char = $rolloverChar;
                $rolloverChar = '';
            } else {
                $char = fgetc($handle);
            }

            if (substr($this->testString, $i, 1) !== $char) {
                $found = false;
                break;
            }
        }

        if ($found) {
            if ($returnMatches) {
                $buffer = $this->testString;
            }
        }

        return array(
            'found' => $found,
            'buffer' => $buffer,
            'length' => $count,
            'rolloverChar' => ''
        );
    }
}
