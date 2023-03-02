<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use NormanHuth\Helpers\Arr;
use Illuminate\Support\Collection;

final class ArrTest extends TestCase
{
    public function testClean(): void
    {
        $array = Arr::clean(['name' => 'Norman', 'lastname' => '', 'phone' => null]);
        self::assertSame(['name' => 'Norman', 'lastname' => ''], $array);

        $array = Arr::clean(['name' => 'Norman', 'lastname' => '', 'phone' => null], true);
        self::assertSame(['name' => 'Norman'], $array);
    }

    public function testKeyMap(): void
    {
        $array = Arr::keyMap('ucfirst', ['cars' => 1, 'boats' => 0, 'bikes' => 2]);;
        self::assertSame(['Cars' => 1, 'Boats' => 0, 'Bikes' => 2], $array);
    }

    public function testAccessible(): void
    {
        $isAccessible = Arr::accessible(['a' => 1, 'b' => 2]);
        self::assertTrue($isAccessible);

        $isAccessible = Arr::accessible(new Collection);
        self::assertTrue($isAccessible);

        $isAccessible = Arr::accessible('abc');
        self::assertFalse($isAccessible);

        $isAccessible = Arr::accessible(new stdClass);
        self::assertFalse($isAccessible);
    }

    public function testAdd(): void
    {
        $array = Arr::add(['name' => 'Desk'], 'price', 100);
        self::assertSame(['name' => 'Desk', 'price' => 100], $array);

        $array = Arr::add(['name' => 'Desk', 'price' => null], 'price', 100);
        self::assertSame(['name' => 'Desk', 'price' => 100], $array);
    }

    public function testCollapse(): void
    {
        $array = Arr::collapse([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        self::assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], $array);
    }

    public function testCrossJoin(): void
    {
        $matrix = Arr::crossJoin([1, 2], ['a', 'b']);
        self::assertSame([
            [1, 'a'],
            [1, 'b'],
            [2, 'a'],
            [2, 'b'],
        ], $matrix);

        $matrix = Arr::crossJoin([1, 2], ['a', 'b'], ['I', 'II']);
        self::assertSame([
            [1, 'a', 'I'],
            [1, 'a', 'II'],
            [1, 'b', 'I'],
            [1, 'b', 'II'],
            [2, 'a', 'I'],
            [2, 'a', 'II'],
            [2, 'b', 'I'],
            [2, 'b', 'II'],
        ], $matrix);
    }

    public function testDivide(): void
    {
        [$keys, $values] = Arr::divide(['name' => 'Desk']);
        self::assertSame(['name'], $keys);
        self::assertSame(['Desk'], $values);
    }

    public function testDot(): void
    {
        $array = ['products' => ['desk' => ['price' => 100]]];

        $flattened = Arr::dot($array);
        self::assertSame(['products.desk.price' => 100], $flattened);
    }

    public function testExcept(): void
    {
        $array = ['name' => 'Desk', 'price' => 100];

        $filtered = Arr::except($array, ['price']);
        self::assertSame(['name' => 'Desk'], $filtered);
    }

    public function testExists(): void
    {
        $array = ['name' => 'John Doe', 'age' => 17];

        $exists = Arr::exists($array, 'name');
        self::assertTrue($exists);

        $exists = Arr::exists($array, 'salary');
        self::assertFalse($exists);
    }

    public function testFirst(): void
    {
        $array = [100, 200, 300];

        $first = Arr::first($array, function (int $value, int $key) {
            return $value >= 150;
        });
        self::assertSame(200, $first);
    }

    public function testFlattern(): void
    {
        $array = ['name' => 'Joe', 'languages' => ['PHP', 'Ruby']];

        $flattened = Arr::flatten($array);
        self::assertSame(['Joe', 'PHP', 'Ruby'], $flattened);
    }

    public function testForget(): void
    {
        $array = ['products' => ['desk' => ['price' => 100]]];

        Arr::forget($array, 'products.desk');
        self::assertSame(['products' => []], $array);
    }

    public function testGet(): void
    {
        $array = ['products' => ['desk' => ['price' => 100]]];

        $price = Arr::get($array, 'products.desk.price');
        self::assertSame(100, $price);

        $discount = Arr::get($array, 'products.desk.discount', 0);
        self::assertSame(0, $discount);
    }

