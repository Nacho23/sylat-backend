<?php

namespace App\Http\Controllers\Api\Unit;

use Illuminate\Http\Request;
use App\Enum\FileExtensionTypes;
use App\Exceptions\Api\FileNotValid;
use App\Exceptions\Api\InvalidParametersException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ApiController;
use App\Repository\AttachmentRepository;
use App\Http\InputRules\ImportUserParse;
use App\Util\FileUtil;

/**
 * Class to handle import requests
 */
class ImportController extends ApiController
{
    /**
     * Create a import
     * @param  Request $request Request
     * @return Response
     */
    public function postCollection(Request $request, string $unitId): Response
    {
        $this->verify($request, [
            'file' => 'file|required',
        ]);

        $file = $request->file('file');

        $data = [
            'file_name' => $file->getClientOriginalName(),
            'content' => $file->get(),
            'extension' => $file->getClientOriginalExtension()
        ];

        $attachment = AttachmentRepository::create(
            $data,
            [FileExtensionTypes::CSV_MIMETYPE]
        );

        try
        {
            $keys = array_keys(ImportUserParse::user());
            $columns = array_values(ImportUserParse::user());

            // Validate csv
            $valid = FileUtil::validateCsv(
                AttachmentRepository::getPath($attachment, config('filesystems.temp_disk')),
                $columns
            );

            if (!$valid)
            {
                AttachmentRepository::delete($attachment);

                throw new FileNotValid('Archivo no valido');
            }

            $inputData = FileUtil::fromCsvToArray(
                AttachmentRepository::getPath($attachment, config('filesystems.temp_disk')),
                $keys,
                true
            );
        }
        catch (RuntimeException $e)
        {
            AttachmentRepository::delete($attachment);

            throw new InvalidParametersException(['content' => 'The file could not be created on the server, try again.']);
        }
        catch (InvalidArgumentException $e)
        {
            AttachmentRepository::delete($attachment);

            throw new InvalidParametersException(['content' => 'Invalid columns']);
        }

        //AGREGAR VALIDACIONES !!!!

        if (!$stats['status'])
        {
            $success = false;
            AttachmentRepository::delete($attachment);
        }

        unset($stats['status']);

        return $this->respond([
            'data' => [
                'attachment_uuid' => $attachment->uuid,
                'success' => $success,
                'stats' => $stats,
            ],
        ]);
    }
}
