<?php

use PHPUnit\Framework\TestCase;
use App\Exception\FullJsonException;

class FullJsonExceptionUnitTest extends TestCase
{
    public function test_exception_contains_expected_json()
    {
        // Load the JSON from file
        $jsonPath = __DIR__ . '/../../resources/package_not_found.json';
        $expectedData = json_decode(file_get_contents($jsonPath), true);
        $expectedJson = json_encode($expectedData, JSON_PRETTY_PRINT);

        // Test that the exception is thrown with this JSON
        $this->expectException(FullJsonException::class);
        $this->expectExceptionMessage($expectedJson);


        throw new FullJsonException($expectedData);

         // for the JSON
    }
}
