<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
        $file_name = 'students_info.csv';
        $header = "\"Firstname\",\"Surname\",\"Email\",\"University\",\"Course\"\r\n";
        File::put($file_name, $header);

        foreach( $students as $key => $value){
            $student = Student::with('course')->where('id', $value)->first();
            $firstname = $student->firstname;
            $surname = $student->surname;
            $email = $student->email;
            if($student->course !== null){
                $university = $student->course->university;
                $course = $student->course->course_name;
            } else{
                $university = "";
                $course = "";
            }
            $string = "\"$firstname\",\"$surname\",\"$email\",\"$university\",\"$course\"\r\n";
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
        $file_name = 'students.csv';
        $header = "\"Firstname\",\"Surname\",\"Email\",\"Nationality\",\"House№\",\"Line_1\",\"Line_2\",\"PostCode\",\"City\"\r\n";
        File::put($file_name, $header);

        $students = Student::all();
        foreach( $students as $student){
            $firstname = $student->firstname;
            $surname = $student->surname;
            $email = $student->email;
            $nationality = $student->nationality;

            $house = $student->address['houseNo'];
            $line_1 = $student->address['line_1'];
            $line_2 = $student->address['line_2'];
            $postcode = $student->address['postcode'];
            $city = $student->address['city'];

            $string = "\"$firstname\",\"$surname\",\"$email\",\"$nationality\",\"$house\",\"$line_1\",\"$line_2\",\"$postcode\",\"$city\"\r\n";
            File::append($file_name, $string);
        }

        $file = public_path(). "/$file_name";
        $download_name = date('Y_m_d H-i-s').$file_name;
        return response()->download($file, $download_name);
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exporttCourseAttendenceToCSV()
    {
        $courses = Course::all();
        $file_name = 'courses.csv';
        $header = "\"Course\",\"University\"\r\n";
        File::put($file_name, $header);
        foreach( $courses as $course){
            $course_name = $course->course_name;
            $university = $course->university;
            $string = "\"$course_name\",\"$university\"\r\n";
            File::append($file_name, $string);

        }
        $file = public_path(). "/$file_name";
        $download_name = date('Y_m_d H-i-s').$file_name;
        return response()->download($file, $download_name);

    }
}
