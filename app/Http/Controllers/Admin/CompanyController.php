<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Datatables;
use PDF;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.companies.index');
    }

    public function getCompanies(Request $request)
    {
        if($request->ajax()) {
          
            $data = Company::select(['id', 'name', 'description', 'is_active'])->get();

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
            'description' => 'required',
        ]);

        if($validator->passes()){

            $company         = new Company();
            $company->name   = $request->name;
            $company->description = $request->description;
            $company->is_active = ($request->is_active) ? 1 : 0;
            $company->save();

            return response()->json([
                'status' => true,
                'message' => 'Company added Successfully'
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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
         $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'description' => 'required',
        ]);

        if($validator->passes()){

            $company->name        = $request->name;
            $company->description = $request->description;
            $company->is_active   = ($request->is_active) ? 1 : 0;
            $company->save();

            return response()->json([
                'status' => true,
                'message' => 'Company updated Successfully'
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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if($company){

            $company->delete();

            $request->session()->flash('success', 'Company deleted Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Company deleted Successfully'
            ],200);

        } else {
            
            return response()->json([
                'status' => false,
                'message' => 'Company not found'
            ],400);
        }
    }

}