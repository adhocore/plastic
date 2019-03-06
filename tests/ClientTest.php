<?php

/*
 * This file is part of the PLASTIC package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\Plastic\Test;

use Ahc\Plastic\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testConstructor()
    {
        $host = 'http://localhost:9200';

        $client = new Client($host, true);

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @dataProvider postSchoolProvider
     */
    public function testPostSchoolOnGivenId($school, $expected)
    {
        $client = new Client();

        $id = (string) $school['id'];

        $this->assertSame($expected, $client->post->schools->school->$id($school));
    }

    public function postSchoolProvider()
    {
        return [
            [
                [
                    'id'   => '1',
                    'name' => 'City School',
                    'addr' => 'City, Street, Province, Country',
                    'tags' => ['school', '1'],
                ],
                '{"_index":"schools","_type":"school","_id":"1","_version":1,"result":"created","_shards":{"total":2,"successful":1,"failed":0},"created":true}',
            ],
            [
                [
                    'id'   => '2',
                    'name' => 'City School 2',
                    'addr' => 'City 2, Street 2, Province 2, Country 2',
                    'tags' => ['school', '2'],
                ],
                '{"_index":"schools","_type":"school","_id":"2","_version":1,"result":"created","_shards":{"total":2,"successful":1,"failed":0},"created":true}',
            ],
        ];
    }
}
