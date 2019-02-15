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

$client = new Ahc\Plastic\Client(null, true);

foreach ($schools as $school) {
    $id = (string) $school['id'];

    // post a school with given id
    echo $client->post->schools->school->$id($school);

    // find a school by id
    echo $client->get->schools->school->$id();
}

echo $client->put->_cluster->settings([
    'persistent' => ['action.auto_create_index' => 'true'],
]);

$school3 = [
    'id'   => '3',
    'name' => 'City School 3',
    'addr' => 'City 3, Street 3, Province 3, Country 3',
    'tags' => ['school', '3'],
];

// Create using put
echo $client->put->schools->school->_3($school3, ['op_type' => 'create']);

// Get only source
echo $client->get->schools->school->_3->_source();
