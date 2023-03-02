<?php declare(strict_types=1);

use NormanHuth\Helpers\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    public function testAfter(): void
    {
        $slice = Str::after('This is my name', 'This is');
        self::assertSame(' my name', $slice);
    }

    public function testAfterLast(): void
    {
        $slice = Str::afterLast('App\Http\Controllers\Controller', '\\');
        self::assertSame('Controller', $slice);
    }

    public function testAscii(): void
    {
        $slice = Str::ascii('û');
        self::assertSame('u', $slice);
    }

    public function testBefore(): void
    {
        $slice = Str::before('This is my name', 'my name');
        self::assertSame('This is ', $slice);
    }

    public function testBeforeLast(): void
    {
        $slice = Str::beforeLast('This is my name', 'is');
        self::assertSame('This ', $slice);
    }

    public function testBetween(): void
    {
        $slice = Str::between('This is my name', 'This', 'name');
        self::assertSame(' is my ', $slice);
    }

    public function testBetweenFirst(): void
    {
        $slice = Str::betweenFirst('[a] bc [d]', '[', ']');
        self::assertSame('a', $slice);
    }

    public function testCamel(): void
    {
        $converted = Str::camel('foo_bar');
        self::assertSame('fooBar', $converted);
    }

    public function testContains(): void
    {
        $contains = Str::contains('This is my name', 'my');
        self::assertTrue($contains);

        $contains = Str::contains('This is my name', ['my', 'foo']);
        self::assertTrue($contains);
    }

    public function testContainsAll(): void
    {
        $containsAll = Str::containsAll('This is my name', ['my', 'name']);
        self::assertTrue($containsAll);
    }

    public function testEndsWith(): void
    {
        $result = Str::endsWith('This is my name', 'name');
        self::assertTrue($result);

        $result = Str::endsWith('This is my name', ['name', 'foo']);
        self::assertTrue($result);

        $result = Str::endsWith('This is my name', ['this', 'foo']);
        self::assertFalse($result);
    }

    public function testExcerpt(): void
    {
        $excerpt = Str::excerpt('This is my name', 'my', [
            'radius' => 3
        ]);
        self::assertSame('...is my na...', $excerpt);

        $excerpt = Str::excerpt('This is my name', 'name', [
            'radius'   => 3,
            'omission' => '(...) '
        ]);
        self::assertSame('(...) my name', $excerpt);
    }

    public function testFinish(): void
    {
        $adjusted = Str::finish('this/string', '/');
        self::assertSame('this/string/', $adjusted);

        $adjusted = Str::finish('this/string/', '/');
        self::assertSame('this/string/', $adjusted);
    }

    public function testHeadline(): void
    {
        $headline = Str::headline('steve_jobs');
        self::assertSame('Steve Jobs', $headline);

        $headline = Str::headline('EmailNotificationSent');
        self::assertSame('Email Notification Sent', $headline);
    }

    public function testInlineMarkdown(): void
    {
        $html = Str::inlineMarkdown('**Laravel**');
        self::assertSame('<strong>Laravel</strong>', trim($html));
    }

    public function testIs(): void
    {
        $matches = Str::is('foo*', 'foobar');
        self::assertTrue($matches);

        $matches = Str::is('baz*', 'foobar');
        self::assertFalse($matches);
    }

    public function testIsAscii(): void
    {
        $isAscii = Str::isAscii('Taylor');
        self::assertTrue($isAscii);

        $isAscii = Str::isAscii('ü');
        self::assertFalse($isAscii);
    }

    public function testIsJson(): void
    {
        $result = Str::isJson('[1,2,3]');
        self::assertTrue($result);

        $result = Str::isJson('{"first": "John", "last": "Doe"}');
        self::assertTrue($result);

        $result = Str::isJson('{first: "John", last: "Doe"}');
        self::assertFalse($result);
    }

    public function testIsUlid(): void
    {
        $isUlid = Str::isUlid('01gd6r360bp37zj17nxb55yv40');
        self::assertTrue($isUlid);

        $isUlid = Str::isUlid('laravel');
        self::assertFalse($isUlid);
    }

    public function testIsUuid(): void
    {
        $isUuid = Str::isUuid('a0a2a2d2-0b87-4a18-83f2-2529882be2de');
        self::assertTrue($isUuid);

        $isUuid = Str::isUuid('laravel');
        self::assertFalse($isUuid);
    }

    public function testKebab(): void
    {
        $converted = Str::kebab('fooBar');
        self::assertSame('foo-bar', $converted);
    }

    public function testLcfirst(): void
    {
        $string = Str::lcfirst('Foo Bar');
        self::assertSame('foo Bar', $string);
    }

    public function testLength(): void
    {
        $length = Str::length('Laravel');
        self::assertSame(7, $length);
    }

    public function testLimit(): void
    {
        $truncated = Str::limit('The quick brown fox jumps over the lazy dog', 20);
        self::assertSame('The quick brown fox...', $truncated);
    }

    public function testLower(): void
    {
        $converted = Str::lower('LARAVEL');
        self::assertSame('laravel', $converted);
    }

    public function testMarkdown(): void
    {
        $html = Str::markdown('# Laravel');
        self::assertSame('<h1>Laravel</h1>', trim($html));

        $html = Str::markdown('# Taylor <b>Otwell</b>', [
            'html_input' => 'strip',
        ]);
        self::assertSame('<h1>Taylor Otwell</h1>', trim($html));
    }

    public function testMask(): void
    {
        $string = Str::mask('taylor@example.com', '*', 3);
        self::assertSame('tay***************', $string);

        $string = Str::mask('taylor@example.com', '*', -15, 3);
        self::assertSame('tay***@example.com', $string);
    }

    public function testOrderedUuid(): void
    {
        $string = (string) Str::orderedUuid();
        self::assertIsString($string);
    }

    public function testPadBoth(): void
    {
        $padded = Str::padBoth('James', 10, '_');
        self::assertSame('__James___', $padded);

        $padded = Str::padBoth('James', 10);
        self::assertSame('  James   ', $padded);
    }

    public function testPadLeft(): void
    {
        $padded = Str::padLeft('James', 10, '-=');
        self::assertSame('-=-=-James', $padded);

        $padded = Str::padLeft('James', 10);
        self::assertSame('     James', $padded);
    }

    public function testPadRight(): void
    {
        $padded = Str::padRight('James', 10, '-');
        self::assertSame('James-----', $padded);

        $padded = Str::padRight('James', 10);
        self::assertSame('James     ', $padded);
    }

    public function testPassword(): void
    {
        $password = Str::password();
        self::assertIsString($password);
        self::assertEquals(32, strlen($password));

        $password = Str::password(12);;
        self::assertIsString($password);
        self::assertEquals(12, strlen($password));
    }

    public function testPlural(): void
    {
        $plural = Str::plural('car');
        self::assertSame('cars', $plural);

        $plural = Str::plural('child');
        self::assertSame('children', $plural);
    }

    public function testPluralStudly(): void
    {
        $plural = Str::pluralStudly('VerifiedHuman');
        self::assertSame('VerifiedHumans', $plural);

        $plural = Str::pluralStudly('UserFeedback');
        self::assertSame('UserFeedback', $plural);

        $plural = Str::pluralStudly('VerifiedHuman', 2);
        self::assertSame('VerifiedHumans', $plural);

        $plural = Str::pluralStudly('VerifiedHuman', 1);
        self::assertSame('VerifiedHuman', $plural);
    }

    public function testRandom(): void
    {
        $random = Str::random(40);
        self::assertIsString($random);
        self::assertEquals(40, strlen($random));
    }

    public function testRemove(): void
    {
        $string = 'Peter Piper picked a peck of pickled peppers.';
        $removed = Str::remove('e', $string);
        self::assertSame('Ptr Pipr pickd a pck of pickld ppprs.', $removed);
    }

    public function testReplace(): void
    {
        $string = 'Laravel 8.x';
        $replaced = Str::replace('8.x', '9.x', $string);
        self::assertSame('Laravel 9.x', $replaced);
    }

    public function testReplaceArray(): void
    {
        $string = 'The event will take place between ? and ?';
        $replaced = Str::replaceArray('?', ['8:30', '9:00'], $string);
        self::assertSame('The event will take place between 8:30 and 9:00', $replaced);
    }

    public function testReplaceFirst(): void
    {
        $replaced = Str::replaceFirst('the', 'a', 'the quick brown fox jumps over the lazy dog');
        self::assertSame('a quick brown fox jumps over the lazy dog', $replaced);
    }

    public function testReplaceLast(): void
    {
        $replaced = Str::replaceLast('the', 'a', 'the quick brown fox jumps over the lazy dog');
        self::assertSame('the quick brown fox jumps over a lazy dog', $replaced);
    }

    public function testReverse(): void
    {
        $reversed = Str::reverse('Hello World');
        self::assertSame('dlroW olleH', $reversed);
    }

    public function testSingular(): void
    {
        $singular = Str::singular('cars');
        self::assertSame('car', $singular);

        $singular = Str::singular('children');
        self::assertSame('child', $singular);
    }

    public function testSlug(): void
    {
        $slug = Str::slug('Laravel 5 Framework', '-');
        self::assertSame('laravel-5-framework', $slug);
    }

    public function testSnake(): void
    {
        $converted = Str::snake('fooBar');
        self::assertSame('foo_bar', $converted);

        $converted = Str::snake('fooBar', '-');
        self::assertSame('foo-bar', $converted);
    }

    public function testSquish(): void
    {
        $string = Str::squish('    laravel    framework    ');
        self::assertSame('laravel framework', $string);
    }

    public function testStart(): void
    {
        $adjusted = Str::start('this/string', '/');
        self::assertSame('/this/string', $adjusted);

        $adjusted = Str::start('/this/string', '/');
        self::assertSame('/this/string', $adjusted);
    }

    public function testStartsWith(): void
    {
        $result = Str::startsWith('This is my name', 'This');
        self::assertTrue($result);

        $result = Str::startsWith('This is my name', ['This', 'That', 'There']);
        self::assertTrue($result);
    }

    public function testStudly(): void
    {
        $converted = Str::studly('foo_bar');
        self::assertSame('FooBar', $converted);
    }

    public function testSubstr(): void
    {
        $converted = Str::substr('The Laravel Framework', 4, 7);
        self::assertSame('Laravel', $converted);
    }

    public function testSubstrCount(): void
    {
        $count = Str::substrCount('If you like ice cream, you will like snow cones.', 'like');
        self::assertSame(2, $count);
    }

    public function testSubstrReplace(): void
    {
        $result = Str::substrReplace('1300', ':', 2);
        self::assertSame('13:', $result);

        $result = Str::substrReplace('1300', ':', 2, 0);
        self::assertSame('13:00', $result);
    }

    public function testSwap(): void
    {
        $string = Str::swap([
            'Tacos' => 'Burritos',
            'great' => 'fantastic',
        ], 'Tacos are great!');
        self::assertSame('Burritos are fantastic!', $string);
    }

    public function testTitle(): void
    {
        $converted = Str::title('a nice title uses the correct case');
        self::assertSame('A Nice Title Uses The Correct Case', $converted);
    }

    public function testToHtmlString(): void
    {
        $htmlString = Str::of('Nuno Maduro')->toHtmlString();
        self::assertInstanceOf(\Illuminate\Support\HtmlString::class, $htmlString);
    }

    public function testUcfirst(): void
    {
        $string = Str::ucfirst('foo bar');
        self::assertSame('Foo bar', $string);
    }

    public function testUcsplit(): void
    {
        $segments = Str::ucsplit('FooBar');
        self::assertSame([0 => 'Foo', 1 => 'Bar'], $segments);
    }

    public function testUpper(): void
    {
        $string = Str::upper('laravel');
        self::assertSame('LARAVEL', $string);
    }

    public function testUlid(): void
    {
        $string = (string) Str::ulid();
        self::assertIsString($string);
    }

    public function testUid(): void
    {
        $string = (string) Str::uuid();
        self::assertIsString($string);
    }

    public function testWordCount(): void
    {
        $count = Str::wordCount('Hello, world!');
        self::assertSame(2, $count);
    }

    public function testWords(): void
    {
        $string = Str::words('Perfectly balanced, as all things should be.', 3, ' >>>');
        self::assertSame('Perfectly balanced, as >>>', $string);
    }

    public function testSpaceBeforeCapitals(): void
    {
        $string = Str::spaceBeforeCapitals('AddWhitespaceBeforeEveryUpperChar');
        self::assertSame('Add Whitespace Before Every Upper Char', $string);
    }

    public function testHttpBuildQueryUrl(): void
    {
        $string = Str::httpBuildQueryUrl('https://huth.it', ['foo' => 'bar', 'one' => 'two']);
        self::assertSame('https://huth.it?foo=bar&one=two', $string);
    }

    public function testIndexNumber(): void
    {
        $result = Str::indexNumber(12);
        self::assertSame(0, $result);

        $result = Str::indexNumber(78);
        self::assertSame(0, $result);

        $result = Str::indexNumber(109);
        self::assertSame(100, $result);

        $result = Str::indexNumber(323);
        self::assertSame(300, $result);

        $result = Str::indexNumber(1230, 1000);
        self::assertSame(1000, $result);
    }

    public function testLastAnd(): void
    {
        $string = Str::lastAnd(['Jane', 'John', 'Norman']);
        self::assertSame('Jane, John and Norman', $string);

        $string = Str::lastAnd('Jane, John, Norman');
        self::assertSame('Jane, John and Norman', $string);
    }

    public function testGenerateSerialNo(): void
    {
        $string = Str::generateSerialNo();
        self::assertIsString($string);
        self::assertEquals(29, strlen($string));

        $string = Str::generateSerialNo(false, 3, 3, ' ');
        self::assertIsString($string);
        self::assertEquals(11, strlen($string));
    }

    public function testCeilUpNearest(): void
    {
        $result = Str::ceilUpNearest(23);
        self::assertSame(25.0, $result);

        $result = Str::ceilUpNearest(27, 10);
        self::assertSame(30.0, $result);
    }

    public function testFillDigits(): void
    {
        $string = Str::fillDigits(23);
        self::assertSame('00023', $string);

        $string = Str::fillDigits(23, 3);
        self::assertSame('023', $string);
    }

    public function testRandomHexColor(): void
    {
        $string = Str::randomHexColor();
        self::assertStringMatchesFormat('%x%x%x', $string);
    }

    public function testRandomHexColorPart(): void
    {
        $string = Str::randomHexColor();
        self::assertStringMatchesFormat('%x', $string);
    }

    public function testJsonPrettyEncode(): void
    {
        $array = ['foo' => 'bar', 'dog' => 'fur'];
        $string = Str::jsonPrettyEncode($array);
        self::assertIsString($string);
        self::assertSame($array, json_decode($string, true));
    }

    public function testEmojiToUnicode(): void
    {
        $string = Str::emojiToUnicode('😊');
        self::assertSame('U+1F60A', $string);
    }

    public function testGetDomain(): void
    {
        $string = Str::getDomain('https://huth.it/coffee');
        self::assertSame('huth.it', $string);
    }

    public function testNormalizeUserSubmit(): void
    {
        $string = Str::normalizeUserSubmit("Hi\n\nLorem Ipsum");
        self::assertEquals("Hi\n\nLorem Ipsum", $string);
    }
}
