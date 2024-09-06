 <table>
    <thead>
        <tr>
           <td colspan="6" style="font-weight: bold; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Attendance Report</td> 
        </tr>
        <tr>
            <td colspan="6" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Teacher: {{ Auth::user()->firstName. ' ' .Auth::user()->lastName}}</td> 
         </tr>
         <tr>
            <td colspan="6" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Grade and Section: {{ $class->grade_section }}</td> 
         </tr>
         <tr>
            <td colspan="6" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Time: {{ $class->time_from. ' - ' .$class->time_to }}</td> 
         </tr>
         <tr>
            <td colspan="6" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Date of attendance: {{ $date_attendance }}</td> 
         </tr>
         <tr>
            <td></td>
            <td></td>
         </tr>
        <tr>  
            <th colspan="3">Student</th>
            <th colspan="3">Status</th> 
        </tr>
    </thead>
    <tbody>  
        @foreach ($attendances as $attendance) 
        <tr>
            <td colspan="3">{{ $attendance->student->firstName. ' ' .$attendance->student->lastName}}</td>
            <td colspan="3">{{  Str::ucfirst($attendance->status) }}</td> 
        </tr> 
        @endforeach
    </tbody>
</table>