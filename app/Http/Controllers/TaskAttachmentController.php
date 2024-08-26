<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskAttachmentDeleteRequest;
use App\Http\Requests\TaskAttachmentUploadRequest;
use App\Models\Attachment;
use App\Services\TaskAttachmentService;

class TaskAttachmentController extends Controller
{
    public function __construct(
        protected TaskAttachmentService $taskAttachmentService
    ) {}

    public function store(TaskAttachmentUploadRequest $request)
    {
        $request->validated();
        $taskId = $request->task_id;
        $attachment = $request->file('attachment');

        try {
            // Store the attachment and get the newly created attachment record
            $newAttachment = $this->taskAttachmentService->store($attachment, $taskId);

            return $request->wantsJson()
                ? response()->json([
                    'message' => 'Attachment uploaded successfully',
                    'attachment' => $newAttachment,
                ], 201)
                : back()->with('success', 'Attachment uploaded successfully');

        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Attachment upload failed'], 500)
                : back()->with('error', 'Attachment upload failed');
        }
    }

    public function destroy(TaskAttachmentDeleteRequest $request, $attachmentId)
    {
        try {
            $request->validated();
            $this->taskAttachmentService->destroy($attachmentId);

            return response()->json(['message' => 'Attachment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Attachment deletion failed'], 500);
        }
    }
}
