<?php

class CalculateApiTest extends PHPUnit_Framework_TestCase
{
    private $data = [];

    public function setUp()
    {
        $this->data = [
            ['id' => 1, 'cost' => 1, 'revenue' => 11, 'sellPrice' => 21],
            ['id' => 2, 'cost' => 2, 'revenue' => 12, 'sellPrice' => 21],
            ['id' => 3, 'cost' => 3, 'revenue' => 13, 'sellPrice' => 23],
            ['id' => 4, 'cost' => 4, 'revenue' => 14, 'sellPrice' => 24],
            ['id' => 5, 'cost' => 5, 'revenue' => 15, 'sellPrice' => 25],
            ['id' => 6, 'cost' => 6, 'revenue' => 16, 'sellPrice' => 26],
            ['id' => 7, 'cost' => 7, 'revenue' => 17, 'sellPrice' => 27],
            ['id' => 8, 'cost' => 8, 'revenue' => 18, 'sellPrice' => 28],
            ['id' => 9, 'cost' => 9, 'revenue' => 19, 'sellPrice' => 29],
            ['id' => 10, 'cost' => 10, 'revenue' => 20, 'sellPrice' => 30],
            ['id' => 11, 'cost' => 11, 'revenue' => 21, 'sellPrice' => 31]
        ];
    }

    public function test_Sum_Api_Take_Each_3_Cost_Data_To_Sum()
    {
        /** arrange */
        $target = new CalculateApi($this->data);
        $expected = [6, 15, 24, 21];

        /** act */
        $actual = $target->getSum('cost', 3);

        /** assert */
        $this->assertEquals($expected, $actual);
    }

    public function test_Sum_Api_Take_Each_4_Revenue_Data_To_Sum()
    {
        /** arrange */
        $target = new CalculateApi($this->data);
        $expected = [50, 66, 60];

        /** act */
        $actual = $target->getSum('revenue', 4);

        /** assert */
        $this->assertEquals($expected, $actual);
    }

    public function test_Sum_Api_By_Multi_field()
    {
        /** arrange */
        $target = new CalculateApi($this->data);
        $expected = [
            'cost' => [6, 15, 24, 21],
            'revenue' => [36, 45, 54, 41]
        ];

        /** act */
        $actual = $target->getSum(['cost', 'revenue'], 3);

        /** assert */
        $this->assertEquals($expected, $actual);
    }

    public function test_Sum_Api_if_input_wrong_field()
    {
        /** arrange */
        $target = new CalculateAPI($this->data);

        /** assert */
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field Error! Only Allow id cost revenue sellPrice');

        /** act */
        $target->getSum('profit', 3);
    }

    public function test_Sum_Api_if_input_negative()
    {
        /** arrange */
        $target = new CalculateAPI($this->data);

        /** assert */
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Second Argument must > 0');

        $target->getSum('profit', -1);
    }
}
