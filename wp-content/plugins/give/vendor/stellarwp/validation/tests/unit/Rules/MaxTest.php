<?php

declare(strict_types=1);

namespace StellarWP\Validation\Tests\Unit\Rules;

use InvalidArgumentException;
use StellarWP\Validation\Exceptions\ValidationException;
use StellarWP\Validation\Rules\Max;
use StellarWP\Validation\Tests\TestCase;

class MaxTest extends TestCase
{
    /**
     * @dataProvider validationsProvider
     */
    public function testRuleValidations($value, $shouldPass)
    {
        $rule = new Max(5);

        if ( $shouldPass ) {
            self::assertValidationRulePassed($rule, $value);
        } else {
            self::assertValidationRuleFailed($rule, $value);
        }
    }

    public function validationsProvider(): array
    {
        return [
            // numbers
            [-1, true],
            [0, true],
            [3, true],
            [3.2, true],
            [5, true],
            [6, false],

            // strings
            ['', true],
            ['a', true],
            ['bill', true],
            ['billy-bob', false],
        ];
    }

    public function testRuleShouldThrowValidationExceptionForInvalidValue()
    {
        $this->expectException(ValidationException::class);

        $rule = new Max(5);
        self::assertValidationRulePassed($rule, true);
    }

    public function testRuleThrowsExceptionForNonPositiveSize()
    {
        $this->expectException(InvalidArgumentException::class);
        new Max(0);
    }
}
