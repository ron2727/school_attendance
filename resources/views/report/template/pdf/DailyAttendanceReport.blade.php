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
            <span class=" font-bold">Subject: </span>
            <span>{{ $class->subject }}</span>
         </div>
         <div class="text-gray-700 text-sm space-x-1 mt-1">
            <span class=" font-bold">Teacher: </span>
            <span>{{ Auth::user()->firstName. ' ' .Auth::user()->lastName}}</span>
         </div>
        <div class="text-gray-700 text-sm space-x-1 mt-1">
            <span class=" font-bold">Time of class: </span>
            <span>{{ $class->time_from. ' - ' .$class->time_to }}</span>
         </div>
         <div class="text-gray-700 text-sm space-x-1 mt-1">
            <span class=" font-bold">Date of attendance: </span>
            <span>{{ $date_attendance }}</span>
         </div>
    </div>
    <div class="border border-b-0 border-gray-200 rounded-md my-5">
        <table class=" table-auto border-collapse w-full overflow-hidden">
            <thead>
                <tr class=" text-gray-600 text-sm font-bold border-b border-b-gray-200">  
                    <td class=" px-3 py-2">Student</td>
                    <td class=" px-3 py-2">Status</td> 
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance) 
                <tr class=" text-gray-500 border-b border-b-gray-200 even:bg-gray-50">
                    <td class=" px-3 py-2 text-sm">{{ $attendance->student->firstName. ' ' .$attendance->student->lastName}}</td>
                    <td class=" px-3 py-2 text-sm">{{ $attendance->status }}</td> 
                </tr> 
                @endforeach
            </tbody>
        </table>
    </div> 
</body>
</html>