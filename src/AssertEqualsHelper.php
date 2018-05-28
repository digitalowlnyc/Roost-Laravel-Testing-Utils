<?php
/**
 * Creator: Bryan Mayor
 * Company: Blue Nest Digital, LLC
 * License: (Blue Nest Digital LLC, All rights reserved)
 * Copyright: Copyright 2018 Blue Nest Digital LLC
 */

namespace Roost\Testing\Laravel;

use PHPUnit\Framework\AssertionFailedError;

class AssertEqualsHelper
{
    public static function assertKeysAndValuesAreEqual($expected, $actual, $ignoredKeys = [], $compareBothSideKeys = true)
    {
        if(!is_array($expected) || !is_array($actual)) {
            throw new \InvalidArgumentException("Expected and actual must be arrays, saw: " . gettype($expected) . ", " . gettype($actual));
        }

        try {
            foreach($expected as $key => $val) {
                if(in_array($key, $ignoredKeys)) {
                    continue;
                }
                if(!array_key_exists($key, $actual)) {
                    throw new AssertionFailedError("Key '" . $key . "' not found in 'actual' value, keys present are: " . print_r(array_keys($actual), true));
                }

                if(is_array($val)) {
                    static::assertKeysAndValuesAreEqual($expected[$key], $actual[$key], $ignoredKeys, $compareBothSideKeys);
                } else {
                    if($expected[$key] != $actual[$key]) {
                        throw new AssertionFailedError("Value for key " . $key . " does not match expected: " . print_r($expected, true) . " vs " . print_r($actual, true));
                    }
                }
            }

            if($compareBothSideKeys) {
                foreach($actual as $actualKey => $actualVal) {
                    if(in_array($actualKey, $ignoredKeys)) {
                        continue;
                    }

                    if(!array_key_exists($actualKey, $expected)) {
                        throw new AssertionFailedError("Key '" . $actualKey . "' not found in 'expected' value, keys present are: " . print_r(array_keys($expected), true));
                    }
                }
            }
        } catch(AssertionFailedError $e) {
            var_dump(['Expected' => $expected, "Actual" => $actual]);
            throw $e;
        }
    }
}