    public function testHas(): void
    {
        $array = ['product' => ['name' => 'Desk', 'price' => 100]];

        $contains = Arr::has($array, 'product.name');
        self::assertTrue($contains);

        $contains = Arr::has($array, ['product.price', 'product.discount']);
        self::assertFalse($contains);
    }

    public function testHasAny(): void
    {
        $array = ['product' => ['name' => 'Desk', 'price' => 100]];

        $contains = Arr::hasAny($array, 'product.name');
        self::assertTrue($contains);

        $contains = Arr::hasAny($array, ['product.name', 'product.discount']);
        self::assertTrue($contains);

        $contains = Arr::hasAny($array, ['category', 'product.discount']);
        self::assertFalse($contains);
    }

    public function testIsAssoc(): void
    {
        $isAssoc = Arr::isAssoc(['product' => ['name' => 'Desk', 'price' => 100]]);
        self::assertTrue($isAssoc);

        $isAssoc = Arr::isAssoc([1, 2, 3]);
        self::assertFalse($isAssoc);
    }

    public function testIsList(): void
    {
        $isList = Arr::isList(['foo', 'bar', 'baz']);
        self::assertTrue($isList);

        $isList = Arr::isList(['product' => ['name' => 'Desk', 'price' => 100]]);
        self::assertFalse($isList);
    }

    public function testJoin(): void
    {
        $array = ['Tailwind', 'Alpine', 'Laravel', 'Livewire'];

        $joined = Arr::join($array, ', ');
        self::assertSame('Tailwind, Alpine, Laravel, Livewire', $joined);

        $joined = Arr::join($array, ', ', ' and ');
        self::assertSame('Tailwind, Alpine, Laravel and Livewire', $joined);
    }

    public function testKeyBy(): void
    {
        $array = [
            ['product_id' => 'prod-100', 'name' => 'Desk'],
            ['product_id' => 'prod-200', 'name' => 'Chair'],
        ];

        $keyed = Arr::keyBy($array, 'product_id');
        self::assertSame([
            'prod-100' => ['product_id' => 'prod-100', 'name' => 'Desk'],
            'prod-200' => ['product_id' => 'prod-200', 'name' => 'Chair'],
        ], $keyed);
    }

    public function testLast(): void
    {
        $array = [100, 200, 300, 110];

        $last = Arr::last($array, function (int $value, int $key) {
            return $value >= 150;
        });
        self::assertSame(300, $last);
    }

    public function testMap(): void
    {
        $array = ['first' => 'james', 'last' => 'kirk'];

        $mapped = Arr::map($array, function (string $value, string $key) {
            return ucfirst($value);
        });
        self::assertSame(['first' => 'James', 'last' => 'Kirk'], $mapped);
    }

    public function testOnly(): void
    {
        $array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];

