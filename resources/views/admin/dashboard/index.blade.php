@extends('admin.layouts.app')

@section('style')
<style>
    .stat-title {
        font-size: 13px;
        color: #6c757d;
    }
    .stat-value {
        font-size: 22px;
        font-weight: 600;
    }
</style>
@endsection

@section('content')

<div class="container-fluid flex-grow-1 container-p-y">

    {{-- ================= WELCOME CARD ================= --}}
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                Welcome Super Admin 🎓
                            </h5>
                            <p class="mb-3">
                                Manage institutes, subscriptions, users and platform growth from one place.
                            </p>
                            <span class="badge bg-label-success">
                                LMS Platform Control Panel
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center">
                        <img src="../assets/img/illustrations/man-with-laptop-light.png"
                             height="130" alt="Dashboard">
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= QUICK STATS ================= --}}
        <div class="col-lg-4">
            <div class="row">
                <div class="col-6 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <span class="stat-title">Institutes</span>
                            <div class="stat-value">24</div>
                            <small class="text-success">Active</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <span class="stat-title">Subscriptions</span>
                            <div class="stat-value">18</div>
                            <small class="text-warning">Running</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= PLATFORM METRICS ================= --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <span class="stat-title">Total Users</span>
                    <div class="stat-value">1,248</div>
                    <small class="text-muted">Across all institutes</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <span class="stat-title">Teachers</span>
                    <div class="stat-value">312</div>
                    <small class="text-muted">Verified</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <span class="stat-title">Students</span>
                    <div class="stat-value">876</div>
                    <small class="text-muted">Enrolled</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <span class="stat-title">Expired Plans</span>
                    <div class="stat-value text-danger">6</div>
                    <small class="text-muted">Needs attention</small>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= SUBSCRIPTION OVERVIEW ================= --}}
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Subscription Overview</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="d-flex justify-content-between mb-3">
                            <span>Basic Plan</span>
                            <span class="fw-medium">8 Institutes</span>
                        </li>
                        <li class="d-flex justify-content-between mb-3">
                            <span>Standard Plan</span>
                            <span class="fw-medium">6 Institutes</span>
                        </li>
                        <li class="d-flex justify-content-between mb-3">
                            <span>Premium Plan</span>
                            <span class="fw-medium">4 Institutes</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ================= REVENUE ================= --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Revenue Summary</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-primary">₹ 4,25,000</h2>
                    <small class="text-muted">Total Subscription Revenue</small>

                    <hr>

                    <div class="d-flex justify-content-around">
                        <div>
                            <small>Monthly</small>
                            <h6>₹ 78,000</h6>
                        </div>
                        <div>
                            <small>Yearly</small>
                            <h6>₹ 3,47,000</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= RECENT ACTIVITY ================= --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">🏫 New institute registered</li>
                        <li class="mb-2">💳 Subscription upgraded to Premium</li>
                        <li class="mb-2">⚠️ Institute plan expired</li>
                        <li class="mb-2">👤 New admin user created</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
{{-- Static dashboard – no JS required --}}
@endsection
