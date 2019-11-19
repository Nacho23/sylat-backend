<?php

namespace App\Http\Controllers\Api\Unit;

use Illuminate\Http\Request;
use App\Enum\FileExtensionTypes;
use App\Enum\RolType;
use App\Exceptions\Api\FileNotValid;
use App\Exceptions\Api\InvalidParametersException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ApiController;
use App\Repository\AttachmentRepository;
use App\Repository\UserRepository;
use App\Models\UserRol;
use App\Repository\AccountRepository;
use App\Http\InputRules\ImportUserParse;
use App\Util\FileUtil;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
            'type' => ['required', Rule::in(RolType::ALLOWED)],
        ]);

        $type = $request['type'] == RolType::GODSON ? 3 : 4;

        $file = $request->file('file');

        $success = true;

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

            $this->addUsersFromCsv($inputData, $type, $unitId);
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

        AttachmentRepository::delete($attachment);

        return $this->respond([
            'data' => [
                'attachment_uuid' => $attachment->uuid,
                'success' => $success,
            ],
        ]);
    }

    private function addUsersFromCsv(array $usersData, int $rol_id, string $unitId)
    {
        try
        {
            DB::beginTransaction();

            foreach($usersData as $user)
            {
                $account = AccountRepository::add($user);

                $user = UserRepository::add($user + ['account_id' => $account->id, 'unit_id' => $unitId]);

                UserRol::create(['user_id' => $user->id, 'rol_id' => $rol_id, 'created_at' => gmdate('Y-m-d H:i:s')]);
            }

            DB::commit();
        }
        catch (Exception $e)
        {
            throw $e;

            DB::rollBack();
        }
    }
}
