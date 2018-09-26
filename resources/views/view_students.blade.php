<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to the task</title>
        <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
        <style>
            @import url(//fonts.googleapis.com/css?family=Lato:700);

            body {
                margin:0;
                font-family:'Lato', sans-serif;
                text-align:center;
                color: #999;
            }

            .header {
                width: 100%;
                left: 0px;
                top: 5%;
                text-align: left;
                border-bottom: 1px  #999 solid;
            }

            .student-table{
                width:100%;  
            }

            table.student-table th{
                background-color: #C6C6C6;
                text-align: left;
                color: white;
                padding:7px 3px;
                font-weight: 700;
                font-size: 18px;
            }

            table.student-table tr.odd {
                text-align: left;
                padding:5px;
                background-color: #F9F9F9;
            }

            table.student-table td{
                text-align: left;
                padding:5px;
            }

            a, a:visited {
                text-decoration:none;
                color: #999;
            }

            h1 {
                font-size: 32px;
                margin: 16px 0 0 0;
            }
        </style>
    </head>

    <body>
        
        <div class="header">
            <div><img src="/images/logo_sm.jpg" alt="Logo" title="logo"></div>
            <div  style='margin: 10px;  text-align: left'>
                <label for="all_check">Select All</label>
                <button type="submit" form="form" value="Submit">Export</button>
                <a style="float: right" href="{{route('export_students')}}">export all students </a>
                <a style="float: right" href="{{route('export_courses')}}">export all courses</a>

            </div>
        </div>

        <form id="form" action="{{route('export')}}" method="get">
            {{ csrf_field() }}
            <div style='margin: 10px; text-align: center;'>
                <table class="student-table">
                    <tr>
                        <th><input type="checkbox" id="all_check" onclick="checkboxes_sel_all(this)"></th>
                        <th>Firstname</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>University</th>
                        <th>Course</th>
                    </tr>

                    @if(  count($students) > 0 )
                    @foreach($students as $student)
                    <tr>
                        <td><input type="checkbox" name="studentId{{$student['id']}}" value="{{$student['id']}}"></td>
                        <td style=' text-align: left;'>{{$student['firstname']}}</td>
                        <td style=' text-align: left;'>{{$student['surname']}}</td>
                        <td style=' text-align: left;'>{{$student['email']}}</td>
                        <td style=' text-align: left;'>{{$student['course']['university']}}</td>
                        <td style=' text-align: left;'>{{$student['course']['course_name']}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                    </tr>
                    @endif
                </table>
            </div>

        </form>

        <script>
            function checkboxes_sel_all(obj){
                var items = obj.form.getElementsByTagName("input"), len, i;
                for (i = 0, len = items.length; i < len; i += 1){
                    if (items.item(i).type && items.item(i).type === "checkbox"){
                        if (obj.checked){
                            items.item(i).checked = true;
                        }
                        else{
                            items.item(i).checked = false;
                        }
                    }
                }
            }
        </script>
    </body>

</html>
