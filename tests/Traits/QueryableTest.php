<?php

namespace Tests\Traits;

use Tests\TestCase;
use Tests\TestModel;
use App\Traits\Queryable;
use Illuminate\Http\Request;

class QueryableTest extends TestCase
{
    public function testFilterWithFilterableFieldsSet()
    {
        $trait = new class {
            use Queryable;

            protected static $filterableFields = ['series', 'title', 'game'];
        };

        $inputQuery = TestModel::query();
        $mockRequest = $this->getMockBuilder(Request::class)
                            ->disableOriginalConstructor()
                            ->onlyMethods(['filled', 'query'])
                            ->getMock();

        $mockRequest->expects($this->atLeastOnce())
                    ->method('filled')
                    ->willReturnMap([
                        ['series', true],
                        ['title', true],
                        ['game', false]
                    ]);

        $outputQuery = $trait::scopeFilter($inputQuery, $mockRequest)->toSql();

        $this->assertStringContainsString('series', $outputQuery);
        $this->assertStringContainsString('title', $outputQuery);
        $this->assertStringNotContainsString('game', $outputQuery);
    }

    public function testFilterWithNoFilterableFields()
    {
        $trait = new class {
            use Queryable;
        };

        $inputQuery = TestModel::query();
        $mockRequest = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->onlyMethods(['filled'])
                        ->getMock();

        $mockRequest->expects($this->never())->method('filled');
        $outputQuery = $trait::scopeFilter($inputQuery, $mockRequest);

        $this->assertEquals($inputQuery, $outputQuery);
    }

    public function testSelectableWithFieldsQueryParamAbsent()
    {
        $trait = new class {
            use Queryable;
        };

        $inputQuery = TestModel::query();
        $mockRequest = $this->getMockBuilder(Request::class)
                            ->disableOriginalConstructor()
                            ->onlyMethods(['filled', 'query'])
                            ->getMock();

        $mockRequest->expects($this->any())
                    ->method('filled')
                    ->willReturn(false);

        $mockRequest->expects($this->never())
                    ->method('query');

        $outputQuery = $trait::scopeSelectable($inputQuery, $mockRequest);

        $this->assertEquals($inputQuery, $outputQuery);
    }

    public function testSelectableWithDefaultProhibitedFields()
    {
        $trait = new class {
            use Queryable;

            protected static function getColumnListing()
            {
                return ['id', 'email', 'name'];
            }
        };

        $inputQuery = TestModel::query();
        $mockRequest = $this->getMockBuilder(Request::class)
                            ->disableOriginalConstructor()
                            ->onlyMethods(['filled', 'query'])
                            ->getMock();

        $mockRequest->expects($this->any())
                    ->method('filled')
                    ->willReturn(true);

        $mockRequest->expects($this->any())
                    ->method('query')
                    ->willReturn('id,email,name');

        $outputQuery = $trait::scopeSelectable($inputQuery, $mockRequest)->toSql();

        $this->assertStringContainsString('name', $outputQuery);
        $this->assertStringNotContainsString('email', $outputQuery);
    }

    public function testSelectableWithNoProhibitedFields()
    {
        $trait = new class {
            use Queryable;

            protected static $prohibitedFields = [];
            protected static function getColumnListing()
            {
                return ['id', 'game', 'name'];
            }
        };

        $inputQuery = TestModel::query();
        $mockRequest = $this->getMockBuilder(Request::class)
                            ->disableOriginalConstructor()
                            ->onlyMethods(['filled', 'query'])
                            ->getMock();

        $mockRequest->expects($this->any())
                    ->method('filled')
                    ->willReturn(true);

        $mockRequest->expects($this->any())
                    ->method('query')
                    ->willReturn('id,game');

        $outputQuery = $trait::scopeSelectable($inputQuery, $mockRequest)->toSql();

        $this->assertStringContainsString('id', $outputQuery);
        $this->assertStringContainsString('game', $outputQuery);
        $this->assertStringNotContainsString('name', $outputQuery);
    }
}
