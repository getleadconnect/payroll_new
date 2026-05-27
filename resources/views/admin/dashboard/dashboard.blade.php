@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>
.dash-wrap { font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

.page-head {
    display:flex; justify-content:space-between; align-items:center;
    margin: 4px 0 18px;
}
.page-head h3 {
    margin:0; font-size:22px; font-weight:600; color:#1f2d3d;
}
.page-head .crumb {
    font-size:12.5px; color:#6b7a8f;
}

.stat-card {
    background:#fff;
    border-radius:14px;
    padding:18px;
    box-shadow:0 4px 18px rgba(15,35,70,0.06);
    border:1px solid #eef1f6;
    display:flex; align-items:center; justify-content:space-between;
    transition: transform .15s ease, box-shadow .15s ease;
    height:100%;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow:0 10px 24px rgba(15,35,70,0.09);
}
.stat-card .meta { min-width:0; }
.stat-card .label {
    font-size:12px; color:#6b7a8f;
    text-transform:uppercase; letter-spacing:.4px;
    margin:0 0 6px; font-weight:500;
}
.stat-card .value {
    font-size:22px; font-weight:600; color:#1f2d3d; margin:0;
    line-height:1.1;
}
.stat-card .sub {
    font-size:11.5px; color:#8a97aa; margin-top:4px;
}
.stat-card .icon-box {
    width:46px; height:46px; border-radius:12px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:17px; color:#fff;
    box-shadow:0 6px 14px rgba(0,0,0,0.08);
    flex-shrink:0; margin-left:12px;
}
.icon-grad-1 { background:linear-gradient(135deg,#ff6a6a,#ee3b3b); }
.icon-grad-2 { background:linear-gradient(135deg,#4caf50,#2f7a10); }
.icon-grad-3 { background:linear-gradient(135deg,#36b9f0,#2196f3); }
.icon-grad-4 { background:linear-gradient(135deg,#a370f7,#7e3ff2); }
.icon-grad-5 { background:linear-gradient(135deg,#ffb648,#ff8a00); }
.icon-grad-6 { background:linear-gradient(135deg,#26c6da,#00838f); }
.icon-grad-7 { background:linear-gradient(135deg,#66bb6a,#1b5e20); }
.icon-grad-8 { background:linear-gradient(135deg,#ec407a,#ad1457); }

.panel-card {
    background:#fff;
    border-radius:14px;
    border:1px solid #eef1f6;
    box-shadow:0 4px 18px rgba(15,35,70,0.05);
    overflow:hidden;
    height:100%;
}
.panel-card .panel-head {
    display:flex; justify-content:space-between; align-items:center;
    padding:14px 20px;
    border-bottom:1px solid #f0f2f6;
}
.panel-card .panel-head h4 {
    margin:0; font-size:15px; font-weight:600; color:#1f2d3d;
}
.panel-card .panel-head .head-sub {
    font-size:12px; color:#8a97aa;
}
.panel-card .panel-body { padding:18px 20px; }

.kv-table { width:100%; font-size:13.5px; }
.kv-table td { padding:7px 0; vertical-align:top; }
.kv-table td.k { color:#6b7a8f; width:110px; font-weight:500; }
.kv-table td.s { width:18px; color:#b6bfcf; }
.kv-table td.v { color:#1f2d3d; word-break:break-word; }
.kv-table tr + tr td { border-top:1px dashed #eef1f6; }

.rev-list { display:flex; flex-direction:column; gap:12px; }
.rev-item {
    padding:14px 16px;
    border-radius:12px;
    border:1px solid #eef1f6;
    background:#fafbfd;
    display:flex; justify-content:space-between; align-items:center;
}
.rev-item .left .lbl {
    font-size:11.5px; color:#6b7a8f;
    text-transform:uppercase; letter-spacing:.4px;
}
.rev-item .left .desc {
    font-size:12px; color:#8a97aa; margin-top:2px;
}
.rev-item .amt {
    font-size:18px; font-weight:600;
}
.rev-item.income   { border-left:4px solid #4caf50; }
.rev-item.income   .amt { color:#2f7a10; }
.rev-item.expense  { border-left:4px solid #ee3b3b; }
.rev-item.expense  .amt { color:#c62828; }
.rev-item.net      { border-left:4px solid #2196f3; }
.rev-item.net      .amt { color:#1565c0; }
.rev-item.lifetime { border-left:4px solid #7e3ff2; }
.rev-item.lifetime .amt { color:#4a1fb8; font-size:15px; }

.recent-table { width:100%; font-size:13px; }
.recent-table thead th {
    text-align:left;
    font-size:11.5px; font-weight:600; color:#6b7a8f;
    text-transform:uppercase; letter-spacing:.3px;
    padding:10px 12px;
    background:#f7f9fc;
    border-bottom:1px solid #eef1f6;
}
.recent-table tbody td {
    padding:12px;
    border-bottom:1px solid #f3f5f9;
    color:#1f2d3d; vertical-align:middle;
}
.recent-table tbody tr:last-child td { border-bottom:0; }

.badge-pill-soft {
    display:inline-block; padding:3px 10px; border-radius:20px;
    font-size:11px; font-weight:500;
}
.badge-active   { background:#e6f4ea; color:#2f7a10; }
.badge-inactive { background:#fdecec; color:#c62828; }

.btn-edit-sm {
    background:#bcd1f4; color:#3a4a5e; border:0;
    padding:6px 10px; border-radius:8px; font-size:12px;
    transition:background .15s;
}
.btn-edit-sm:hover { background:#98bbf6; color:#1f2d3d; }

.empty {
    text-align:center; color:#8a97aa; padding:36px 12px; font-size:13px;
}

.chart-frame {
    width: 100%;
    height: 260px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.chart-frame canvas {
    max-width: 100%;
    max-height: 100%;
}
</style>

@php
$role     = Session::get('admin_role_id');
$net      = $monthly_income - $monthly_expense;
$currency = '₹';
@endphp

<div class="dash-wrap">

    <div class="page-head">
        <div>
            <h3>Dashboard</h3>
            <div class="crumb">Welcome back, {{ Session::get('admin_name') ?? 'Admin' }} — here's what's happening today.</div>
        </div>
        <div class="crumb">{{ \Carbon\Carbon::now()->format('l, d M Y') }}</div>
    </div>

    @if($role==1)

    <!-- Stat cards row -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Labours</p>
                    <p class="value">{{ $lbr_count }}</p>
                    <div class="sub">Total registered labourers</div>
                </div>
                <span class="icon-box icon-grad-1"><i class="fas fa-users"></i></span>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Projects</p>
                    <p class="value">{{ $prj_count }}</p>
                    <div class="sub">{{ $active_prj_count }} active</div>
                </div>
                <span class="icon-box icon-grad-2"><i class="fas fa-building"></i></span>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Completed Projects</p>
                    <p class="value">{{ $completed_prj_count }}</p>
                    <div class="sub">Marked as completed</div>
                </div>
                <span class="icon-box icon-grad-7"><i class="fas fa-check-circle"></i></span>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Staffs</p>
                    <p class="value">{{ $stf_count }}</p>
                    <div class="sub">On-roll staff members</div>
                </div>
                <span class="icon-box icon-grad-3"><i class="fas fa-user-tie"></i></span>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Clients</p>
                    <p class="value">{{ $client_count }}</p>
                    <div class="sub">Total clients onboarded</div>
                </div>
                <span class="icon-box icon-grad-4"><i class="fas fa-handshake"></i></span>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Sub-Contractors</p>
                    <p class="value">{{ $sub_count }}</p>
                    <div class="sub">Active partner contractors</div>
                </div>
                <span class="icon-box icon-grad-5"><i class="fas fa-hard-hat"></i></span>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Suppliers</p>
                    <p class="value">{{ $supplier_count }}</p>
                    <div class="sub">Registered material suppliers</div>
                </div>
                <span class="icon-box icon-grad-6"><i class="fas fa-truck"></i></span>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="meta">
                    <p class="label">Active Users</p>
                    <p class="value">{{ $active_user_count }}</p>
                    <div class="sub">Admin users currently active</div>
                </div>
                <span class="icon-box icon-grad-8"><i class="fas fa-user-shield"></i></span>
            </div>
        </div>
    </div>

    <!-- Yearly project count chart + Company info -->
    <div class="row mt-2">
        <div class="col-xl-6 col-lg-6 mb-3">
            <div class="panel-card">
                <div class="panel-head">
                    <h4>Yearly Project Count</h4>
                    <span class="head-sub">Last 6 years</span>
                </div>
                <div class="panel-body">
                    <div class="chart-frame">
                        <canvas id="yearlyProjectsChart" width="640" height="260"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-3">
            <div class="panel-card">
                <div class="panel-head">
                    <h4>Company Info</h4>
                    @if($cm)
                    <button id="btnEdit" data-id="{{ $cm->id }}" class="btn-edit-sm" data-toggle="modal" title="Edit Company">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    @endif
                </div>
                <div class="panel-body">
                    @if($cm)
                    <table class="kv-table">
                        <tr><td class="k">Company</td><td class="s">:</td><td class="v">{{ $cm->company_name }}</td></tr>
                        <tr><td class="k">Address</td><td class="s">:</td><td class="v">{{ $cm->address }}</td></tr>
                        <tr><td class="k">Email</td><td class="s">:</td><td class="v">{{ $cm->email }}</td></tr>
                        <tr><td class="k">Phone</td><td class="s">:</td><td class="v">{{ $cm->mobile }}</td></tr>
                        <tr><td class="k">GST No</td><td class="s">:</td><td class="v">{{ $cm->gst_no }}</td></tr>
                        <tr><td class="k">PAN No</td><td class="s">:</td><td class="v">{{ $cm->pan_no }}</td></tr>
                        @if(!empty($cm->others))
                        <tr><td class="k">Others</td><td class="s">:</td><td class="v">{{ $cm->others }}</td></tr>
                        @endif
                    </table>
                    @else
                    <div class="empty">No company info available.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent projects -->
    <div class="row mt-2">
        <div class="col-12 mb-3">
            <div class="panel-card">
                <div class="panel-head">
                    <h4>Recent Projects</h4>
                    <a href="{{ url('projects') }}" class="head-sub" style="text-decoration:none;color:#2f7a10;font-weight:500;">
                        View all <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>
                <div class="panel-body" style="padding:0;">
                    @if($recent_projects && count($recent_projects))
                    <div class="table-responsive">
                        <table class="recent-table">
                            <thead>
                                <tr>
                                    <th style="padding-left:20px;">Project</th>
                                    <th>Client</th>
                                    <th>Start</th>
                                    <th>Finish</th>
                                    <th class="text-right">Cost</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_projects as $p)
                                <tr>
                                    <td style="padding-left:20px;font-weight:500;">{{ $p->project_name }}</td>
                                    <td>{{ $p->client_name ?? '—' }}</td>
                                    <td>{{ $p->start_date ? \Carbon\Carbon::parse($p->start_date)->format('d M Y') : '—' }}</td>
                                    <td>{{ $p->finish_date ? \Carbon\Carbon::parse($p->finish_date)->format('d M Y') : '—' }}</td>
                                    <td class="text-right">{{ $currency }}{{ number_format((float) $p->cost, 2) }}</td>
                                    <td>
                                        @if($p->status==1)
                                        <span class="badge-pill-soft badge-active">Active</span>
                                        @else
                                        <span class="badge-pill-soft badge-inactive">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty">No projects yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="row">
        <div class="col-12">
            <div class="panel-card">
                <div class="panel-body empty">
                    <i class="fas fa-info-circle" style="font-size:28px;color:#b6bfcf;"></i>
                    <p class="mt-2 mb-0">Your dashboard view will appear here.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="padding-bottom:.5rem;"></div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
$('#btnEdit').click(function () {
    var cid = $(this).attr('data-id');
    var Result = $("#basicModal-1 .modal-body");
    $(this).attr('data-target', '#basicModal-1');
    jQuery.ajax({
        type: "GET",
        url: "edit-company/" + cid,
        dataType: 'html',
        success: function (res) { Result.html(res); }
    });
});

@if($role==1)
jQuery(function () {
    var canvas = document.getElementById('yearlyProjectsChart');
    if (!canvas || typeof Chart === 'undefined') return;
    if (canvas.dataset.inited === '1') return;
    canvas.dataset.inited = '1';

    var labels = {!! json_encode(array_column($yearly_projects, 'year')) !!};
    var counts = {!! json_encode(array_column($yearly_projects, 'cnt')) !!};

    new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Projects',
                data: counts,
                backgroundColor: 'rgba(74, 163, 223, 0.85)',
                hoverBackgroundColor: 'rgba(46, 127, 184, 0.95)',
                borderRadius: 6,
                barPercentage: 0.55,
                categoryPercentage: 0.6
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            animation: false,
            legend: { display: false },
            tooltips: {
                backgroundColor: '#1f2d3d',
                titleFontSize: 12,
                bodyFontSize: 12,
                callbacks: {
                    label: function (item) { return ' Projects: ' + item.yLabel; }
                }
            },
            scales: {
                xAxes: [{
                    gridLines: { display: false, drawBorder: false },
                    ticks: { fontColor: '#6b7a8f', fontSize: 12 }
                }],
                yAxes: [{
                    gridLines: { color: '#f0f2f6', drawBorder: false, zeroLineColor: '#e4e9f0' },
                    ticks: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1,
                        fontColor: '#8a97aa',
                        fontSize: 11
                    }
                }]
            }
        }
    });
});
@endif
</script>
@endpush

@endsection
