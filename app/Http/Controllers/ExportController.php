<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Response;
use Storage;
use File;

class ExportController extends Controller
{
    public function __construct()
    {

    }

    public function welcome()
    {
        return view('hello');
    }

    /**
     * View all students found in the database
     */
    public function viewStudents()
    {
        $students = Student::with('course')->get();
        return view('view_students', compact(['students']));
    }

    public function export(Request $Request)
    {
        $students = $Request->except('_token');
        $file_name = 'students.csv';
        $header = "\"Forename\",\"Surname\",\"Email\",\"University\",\"Course\"\r\n";
        File::put($file_name, $header);

        foreach( $students as $key => $value){
            $student = Student::with('course')->where('id', $value)->first();
            $firstname = $student->firstname;
            $surname = $student->surname;
            $email = $student->email;
            $university = $student->course->university;
            $course = $student->course->course_name;
            $string ="\"$firstname\",\"$surname\",\"$email\",\"$university\",\"$course\"\r\n";
            File::append($file_name, $string);
        }

        $file = public_path(). "/$file_name";
        $download_name = date('Y_m_d H-i-s').$file_name;
        return response()->download($file, $download_name);
    }


    /**
     * Exports all student data to a CSV file
     */
    public function exportStudentsToCSV()
    {

    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exporttCourseAttendenceToCSV()
    {

    }
}
