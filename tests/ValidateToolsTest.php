<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Helpers\ValidateTools;
use App\Helpers\Tools;


class ValidateToolsTest extends TestCase{
	public function test_toStr(){
        $inputObj = New Foo;
        $inputArray = ['1', 2];
        $inputHashArray = ['key' => 'value'];

        $input = 'string';
        $output = ValidateTools::toStr($input);
        $result = $output === 'string';
        $this->assertTrue($result);

        $input = '';
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = 'null';
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = 'Null';
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = 'NULL';
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = 123;
        $output = ValidateTools::toStr($input);
        $result = $output === '123';
        $this->assertTrue($result);

        $input = true;
        $output = ValidateTools::toStr($input);
        $result = $output === '1';
        $this->assertTrue($result);

        $input = false;
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = 1.23;
        $output = ValidateTools::toStr($input);
        $result = $output === '1.23';
        $this->assertTrue($result);

        $input = 0xff;
        $output = ValidateTools::toStr($input);
        $result = $output === '255';
        $this->assertTrue($result);

        $input = null;
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = $inputObj;
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = $inputArray;
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);

        $input = $inputHashArray;
        $output = ValidateTools::toStr($input);
        $result = $output === '';
        $this->assertTrue($result);
    }

    public function test_toBool(){
        $inputObj = New Foo;
        $inputArray = ['1', 2];
        $inputEmptyArray = [];
        $inputHashArray = ['key' => 'value'];

        $input = 'string';
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);

        $input = '';
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 'null';
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 'Null';
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 'NULL';
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 'false';
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 'False';
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 'FALSE';
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 123;
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);

        $input = true;
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);

        $input = false;
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = 1.23;
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);

        $input = 0xff;
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);

        $input = null;
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = $inputObj;
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);

        $input = $inputArray;
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);

        $input = $inputEmptyArray;
        $output = ValidateTools::toBool($input);
        $result = $output === false;
        $this->assertTrue($result);

        $input = $inputHashArray;
        $output = ValidateTools::toBool($input);
        $result = $output === true;
        $this->assertTrue($result);
    }

    public function test_toInt(){
        $inputObj = New Foo;
        $inputArray = ['1', 2];
        $inputEmptyArray = [];
        $inputHashArray = ['key' => 'value'];

        $input = 'string';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = '';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 'null';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 'Null';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 'NULL';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 'false';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 'False';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 'FALSE';
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 123;
        $output = ValidateTools::toInt($input);
        $result = $output === 123;
        $this->assertTrue($result);

        $input = '123';
        $output = ValidateTools::toInt($input);
        $result = $output === 123;
        $this->assertTrue($result);

        $input = true;
        $output = ValidateTools::toInt($input);
        $result = $output === 1;
        $this->assertTrue($result);

        $input = false;
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = 1.23;
        $output = ValidateTools::toInt($input);
        $result = $output === 1;
        $this->assertTrue($result);

        $input = 0xff;
        $output = ValidateTools::toInt($input);
        $result = $output === 255;
        $this->assertTrue($result);

        $input = null;
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = $inputObj;
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = $inputArray;
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = $inputEmptyArray;
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);

        $input = $inputHashArray;
        $output = ValidateTools::toInt($input);
        $result = $output === 0;
        $this->assertTrue($result);
    }

    public function test_toFloat(){
        $inputObj = New Foo;
        $inputArray = ['1', 2];
        $inputEmptyArray = [];
        $inputHashArray = ['key' => 'value'];

        $input = 'string';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = '';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 'null';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 'Null';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 'NULL';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 'false';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 'False';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 'FALSE';
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 123;
        $output = ValidateTools::toFloat($input);
        $result = $output === 123.0;
        $this->assertTrue($result);

        $input = true;
        $output = ValidateTools::toFloat($input);
        $result = $output === 1.0;
        $this->assertTrue($result);

        $input = false;
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = 1.23;
        $output = ValidateTools::toFloat($input);
        $result = $output === 1.23;
        $this->assertTrue($result);

        $input = '1.23';
        $output = ValidateTools::toFloat($input);
        $result = $output === 1.23;
        $this->assertTrue($result);

        $input = 0xff;
        $output = ValidateTools::toFloat($input);
        $result = $output === 255.0;
        $this->assertTrue($result);

        $input = null;
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = $inputObj;
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = $inputArray;
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = $inputEmptyArray;
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);

        $input = $inputHashArray;
        $output = ValidateTools::toFloat($input);
        $result = $output === 0.0;
        $this->assertTrue($result);
    }

    public function test_toDate(){
        $input = '2009-01-08';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '2009-1-8';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '2009/01/08';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '2009/1/8';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '2009/1/8 00:00:00';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '2009/1/8 05:30:49';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '2009/1/8 24:30:49';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090109;
        $this->assertTrue($result);

        $input = '2009/1/8 0:0:49';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '2009/1/8 0:0:0';
        $output = ValidateTools::toDate($input);
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '08-01-2009';
        $output = ValidateTools::toDate($input, 'd-m-Y');
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '8-1-2009';
        $output = ValidateTools::toDate($input, 'd-m-Y');
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = '8-1-2009 0:0:0';
        $output = ValidateTools::toDate($input, 'd-m-Y');
        $output = Tools::carbonToYearMonthDay($output);
        $result = $output === 20090108;
        $this->assertTrue($result);

        $input = [];
        $output = ValidateTools::toDate($input, 'd-m-Y');
        $result = $output === null;
        $this->assertTrue($result);

        $input = 1;
        $output = ValidateTools::toDate($input, 'd-m-Y');
        $result = $output === null;
        $this->assertTrue($result);
    }

    public function test_validateInput(){
        $expect = [
            'success' => true,
            'data' => [
                'title' => 'hello',
                'tax' => 0.1,
                'approve' => true,
                'date' => 20160809,
                'order' => 1,
            ]
        ];
        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];



        $input = [
            'title' => 'hello',
            'tax' => 0.1,
            'approve' => true,
            'date' => '2016/08/09',
            'order' => 1,
        ];
        $output = ValidateTools::validateData($input, $fieldDescriptions);
        $output['data']['date'] = Tools::carbonToYearMonthDay($output['data']['date']);
        $result = $output === $expect;
        $this->assertTrue($result);

        $input = [
            'title' => 'hello',
            'tax' => '0.1',
            'approve' => 'true',
            'date' => '2016/08/09',
            'order' => '1',
        ];
        $output = ValidateTools::validateData($input, $fieldDescriptions);
        $output['data']['date'] = Tools::carbonToYearMonthDay($output['data']['date']);
        $result = $output === $expect;
        $this->assertTrue($result);
    }

    public function test_parseRules(){
        $input = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $expect = [
            "rules" => [
                'title' => 'required|max:150',
                'tax' => 'required',
            ],
            "dataRules" => [
                'title' => 'str',
                'tax' => 'float',
                'approve' => 'bool',
                'order' => 'int',
                'date' => 'date',
            ]
        ];

        $output = ValidateTools::parseRules($input);
        $result = $output === $expect;
        $this->assertTrue($result);
    }

    public function test_getRules(){
        $input = [
            'title' => 'required|max:150',
            'tax' => 'required',
        ];

        $expect = [
            'title' => 'required|max:150',
            'tax' => 'required',
        ];
        $output = ValidateTools::getRules($input);
        $result = $output === $expect;
        $this->assertTrue($result);

        $expect = [
            'title' => 'required|max:150',
            'tax' => 'required',
        ];
        $output = ValidateTools::getRules($input, []);
        $result = $output === $expect;
        $this->assertTrue($result);

        $expect = [
            'title' => 'required|max:150',
        ];
        $output = ValidateTools::getRules($input, ['title']);
        $result = $output === $expect;
        $this->assertTrue($result);
    }

    public function test_checkRules(){
        # Case success
        $input = [
            'title' => 'hello',
            'tax' => '0.1'
        ];

        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $onlyField = [];
        $excludeField = [];


        $expect = false;
        $output = ValidateTools::checkRules($input, $fieldDescriptions, $onlyField, $excludeField);
        $result = $output === $expect;
        $this->assertTrue($result);


        # Case fail: missing required
        $input = [
            'title' => '', # Error here (required)
            'tax' => '0.1'
        ];

        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $onlyField = [];
        $excludeField = [];


        $expect = false;
        $output = ValidateTools::checkRules($input, $fieldDescriptions, $onlyField, $excludeField);
        $result = $output['success'] === false;
        $this->assertTrue($result);


        # Case success with specific field
        $input = [
            'title' => 'hello', # Error here (required)
            'tax' => '0.1'
        ];

        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $onlyField = ['title'];
        $excludeField = [];


        $expect = false;
        $output = ValidateTools::checkRules($input, $fieldDescriptions, $onlyField, $excludeField);
        $result = $output === false;
        $this->assertTrue($result);


        # Case success with specific field
        $input = [
            'title' => '', # Error here (required)
            'tax' => '0.1'
        ];

        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $onlyField = ['tax'];
        $excludeField = [];


        $expect = false;
        $output = ValidateTools::checkRules($input, $fieldDescriptions, $onlyField, $excludeField);
        $result = $output === false;
        $this->assertTrue($result);


        # Case fail: missing required with specific field
        $input = [
            'title' => '', # Error here (required)
            'tax' => '0.1'
        ];

        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $onlyField = ['title'];
        $excludeField = [];


        $expect = false;
        $output = ValidateTools::checkRules($input, $fieldDescriptions, $onlyField, $excludeField);

        $result = $output['success'] === false;
        $this->assertTrue($result);
    }

    public function test_validateData(){
        $input = [
            'title' => 'hello',
            'tax' => '0.1',
            'approve' => 'false',
            'order' => '5'
        ];

        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $onlyField = [];
        $excludeField = [];


        $eput = [
            'success' => true,
            'data' => [
                'title' => 'hello',
                'tax' => 0.1,
                'approve' => false,
                'order' => 5
            ]
        ];
        $output = ValidateTools::validateData($input, $fieldDescriptions, $onlyField, $excludeField);
        $this->assertEquals($output, $eput);


        $input = [
            'title' => '',
            'tax' => '0.1',
            'approve' => 'false',
            'order' => '5'
        ];

        $fieldDescriptions = [
            'title' => 'str,required|max:150',
            'tax' => 'float,required',
            'approve' => 'bool',
            'order' => 'int',
            'date' => 'date',
        ];

        $onlyField = [];
        $excludeField = [];

        $output = ValidateTools::validateData($input, $fieldDescriptions, $onlyField, $excludeField);
        $result = $output['success'] === false;
        $this->assertTrue($result);
    }
}
