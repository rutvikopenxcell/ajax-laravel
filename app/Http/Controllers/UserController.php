<?php

namespace App\Http\Controllers;

use DataTables;
use Validator;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm editUser">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm deleteUser">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|size:10',
            'gender' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->first()], 422);
        }

        // Handle file upload
        $avatarName = null;
        if (isset($request->avatar)) {
            if ($request->hasFile('avatar')) {
                $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
                $request->avatar->storeAs('public/avatars', $avatarName);
            }
        }else{
            if($request->user_id){
                $avatarName = User::find($request->user_id)->avatar;
            }
        }

        $file = null;
        if (isset($request->file)) {
            if ($request->hasFile('file')) {
                $file = time() . '.' . $request->file->getClientOriginalExtension();
                $request->file->storeAs('public/file', $file);
            }
        }else{
            if($request->user_id){
                $file = User::find($request->user_id)->file;
            }
        }

        User::updateOrCreate(['id' => $request->user_id], [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('Test@1234'),
            'avatar' => $avatarName,
            'file' => $file,
            'phone' => $request->phone,
            'gender' => $request->gender
        ]);

        return response()->json(['success' => 'User saved successfully.']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}
