@extends('layouts.main')

@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Input Criteria Comparison Value</h1>
  </div>

  <div class="table-responsive col-lg-12">
    <div class="d-lg-flex justify-content-end gap-2">
      <a href="/dashboard/criteria-comparisons" class="btn btn-secondary mb-3">
        <span data-feather="arrow-left"></span>
        Back To Comparisons Data
      </a>

      @if ($isDoneCounting)
      <a href="/dashboard/criteria-comparisons/result/{{ $criteria_analysis->id }}" class="btn btn-success mb-3 ml-4">
        <span data-feather="clipboard"></span>
        See Comparison Result
      </a>
      @endif
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col" class="text-center">First Criteria</th>
          <th scope="col" class="text-center">Value</th>
          <th scope="col" class="text-center">Second Criteria</th>
          <th scope="col" colspan="2"></th>
        </tr>
      </thead>
      <tbody>
        @if (count($details))
          <form action="/dashboard/criteria-comparisons/{{ $details[0]->criteria_analysis_id }}" method="POST">
            @method('put')
            @csrf

            <input type="hidden" name="id" value="{{ $details[0]->criteria_analysis_id }}">
            @foreach ($details as $detail)
              <tr>
                <input type="hidden" name="criteria_analysis_detail_id[]" value="{{ $detail->id }}">

                <td class="text-center">
                  {{ $detail->firstCriteria->name }}
                </td>
                <td class="text-center">
                  <select class="form-select" name="comparison_values[]" required>
                    <option value="" disabled selected>--Choose Value--</option>
                    <option value="1" {{ $detail->comparison_value == 1 ? 'selected' : '' }}>
                      1 - Equally Important
                    </option>
                    <option value="2" {{ $detail->comparison_value == 2 ? 'selected' : '' }}>
                      2 - Equally Important / A Little More Important
                    </option>
                    <option value="3" {{ $detail->comparison_value == 3 ? 'selected' : '' }}>
                      3 - A Little More Important
                    </option>
                    <option value="4" {{ $detail->comparison_value == 4 ? 'selected' : '' }}>
                      4 - Equally Important / Obviously More Important
                    </option>
                    <option value="5" {{ $detail->comparison_value == 5 ? 'selected' : '' }}>
                      5 - Obviously More Important
                    </option>
                    <option value="6" {{ $detail->comparison_value == 6 ? 'selected' : '' }}>
                      6 - Obviously More Important / Very Clearly Important
                    </option>
                    <option value="7" {{ $detail->comparison_value == 7 ? 'selected' : '' }}>
                      7 - Very Clearly Important
                    </option>
                    <option value="8" {{ $detail->comparison_value == 8 ? 'selected' : '' }}>
                      8 - Very Clearly Important / Absolutely More Important
                    </option>
                    <option value="9" {{ $detail->comparison_value == 9 ? 'selected' : '' }}>
                      9 - Absolutely More Important
                    </option>
                  </select>
                </td>
                <td class="text-center">
                  {{ $detail->secondCriteria->name }}
                </td>
              </tr>
            @endforeach
            @can('update', $criteria_analysis)
              <tr>
                <td class="text-center">
                  <button type="submit" class="btn btn-primary">Save</button>
                </td>
              </tr>
            @endcan
          </form>
        @endif
      </tbody>
    </table>
  </div>
@endsection