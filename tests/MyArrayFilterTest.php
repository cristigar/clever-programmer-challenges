<?php

declare(strict_types=1);

namespace CleverProgrammerChallenges\Tests;

use PHPStan\Testing\TestCase;

require_once dirname(__DIR__) . '/src/MyArrayFilter.php';

class MyArrayFilterTest extends TestCase
{
    public function testPassingOnlyAnArrayWithAllNonFalsyValuesReturnsTheSameArray(): void
    {
        $testArray = [0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6];

        static::assertSame(
            [0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6],
            my_array_filter($testArray)
        );
    }

    public function testPassingOnlyAnArrayWithAllFalsyValuesReturnsTheArrayWithoutThoseValues(): void
    {
        $testArray = [0 => 'foo', 1 => false, 2 => -1, 3 => null, 4 => '', 5 => '0', 6 => 0];

        static::assertSame(
            [0 => 'foo', 2 => -1],
            my_array_filter($testArray)
        );
    }

    public function testPassingCallbackToRemoveEvenNumbers(): void
    {
        $testArray = [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6];

        static::assertSame(
            [1 => 1, 3 => 3, 5 => 5],
            my_array_filter($testArray, [__CLASS__, 'filterOdd'])
        );
    }

    public static function filterOdd($number): int
    {
        return $number & 1;
    }

    public function testFlagArrayFilterUseKey(): void
    {
        $testArray = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

        static::assertSame(
            ['b' => 2],
            my_array_filter($testArray, [__CLASS__, 'filterKeyB'], ARRAY_FILTER_USE_KEY)
        );
    }

    public static function filterKeyB($key): bool
    {
        return 'b' === $key;
    }

    public function testFlagArrayFilterUseBoth(): void
    {
        $testArray = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

        static::assertSame(
            ['b' => 2, 'd' => 4],
            my_array_filter($testArray, [__CLASS__, 'filterKeyBAndValue4'], ARRAY_FILTER_USE_BOTH)
        );
    }

    public static function filterKeyBAndValue4($value, $key): bool
    {
        return 'b' === $key || 4 === $value;
    }
}
