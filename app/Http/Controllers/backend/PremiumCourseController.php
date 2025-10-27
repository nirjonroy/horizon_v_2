<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\PremiumCourse;
use App\Models\PremiumCourseModule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PremiumCourseController extends Controller
{
    public function index()
    {
        $courses = PremiumCourse::latest()->get();
        return view('backend.premium_courses', compact('courses'));
    }

    public function create()
    {
        return view('backend.create_premium_courses');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'effort' => 'nullable|string|max:255',
            'questions' => 'nullable|string|max:255',
            'format' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'old_price' => 'numeric|nullable',
            'type' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
            'link' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'site_name' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
        ]);

        $data = $request->only([
            'title',
            'instructor',
            'duration',
            'effort',
            'questions',
            'format',
            'price',
            'old_price',
            'type',
            'link',
            'short_description',
            'long_description',
            'status',
            'meta_title',
            'meta_description',
            'author',
            'publisher',
            'copyright',
            'site_name',
        ]);

        $data['slug'] = Str::slug($request->slug ?: $request->title);
        $data['status'] = (int) $request->status;
        $data['keywords'] = $this->normaliseKeywords($request->keywords);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        if ($request->hasFile('meta_image')) {
            $data['meta_image'] = $this->uploadImage($request->file('meta_image'));
        }

        PremiumCourse::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function show($id)
    {
        $course = PremiumCourse::with('modules')->findOrFail($id);
        return view('premium_courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = PremiumCourse::findOrFail($id);
        return view('backend.edit_premium_courses', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = PremiumCourse::findOrFail($id);

        $course->title = $request->title;
        $course->slug = Str::slug($request->slug ?: $request->title);
        $course->instructor = $request->instructor;
        $course->type = $request->type;
        $course->duration = $request->duration;
        $course->effort = $request->effort;
        $course->questions = $request->questions;
        $course->format = $request->format;
        $course->price = $request->price;
        $course->old_price = $request->old_price;
        $course->link = $request->link;
        $course->short_description = $request->short_description;
        $course->long_description = $request->long_description;
        $course->status = $request->has('status') ? 1 : 0;
        $course->meta_title = $request->meta_title;
        $course->meta_description = $request->meta_description;
        $course->author = $request->author;
        $course->publisher = $request->publisher;
        $course->copyright = $request->copyright;
        $course->site_name = $request->site_name;
        $course->keywords = $this->normaliseKeywords($request->keywords);

        if ($request->hasFile('image')) {
            $course->image = $this->updateImage($request->file('image'), $course->image);
        }

        $course->meta_image = $this->updateImage($request->file('meta_image'), $course->meta_image);

        $course->save();

        return redirect()->back()->with('success', 'Premium course updated successfully!');
    }

    private function updateImage($file, $previousImagePath)
    {
        if ($file) {
            $this->deleteImageIfExists($previousImagePath);
            return $this->uploadImage($file);
        }

        return $previousImagePath;
    }

    private function uploadImage($file)
    {
        $directory = 'premium-courses';
        $destinationPath = public_path($directory);

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $filename = basename($file->getClientOriginalName());
        $file->move($destinationPath, $filename);

        return $directory . '/' . $filename;
    }

    private function deleteImageIfExists($path)
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    public function destroy($id)
    {
        $whereToStudy = PremiumCourse::findOrFail($id);

        $this->deleteImageIfExists($whereToStudy->image);
        $this->deleteImageIfExists($whereToStudy->meta_image);

        $whereToStudy->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Record deleted successfully');
    }

    private function normaliseKeywords(?string $keywords): ?string
    {
        if ($keywords === null) {
            return null;
        }

        $keywordsArray = array_filter(array_map('trim', explode(',', $keywords)));

        if (empty($keywordsArray)) {
            return null;
        }

        return implode(', ', $keywordsArray);
    }
}
