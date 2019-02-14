<?php

namespace Ahc\Plastic;

class Client
{
    protected $segments = [];
    protected $method   = 'GET';
    protected $pretty   = \false;
    protected $verbs    = ['GET', 'POST', 'PUT', 'DELETE'];

    public function __construct(bool $pretty = \false)
    {
        $this->pretty = $pretty;
    }

    public function __get(string $key): self
    {
        if (\in_array($verb = \strtoupper($key), $this->verbs, \true)) {
            $this->method = $verb;
        } else {
            $this->segments[] = $key;
        }

        return $this;
    }

    public function __call(string $method, array $data = [])
    {
        $this->segments[] = \ltrim($method, '_');

        $segments = \implode('/', $this->segments);
        $method   = $this->method;

        $this->segments = [];
        $this->method   = 'GET';

        return $this->call($method, $segments, $this->prepare($method, $data));
    }

    private function prepare(string $method, array $data): string
    {
        if (empty($data[0])) {
            return '';
        }

        if ($method === 'GET') {
            return \http_build_query($data[0]);
        } elseif ($method === 'POST') {
            return \json_encode($data[0]);
        }
    }

    private function call(string $method, string $segments, string $data)
    {
        $curl = "curl --silent -X $method 'http://localhost:9200/$segments?";

        if ($this->pretty) {
            $curl .= 'pretty=true&';
        }

        if ($method === 'GET') {
            $curl .= $data . "'";
        } elseif ($method === 'POST') {
            $curl .= "' -H 'content-type: application/json' -d '$data'";
        }

        return shell_exec($curl);
    }
}
