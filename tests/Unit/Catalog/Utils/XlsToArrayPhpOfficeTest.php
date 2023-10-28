<?php

namespace App\Tests\Unit\Catalog\Utils;

use App\Catalog\Utils\XlsToArrayPhpOffice;
use PHPUnit\Framework\TestCase;
use function file_get_contents;

final class XlsToArrayPhpOfficeTest extends TestCase
{
    public function testNormalize(): void
    {
        $xlsToArray = new XlsToArrayPhpOffice();

        $content = file_get_contents(__DIR__ . '/sample.xlsx');
        $array = $xlsToArray->normalize($content);

        $this->assertCount(3, $array);
    }
}
