<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Department;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Room::query()->with('department');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('roomname', 'like', "%{$search}%")
                ->orWhereHas('department', function ($q) use ($search) {
                    $q->where('roomname', 'like', "%{$search}%");
                });
        }

        $rooms = $query->latest()->paginate(10);

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('rooms.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'roomname' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $room->load('department');
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $departments = Department::all();
        return view('rooms.edit', compact('room', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'roomname' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully');
    }

    /**
     * Export rooms to PDF.
     */
    public function exportPdf()
    {
        $rooms = Room::with('department')->get();

        $pdf = PDF::loadView('rooms.pdf', [
            'rooms' => $rooms,
            'title' => 'Room Records'
        ]);

        return $pdf->download('room_records_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export individual room to PDF
     */
    public function exportIndividualPdf(Room $room)
    {
        $room->load('department');

        $pdf = PDF::loadView('rooms.individual-pdf', [
            'room' => $room,
            'title' => 'Room Record'
        ]);

        return $pdf->download('room_record_' . $room->id . '_' . now()->format('Y-m-d') . '.pdf');
    }
}
