<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        
        return view('exams.room', compact('rooms'));
    }
    
    public function addRoom(Request $request)
    {
    
    $data = $request->validate([
        'room_name' => 'required|string|max:255',
        'room_status' => 'required|string|max:255',
    ]);
    // dd($data);

    
    $room = new Room();

    
    $room->room_name = $data['room_name'];
    $room->room_status = $data['room_status']; 
    
    $room->save();
    

    return response()->json(['message' => 'success']);

    }

    public function deleteRoom(Request $request)
    {
    $roomId = $request->input('room_id');
    $room = Room::find($roomId);

   
    $room->delete();

    return response()->json(['message' => 'success']);
    }

    public function updateRoom(Request $request)
    {
    $roomId = $request->input('room_id');
    $roomName = $request->input('room_name');
    $roomStatus = $request->input('room_status');

    $room = Room::find($roomId);

    $room->room_name = $roomName;
    $room->room_status = $roomStatus;
    $room->save();

    return response()->json(['message' => 'Room name updated']);
    }



 

    
}
