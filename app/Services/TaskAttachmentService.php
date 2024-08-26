<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Models\Attachment;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskAttachmentService
{
    public function store(UploadedFile $attachment, int $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            // Sanitize the original filename
            $originalName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $attachment->getClientOriginalExtension();

            // Clean the name: convert spaces to hyphens, remove special characters, and lowercase it
            $sanitizedName = Str::slug($originalName, '-').'.'.$extension;

            // Prepend a unique ID to avoid collisions
            $uniqueName = uniqid().'_'.$sanitizedName;

            // Store the file in the 'task-attachments' directory within the public disk
            $filePath = "task-attachments/$uniqueName";
            $storedPath = Storage::disk('public')->putFileAs('task-attachments', $attachment, $uniqueName);

            if (! $storedPath) {
                throw new \Exception('Failed to store the file');
            }

            // Create a new attachment record in the database
            $newAttachment = $task->attachments()->create([
                'name' => $uniqueName,
                'path' => $filePath,
            ]);

            return $newAttachment;

        } catch (ModelNotFoundException $e) {
            Log::error("Task not found: {$e->getMessage()}");
            throw new TaskNotFoundException;
        } catch (\Exception $e) {
            Log::error("Error uploading attachment: {$e->getMessage()}");
            throw new \Exception('Attachment upload failed');
        }
    }

    public function destroy(int $attachmentId)
    {
        try {
            $attachment = Attachment::findOrFail($attachmentId);

            // Delete the file from storage
            Storage::disk('public')->delete($attachment->path);

            // Delete the database record
            $attachment->delete();

        } catch (ModelNotFoundException $e) {
            Log::error("Attachment not found: {$e->getMessage()}");
            throw new \Exception('Attachment not found');
        } catch (\Exception $e) {
            Log::error("Error deleting attachment: {$e->getMessage()}");
            throw new \Exception('Attachment deletion failed');
        }
    }
}
