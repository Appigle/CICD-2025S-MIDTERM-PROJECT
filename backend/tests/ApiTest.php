<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    /** @var string */
    private string $baseUrl;

    protected function setUp(): void
    {
        parent::setUp();
        // Get base URL from environment variable or use default
        $this->baseUrl = getenv('API_BASE_URL') ?: 'http://localhost:8000/api/';
    }

    public function testHealthCheck(): void
    {
        $response = @file_get_contents($this->baseUrl . 'health_check');
        if ($response === false) {
            $this->fail('Could not connect to API endpoint: ' . $this->baseUrl . 'health_check');
        }
        $data = json_decode($response, true);
        $this->assertEquals('ok', $data['status']);
    }

    public function testRollDice(): void
    {
        $response = @file_get_contents($this->baseUrl . 'rolldice');
        if ($response === false) {
            $this->fail('Could not connect to API endpoint: ' . $this->baseUrl . 'rolldice');
        }
        $data = json_decode($response, true);
        $this->assertGreaterThanOrEqual(1, $data['dice']);
        $this->assertLessThanOrEqual(6, $data['dice']);
    }

    public function testGetCurrentSystemTime(): void
    {
        $response = @file_get_contents($this->baseUrl . 'get_current_system_time');
        if ($response === false) {
            $this->fail('Could not connect to API endpoint: ' . $this->baseUrl . 'get_current_system_time');
        }
        $data = json_decode($response, true);
        $this->assertArrayHasKey('time', $data);
        $this->assertMatchesRegularExpression('/^\d{4}:\d{2}:\d{2} \d{2}:\d{2}:\d{2}$/', $data['time']);
    }

    public function testGetUserInfo(): void
    {
        $response = @file_get_contents($this->baseUrl . 'get_user_info');
        if ($response === false) {
            $this->fail('Could not connect to API endpoint: ' . $this->baseUrl . 'get_user_info');
        }
        $data = json_decode($response, true);
        $this->assertArrayHasKey('user_id', $data);
        $this->assertArrayHasKey('first_name', $data);
        $this->assertArrayHasKey('age', $data);
    }
}
