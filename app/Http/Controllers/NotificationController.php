<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected NotificationService $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService=$notificationService;
        $this->middleware(['auth:api'])->only('index');
    }

    public function index()
    {
        // Get the authenticated user
        $authUserId = auth()->id(); // This assumes you're using Laravel's built-in authentication

        // Fetch notifications for the authenticated user, along with related course and subject info
        $notifications = Notification::with(['course.subject']) ->with('user')// Eager load course and subject
        ->where('receiver', $authUserId) // Filter notifications by the authenticated user's ID
        ->get();

        return ['data' => $notifications];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function sendNotification(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'tokens' => 'required',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'additionalData' => 'nullable|array',
        ]);

        // Call the notification service
        $tokens = $validatedData['tokens'];
        $title = $validatedData['title'];
        $body = $validatedData['body'];
        $additionalData = $validatedData['additionalData'] ?? [];

        $response = $this->notificationService->notification($tokens, $title, $body, $additionalData);

        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully!',
            'response' => $response
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
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
    public function update(UpdateNotificationRequest $request, Notification $notification)
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
