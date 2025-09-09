<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Datatables;
use PDF;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function getUsers(Request $request)
    {
        if($request->ajax()) {
          
          //$data = User::all();
            $data = User::select(['id', 'name', 'email', 'role_id', 'is_active'])->get();

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

    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date'  => date('m/d/Y')
        ];

        $pdf = PDF::loadView('myPDF', $data);

        return $pdf->download('itsolutionstuff.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'email' => 'required|unique:users',
            'role'  => 'required',
        ]);

        if($validator->passes()){

            $user            = new User();
            $user->name      = $request->name;
            $user->email     = $request->email;
            $user->password  = Hash::make($request->password);
            $user->role_id   = $request->role;
            $user->is_active = ($request->is_active) ? 1 : 0;
            $user->save();

          //$request->session()->flash('success', 'User added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'User added Successfully'
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
        $user = User::findOrFail($id);

        //return view('admin.users.edit', compact('user'));

        return response()->json($user);
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
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required',
            'role'  => 'required',
        ]);

        if($validator->passes()){

            $user = User::findOrFail($id);

            $user->name      = $request->name;
            $user->email     = $request->email;
            if(!empty($request->password)){ $user->password = Hash::make($request->password); }
            $user->role_id   = $request->role;
            $user->is_active = ($request->is_active) ? 1 : 0;
            $user->save();

          //$request->session()->flash('success', 'User updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'User updated Successfully'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if($user){

            $user->delete();

            $request->session()->flash('success', 'User deleted Successfully');

            return response()->json([
                'status' => true,
                'message' => 'User deleted Successfully'
            ],200);

        } else {
            
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ],400);
        }
    }


}