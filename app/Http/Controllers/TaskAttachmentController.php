<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentDeleteRequest;
use App\Http\Requests\AttachmentUploadRequest;
use App\Services\TaskAttachmentService;

class TaskAttachmentController extends Controller
{
    public function __construct(
        protected TaskAttachmentService $taskAttachmentService
    ) {}

    public function store(AttachmentUploadRequest $request)
    {
        $request->validated();
        $taskId = $request->task_id;
        $attachment = $request->file('attachment');

        try {
            $this->taskAttachmentService->store($attachment, $taskId);

            return $request->wantsJson()
                ? response()->json(['message' => 'Attachment uploaded successfully'], 201)
                : back()->with('success', 'Attachment uploaded successfully');

        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Attachment upload failed'], 500)
                : back()->with('error', 'Attachment upload failed');
        }
    }

    public function destroy(AttachmentDeleteRequest $request)
    {
        $attachmentId = $request->attachment_id;

        try {
            $this->taskAttachmentService->destroy($attachmentId);

            return $request->wantsJson()
                ? response()->json(['message' => 'Attachment deleted successfully'], 200)
                : back()->with('success', 'Attachment deleted successfully');

        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Attachment deletion failed'], 500)
                : back()->with('error', 'Attachment deletion failed');
        }
    }
}
