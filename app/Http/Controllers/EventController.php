<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Event;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $events = Event::where('user_id', Auth::id())->get();
            return response()->json($events, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching events', [
                'user_id' => Auth::id(),
                'exception' => $e,
            ]);
            return response()->json(['error' => 'Unable to fetch tasks.'], 500);
        }
    }

    public function upcomingEvents()
    {
        try {
            $events = Event::where('date', '>=', Carbon::today())
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->get();
            return response()->json($events, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching upcoming events', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Unable to fetch upcoming events.'], 500);
        }
    }

    public function showFrount($id)
{
    try {
        $event = Event::findOrFail($id);
        return response()->json($event);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Event not found'], 404);
    }
}

    public function show(Task $task)
    {
        try {
          //  Gate::authorize('view', $task);
            return response()->json($task, 200);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Log::warning('Unauthorized task view attempt', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
            ]);
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            Log::error('Error fetching task', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'exception' => $e,
            ]);
            return response()->json(['error' => 'Unable to fetch task.'], 500);
        }
    }

    public function store(StoreEventRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['date'] = Carbon::parse($validated['date'])->toDateString();
            $validated['time'] = Carbon::parse($validated['time'])->format('H:i:s');

            $event = Event::create([
                ...$validated,
                'user_id' => Auth::id(),
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');
                $event->update(['image' => $path]);
            }

            return response()->json($event, 201);
        } catch (\Exception $e) {
            Log::error('Error creating event', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Unable to create event.'], 500);
        }
    }
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            Gate::authorize('update', $task);

            $task->update($request->validated());

            if ($request->hasFile('attachment')) {
                if ($task->attachment) {
                    Storage::disk('public')->delete($task->attachment);
                }
                $path = $request->file('attachment')->store('attachments', 'public');
                $task->update(['attachment' => $path]);
            }

            return response()->json($task, 200);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Log::warning('Unauthorized task update attempt', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
            ]);

            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            Log::error('Error updating task', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'exception' => $e,
            ]);

            return response()->json(['error' => 'Unable to update task.'], 500);
        }
    }

    public function destroy(Task $task)
    {
        try {
            Gate::authorize('delete', $task);

            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }

            $task->delete();

            return response()->json(['message' => 'Task deleted.'], 200);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Log::warning('Unauthorized task delete attempt', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
            ]);

            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            Log::error('Error deleting task', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'exception' => $e,
            ]);

            return response()->json(['error' => 'Unable to delete task.'], 500);
        }
    }
}
