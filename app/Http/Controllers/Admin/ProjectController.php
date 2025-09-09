<?php

namespace App\Http\Controllers\Admin;

 use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Datatables;
use PDF;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.projects.index');
    }

    public function getProjects(Request $request)
    {
        if($request->ajax()) {
          
            $data = Project::select('projects.id', 'projects.name as project_name', 'projects.description as project_description','projects.company_id','companies.name as company_name','projects.user_id', 'users.name as user_name')
                ->join('companies','companies.id','=','projects.company_id')
                ->join('users','users.id','=','projects.user_id')
                ->get(); 
                      
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
            'name'        => 'required',
            'description' => 'required',
        ]);

        if($validator->passes()){
 
            $project              = new Project();
            $project->name        = $request->name;
            $project->description = $request->description;
            $project->company_id  = $request->company;
            $project->user_id     = $request->user;
            $project->days        =  $request->days;
            $project->is_active   = ($request->is_active) ? 1 : 0;
            $project->save();

            return response()->json([
                'status' => true,
                'message' => 'Project added Successfully'
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'description' => 'required',
        ]);

        if($validator->passes()){

            $project->name        = $request->name;
            $project->description = $request->description;
            $project->company_id  = $request->company;
            $project->user_id     = $request->user;
            $project->days        = $request->days;
            $project->is_active   = ($request->is_active) ? 1 : 0;
            $project->save();

            return response()->json([
                'status' => true,
                'message' => 'Project updated Successfully'
            ], 200);

        } else {
            
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if($project){

            $project->delete();

            $request->session()->flash('success', 'Project deleted Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Project deleted Successfully'
            ],200);

        } else {
            
            return response()->json([
                'status' => false,
                'message' => 'Project not found'
            ],400);
        }

    }

}