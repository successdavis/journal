<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use function Laravel\Prompts\form;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        $notifications = Notification::where('receiver_id', $user_id)->get();
        $notificationsCount = Notification::where('receiver_id', $user_id)->where('status', false)->count();

        if ($notifications) {
            return response()->json([$notifications, $notificationsCount]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function notificationsRead($user_id)
    {
        $readNotifications = Notification::where('receiver_id', $user_id)->where('status', false)->get();
        $notifications = Notification::where('receiver_id', $user_id)->get();

        foreach ($readNotifications as $notification) {
            $notification->status = true;
            $notification->save();
        }
        return response()->json($notifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
