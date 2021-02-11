<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::paginate(10);
        return view('admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request, [
            'name' => 'required|min:3|max:100',
            'email' => 'required|min:3|email',
            'type' => 'required'
        ]);

        if($request->has('password')) {
            User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => bcrypt($request->password)
            ]);
        } else {
            User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => bcrypt('author')
            ]);
        }

        

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
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
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
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
        $this -> validate($request, [
            'name' => 'required|min:3|max:100',
            'type' => 'required'
        ]);

        if($request -> has('password')) {
            $user_data = [
            'name' => $request->name,
            'type' => $request->type,
            'password' => bcrypt($request->password)
            ];
        } else {
            $user_data = [
                'name' => $request->name,
                'type' => $request->type,
            ];
        }

        User::whereId($id)->update($user_data);

        return redirect()->route('user.index')->with('success', 'Data berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorfail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
