<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Section;
use App\Models\Instructor;
use App\Models\Room;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::with(['section', 'instructor', 'room', 'course']);
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('course_code', 'like', "%{$search}%")
                  ->orWhereHas('instructor', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('section', function($q) use ($search) {
                      $q->where('section_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('room', function($q) use ($search) {
                      $q->where('roomname', 'like', "%{$search}%");
                  })
                  ->orWhereHas('course', function($q) use ($search) {
                      $q->where('course_name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by day
        if ($request->has('day') && $request->day != '') {
            $query->where('day', $request->day);
        }
        
        $schedules = $query->latest()->paginate(10);
        
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        $instructors = Instructor::all();
        $rooms = Room::all();
        $courses = Course::all();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        return view('schedules.create', compact('sections', 'instructors', 'rooms', 'courses', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'starting_time' => 'required',
            'ending_time' => 'required|after:starting_time',
            'day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'course_code' => 'required|exists:courses,course_code',
            'section_id' => 'required|exists:sections,id',
            'instructor_id' => 'required|exists:instructors,id',
            'room_id' => 'required|exists:rooms,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Check for time conflicts in the same room on the same day
        $conflictingRoom = Schedule::where('day', $request->day)
            ->where('room_id', $request->room_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('starting_time', [$request->starting_time, $request->ending_time])
                    ->orWhereBetween('ending_time', [$request->starting_time, $request->ending_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('starting_time', '<=', $request->starting_time)
                          ->where('ending_time', '>=', $request->ending_time);
                    });
            })->exists();
            
        if ($conflictingRoom) {
            return redirect()->back()
                ->withErrors(['time_conflict' => 'There is a scheduling conflict with this room at the selected time.'])
                ->withInput();
        }
        
        // Check for time conflicts for the instructor on the same day
        $conflictingInstructor = Schedule::where('day', $request->day)
            ->where('instructor_id', $request->instructor_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('starting_time', [$request->starting_time, $request->ending_time])
                    ->orWhereBetween('ending_time', [$request->starting_time, $request->ending_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('starting_time', '<=', $request->starting_time)
                          ->where('ending_time', '>=', $request->ending_time);
                    });
            })->exists();
            
        if ($conflictingInstructor) {
            return redirect()->back()
                ->withErrors(['time_conflict' => 'The instructor already has a class scheduled at this time.'])
                ->withInput();
        }
        
        // Check for time conflicts for the section on the same day
        $conflictingSection = Schedule::where('day', $request->day)
            ->where('section_id', $request->section_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('starting_time', [$request->starting_time, $request->ending_time])
                    ->orWhereBetween('ending_time', [$request->starting_time, $request->ending_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('starting_time', '<=', $request->starting_time)
                          ->where('ending_time', '>=', $request->ending_time);
                    });
            })->exists();
            
        if ($conflictingSection) {
            return redirect()->back()
                ->withErrors(['time_conflict' => 'This section already has a class scheduled at this time.'])
                ->withInput();
        }
        
        Schedule::create($request->all());
        
        return redirect()->route('schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['section', 'instructor', 'room', 'course']);
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $sections = Section::all();
        $instructors = Instructor::all();
        $rooms = Room::all();
        $courses = Course::all();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        return view('schedules.edit', compact('schedule', 'sections', 'instructors', 'rooms', 'courses', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'starting_time' => 'required',
            'ending_time' => 'required|after:starting_time',
            'day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'course_code' => 'required|exists:courses,course_code',
            'section_id' => 'required|exists:sections,id',
            'instructor_id' => 'required|exists:instructors,id',
            'room_id' => 'required|exists:rooms,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Check for time conflicts in the same room on the same day (excluding current schedule)
        $conflictingRoom = Schedule::where('day', $request->day)
            ->where('room_id', $request->room_id)
            ->where('id', '!=', $schedule->id)
            ->where(function($query) use ($request) {
                $query->whereBetween('starting_time', [$request->starting_time, $request->ending_time])
                    ->orWhereBetween('ending_time', [$request->starting_time, $request->ending_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('starting_time', '<=', $request->starting_time)
                          ->where('ending_time', '>=', $request->ending_time);
                    });
            })->exists();
            
        if ($conflictingRoom) {
            return redirect()->back()
                ->withErrors(['time_conflict' => 'There is a scheduling conflict with this room at the selected time.'])
                ->withInput();
        }
        
        // Check for time conflicts for the instructor on the same day (excluding current schedule)
        $conflictingInstructor = Schedule::where('day', $request->day)
            ->where('instructor_id', $request->instructor_id)
            ->where('id', '!=', $schedule->id)
            ->where(function($query) use ($request) {
                $query->whereBetween('starting_time', [$request->starting_time, $request->ending_time])
                    ->orWhereBetween('ending_time', [$request->starting_time, $request->ending_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('starting_time', '<=', $request->starting_time)
                          ->where('ending_time', '>=', $request->ending_time);
                    });
            })->exists();
            
        if ($conflictingInstructor) {
            return redirect()->back()
                ->withErrors(['time_conflict' => 'The instructor already has a class scheduled at this time.'])
                ->withInput();
        }
        
        // Check for time conflicts for the section on the same day (excluding current schedule)
        $conflictingSection = Schedule::where('day', $request->day)
            ->where('section_id', $request->section_id)
            ->where('id', '!=', $schedule->id)
            ->where(function($query) use ($request) {
                $query->whereBetween('starting_time', [$request->starting_time, $request->ending_time])
                    ->orWhereBetween('ending_time', [$request->starting_time, $request->ending_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('starting_time', '<=', $request->starting_time)
                          ->where('ending_time', '>=', $request->ending_time);
                    });
            })->exists();
            
        if ($conflictingSection) {
            return redirect()->back()
                ->withErrors(['time_conflict' => 'This section already has a class scheduled at this time.'])
                ->withInput();
        }
        
        $schedule->update($request->all());
        
        return redirect()->route('schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        
        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
    
    /**
     * Export schedules to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Schedule::with(['section', 'instructor', 'room', 'course']);
        
        // Apply filters if provided
        if ($request->has('day') && $request->day != '') {
            $query->where('day', $request->day);
        }
        
        if ($request->has('instructor_id') && $request->instructor_id != '') {
            $query->where('instructor_id', $request->instructor_id);
        }
        
        if ($request->has('section_id') && $request->section_id != '') {
            $query->where('section_id', $request->section_id);
        }
        
        if ($request->has('room_id') && $request->room_id != '') {
            $query->where('room_id', $request->room_id);
        }
        
        // Get all schedules with the applied filters
        $schedules = $query->orderBy('day')->orderBy('starting_time')->get();
        
        // Group schedules by day for cleaner display
        $groupedSchedules = $schedules->groupBy('day');
        
        // Set PDF title based on filters
        $title = 'Schedule ';
        
        if ($request->has('day') && $request->day != '') {
            $title .= 'for ' . $request->day . ' ';
        }
        
        if ($request->has('instructor_id') && $request->instructor_id != '') {
            $instructor = Instructor::find($request->instructor_id);
            $title .= 'for ' . $instructor->first_name . ' ' . $instructor->last_name . ' ';
        }
        
        if ($request->has('section_id') && $request->section_id != '') {
            $section = Section::find($request->section_id);
            $title .= 'for Section ' . $section->name . ' ';
        }
        
        if ($request->has('room_id') && $request->room_id != '') {
            $room = Room::find($request->room_id);
            $title .= 'for Room ' . $room->name . ' ';
        }
        
        $title .= 'Records';
        
        // Load PDF view
        $pdf = PDF::loadView('schedules.pdf', [
            'groupedSchedules' => $groupedSchedules,
            'title' => $title
        ]);
        
        // Download the PDF file
        return $pdf->download('schedule_records_' . now()->format('Y-m-d') . '.pdf');
    }
}