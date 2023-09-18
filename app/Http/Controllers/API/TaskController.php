<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Task\StoreTaskDocumentRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskArchiveRequest;
use App\Http\Requests\Task\UpdateTaskCompleteRequest;
use App\Http\Requests\Task\UpdateTaskDeadlineRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\UpdateTaskTagRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Traits\TaskManagerTrait;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends BaseController
{   
    use TaskManagerTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $tasks = QueryBuilder::for(Task::class)
            ->defaultSort('name')
            ->allowedSorts(['name', 'status', 'deadline_at', 'archived_at', 'completed_at'])
            ->allowedFilters(['name', 'status', 'deadline_at', 'archived_at', 'completed_at'])
            ->paginate(10);

        return new TaskCollection($tasks);
    }

    /**
     * The store function in PHP creates a new task with the validated data from the request, assigns
     * the user ID of the authenticated user to the task, syncs the tags associated with the task, and
     * returns a resource representation of the task.
     * 
     * @param StoreTaskRequest request The `` parameter is an instance of the
     * `StoreTaskRequest` class. It represents the incoming HTTP request that is being made to store a
     * new task. It contains all the data and information sent in the request, such as form inputs,
     * headers, and other request details.
     * 
     * @return a new instance of the TaskResource class, passing in the created task as a parameter.
     */
    public function store(StoreTaskRequest $request)
    {   
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        $task = Task::create($validated);

        $task->tags()->sync($request->tags);

        return new TaskResource($task);
    }

    /**
     * The show function returns a TaskResource object for a given Task.
     * 
     * @param Task task The parameter `Task` is of type `Task`. It is an instance of the `Task` class.
     * 
     * @return a new instance of the TaskResource class, passing in the  object as a parameter.
     */
    public function show(Task $task)
    {   
        return new TaskResource($task);
    }

    /**
     * The function updates a task with the validated data from the request and syncs the task's tags
     * with the tags provided in the request.
     * 
     * @param UpdateTaskRequest request The  parameter is an instance of the UpdateTaskRequest
     * class. It represents the HTTP request made to update a task. It contains the data sent in the
     * request, such as the task title, description, and tags.
     * @param Task task The `` parameter is an instance of the `Task` model. It represents the
     * task that needs to be updated.
     * 
     * @return a new instance of the TaskResource class, passing in the updated task as a parameter.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {   
        $validated = $request->validated();
        
        $task->update($validated);

        $task->tags()->sync($request->tags);

        return new TaskResource($task);
    }

    /**
     * The "destroy" function removes a specified task from storage and returns a success response with
     * a status code of 204.
     * 
     * @param Task task The "task" parameter is an instance of the Task model. It represents the
     * specific task that needs to be removed from storage.
     * 
     * @return The method is returning a success response with an empty array and a status code of 204.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return $this->successResponse([], 204);
    }

    /**
     * The function updates the completion status and completion time of a task based on the validated
     * request data.
     * 
     * @param UpdateTaskCompleteRequest request The  parameter is an instance of the
     * UpdateTaskCompleteRequest class. It is used to validate and retrieve the data sent in the
     * request.
     * @param Task task The `` parameter is an instance of the `Task` model. It represents the
     * task that needs to be marked as completed.
     * 
     * @return a TaskResource object.
     */
    public function taskCompleted(UpdateTaskCompleteRequest $request, Task $task)
    {       
        $validated = $request->validated();

        if (isset($validated['completed'])) 
        {
            $task->update([
                'completed' => ($validated['completed'] === true) ? true : false,
                'completed_at' => ($validated['completed'] === true) ? Carbon::now() : null 
            ]);
        }
        
        return new TaskResource($task);
    }

   /**
    * The function updates the deadline of a task and returns the updated task as a resource.
    * 
    * @param UpdateTaskDeadlineRequest request The  parameter is an instance of the
    * UpdateTaskDeadlineRequest class. It represents the HTTP request made to update the deadline of a
    * task. This request may contain data such as the new deadline value.
    * @param Task task The `` parameter is an instance of the `Task` model. It represents the task
    * that needs to be updated with a new deadline.
    * 
    * @return The method is returning a TaskResource object.
    */
    public function taskDeadline(UpdateTaskDeadlineRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);

        return new TaskResource($task);
    }
   
    /**
     * The function updates the tags of a task based on the request and returns the updated task as a
     * resource.
     * 
     * @param UpdateTaskTagRequest request The  parameter is an instance of the
     * UpdateTaskTagRequest class. It is used to validate and retrieve the data sent in the request.
     * @param Task task The `` parameter is an instance of the `Task` model. It represents the
     * task that needs to be updated with new tags.
     * 
     * @return a TaskResource object.
     */
    public function taskTagged(UpdateTaskTagRequest $request, Task $task)
    {
        $request->validated();

        $task->tags()->sync($request->tags);

        return new TaskResource($task);
    }

    
    /**
     * The function `taskDocument` validates a request, uploads a task document, and returns a task
     * resource.
     * 
     * @param StoreTaskDocumentRequest request The `` parameter is an instance of the
     * `StoreTaskDocumentRequest` class. It represents the HTTP request made to store a task document.
     * @param Task task The "task" parameter is an instance of the Task model. It represents a specific
     * task in the application.
     * 
     * @return a TaskResource object.
     */
    public function taskDocument(StoreTaskDocumentRequest $request, Task $task)
    {   
        $request->validated();

        $this->uploadTaskDocument($request, $task);
        
        return new TaskResource($task);
    }

    /**
     * The function updates the "archived" status of a task and sets the "archived_at" timestamp if the
     * "archived" value is true.
     * 
     * @param UpdateTaskArchiveRequest request The  parameter is an instance of the
     * UpdateTaskArchiveRequest class. It is used to validate and retrieve the data sent in the
     * request.
     * @param Task task The `` parameter is an instance of the `Task` model. It represents the
     * task that needs to be archived or unarchived.
     * 
     * @return a TaskResource object.
     */
    public function taskArchived(UpdateTaskArchiveRequest $request, Task $task)
    {
        $validated = $request->validated();

        if (isset($validated['archived'])) 
        {
            $task->update([
                'archived' => ($validated['archived'] === true) ? true : false,
                'archived_at' => ($validated['archived'] === true) ? Carbon::now() : null 
            ]);
        }
        
        return new TaskResource($task);
    }

}
