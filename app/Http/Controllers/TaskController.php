<?php
namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json(['data' => $tasks], 200);
    }
    public function addTask(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,Completed',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $task = Task::create($request->all());
        return response()->json(['data' => $task, 'message' => 'Task created successfully'], 201);
    }

    public function show($id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        
        return response()->json(['data' => $task], 200);
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        
        $task->update($request->all());
        return response()->json(['data' => $task, 'message' => 'Task updated successfully'], 200);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}
