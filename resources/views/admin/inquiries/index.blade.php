@extends('layouts.admin')

@section('title', 'Enquiries')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Enquiries</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Enquiries</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card blue">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Enquiries</p>
                        <h3 class="mb-0" id="totalCount">{{ $totalCount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card pink">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Unread</p>
                        <h3 class="mb-0" id="unreadCount">{{ $unreadCount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="bi bi-envelope-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Investor</p>
                        <h3 class="mb-0" id="investorCount">{{ $investorCount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Events</p>
                        <h3 class="mb-0" id="eventCount">{{ $eventCount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Inquiries Table -->
    <div class="content-card">
        <div class="card-header">
            <h5><i class="bi bi-list-ul me-2"></i>All Enquiries</h5>
            <div class="d-flex gap-2">
                <select id="typeFilter" class="form-select form-select-sm" style="width: 150px;">
                    <option value="">All Types</option>
                    @if(auth()->user()->role === 'admin')
                        <option value="general">General</option>
                        <option value="investor">Investor</option>
                        <option value="event">Event</option>
                    @endif
                    <option value="property">Property</option>
                </select>
                <select id="statusFilter" class="form-select form-select-sm" style="width: 150px;">
                    <option value="">All Status</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="inquiriesTable" class="table admin-table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 30px;"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Source</th>
                            <th>Date</th>
                            <th style="width: 150px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inquiries as $inquiry)
                            <tr class="{{ !$inquiry->is_read ? 'table-active' : '' }}"
                                data-status="{{ $inquiry->is_read ? 'read' : 'unread' }}" data-type="{{ $inquiry->type }}">
                                <td>
                                    @if(!$inquiry->is_read)
                                        <i class="bi bi-circle-fill text-pink" style="font-size: 8px;"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $inquiry->name }}</div>
                                    @if($inquiry->budget)
                                        <small class="text-pink fw-bold">Budget: {{ $inquiry->budget }}</small><br>
                                    @endif
                                    @if($inquiry->comments)
                                        <small class="text-muted">{{ Str::limit($inquiry->comments, 40) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $inquiry->email }}"
                                        class="text-decoration-none">{{ $inquiry->email }}</a>
                                </td>
                                <td>
                                    <a href="tel:{{ $inquiry->phone }}" class="text-decoration-none">{{ $inquiry->phone }}</a>
                                </td>
                                <td>
                                    @if($inquiry->type === 'general')
                                        <span class="badge badge-admin bg-primary">General</span>
                                    @elseif($inquiry->type === 'investor')
                                        <span class="badge badge-admin bg-success">Investor</span>
                                    @elseif($inquiry->type === 'event')
                                        <span class="badge badge-admin bg-warning">Event</span>
                                    @elseif($inquiry->type === 'property')
                                        <span class="badge badge-admin bg-info">Property</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $inquiry->source_page ?? 'N/A' }}</small>
                                </td>
                                <td data-order="{{ $inquiry->created_at->timestamp }}">
                                    <small class="text-muted">{{ $inquiry->created_at->format('M d, Y') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $inquiry->created_at->format('h:i A') }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.inquiries.show', $inquiry->id) }}"
                                            class="btn btn-sm btn-admin-edit" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(!$inquiry->is_read)
                                            <form action="{{ route('admin.inquiries.mark-read', $inquiry->id) }}" method="POST"
                                                class="d-inline mark-read-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-admin-edit" title="Mark as Read">
                                                    <i class="bi bi-check2"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-admin-delete" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        .table-active {
            background-color: rgba(249, 92, 168, 0.05) !important;
            font-weight: 500;
        }

        /* DataTables Wrapper */
        .dataTables_wrapper {
            padding: 0;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            padding: 20px 25px;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e3e6f0;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.9rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 8px;
            width: 250px;
        }

        .dataTables_wrapper .dataTables_info {
            padding: 20px 25px;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 20px 25px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px;
            margin: 0 2px;
            padding: 6px 12px;
            border: 1px solid #e3e6f0;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f8f9fc;
            border-color: #e3e6f0;
            color: var(--primary-blue) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--primary-blue), #2a5a9e) !important;
            border-color: var(--primary-blue) !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: linear-gradient(135deg, #2a5a9e, var(--primary-blue)) !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Table Styling */
        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #e3e6f0 !important;
        }

        table.dataTable tbody tr {
            transition: background-color 0.2s;
        }

        table.dataTable tbody tr:hover {
            background-color: #f8f9fc !important;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid #e3e6f0;
        }

        /* Sorting Icons */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            cursor: pointer;
            position: relative;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            opacity: 0.3;
            font-family: 'Bootstrap Icons';
            position: absolute;
            right: 10px;
        }

        table.dataTable thead .sorting:after {
            content: '\F282';
        }

        table.dataTable thead .sorting_asc:after {
            content: '\F145';
            opacity: 1;
            color: var(--primary-blue);
        }

        table.dataTable thead .sorting_desc:after {
            content: '\F148';
            opacity: 1;
            color: var(--primary-blue);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#inquiriesTable').DataTable({
                order: [[6, 'desc']], // Sort by date column (newest first)
                pageLength: 25,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search by name, email, phone...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ inquiries",
                    infoEmpty: "No Enquiries found",
                    infoFiltered: "(filtered from _MAX_ total inquiries)"
                },
                columnDefs: [
                    { orderable: false, targets: [0, 7] } // Disable sorting on status dot and actions columns
                ]
            });

            // Custom filter function for type and status
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var typeFilter = $('#typeFilter').val();
                    var statusFilter = $('#statusFilter').val();
                    var row = table.row(dataIndex).node();
                    var rowType = $(row).data('type');
                    var rowStatus = $(row).data('status');

                    // Type filter
                    if (typeFilter && rowType !== typeFilter) {
                        return false;
                    }

                    // Status filter
                    if (statusFilter && rowStatus !== statusFilter) {
                        return false;
                    }

                    return true;
                }
            );

            // Type filter
            $('#typeFilter').on('change', function () {
                table.draw();
            });

            // Status filter
            $('#statusFilter').on('change', function () {
                table.draw();
            });

            // Delete confirmation
            $('.delete-form').on('submit', function (e) {
                if (!confirm('Are you sure you want to delete this inquiry?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush