<?php
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private $baseUrl = 'http://localhost:8000/api/';

    public function testHealthCheck()
    {
        $response = file_get_contents($this->baseUrl . 'health_check');
        $data = json_decode($response, true);
        $this->assertEquals('ok', $data['status']);
    }

    public function testRollDice()
    {
        $response = file_get_contents($this->baseUrl . 'rolldice');
        $data = json_decode($response, true);
        $this->assertGreaterThanOrEqual(1, $data['dice']);
        $this->assertLessThanOrEqual(6, $data['dice']);
    }

    public function testGetCurrentSystemTime()
    {
        $response = file_get_contents($this->baseUrl . 'get_current_system_time');
        $data = json_decode($response, true);
        $this->assertArrayHasKey('time', $data);
        $this->assertMatchesRegularExpression('/^\d{4}:\d{2}:\d{2} \d{2}:\d{2}:\d{2}$/', $data['time']);
    }

    public function testGetUserInfo()
    {
        $response = file_get_contents($this->baseUrl . 'get_user_info');
        $data = json_decode($response, true);
        $this->assertArrayHasKey('user_id', $data);
        $this->assertArrayHasKey('first_name', $data);
        $this->assertArrayHasKey('age', $data);
    }
} 