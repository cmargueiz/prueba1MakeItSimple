<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

use function GuzzleHttp\Promise\task;

class TaskApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request['user_id'];
        return Task::where('user_id',$id)->get();;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $validateData = $request->validate([
            'title'=>'string|required',
            'description'=>'string',
            'priority'=>'integer'
        ]);

        $task = Task::create([
            'title'=>$validateData['title'],
            'description'=>$validateData['description'],
            'priority'=>$validateData['priority'],
            'user_id' => $user_id
        ]);

        return response()->json([
            'title'=>$validateData['title'],
            'description'=>$validateData['description']
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $validateData = $request->validate([
            'title'=>'string|required',
            'description'=>'string',
            'priority'=>'integer'
        ]);


        $user_id = auth()->user()->id;
        if (Task::where(['user_id'=>$user_id,'id'=>$id])->exists()) {
            $task = Task::find($id);
            $task->title = isset($request->title)?$validateData['title']:$task->title;
            $task->description = isset($request->description) ? $validateData['description'] : $task->description;
            $task->priority = isset($request->priority) ? $validateData['priority'] : $task->priority ;
            $task->user_id = $user_id;
            $task->save();

            return response()->json([
                'message'=>'Tarea Modificada',
                'task'=>[
                    'title'=>$task->title,
                    'description'=>$task->description,
                    'priority'=>$task->priority
                ]
            ],200);

        } else {
            return response()->json([
                'message'=>'Tarea No encontrada',
                
            ],404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $user_id = auth()->user()->id;
        if (Task::where(['id'=>$id])->exists()) {
            $task = Task::find($id);
            $task->delete();

            return response()->json([
                'message'=>'Tarea Eliminada',
            ],200);

        } else {
            return response()->json([
                'message'=>'Tarea No encontrada',
                
            ],404);
        }

    }
}
