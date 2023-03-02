<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class HelperTest extends TestCase
{
    public function test_data_fill(): void
    {
        $data = ['products' => ['desk' => ['price' => 100]]];

        data_fill($data, 'products.desk.price', 200);
        self::assertSame(['products' => ['desk' => ['price' => 100]]], $data);

        data_fill($data, 'products.desk.discount', 10);
        self::assertSame(['products' => ['desk' => ['price' => 100, 'discount' => 10]]], $data);

        $data = [
            'products' => [
                ['name' => 'Desk 1', 'price' => 100],
                ['name' => 'Desk 2'],
            ],
        ];
        data_fill($data, 'products.*.price', 200);
        self::assertSame([
            'products' => [
                ['name' => 'Desk 1', 'price' => 100],
                ['name' => 'Desk 2', 'price' => 200],
            ],
        ], $data);
    }

    public function test_data_get(): void
    {
        $data = ['products' => ['desk' => ['price' => 100]]];

        $price = data_get($data, 'products.desk.price');
        self::assertSame(100, $price);

        $discount = data_get($data, 'products.desk.discount', 0);
        self::assertSame(0, $discount);

        $data = [
            'product-one' => ['name' => 'Desk 1', 'price' => 100],
            'product-two' => ['name' => 'Desk 2', 'price' => 150],
        ];
        $result = data_get($data, '*.name');
        self::assertSame(['Desk 1', 'Desk 2'], $result);
    }

    public function test_data_set(): void
    {
        $data = ['products' => ['desk' => ['price' => 100]]];
        data_set($data, 'products.desk.price', 200);
        self::assertSame(['products' => ['desk' => ['price' => 200]]], $data);

        $data = [
            'products' => [
                ['name' => 'Desk 1', 'price' => 100],
                ['name' => 'Desk 2', 'price' => 150],
            ],
        ];
        data_set($data, 'products.*.price', 200);
        self::assertSame([
            'products' => [
                ['name' => 'Desk 1', 'price' => 200],
                ['name' => 'Desk 2', 'price' => 200],
            ],
        ], $data);

        $data = ['products' => ['desk' => ['price' => 100]]];
        data_set($data, 'products.desk.price', 200, overwrite: false);
        self::assertSame(['products' => ['desk' => ['price' => 100]]], $data);
    }

    public function test_head(): void
    {
        $array = [100, 200, 300];

        $first = head($array);
        self::assertSame(100, $first);
    }

    public function test_last(): void
    {
        $array = [100, 200, 300];

        $last = last($array);
        self::assertSame(300, $last);
    }

    public function test_class_basename(): void
    {
        $class = class_basename('Foo\Bar\Baz');
        self::assertSame('Baz', $class);
    }

    public function test_e(): void
    {
        $string = e('<html>foo</html>');
        self::assertSame('&lt;html&gt;foo&lt;/html&gt;', $string);
    }

    public function test_preg_replace_array(): void
    {
        $string = 'The event will take place between :start and :end';
        $replaced = preg_replace_array('/:[a-z_]+/', ['8:30', '9:00'], $string);
        self::assertSame('The event will take place between 8:30 and 9:00', $replaced);
    }

    public function test_str(): void
    {
        $stringable = str('Taylor')->append(' Otwell');
        self::assertSame('Taylor Otwell', $stringable->toString());

        $string = str()->snake('FooBar');
        self::assertSame('foo_bar', $string);
    }

    public function test_arrayClean(): void
    {
        $array = arrayClean(['name' => 'Norman', 'lastname' => '', 'phone' => null]);
        self::assertSame(['name' => 'Norman', 'lastname' => ''], $array);

        $array = arrayClean(['name' => 'Norman', 'lastname' => '', 'phone' => null], true);
        self::assertSame(['name' => 'Norman'], $array);
    }

    public function test_arrayKeyMap(): void
    {
        $array = arrayKeyMap('ucfirst', ['cars' => 1, 'boats' => 0, 'bikes' => 2]);;
        self::assertSame(['Cars' => 1, 'Boats' => 0, 'Bikes' => 2], $array);
    }

    public function test_strSlug(): void
    {
        $slug = strSlug('Laravel 5 Framework', '-');
        self::assertSame('laravel-5-framework', $slug);
    }

    public function test_ceilUpNearest(): void
    {
        $result = ceilUpNearest(23);
        self::assertSame(25.0, $result);

        $result = ceilUpNearest(27, 10);
        self::assertSame(30.0, $result);
    }

    public function test_fillDigits(): void
    {
        $string = fillDigits(23);
        self::assertSame('00023', $string);

        $string = fillDigits(23, 3);
        self::assertSame('023', $string);
    }

    public function test_indexNumber(): void
    {
        $result = indexNumber(12);
        self::assertSame(0, $result);

        $result = indexNumber(78);
        self::assertSame(0, $result);

        $result = indexNumber(109);
        self::assertSame(100, $result);

        $result = indexNumber(323);
        self::assertSame(300, $result);

        $result = indexNumber(1230, 1000);
        self::assertSame(1000, $result);
    }

    public function test_parseMarkdown(): void
    {
        $html = parseMarkdown('# Laravel');
        self::assertSame('<h1>Laravel</h1>', trim($html));

        $html = parseMarkdown('# Taylor <b>Otwell</b>', [
            'html_input' => 'strip',
        ]);
        self::assertSame('<h1>Taylor Otwell</h1>', trim($html));
    }

    public function test_jsonPrettyEncode(): void
    {
        $array = ['foo' => 'bar', 'dog' => 'fur'];
        $string = jsonPrettyEncode($array);
        self::assertIsString($string);
        self::assertSame($array, json_decode($string, true));
    }

    public function test_normalizeUserSubmit(): void
    {
        $string = normalizeUserSubmit("Hi\n\nLorem Ipsum");
        self::assertEquals("Hi\n\nLorem Ipsum", $string);
    }

    public function test_isJson(): void
    {
        $result = isJson('[1,2,3]');
        self::assertTrue($result);

        $result = isJson('{"first": "John", "last": "Doe"}');
        self::assertTrue($result);

        $result = isJson('{first: "John", last: "Doe"}');
        self::assertFalse($result);
    }

    public function test_httpBuildQueryUrl(): void
    {
        $string = httpBuildQueryUrl('https://huth.it', ['foo' => 'bar', 'one' => 'two']);
        self::assertSame('https://huth.it?foo=bar&one=two', $string);
    }

    public function test_now(): void
    {
        $result = now();

        self::assertInstanceOf(\Illuminate\Support\Carbon::class, $result);
        self::assertInstanceOf(\Carbon\Carbon::class, $result);
    }
}
