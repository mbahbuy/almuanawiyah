<?php

namespace App\Http\Controllers;

use App\Models\{Category,Courses};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller
{
    public function index()
    {
        return view('dashboard.courses.index',[
            'title' => 'Courses List',
            'courses' => Courses::all()
        ]);
    }
    
    public function create()
    {
        return view('dashboard.courses.index',[
            'title' => 'Courses List',
            'courses' => Courses::all(),
            'create' => '',
            'categories' => Category::all()
        ]);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:courses',
            'category_id' => 'required',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ]);

        if($request->file('image'))
        {
            $validatedData['image'] = $request->file('image')->store('courses-image');
        };

        Courses::create($validatedData);

        return redirect('/views/courses')->with('success', 'New Courses has been added!!!');
    }
    
    public function edit(Courses $courses)
    {
        return view('dashboard.courses.index',[
            'title' => 'Courses List',
            'courses' => Courses::all(),
            'edit' => $courses,
            'categories' => Category::all()
        ]);

    }

    public function update(Request $request, Courses $courses)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ];
        
        if($request->slug != $courses->slug)
        {
            $rules['slug'] = 'required|unique:courses|min:3';
        };

        $validatedData = $request->validate($rules);

        if($request->file('image'))
        {
            if($request->oldImage){
                Storage::delete($request->oldImage);
            };
            $validatedData['image'] = $request->file('image')->store('courses-image');
        };

        $courses->update($validatedData);

        return redirect('/views/courses')->with('success', 'The Courses has been updated!!!');
    }
    
    public function destroy(Courses $courses)
    {
        if($courses->image){
            Storage::delete($courses->image);
        };
        $courses->delete();
        
        return redirect('/views/courses')->with('success', 'The Courses has been deleted!!!');
    }
}
