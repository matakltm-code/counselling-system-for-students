<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $files = File::orderBy('created_at', 'desc')->paginate(10);
        if (auth()->user()->user_type === 'counselor') {
            $files = File::where('counselor_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('admin.files.index')->with([
            'files' => $files
        ]);
    }

    public function create()
    {
        if (auth()->user()->user_type != 'admin') {
            return redirect('/')->with('error', 'Your are not allowed to see this page');
        }
        return view('admin.files.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->user_type != 'admin') {
            return redirect('/')->with('error', 'Your are not allowed to see this page');
        }
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'file' => 'required|max:1999',
            'counselor_id' => 'integer|required',
        ]);

        // Handle File Upload
        if ($request->hasFile('file')) {
            $file_path = 'storage/' . $request->file->store('uploads', 'public');
        } else {
            $file_path = null;
        }

        // Create Post
        $post = new File;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->counselor_id = $request->input('counselor_id');
        $post->file_path = $file_path;
        $post->save();

        return redirect('/files')->with('success', 'File  shared successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return view('admin.files.show')->with('file', $file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        if (auth()->user()->user_type != 'admin') {
            return redirect('/')->with('error', 'Your are not allowed to see this page');
        }
        // Check for correct user
        if (auth()->user()->id !== $file->user_id) {
            return redirect('/files')->with('error', 'Unauthorized Page');
        }

        if ($file->file_path != null) {
            // Delete file
            Storage::delete($file->file_path);
        }

        $file->delete();
        return redirect('/files')->with('success', 'file Removed');
    }
}
