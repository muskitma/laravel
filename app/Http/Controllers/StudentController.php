<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // Display the registration form and list of students
    public function viewForm()
    {
        $students = Student::all();
        return view('student-reg', compact('students'));
    }

    // Add a new student
    public function addStudent(Request $request)
    {
        $validatedData = $request->validate([
            'uname' => 'required|string|unique:students',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:students',
            'phone' => 'required|string|unique:students',
            'address' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'department' => 'required|string',
            'joined_date' => 'required|date',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        Student::create($validatedData);
        return redirect()->route('student-list')->with('message', 'Student added successfully');
    }

    // Show the edit form
    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('edit-student', compact('student'));
    }
    
    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
    
        // Update student data
        $student->update($request->all());
    
        return redirect()->route('student-list')->with('message', 'Student updated successfully');
    }
    

    // Delete a student
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('student-list')->with('message', 'Student deleted successfully');
    }

}
