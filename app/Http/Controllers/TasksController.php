<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todos = User::find($request->user()->id)->todos;
        // $todos = $user->todos;

        return response()->json([
            'data' => [
                'todos' => $todos
            ],
            'status' => 'success',
            'message' => 'todos retrieved successfully'
        ], 200);
    }

    /**
     * Create a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $rules = array(
                'task' => 'required',
                'date' => 'date_format:Y-m-d',
                'time' => 'date_format:H:i'
            );
            $messages = array(
                'task.required' => 'Name of todo is required',
                'date.date_format' => 'Incorrect date format',
                'time.date_format' => 'Incorrect time format'
            );
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Todo creation failed. Incorrect request formats'
                ], 400);
            }

            $todo = Task::create([
                'user_id' => $request->user()->id,
                'task' => $request->task,
                'note' => $request->note,
                'time' => $request->time,
                'date' => $request->date,
                'status' => $request->status ?? 'not started'
            ]);

            return response()->json([
                'data' => [
                    'todo' => $todo
                ],
                'status' => 'success',
                'message' => 'todo created successfully'
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'failed',
                'message' => 'Todo creation failed'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if ($task->user_id !== request()->user()->id) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Todo does not belong to authenticated user'
            ], 400);
        }

        return response()->json([
            'data' => [
                'todo' => $task
            ],
            'status' => 'success',
            'message' => 'todo retrieved successfully'
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
