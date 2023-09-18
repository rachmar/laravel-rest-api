<?php

namespace App\Http\Traits;

use App\Http\Requests\Task\StoreTaskDocumentRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait TaskManagerTrait
{
    /**
     * The function uploads one or multiple documents for a given task.
     * 
     * @param Request request The  parameter is an instance of the Request class, which
     * represents an HTTP request made to the server. It contains information about the request, such
     * as the request method, headers, and any data sent with the request.
     * @param Task task The  parameter is an instance of the Task model. It represents the task
     * for which the documents are being uploaded.
     */
    public function uploadTaskDocument(StoreTaskDocumentRequest $request, Task $task)
    {
        if ($request->hasFile('documents')) 
        {
            $documents = $request->file('documents');
            
            if (is_array($documents)) {
                foreach ($documents as $document) {
                    $this->processDocument($task, $document);
                }
            } else {
                $this->processDocument($task, $documents);
            }
        }
    }
    
    /**
     * The function "processDocument" takes a task and a document as input, retrieves the original name
     * and file extension of the document, stores the document in a specified directory, and creates a
     * new record in the task's documents table with the original name, file path, and file extension.
     * 
     * @param task The "task" parameter is an instance of the Task model. It represents a specific task
     * that the document is associated with.
     * @param document The "document" parameter is an instance of the UploadedFile class, which
     * represents a file that has been uploaded through a form. It contains information about the
     * uploaded file, such as its original name, file extension, and temporary storage path.
     */
    private function processDocument($task, $document)
    {
        $originalName = $document->getClientOriginalName();
        
        $fileExtension = $document->getClientOriginalExtension();

        $filePath = $document->store('public/documents');
        
        $publicUrl = Storage::url($filePath);

        $task->documents()->create([
            'task_id' => $task->id,
            'name' => $originalName,
            'path' => $publicUrl,
            'extension' => $fileExtension,
        ]);
    }
    
}
