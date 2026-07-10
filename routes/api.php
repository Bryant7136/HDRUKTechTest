<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\json;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/list', function(Request $request){
    // Extract all the events from the table Need to think about validating information
     function index(){
        $events = DB::table("events") ->select("event_name","event_date","current_attendees") ->sharedLock() ->get();
    
        return $events;
    };
    return response() -> json(index());
}
);

Route::post("/create",function(Request $request)
{
    // Get data from the request, needs to be validated before anything happens to put it into the database.
    $data = json_decode(file_get_contents('php://input'),true);
    try{
    $created = DB::insert('insert into events (event_name,event_date,current_attendees) values(?,?,?)',[$data['event_name'],$data['event_date'],$data['current_attendees']]);
    }
    catch(PDOException $e)
    {
        return $e;
    }
    return ("Event Created Successfully");
});

Route::put("/update_event", function(Request $request)
{
    $data = json_decode(file_get_contents('php://input'),true);
    try{
    $updated = DB::table('events')->where('event_name',$data['event_name'])->update(['current_attendees' => $data['current_attendees']]);
    }
    catch( PDOException $e )
    {
        return $e;
    }
    return('Event Updated Successfully');
}
);

Route::put("/update_attendees", function(Request $request)
{
    $data = json_decode(file_get_contents('php://input'),true);
    if ($data['current_attendees'] == "increase")
        {
            try{
            DB::table('events')->where('event_name',$data['event_name']) -> increment('current_attendees');
            }
            catch (PDOException $e)
            {
                return $e;
            }
        return("attendees increased");
        }
    else
        {
            DB::table('events')->where('event_name',$data['event_name']) -> decrement('current_attendees');
        return("attendees decreased");
        }
    
}
);

Route::delete("/remove", function(Request $request)
{
        $data = json_decode(file_get_contents('php://input'),true);
        try{
        $deleted = DB::table('events')->where('event_name', '=',$data['event_name'])->delete();
        }
        catch(PDOException $e)
        {
            return $e;
        }
    return 'Event Deleted';
}
);