<?php

namespace App\Http\Controllers;

use App\Models\UserImage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function apiResponse($result = [], $message = "", $status = 1)
    {
        $response = [
            'status' => $status,
            'message' => $message,
            // "server_date" => date('d/m/Y h:i')
        ];

        if (! empty($result)) {
            $response['data'] = $result;
        }
        return response()->json($response, 200);
    }

    public static function apiError($error, $status = 0, $errorData = [], $code = 200)
    {
        $response = [
            'status' => $status,
            'message' => $error,
            // "server_date" => date('d/m/Y h:i')
        ];
        if (! empty($errorData)) {
            $response['data'] = $errorData;
        }
        return response()->json($response, $code);
    }

    public static function deleteUserImages(int $id = null)
    {
        if (!isset($id)) {
            $userImages = UserImage::where('user_id', auth()->user()->id)->get();
            if ($userImages->isNotEmpty()) {
                foreach ($userImages as $userImage) {
                    // Get the file path from the URL
                    $filePath = str_replace(url('storage'), 'public', $userImage->image);
                    // Delete the image file
                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                    }
                    $userImage->delete();
                }
            }
        } elseif($id != 0) {
            $userImage = UserImage::find($id);
            if ($userImage) {
                // Get the file path from the URL
                $filePath = str_replace(url('storage'), 'public', $userImage->image);
                // Delete the image file
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                $userImage->delete();
            }
        }
    }
    public static function removeAllDeletedImages(array $ids)
    {
        $userImages = UserImage::where('user_id', auth()->user()->id)
        ->whereNotIn('id', $ids)->get();
        if ($userImages->isNotEmpty()) {
            foreach ($userImages as $userImage) {
                // Get the file path from the URL
                $filePath = str_replace(url('storage'), 'public', $userImage->image);
                // Delete the image file
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                $userImage->delete();
            }
        }
    }
}
