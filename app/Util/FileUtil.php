<?php

namespace App\Util;

use App\Exceptions\Api\InvalidParametersException;
use App\Models\Attachment;
use App\Models\Company;
use App\Models\Remuneration;
use Illuminate\Support\Facades\Storage;
use mikehaertl\wkhtmlto\Pdf;
use RuntimeException;
use DateTimeImmutable;
use App\Util\DateUtil;
use App\Models\Profile;
use App\Enum\PropertyBagTypes;

/**
 * Class to handle the file processing
 * @author Gustavo Delgado <gustavo@onecore.cl>
 */
final class FileUtil
{
    /**
     * Validate a csv for columns names
     *
     * @param string $path
     * @param array  $columns
     * @return void
     */
    public static function validateCsv(string $path, array $columns)
    {
        if (!file_exists($path)) {
            throw new RuntimeException('File not found for path: ' . $path);
        }

        $handle = fopen($path, "r");

        $delimiter = self::detectDelimiter($handle);

        $data = fgetcsv($handle, 1000, $delimiter);

        fclose($handle);

        return count($data) === count($columns);
    }

    /**
     * Parse a CSV file into an array
     *
     * @param string  $path
     * @param array   $columns
     * @param boolean $fixInvalidColumns
     * @param integer $length
     * @return array
     */
    public static function fromCsvToArray(string $path, array $columns, bool $fixInvalidColumns = false, int $length = 1000): array
    {
        if (!file_exists($path)) {
            throw new RuntimeException('File not found for path: ' . $path);
        }

        $handle = fopen($path, "r");

        $output = [];

        $delimiter = self::detectDelimiter($handle);

        while (($data = fgetcsv($handle, $length, $delimiter)) !== false) {
            if (count($data) !== count($columns)) {
                if (!$fixInvalidColumns) {
                    throw new InvalidParametersException(['content' => 'Invalid columns']);
                } else {
                    $data = self::fixColumns($columns, $data);
                }
            }

            $output[] = array_combine($columns, array_values($data));
        }

        fclose($handle);

        unset($output[0]);

        return $output;
    }

    /**
     * Parse a String with csv format into an array
     *
     * @param array   $columns
     * @param boolean $fixInvalidColumns
     * @param array   $csvData
     * @return array
     */
    public static function StringCsvToArray(array $columns, bool $fixInvalidColumns = false, array $csvData) : array
    {
        $output = [];

        foreach($csvData as $data)
        {
            $data = str_getcsv($data, ";");

            if (count($data) !== count($columns)) {
                if (!$fixInvalidColumns) {
                    throw new InvalidParametersException(['content' => 'Invalid columns']);
                }
                else
                {
                    $data = self::fixColumns($columns, $data);
                }
            }

            $output[] = array_combine($columns, array_values($data));
        }

        unset($output[0]);

        return $output;
    }


    /**
     * Detect CSV delimiter
     *
     * @param string $handle  File handle
     * @return string
     */
    private static function detectDelimiter($handle): string
    {
        $delimiters = [";", ",", "\t", "|"];
        $data1 = [];
        $data2 = [];
        $delimiter = $delimiters[0];

        foreach ($delimiters as $d) {
            $data1 = fgetcsv($handle, 4096, $d);

            if (sizeof($data1) > sizeof($data2)) {
                $delimiter = sizeof($data1) > sizeof($data2) ? $d : $delimiter;
                $data2 = $data1;
            }

            rewind($handle);
        }

        return $delimiter;
    }

    /**
     * Fix csv columns
     *
     * @param array $columns
     * @param array $data
     * @return void
     */
    private static function fixColumns(array $columns, array $data)
    {
        if (count($columns) > count($data)) {
            $numberOfExtraColumns = count($columns) - count($data);

            foreach (range(0, $numberOfExtraColumns) as $index) {
                $data[] = null;
            }
        } else {
            $data = array_slice($data, 0, count($columns));
        }

        if (count($data) !== count($columns)) {
            throw new InvalidParametersException(['content' => 'Invalid columns']);
        }

        return $data;
    }

    /**
     * Move file from temp disk to final disk
     *
     * @return void
     */
    final public static function moveToFinalDisk(Attachment $attachment)
    {
        $fileName = $attachment->getFileName();

        if (Storage::disk(config('filesystems.temp_disk'))->exists($fileName)) {
            $file = Storage::disk(config('filesystems.temp_disk'))->get($fileName);

            Storage::disk(config('filesystems.final_disk'))->put($fileName, $file);

            Storage::disk(config('filesystems.temp_disk'))->delete($fileName);
        }
    }
}
