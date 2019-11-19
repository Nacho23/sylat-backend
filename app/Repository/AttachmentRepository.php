<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;
use App\Exceptions\Api\NotAllowedExtensionException;
use App\Models\Attachment;

class AttachmentRepository
{
    /**
     * Create attachment
     *
     * @param array $data
     * @param array $extensions
     * @return void
     */
    public static function create(array $data, array $extensions)
    {
        try
        {
            // Get sh1  hash
            $sha1 = sha1($data['file_name'] . microtime());

            // Set file_name and extension
            $filename = $sha1 . '.' . $data['extension'];

            // Save in storage
            Storage::disk('tmp')->put($filename, $data['content']);

            // Get saved file path
            $path = Storage::disk('tmp')->getAdapter()->applyPathPrefix($filename);

            // Get mime type
            $mimeType = mime_content_type($path);

            if (!in_array($mimeType, $extensions))
            {
                Storage::disk('tmp')->delete($filename);
                    throw new NotAllowedExtensionException(['extension' => 'Not allowed extension']);
            }

            // Create attachment related to the model
            $attachment = Attachment::create([
                'extension' => $data['extension'],
                'sha' => $sha1,
                'file_name' => $data['file_name'],
                'created_at' =>  gmdate('Y-m-d H:i:s'),
            ]);

            return $attachment;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Delete attachment
     *
     * @param Attachment $attachment
     * @return void
     */
    public static function delete(Attachment $attachment)
    {
        self::deleteRelatedFiles($attachment);

        $attachment->delete();
    }

    /**
     * Delete all related files for an attachment
     *
     * @param Attachment $attachment
     * @return void
     */
    private static function deleteRelatedFiles(Attachment $attachment)
    {
        $filename = $attachment->getFileName();

        if (Storage::disk(config('filesystems.temp_disk'))->exists($filename))
        {
            Storage::disk(config('filesystems.temp_disk'))->delete($filename);
        }

        if (Storage::disk(config('filesystems.final_disk'))->exists($filename))
        {
            Storage::disk(config('filesystems.final_disk'))->delete($filename);
        }
    }

    /**
     * Get attachment path
     *
     * @param Attachment $attachment
     * @param string     $disk
     * @return string
     */
    public static function getPath(Attachment $attachment, string $disk = 'tmp') : string
	{
		return Storage::disk($disk)->getAdapter()->applyPathPrefix($attachment->getFileName());
	}
}
