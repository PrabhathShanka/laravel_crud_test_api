<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Jobs\SendRegistrationEmail;
use App\Jobs\SendRegistrationSuccessMail;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\RegistrationSuccessMail;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function store(StoreRegistrationRequest $request)
    {
        try {
            $registration = Registration::create($request->validated());

            // Dispatch the job to send email
            SendRegistrationEmail::dispatch($request->validated())->onQueue('emails');

            return response()->json(['message' => 'Successfully registered!'], 201);
        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong during registration.',
                'error' => $e->getMessage() // Remove in production for security
            ], 500);
        }
    }
}
