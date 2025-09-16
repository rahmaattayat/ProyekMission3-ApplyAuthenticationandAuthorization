<?php
namespace App\Controllers;

use App\Models\CourseModel;

class Course extends BaseController
{
    public function index()
    {
        $model = new CourseModel();
        return view('admin/courses/index', [
            'courses' => $model->orderBy('course_code')->findAll()
        ]);
    }

    public function new()
    {
        return view('admin/courses/form');
    }

    public function create()
    {
        $model = new CourseModel();
        $data = $this->request->getPost(['course_code','course_name','credits']);
        if (!$model->save($data)) {
            return redirect()->back()->with('error', 'Validasi gagal.')->with('errors', $model->errors())->withInput();
        }
        return redirect()->to('/admin/courses')->with('success', 'Course ditambahkan.');
    }

    public function edit($id)
    {
        $model = new CourseModel();
        return view('admin/courses/form', ['course' => $model->find($id)]);
    }

    public function update($id)
    {
        $model = new CourseModel();
        $data  = $this->request->getPost(['course_code','course_name','credits']);
        $data['course_id'] = $id;

        if (!$model->save($data)) {
            return redirect()->back()->with('error', 'Validasi gagal.')->with('errors', $model->errors())->withInput();
        }
        return redirect()->to('/admin/courses')->with('success', 'Course diupdate.');
    }

    public function delete($id)
    {
        (new CourseModel())->delete($id);
        return redirect()->to('/admin/courses')->with('success', 'Course dihapus.');
    }
}
