<?php

class CalculateApi
{
    protected $data;

    /**
     * CalculateApi constructor.
     * @param array $data
     */
    public function __construct(Array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $field
     * @param int $take
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getSum($field, $take = 1) : array
    {
        if ($take < 0) {
            throw new InvalidArgumentException('Second Argument must > 0');
        }

        if (is_string($field)) {
            if ($this->checkFieldWasExist($field)) {
                return array_map(function ($item) use ($field) {
                    return array_reduce($item, function($carry, $item) use ($field) {
                        return $carry + $item[$field];
                    });
                }, array_chunk($this->data, $take, true));
            } else {
                throw new InvalidArgumentException(sprintf('Field Error! Only Allow %s',
                    implode(' ', array_keys($this->data[0]))));
            }
        }
        if (is_array($field)) {
            $ret = [];
            foreach ($field as $key) {
                if ($this->checkFieldWasExist($key)) {
                    $ret[$key] = array_map(function ($item) use ($key) {
                        return array_reduce($item, function($carry, $item) use ($key) {
                            return $carry + $item[$key];
                        });
                    }, array_chunk($this->data, $take, true));
                } else {
                    throw new InvalidArgumentException(sprintf('Field Error! Only Allow %s',
                        implode(' ', array_keys($this->data[0]))));
                }
            }
            return $ret;
        } else {
            throw new InvalidArgumentException('First Argument must be Array Or String');
        }
    }

    /**
     * @param $field
     * @return bool
     */
    protected function checkFieldWasExist($field) : bool
    {
        return array_key_exists($field, $this->data[0]);
    }
}