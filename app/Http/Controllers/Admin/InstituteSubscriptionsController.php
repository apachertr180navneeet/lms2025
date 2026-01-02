<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    InstituteSubscription,
    SubscriptionPlan,
    Institute
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class InstituteSubscriptionsController extends Controller
{
    /**
     * Display subscription plans list page
     */
    public function index()
    {
        return view('admin.institute_subscription.index');
    }

    /**
     * Get all subscription plans (AJAX - DataTable)
     */
    public function getAll(Request $request)
    {
        $subscriptions = InstituteSubscription::with(['institute', 'plan'])
            ->latest()
            ->get()
            ->map(function ($sub) {
                return [
                    'id' => $sub->id,
                    'institute_name' => $sub->institute->name ?? '-',
                    'plan_name' => $sub->plan->name ?? '-',
                    'start_date' => $sub->start_date,
                    'end_date' => $sub->end_date,
                    'teacher_count' => $sub->teacher_count,
                    'student_count' => $sub->student_count,
                ];
            });

        return response()->json([
            'data' => $subscriptions
        ]);
    }

    /**
     * Display create plan page
     */
    public function create()
    {
        $institutes = Institute::where('status', 1)->get();
        $plans = SubscriptionPlan::where('status', 1)->get();

        return view('admin.institute_subscription.create', compact('institutes', 'plans'));
    }

    /**
     * Store institute subscription (AJAX)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'institute_id'          => 'required|exists:institutes,id',
            'subscription_plan_id'  => 'required|exists:subscription_plans,id',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after:start_date',
            'teacher_count'         => 'required|integer|min:0',
            'student_count'         => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        InstituteSubscription::create([
            'institute_id'         => $request->institute_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'start_date'           => $request->start_date,
            'end_date'             => $request->end_date,
            'teacher_count'        => $request->teacher_count,
            'student_count'        => $request->student_count,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Institute subscription assigned successfully'
        ]);
    }

    /**
     * Edit subscription plan
     */
    public function edit($id)
    {
        $institutes = Institute::where('status', 1)->get();
        $plans = SubscriptionPlan::where('status', 1)->get();
        $institutesubscription = InstituteSubscription::findOrFail($id);
        return view('admin.institute_subscription.edit', compact('institutesubscription', 'institutes', 'plans'));
    }

    /**
     * Update subscription plan (AJAX)
     */
    /**
     * Update institute subscription (AJAX)
     */
    public function update(Request $request, $id)
    {
        $subscription = InstituteSubscription::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'institute_id'          => 'required|exists:institutes,id',
            'subscription_plan_id'  => 'required|exists:subscription_plans,id',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after:start_date',
            'teacher_count'         => 'required|integer|min:0',
            'student_count'         => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $subscription->update([
            'institute_id'         => $request->institute_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'start_date'           => $request->start_date,
            'end_date'             => $request->end_date,
            'teacher_count'        => $request->teacher_count,
            'student_count'        => $request->student_count,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Institute subscription updated successfully'
        ]);
    }

    /**
     * Delete subscription plan (Soft Delete)
     */
    public function destroy($id)
    {
        try {
            InstituteSubscription::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Institute subscription plan deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
