<?php

declare(strict_types=1);

namespace App\Catalog\Utils;

use PhpOffice\PhpSpreadsheet\IOFactory;
use function array_slice;
use function array_values;

final class XlsToArrayPhpOffice implements XlsToArrayInterface
{

    public function normalize(string $content): array
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'xls_');
        file_put_contents($tempFile, $content);
        $spreadsheet = IOFactory::load($tempFile);

        $worksheet = $spreadsheet->getActiveSheet();

        // Convert the worksheet data to an array
        $data = $worksheet->toArray();
        unlink($tempFile);

        return array_values(array_slice($data, 1));
    }
}