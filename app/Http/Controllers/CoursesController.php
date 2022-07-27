<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(5);
      
        return view('courses.index',compact('courses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'name' => 'required',
        ]);
      
        Course::create($request->all());
       
        return redirect()->route('courses.index')
                        ->with('success','Course created successfully.');
    }

    public function show(Course $course)
    {
        return view('courses.show',compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit',compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'kode' => 'required',
            'name' => 'required',
        ]);
      
        $course->update($request->all());
      
        return redirect()->route('courses.index')
                        ->with('success','Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();
       
        return redirect()->route('courses.index')
                        ->with('success','Course deleted successfully');
    }
}
