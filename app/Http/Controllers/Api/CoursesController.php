<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
// use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;

class CoursesController extends Controller
{
    
    public function index()
    {
        $courses = Course::all();
        return response()->json([
            'courses' => $courses
        ]);
    }

    public function show($id)
    {
        $course = Course::find($id);
        if (is_null($course)) {
        return $this->sendError('Course not found.');
        }
        return response()->json([
        "success" => true,
        "message" => "Course retrieved successfully.",
        "data" => $course
        ]);
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());

        return response()->json([
            'message' => "Course saved successfully!",
            'course' => $course
        ], 200);
    }
    
    public function update(StoreCourseRequest $request, Course $course)
    {
        $course->update($request->all());

        return response()->json([
            'message' => "Course updated successfully!",
            'course' => $course
        ], 200);
    }

    
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => "Course deleted successfully!",
        ], 200);
    }
}
