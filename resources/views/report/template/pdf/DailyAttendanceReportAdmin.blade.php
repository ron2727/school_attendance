<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="head">
        <h1 class=" text-gray-700 text-3xl font-bold">Attendance Report</h1> 
         <div class="text-gray-700 text-sm space-x-1 mt-2">
            <span class=" font-bold">Date of attendance: </span>
            <span>{{ $date_attendance }}</span>
         </div>
    </div>
    <div class="border border-b-0 border-gray-200 rounded-md my-5">
        <table class=" table-auto border-collapse w-full overflow-hidden">
            <thead>
                <tr class=" text-gray-600 text-sm font-bold border-b border-b-gray-200">  
                    <td class=" px-3 py-2">Teacher</td>
                    <td class=" px-3 py-2">Classes</td>
                    <td class=" px-3 py-2">Students</td> 
                    <td class=" px-3 py-2">Presents</td>
                    <td class=" px-3 py-2">Absents</td> 
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance) 
                <tr class=" text-gray-500 border-b border-b-gray-200 even:bg-gray-50">
                    <td class=" px-3 py-2 text-sm">{{ $attendance->firstName . ' ' . $attendance->lastName}}</td>
                    <td class=" px-3 py-2 text-sm">{{ count($attendance->classes) }}</td>
                    <td class=" px-3 py-2 text-sm">{{ $attendance->students_overall_total}} </td> 
                    <td class=" px-3 py-2 text-sm">{{ $attendance->presents_overall_total}} </td> 
                    <td class=" px-3 py-2 text-sm">{{ $attendance->absents_overall_total}} </td> 
                </tr> 
                @endforeach
            </tbody>
        </table>
    </div> 
</body>
</html>