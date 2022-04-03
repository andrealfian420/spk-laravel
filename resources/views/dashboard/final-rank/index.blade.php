@extends('layouts.main')

@section('content')
  <style>
    .badge:hover {
      color: #fff !important;
      text-decoration: none;
    }

    .bg-success:hover {
      background: #2f9164 !important;
    }

    .bg-danger:hover {
      background: #e84a59 !important;
    }
  </style>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Final Rank</h1>
  </div>

  <div class="table-responsive col-lg-10">

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col" class="text-center">#</th>
          <th scope="col" class="text-center">Created By</th>
          <th scope="col" class="text-center">Created At</th>
          <th scope="col" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @if ($criteria_analyses->count())
          @foreach ($criteria_analyses as $analysis)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td class="text-center">{{ $analysis->user->name }}</td>
              <td class="text-center">{{ $analysis->created_at->toFormattedDateString() }}</td>
              @if ($isAbleToRank)
                <td class="text-center">
                  <a href="/dashboard/final-ranking/{{ $analysis->id }}" class="badge bg-success text-decoration-none">
                    See Final Ranking
                  </a>
                </td>
              @else
                <td class="text-center">
                  <span role="button" class="badge bg-danger text-decoration-none">
                    Waiting Admin
                  </span>
                </td>
              @endif
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="4" class="text-danger text-center p-4">
              <h4>You haven't create any comparisons yet</h4>
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
@endsection