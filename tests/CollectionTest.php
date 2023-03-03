<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CollectionTest extends TestCase
{
    public function test_all(): void
    {
        $array = [1, 2, 3];
        $result = collect($array)->all();
        self::assertSame($array, $result);
    }

    public function test_avg(): void
    {
        $average = collect([
            ['foo' => 10],
            ['foo' => 10],
            ['foo' => 20],
            ['foo' => 40]
        ])->avg('foo');
        self::assertSame(20, $average);

        $average = collect([1, 1, 2, 4])->avg();
        self::assertSame(2, $average);
    }

    // Todo: Test chunk()
    // Todo: Test chunkWhile()

    public function test_collapse(): void
    {
        $collection = collect([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);
        $collapsed = $collection->collapse();
        self::assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], $collapsed->all());
    }

    public function test_combine(): void
    {
        $collection = collect(['name', 'age']);
        $combined = $collection->combine(['George', 29]);
        self::assertSame(['name' => 'George', 'age' => 29], $combined->all());
    }

    public function test_concat(): void
    {
        $collection = collect(['John Doe']);
        $concatenated = $collection->concat(['Jane Doe'])->concat(['name' => 'Johnny Doe']);
        self::assertSame(['John Doe', 'Jane Doe', 'Johnny Doe'], $concatenated->all());
    }

    public function test_contains(): void
    {
        $collection = collect(['name' => 'Desk', 'price' => 100]);
        self::assertTrue($collection->contains('Desk'));
        self::assertFalse($collection->contains('Berlin'));

        $collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
        ]);
        self::assertFalse($collection->contains('product', 'Bookcase'));
    }

    public function test_containsOneItem(): void
    {
        $contains = collect([])->containsOneItem();
        self::assertFalse($contains);

        $contains = collect(['1'])->containsOneItem();
        self::assertTrue($contains);


        $contains = collect(['1', '2'])->containsOneItem();
        self::assertFalse($contains);
    }

    public function test_count(): void
    {
        $collection = collect([1, 2, 3, 4]);
        self::assertSame(4, $collection->count());
    }

    public function test_countBy(): void
    {
        $collection = collect([1, 2, 2, 2, 3]);
        $counted = $collection->countBy();
        self::assertSame([1 => 1, 2 => 3, 3 => 1], $counted->all());

        $collection = collect(['alice@gmail.com', 'bob@yahoo.com', 'carlos@gmail.com']);
        $counted = $collection->countBy(function ($email) {
            return substr(strrchr($email, "@"), 1);
        });
        self::assertSame(['gmail.com' => 2, 'yahoo.com' => 1], $counted->all());
    }

    public function test_crossJoin(): void
    {
        $collection = collect([1, 2]);
        $matrix = $collection->crossJoin(['a', 'b']);
        self::assertSame([
            [1, 'a'],
            [1, 'b'],
            [2, 'a'],
            [2, 'b'],
        ], $matrix->all());

        $collection = collect([1, 2]);
        $matrix = $collection->crossJoin(['a', 'b'], ['I', 'II']);
        self::assertSame([
            [1, 'a', 'I'],
            [1, 'a', 'II'],
            [1, 'b', 'I'],
            [1, 'b', 'II'],
            [2, 'a', 'I'],
            [2, 'a', 'II'],
            [2, 'b', 'I'],
            [2, 'b', 'II'],
        ], $matrix->all());
    }

    public function test_diff(): void
    {
        $collection = collect([
            'color' => 'orange',
            'type' => 'fruit',
            'remain' => 6,
        ]);
        $diff = $collection->diffAssoc([
            'color' => 'yellow',
            'type' => 'fruit',
            'remain' => 3,
            'used' => 6,
        ]);
        self::assertSame(['color' => 'orange', 'remain' => 6], $diff->all());
    }

    public function test_diffKeys(): void
    {
        $collection = collect([
            'one' => 10,
            'two' => 20,
            'three' => 30,
            'four' => 40,
            'five' => 50,
        ]);
        $diff = $collection->diffKeys([
            'two' => 2,
            'four' => 4,
            'six' => 6,
            'eight' => 8,
        ]);
        self::assertSame(['one' => 10, 'three' => 30, 'five' => 50], $diff->all());
    }

    public function test_doesntContain(): void
    {
        $collection = collect([1, 2, 3, 4, 5]);
        $contains = $collection->doesntContain(function ($value, $key) {
            return $value < 5;
        });
        self::assertFalse($contains);

        $collection = collect(['name' => 'Desk', 'price' => 100]);
        $contains = $collection->doesntContain('Table');
        self::assertTrue($contains);
        $contains = $collection->doesntContain('Desk');
        self::assertFalse($contains);

        $collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
        ]);
        $contains = $collection->doesntContain('product', 'Bookcase');
        self::assertTrue($contains);
    }

    public function test_duplicates(): void
    {
        $collection = collect(['a', 'b', 'a', 'c', 'b']);
        self::assertSame([2 => 'a', 4 => 'b'], $collection->duplicates()->toArray());

        $employees = collect([
            ['email' => 'abigail@example.com', 'position' => 'Developer'],
            ['email' => 'james@example.com', 'position' => 'Designer'],
            ['email' => 'victoria@example.com', 'position' => 'Developer'],
        ]);
        self::assertSame([2 => 'Developer'], $employees->duplicates('position')->toArray());
    }

    public function test_every(): void
    {
        $result = collect([1, 2, 3, 4])->every(function ($value, $key) {
            return $value > 2;
        });
        self::assertFalse($result);

        $collection = collect([]);
        $result = $collection->every(function ($value, $key) {
            return $value > 2;
        });
        self::assertTrue($result);
    }

    public function test_except(): void
    {
        $collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);
        $filtered = $collection->except(['price', 'discount']);
        self::assertSame(['product_id' => 1], $filtered->toArray());
    }

    public function test_filter(): void
    {
        $collection = collect([1, 2, 3, 4]);
        $filtered = $collection->filter(function ($value, $key) {
            return $value > 2;
        });
        self::assertSame([3, 4], array_values($filtered->toArray()));

//        $collection = collect([1, 2, 3, null, false, '', 0, []]);
//        $collection->filter()->all();
//        self::assertSame([1, 2, 3], array_values($filtered->toArray()));
    }

    public function test_first(): void
    {
        $result = collect([1, 2, 3, 4])->first(function ($value, $key) {
            return $value > 2;
        });
        self::assertSame(3, $result);

        $result = collect([1, 2, 3, 4])->first();
        self::assertSame(1, $result);
    }

    public function test_firstOrFail(): void
    {
        self::expectException(\Illuminate\Support\ItemNotFoundException::class);
        collect([1, 2, 3, 4])->firstOrFail(function ($value, $key) {
            return $value > 5;
        });

        collect([])->firstOrFail();
    }

    public function test_firstWhere(): void
    {
        $collection = collect([
            ['name' => 'Regena', 'age' => null],
            ['name' => 'Linda', 'age' => 14],
            ['name' => 'Diego', 'age' => 23],
            ['name' => 'Linda', 'age' => 84],
        ]);
        self::assertSame(['name' => 'Linda', 'age' => 14], $collection->firstWhere('name', 'Linda'));
        self::assertSame(['name' => 'Diego', 'age' => 23], $collection->firstWhere('age', '>=', 18));
        self::assertSame(['name' => 'Linda', 'age' => 14], $collection->firstWhere('age'));
    }

    public function test_flatMap(): void
    {
        $collection = collect([
            ['name' => 'Sally'],
            ['school' => 'Arkansas'],
            ['age' => 28]
        ]);
        $flattened = $collection->flatMap(function ($values) {
            return array_map('strtoupper', $values);
        });
        self::assertSame(['name' => 'SALLY', 'school' => 'ARKANSAS', 'age' => '28'], $flattened->all());
    }

    public function test_flatten(): void
    {
        $collection = collect([
            'name' => 'taylor',
            'languages' => [
                'php', 'javascript'
            ]
        ]);
        $flattened = $collection->flatten();
        self::assertSame(['taylor', 'php', 'javascript'], $flattened->all());

        $collection = collect([
            'Apple' => [
                [
                    'name' => 'iPhone 6S',
                    'brand' => 'Apple'
                ],
            ],
            'Samsung' => [
                [
                    'name' => 'Galaxy S7',
                    'brand' => 'Samsung'
                ],
            ],
        ]);
        $products = $collection->flatten(1);
        self::assertSame([
            ['name' => 'iPhone 6S', 'brand' => 'Apple'],
            ['name' => 'Galaxy S7', 'brand' => 'Samsung'],
        ], $products->values()->all());
    }

    public function test_flip(): void
    {
        $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        $flipped = $collection->flip();
        self::assertSame(['taylor' => 'name', 'laravel' => 'framework'], $flipped->all());
    }

    public function test_forget(): void
    {
        $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        $collection->forget('name');
        self::assertSame(['framework' => 'laravel'], $collection->all());
    }

    public function test_forPage(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $chunk = $collection->forPage(2, 3);
        self::assertSame([4, 5, 6], array_values($chunk->all()));
    }

    public function test_get(): void
    {
        $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        $value = $collection->get('name');
        self::assertSame('taylor', $value);

        $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        $value = $collection->get('age', 34);
        self::assertSame(34, $value);

        $value = $collection->get('email', function () {
            return 'taylor@example.com';
        });
        self::assertSame('taylor@example.com', $value);
    }

    // Todo: test_groupBy

    public function test_has(): void
    {
        $collection = collect(['account_id' => 1, 'product' => 'Desk', 'amount' => 5]);
        self::assertTrue($collection->has('product'));
        self::assertTrue($collection->has(['product', 'amount']));
        self::assertFalse($collection->has(['amount', 'price']));
    }

    public function test_hasAny(): void
    {
        $collection = collect(['account_id' => 1, 'product' => 'Desk', 'amount' => 5]);
        self::assertTrue($collection->hasAny(['product', 'price']));
        self::assertFalse($collection->hasAny(['name', 'price']));
    }

    public function test_implode(): void
    {
        $collection = collect([
            ['account_id' => 1, 'product' => 'Desk'],
            ['account_id' => 2, 'product' => 'Chair'],
        ]);
        self::assertSame('Desk, Chair', $collection->implode('product', ', '));
        self::assertSame('1-2-3-4-5', collect([1, 2, 3, 4, 5])->implode('-'));
        self::assertSame('DESK, CHAIR', $collection->implode(function ($item, $key) {
            return strtoupper($item['product']);
        }, ', '));
    }

    public function test_intersect(): void
    {
        $collection = collect(['Desk', 'Sofa', 'Chair']);
        $intersect = $collection->intersect(['Desk', 'Chair', 'Bookcase']);
        self::assertSame([0 => 'Desk', 2 => 'Chair'], $intersect->all());
    }

    public function test_intersectByKeys(): void
    {
        $collection = collect([
            'serial' => 'UX301', 'type' => 'screen', 'year' => 2009,
        ]);
        $intersect = $collection->intersectByKeys([
            'reference' => 'UX404', 'type' => 'tab', 'year' => 2011,
        ]);
        self::assertSame(['type' => 'screen', 'year' => 2009], $intersect->all());
    }

    public function test_isEmpty(): void
    {
        self::assertTrue(collect([])->isEmpty());
    }

    public function test_isNotEmpty(): void
    {
        self::assertFalse(collect([])->isNotEmpty());
    }

    public function test_join(): void
    {
        self::assertSame('a, b, c', collect(['a', 'b', 'c'])->join(', '));
        self::assertSame('a, b, and c', collect(['a', 'b', 'c'])->join(', ', ', and '));
        self::assertSame('a and b', collect(['a', 'b'])->join(', ', ' and '));
        self::assertSame('a', collect(['a'])->join(', ', ' and '));
        self::assertSame('', collect([])->join(', ', ' and '));
    }

    public function test_keyBy(): void
    {
        $collection = collect([
            ['product_id' => 'prod-100', 'name' => 'Desk'],
            ['product_id' => 'prod-200', 'name' => 'Chair'],
        ]);

        $keyed = $collection->keyBy('product_id');
        self::assertSame([
            'prod-100' => ['product_id' => 'prod-100', 'name' => 'Desk'],
            'prod-200' => ['product_id' => 'prod-200', 'name' => 'Chair'],
        ], $keyed->all());

        $keyed = $collection->keyBy(function ($item, $key) {
            return strtoupper($item['product_id']);
        });
        self::assertSame([
            'PROD-100' => ['product_id' => 'prod-100', 'name' => 'Desk'],
            'PROD-200' => ['product_id' => 'prod-200', 'name' => 'Chair'],
        ], $keyed->all());
    }

    public function test_keys(): void
    {
        $collection = collect([
            'prod-100' => ['product_id' => 'prod-100', 'name' => 'Desk'],
            'prod-200' => ['product_id' => 'prod-200', 'name' => 'Chair'],
        ]);
        $keys = $collection->keys();
        self::assertSame(['prod-100', 'prod-200'], $keys->all());
    }

    public function test_last(): void
    {
        self::assertSame(2, collect([1, 2, 3, 4])->last(function ($value, $key) {
            return $value < 3;
        }));
        self::assertSame(4, collect([1, 2, 3, 4])->last());
    }

    public function test_map(): void
    {
        $collection = collect([1, 2, 3, 4, 5]);
        $multiplied = $collection->map(function ($item, $key) {
            return $item * 2;
        });
        self::assertSame([2, 4, 6, 8, 10], $multiplied->all());
    }

    // Todo: Test mapInto

    public function mapSpread(): void
    {
        $collection = collect([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $chunks = $collection->chunk(2);
        $sequence = $chunks->mapSpread(function ($even, $odd) {
            return $even + $odd;
        });
        self::assertSame([1, 5, 9, 13, 17], $sequence->all());
    }

    // Todo: Test mapToGroups

    public function test_mapWithKeys(): void
    {
        $collection = collect([
            [
                'name' => 'John',
                'department' => 'Sales',
                'email' => 'john@example.com',
            ],
            [
                'name' => 'Jane',
                'department' => 'Marketing',
                'email' => 'jane@example.com',
            ]
        ]);
        $keyed = $collection->mapWithKeys(function ($item, $key) {
            return [$item['email'] => $item['name']];
        });
        self::assertSame([
            'john@example.com' => 'John',
            'jane@example.com' => 'Jane',
        ], $keyed->all());
    }

    public function test_max(): void
    {
        self::assertSame(20, collect([
            ['foo' => 10],
            ['foo' => 20]
        ])->max('foo'));
        self::assertSame(5, collect([1, 2, 3, 4, 5])->max());
    }

    public function test_median(): void
    {
        self::assertSame(15, collect([
            ['foo' => 10],
            ['foo' => 10],
            ['foo' => 20],
            ['foo' => 40]
        ])->median('foo'));
        self::assertSame(1.5, collect([1, 1, 2, 4])->median());
    }
}
