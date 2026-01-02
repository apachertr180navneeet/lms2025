<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class SubscriptionPlanController extends Controller
{
    /**
     * Display subscription plans list page
     */
    public function index()
    {
        return view('admin.subscription_plans.index');
    }

    /**
     * Get all subscription plans (AJAX - DataTable)
     */
    public function getAll(Request $request)
    {
        $plans = SubscriptionPlan::select(
                'id',
                'name',
                'price',
                'duration_days',
                'decscription',
                'status'
            )
            ->latest()
            ->get();

        return response()->json([
            'data' => $plans,
        ]);
    }

    /**
     * Display create plan page
     */
    public function create()
    {
        return view('admin.subscription_plans.create');
    }

    /**
     * Store new subscription plan (AJAX)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255|unique:subscription_plans,name',
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'description'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        SubscriptionPlan::create([
            'name'          => $request->name,
            'price'         => $request->price,
            'duration_days' => $request->duration_days,
            'decscription'   => $request->description,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Subscription plan created successfully'
        ]);
    }

    /**
     * Edit subscription plan
     */
    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('admin.subscription_plans.edit', compact('plan'));
    }

    /**
     * Update subscription plan (AJAX)
     */
    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255|unique:subscription_plans,name,' . $plan->id,
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'description'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $plan->update([
            'name'          => $request->name,
            'price'         => $request->price,
            'duration_days' => $request->duration_days,
            'decscription'   => $request->description,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Subscription plan updated successfully'
        ]);
    }

    /**
     * Update plan status (Active / Inactive)
     */
    public function status(Request $request)
    {
        try {
            $plan = SubscriptionPlan::findOrFail($request->id);
            $plan->status = $request->status;
            $plan->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Delete subscription plan (Soft Delete)
     */
    public function destroy($id)
    {
        try {
            SubscriptionPlan::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Subscription plan deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
