<?php

require_once __DIR__ . '/src/Client.php';

$schools = [[
    'id'   => '1',
    'name' => 'City School',
    'addr' => 'City, Street, Province, Country',
    'tags' => ['school', '1'],
], [
    'id'   => '2',
    'name' => 'City School 2',
    'addr' => 'City 2, Street 2, Province 2, Country 2',
    'tags' => ['school', '2'],
],
];

$client = new Ahc\Plastic\Client(true);

foreach ($schools as $school) {
    $id = (string) $school['id'];

    // post a school with given id
    echo $client->post->schools->school->$id($school);

    // find a school by id
    echo $client->get->schools->school->$id();
}
