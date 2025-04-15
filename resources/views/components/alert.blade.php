@props(['type' => 'success', 'message' => ''])

@php
    $alertType = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ][$type] ?? 'alert-info';
@endphp

@if ($message)
    <div class="alert {{ $alertType }} alert-dismissible fade show mt-2" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
