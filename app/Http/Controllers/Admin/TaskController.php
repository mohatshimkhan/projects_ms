<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Datatables;
use PDF;             

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tasks.index');
    }

    public function getTasks(Request $request)
    {
        if($request->ajax()) {
          
            $data = Task::select(['id', 'title', 'description', 'company_id', 'project_id','user_id', 'days', 'hours'])->get();
                     
            return Datatables::of($data)                              
                ->addIndexColumn()
                ->addColumn('action', function($row){                             
                    $actionBtn = '<a class="btn_edit btn btn-primary btn-xs" data-id="'.$row->id.'" ><i class="glyphicon glyphicon-edit"></i>Edit</a> ' .
                    '<a class="btn_delete btn btn-danger btn-xs" data-id="'.$row->id.'"><i class="glyphicon glyphicon-trash"></i>Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]); 

        if($validator->passes()){
 
            $task              = new Task();
            $task->title       = $request->title;
            $task->description = $request->description;
            $task->company_id  = $request->company;
            $task->project_id  = $request->project;
            $task->user_id     = $request->user;
            $task->days        = $request->days;
            $task->hours       = $request->hours;
            $task->save();

            return response()->json([
                'status' => true,
                'message' => 'Task added Successfully'
            ],200);

        } else {
            
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if($validator->passes()){

            $task->title       = $request->title;
            $task->description = $request->description;
            $task->company_id  = $request->company;
            $task->project_id  = $request->project;
            $task->user_id     = $request->user;
            $task->days        = $request->days;
            $task->hours       = $request->hours;
            $task->save();

            return response()->json([
                'status' => true,
                'message' => 'Task updated Successfully'
            ],200);

        } else {
            
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if($task){

            $task->delete();

            $request->session()->flash('success', 'Task deleted Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Task deleted Successfully'
            ],200);

        } else {
            
            return response()->json([
                'status' => false,
                'message' => 'Task not found'
            ],400);
        }
    }


}