<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ClassSession;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function addToCalendar($id)
    {
        $event = ClassSession::findOrFail($id);

        $startDate = Carbon::parse($event->start_time)->format('Ymd\THis');
        $endDate = Carbon::parse($event->end_time)->format('Ymd\THis');

        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "PRODID:-//Your Company//Your Product//EN\r\n";
        $ical .= "BEGIN:VEVENT\r\n";
        $ical .= "UID:" . uniqid() . "\r\n";
        $ical .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
        $ical .= "DTSTART:$startDate\r\n";
        $ical .= "DTEND:$endDate\r\n";
        $ical .= "SUMMARY:" . $event->name . "\r\n";
        $ical .= "DESCRIPTION:" . $event->description . "\r\n";
        $ical .= "END:VEVENT\r\n";
        $ical .= "END:VCALENDAR\r\n";

        return response($ical)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="event.ics"');
    }
}