        $slice = Arr::only($array, ['name', 'price']);
        self::assertSame(['name' => 'Desk', 'price' => 100], $slice);
    }

    public function testPluck(): void
    {
        $array = [
            ['developer' => ['id' => 1, 'name' => 'Taylor']],
            ['developer' => ['id' => 2, 'name' => 'Abigail']],
        ];

        $names = Arr::pluck($array, 'developer.name');
        self::assertSame(['Taylor', 'Abigail'], $names);

        $names = Arr::pluck($array, 'developer.name', 'developer.id');
        self::assertSame([1 => 'Taylor', 2 => 'Abigail'], $names);
    }

    public function testPrepend(): void
    {
        $array = ['one', 'two', 'three', 'four'];

        $array = Arr::prepend($array, 'zero');
        self::assertSame(['zero', 'one', 'two', 'three', 'four'], $array);

        $array = ['price' => 100];
        $array = Arr::prepend($array, 'Desk', 'name');
        self::assertSame(['name' => 'Desk', 'price' => 100], $array);
    }

    public function testPrependKeysWith(): void
    {
        $array = [
            'name'  => 'Desk',
            'price' => 100,
        ];
        $keyed = Arr::prependKeysWith($array, 'product.');
        self::assertSame([
            'product.name'  => 'Desk',
            'product.price' => 100,
        ], $keyed);
    }

    public function testPull(): void
    {
        $array = ['name' => 'Desk', 'price' => 100];

        $name = Arr::pull($array, 'name');
        self::assertSame('Desk', $name);
        self::assertSame(['price' => 100], $array);
    }

    public function testQuery(): void
    {
        $array = [
            'name'  => 'Taylor',
            'order' => [
                'column'    => 'created_at',
                'direction' => 'desc'
            ]
        ];

        $result = Arr::query($array);
        self::assertSame('name=Taylor&order[column]=created_at&order[direction]=desc', rawurldecode($result));
    }

    public function testRandom(): void
    {
        $array = [1, 2, 3, 4, 5];

        $random = Arr::random($array);
        self::assertContains($random, $array);
    }

    public function testSet(): void
    {
        $array = ['products' => ['desk' => ['price' => 100]]];

        Arr::set($array, 'products.desk.price', 200);
        self::assertSame(['products' => ['desk' => ['price' => 200]]], $array);
    }

    public function testShuffle(): void
    {
        $initArray = [1, 2, 3, 4, 5];
        $array = Arr::shuffle($initArray);
        self::assertIsArray($array);
        self::assertCount(5, $initArray);
        foreach ($array as $item) {
            self::assertContains($item, $array);
        }
    }

    public function testSort(): void
    {
        $array = ['Desk', 'Table', 'Chair'];

        $sorted = Arr::sort($array);
        self::assertSame(['Chair', 'Desk', 'Table'], array_values($sorted));

        $array = [
            ['name' => 'Desk'],
            ['name' => 'Table'],
            ['name' => 'Chair'],
        ];

        $sorted = array_values(Arr::sort($array, function (array $value) {
            return $value['name'];
        }));
        self::assertSame([
            ['name' => 'Chair'],
            ['name' => 'Desk'],
            ['name' => 'Table'],
        ], array_values($sorted));
    }

    public function testSortDesc(): void
    {
        $array = ['Desk', 'Table', 'Chair'];
        $sorted = Arr::sortDesc($array);
        self::assertSame(['Table', 'Desk', 'Chair'], array_values($sorted));

        $array = [
            ['name' => 'Desk'],
            ['name' => 'Table'],
            ['name' => 'Chair'],
        ];
        $sorted = array_values(Arr::sortDesc($array, function (array $value) {
            return $value['name'];
        }));
        self::assertSame([
            ['name' => 'Table'],
            ['name' => 'Desk'],
            ['name' => 'Chair'],
        ], array_values($sorted));
    }

    public function testSortRecursive(): void
    {
        $array = [
            ['Roman', 'Taylor', 'Li'],
            ['PHP', 'Ruby', 'JavaScript'],
            ['one' => 1, 'two' => 2, 'three' => 3],
        ];
        $sorted = Arr::sortRecursive($array);
        self::assertSame([
            ['JavaScript', 'PHP', 'Ruby'],
            ['one' => 1, 'three' => 3, 'two' => 2],
            ['Li', 'Roman', 'Taylor'],
        ], array_values($sorted));
    }

    public function testToCssClasses(): void
    {
        $array = ['p-4', 'font-bold' => false, 'bg-red' => true];
        $classes = Arr::toCssClasses($array);
        self::assertSame('p-4 bg-red', $classes);
    }

    public function testUndot(): void
    {
        $array = [
            'user.name' => 'Kevin Malone',
            'user.occupation' => 'Accountant',
        ];
        $array = Arr::undot($array);
        self::assertSame(['user' => ['name' => 'Kevin Malone', 'occupation' => 'Accountant']], $array);
    }

    public function testWhere(): void
    {
        $array = [100, '200', 300, '400', 500];
        $filtered = Arr::where($array, function (string|int $value, int $key) {
            return is_string($value);
        });
        self::assertSame([1 => '200', 3 => '400'], $filtered);
    }

    public function testWhereNotNull(): void
    {
        $array = [0, null];
        $filtered = Arr::whereNotNull($array);
        self::assertSame([0 => 0], $filtered);
    }

    public function testWrap(): void
    {
        $string = 'Laravel';

        $array = Arr::wrap($string);
        self::assertSame(['Laravel'], $array);

        $array = Arr::wrap(null);
        self::assertSame([], $array);
    }



}
