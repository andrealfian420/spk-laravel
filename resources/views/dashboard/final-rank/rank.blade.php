@extends('layouts.main')

@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Final Rank</h1>
  </div>

  <div class="table-responsive col-lg-12">
    <div class="d-lg-flex justify-content-between gap-2">
      <h1 class="h3 mb-0 text-gray-800">Normalization Table</h1>
      <a href="/dashboard/final-ranking" class="btn btn-secondary mb-3">
        <span data-feather="arrow-left"></span>
        Back To Final Ranks
      </a>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" class="text-center">Divider</th>
          @foreach ($dividers as $divider)
            <th scope="col" class="text-center">{{ $divider['divider_value'] }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @if (!empty($alternatives))
          @foreach ($alternatives as $alternative)
            <tr>
              <td class="text-center">
                {{ $alternative['tourism_name'] }}
              </td>
              @foreach ($alternative['results'] as $result)
                <td class="text-center">
                  {{ $result }}
                </td>
              @endforeach
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="d-sm-flex align-items-center justify-content-between align-items-center my-4">
      <h1 class="h3 mb-0 text-gray-800">Tourism Rank</h1>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" class="text-center">Alternative</th>
          <th scope="col" class="text-center">Rank Result</th>
          <th scope="col" class="text-center">Rank</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($ranks as $rank)
          <tr>
            <td class="text-center">
              {{ $rank['tourism_name'] }}
            </td>
            <td class="text-center">
              {{ $rank['rank_result'] }}
            </td>
            <td class="text-center fw-bold">
              {{ $loop->iteration }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection