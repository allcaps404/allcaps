@extends('layouts.admin.index')
@section('title', 'Environment Report - Table View')

@section('content')
    <div class="content-wrapper" style="padding: 20px 10px;">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm" style="border-radius: 10px;">
                    <div class="card-body">
                        @if ($data->isEmpty())
                            <p>No data available.</p>
                        @else
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <a class="btn btn-outline-primary me-2 {{ request()->routeIs('environment.log') ? 'active' : '' }}" href="{{ route('environment.log', ['page' => $data->currentPage()]) }}"> 
                                        Table View
                                    </a>
                                    <a class="btn btn-outline-primary {{ request()->routeIs('environment.chart') ? 'active' : '' }}" href="{{ route('environment.chart', ['page' => $data->currentPage()]) }}">
                                        Chart View
                                    </a>
                                </div>
                                <div>
                                    <button class="btn btn-success btn-md" data-bs-toggle="modal" data-bs-target="#renameModal"> 
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </div>
                            </div>

                            <!-- Rename Modal -->
                            <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="renameModalLabel">Rename File</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('environment.export.csv') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ $data->currentPage() }}"> <!-- Current page -->
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="filename" class="form-label">New Filename (without extension)</label>
                                                    <input type="text" class="form-control" id="filename" name="filename" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Download</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Responsive Table Wrapper -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Temperature</th>
                                            <th>Humidity</th>
                                            <th>Soil Moisture</th>
                                            <th>Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $entry)
                                            <tr>
                                                <td>{{ number_format($entry->temperature, 2) }} °C</td>
                                                <td>{{ number_format($entry->humidity, 2) }} %</td>
                                                <td>{{ number_format($entry->soil_moisture, 2) }} %</td>
                                                <td>{{ $entry->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $data->appends(request()->input())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS for modal functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection