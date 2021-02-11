<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Posts;
use App\Models\Category;
use App\Models\Tags;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::paginate(10);
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags =Tags::all();
        $category = Category::all();
        return view('admin.post.create', compact('category', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'category_id' => 'required',
            'content' => 'required',
            'gambar' => 'required',
        ]);

        $gambar = $request->gambar;
        $new_gambar = time().$gambar->getClientOriginalName();

        $post = Posts::create([
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'gambar' => 'public/uploads/posts/'.$new_gambar,
            'slug' => str::slug($request->judul),
            'users_id' => Auth::id()
        ]);

        $post->tags()->attach($request->tags);

        $gambar->move('public/uploads/posts/', $new_gambar);

        return redirect()->back()->with('success', 'Post berhasil ditambahkan');
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
        $tags = Tags::all();
        $post = Posts::findorfail($id);
        $category = Category::all();
        return view('admin.post.edit', compact('post', 'tags', 'category'));
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
        $this->validate($request, [
            'judul' => 'required',
            'category_id' => 'required',
            'content' => 'required',
        ]);

        $post = Posts::findorfail($id);
        if($request->has('gambar')) {
            $gambar = $request->gambar;
            $new_gambar = time().$gambar->getClientOriginalName();
            $gambar->move('public/uploads/posts/', $new_gambar);

            $post_data = [
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'gambar' => 'public/uploads/posts/'.$new_gambar,
            'slug' => str::slug($request->judul)
            ];
        } else  {
            $post_data = [
                'judul' => $request->judul,
                'category_id' => $request->category_id,
                'content' => $request->content,
                'slug' => str::slug($request->judul)
            ];
        }

        $post->tags()->sync($request->tags);
        $post->update($post_data);
        return redirect()->route('post.index')->with('success', 'Post berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::findorfail($id);

        $post->delete();

        return redirect()->back()->with('success', 'Post berhasil dihapus');
    }

    public function tampil_hapus() {
        $posts = Posts::onlyTrashed()->paginate(10);
        return view('admin.post.hapus', compact('posts'));
    }

    public function restore($id) {
        $posts = Posts::withTrashed()->where('id', $id)->first();
        $posts -> restore();

        return redirect()->back()->with('success', 'Post berhasil di restore');
    }
    
    public function kill($id) {
        $posts = Posts::withTrashed()->where('id', $id)->first();
        
        $posts->forceDelete();
        return redirect()->back()->with('success', 'Post berhasil di hapus permanen');
    }
}
