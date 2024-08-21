<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Models\Attachment;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class TaskAttachmentService
{
    public function store(UploadedFile $attachment, int $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            $attachmentName = $attachment->getClientOriginalName();
            $attachment->storeAs('attachments', $attachmentName);

            $task->attachments()->create([
                'name' => $attachmentName,
                'path' => 'attachments/'.$attachmentName,
            ]);

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
            $attachment->delete();

        } catch (ModelNotFoundException $e) {
            Log::error("Attachment not found: {$e->getMessage()}");
            throw new TaskNotFoundException;
        } catch (\Exception $e) {
            Log::error("Error deleting attachment: {$e->getMessage()}");
            throw new \Exception('Attachment deletion failed');
        }
    }
}
