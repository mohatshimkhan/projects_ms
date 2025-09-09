<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\Datatables;
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
        $users = User::latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
        //return view('admin.users.index');
    }

    public function apiUsers()
    {
        if($request->ajax()) {

            $users = User::all();

            return  Datatables::of($users)
                    ->addColumn('action', function($categories){
                            
                            $btn = '<a onclick="editForm('. $users->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Edit</a> ' .
                            '<a onclick="deleteData('. $users->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i>Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])->make(true);
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
            'name' => 'required|unique:users',
        ]);

        if($validator->passes()){

            $user            = new User();
            $user->name      = $request->name;
            $user->email     = $request->email;
            $user->password  = Hash::make($request->password);
            $user->role_id   = $request->role;
            $user->is_active = 1;
            $user->save();

            //$request->session()->flash('success', 'User added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'User added Successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        if($validator->passes()){

            $user = User::findOrFail($id);

            $user->name      = $request->name;
            $user->email     = $request->email;
            $user->password  = Hash::make($request->password);
            $user->role_id   = $request->role;
            $user->is_active = 1;
            $user->save();

            $request->session()->flash('success', 'User updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'User updated Successfully'
            ]);

        } else {
            
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
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
            ]);

        } else {
            
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }
    }

}