<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class InstitutesController extends Controller
{
    /**
     * Display institute list page
     */
    public function index()
    {
        return view('admin.institutes.index');
    }

    /**
     * Get all institutes for DataTable (AJAX)
     * status == 1 (Active)
     */
    public function getall(Request $request)
    {
        $institutes = Institute::select(
                'id',
                'name',
                'email',
                'phone',
                'city',
                'status'
            )
            ->latest()
            ->get();

        return response()->json([
            'data' => $institutes,
        ]);
    }

    /**
     * Display institute create page
     */
    public function create()
    {
        return view('admin.institutes.create');
    }


    /**
     * Store new institute (AJAX)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:institutes,email',
            'phone' => 'required|string|max:20',
            'city'  => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        Institute::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'city'   => $request->city,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Institute created successfully'
        ]);
    }

    /**
     * Update status (1 / 0).
     */
    public function status(Request $request)
    {
        try {
            $institute = Institute::find($request->id);
            $institute->status = $request->status;
            $institute->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete subscription plan (Soft Delete).
     */
    public function destroy($id)
    {
        try {
            Institute::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Institute deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
