<?php

declare(strict_types=1);

namespace Tests\integration;

class TeamTest extends TestCase
{
    private static $id;

    public function testCreate()
    {
        $params = [
            '' => '',
            'name' => 'aaa'
        ];
        $app = $this->getAppInstance();
        $req = $this->createRequest('POST', '/team');
        $request = $req->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetAll()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/team');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOne()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/team/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOneNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/team/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdate()
    {
        $app = $this->getAppInstance();
        $req = $this->createRequest('PUT', '/team/' . self::$id);
        $request = $req->withParsedBody(['' => '']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDelete()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/team/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
