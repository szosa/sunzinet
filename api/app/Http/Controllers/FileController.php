<?php

namespace App\Http\Controllers;

use App\File;
use App\Helpers\FileSizeHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);
        $fileModel = new File();

        $file = $request->file('file');
        $fileOriginalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileUniqueName = uniqid();
        $filePath = $file->storeAs('uploads', $fileUniqueName, 'local');

        $fileModel->user_id = auth()->id();
        $fileModel->name = $fileOriginalName;
        $fileModel->file_path = $filePath;
        $fileModel->file_size = FileSizeHelper::sizeHumanReadable($fileSize);
        $fileModel->save();

        return response()->json([
            'id' => $fileModel->id,
            'name' => $fileModel->name,
            'size' => $fileModel->file_size
        ], 201);
    }

    public function getUserFiles()
    {
        $files = File::where(['user_id' => auth()->id()])->get();

        $fileArray = [];
        foreach ($files as $file) {
            $fileArray[] = [
                'id' => $file->id,
                'name' => $file->name,
                'size' => $file->file_size
            ];
        }

        return response()->json($fileArray);
    }

    public function changeFileName(Request $request, int $fileId)
    {
        $newName = $request->get('newName');
        $file = File::where(['user_id' => auth()->id(), 'id' => $fileId])->first();
        if (!$file) {
            return response()->setStatusCode(404);
        } else {
            $file->name = $newName;
            $file->save();
        }
        return response()->json();
    }

    public function deleteFile(int $fileId)
    {
        $file = File::where(['user_id' => auth()->id(), 'id' => $fileId])->first();
        if (!$file) {
            return response()->json([],404);
        } else {
            Storage::disk('local')->delete($file->file_path);
            $file->delete();
        }
        return response()->json();
    }

    public function download(int $fileId)
    {
        $file = File::where(['user_id' => auth()->id(), 'id' => $fileId])->first();
        if (!$file) {
            return response()->json([], 404);
        } else {
            $header = [
                'Content-Type' => 'application/*',
            ];
            return response()->download(storage_path('app') . '/' . $file->file_path, $file->file_name, $header);
        }
    }
}
