<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Datatables;
use PDF;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    public function getRoles(Request $request)
    {
        if($request->ajax()) {
          
            $data = Role::select(['id', 'name', 'is_active'])->get();

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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
        ]);

        if($validator->passes()){

            $role = new Role();
            $role->name      = $request->name;  
            $role->is_active = ($request->is_active) ? 1 : 0;
            $role->save();

            return response()->json([
                'status' => true,
                'message' => 'Role added Successfully'//
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
        ]);

        if($validator->passes()){

            $role->name      = $request->name;  
            $role->is_active = ($request->is_active) ? 1 : 0;
            $role->save();

            return response()->json([
                'status' => true,
                'message' => 'Role updated Successfully'
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if($role){

            $role->delete();

            $request->session()->flash('success', 'Role deleted Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Role deleted Successfully'
            ],200);

        } else {
            
            return response()->json([
                'status' => false,
                'message' => 'Role not found'
            ],400);
        }
    }

}