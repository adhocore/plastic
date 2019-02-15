<?php

namespace Ahc\Plastic;

class Client
{
    protected $segments = [];
    protected $method   = 'GET';
    protected $pretty   = \false;
    protected $hasBody  = \false;
    protected $host     = 'http://localhost:9200';
    protected $verbs    = ['GET', 'POST', 'PUT', 'DELETE', 'HEAD'];

    public function __construct(string $host = \null, bool $pretty = \false)
    {
        if ($host !== null) {
            $this->host = $host;
        }

        $this->pretty = $pretty;
    }

    public function __get(string $key): self
    {
        if (\in_array($verb = \strtoupper($key), $this->verbs, \true)) {
            $this->reset($verb);
        } else {
            $this->segments[] = $this->getPart($key);
        }

        return $this;
    }

    public function __call(string $method, array $data = [])
    {
        $this->segments[] = $this->getPart($method);

        list($data, $params) = $this->prepareData($data);

        return $this->call($data, $params);
    }

    protected function reset(string $verb)
    {
        $this->segments = [];
        $this->method   = $verb;
        $this->hasBody  = $verb === 'POST' || $verb === 'PUT';
    }

    protected function getPart(string $part): string
    {
        return \preg_match('/^_(\d+)$/', $part) ? \substr($part, 1) : $part;
    }

    protected function prepareData(array $data): array
    {
        if ($this->pretty) {
            $data[1]['pretty'] = 'true';
        }

        $params = empty($data[1]) ? '' : $this->asQuery($data[1]);
        $data   = empty($data[0]) ? '' : $this->serialize($data[0]);

        return [$data, $params];
    }

    protected function serialize($data): string
    {
        $data = $this->hasBody ? $this->asJson($data) : $this->asQuery($data);
        $data = \str_replace('"', '\"', $data);

        return $data;
    }

    protected function asJson($data): string
    {
        return \json_encode($data);
    }

    protected function asQuery($data): string
    {
        return \http_build_query($data);
    }

    protected function call(string $data, string $params)
    {
        $curl = "curl --silent -X {$this->method}";
        $url  = "{$this->host}/{$this->uri()}?{$params}";

        if ($this->hasBody) {
            $curl .= ' -H "content-type: application/json" -d "' . $data . '"';
        } else {
            $url .= "&{$data}";
        }

        $curl .= ' "' . $url . '"';

        return \shell_exec($curl);
    }

    protected function uri(): string
    {
        return \implode('/', $this->segments);
    }
}
