<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;

class CalendarController extends Controller
{
    // عرض صفحة التقويم
    public function index()
    {
        return view('manager.calendar');
    }

    // إضافة حدث جديد
   public function addEvent(Request $request)
{
    

    

    try {
        CalendarEvent::create([
            'title' => $request->title,
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'event_date' => $request->event_date,
        ]);

        return response()->json(['success'=>true]);
    } catch (\Exception $e) {
        return response()->json(['success'=>false, 'error'=>$e->getMessage()]);
    }


}
public function deleteEvents(Request $request)
{
    $ids = $request->ids; // array of event IDs
    if(!$ids || count($ids) === 0){
        return response()->json(['success'=>false, 'error'=>'No IDs provided']);
    }

    try {
        CalendarEvent::whereIn('id', $ids)->delete();
        return response()->json(['success'=>true]);
    } catch(\Exception $e) {
        return response()->json(['success'=>false, 'error'=>$e->getMessage()]);
    }
}



    // جلب جميع الأحداث
    public function getEvents()
    {
        $events = CalendarEvent::all()->groupBy('event_date');
        return response()->json($events);
    }
    
}
