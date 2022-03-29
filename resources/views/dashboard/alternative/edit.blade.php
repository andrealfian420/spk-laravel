@extends('layouts.main')

@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit {{ $alternative->name }}'s Values</h1>
  </div>

  <form class="col-lg-8" method="POST" action="/dashboard/alternatives/{{ $alternative->id }}">
    @method('PUT')
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Selected Tourism Name</label>
      <input type="text" class="form-control" id="name" value="{{ old('name', $alternative->name) }}" readonly required>

      @error('name')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    @foreach ($alternative->alternatives as $value)
      <div class="mb-3">
        <input type="hidden" name="criteria_id[]" value="{{ $value->criteria->id }}">
        <input type="hidden" name="alternative_id[]" value="{{ $value->id }}">

        <label for="{{ str_replace(' ','', $value->criteria->name) }}" class="form-label">
          Value of {{ $value->criteria->name }}
        </label>
        <input type="text" id="{{ str_replace(' ','', $value->criteria->name) }}" class="form-control @error('alternative_value') 'is-invalid' : '' @enderror" name="alternative_value[]" placeholder="Enter the value" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57)|| event.charCode == 46)" value="{{ floatval($value->alternative_value) }}" maxlength="5" autocomplete="off" required>

        @error('alternative_value')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    @endforeach

    @if ($newCriterias->count())
      <input type="hidden" name="new_tourism_object_id" value="{{ $alternative->id }}">
      @foreach ($newCriterias as $value)
        <div class="mb-3">
          <input type="hidden" name="new_criteria_id[]" value="{{ $value->id }}">

          <label for="{{ str_replace(' ','', $value->name) }}" class="form-label">
            Value of {{ $value->name }}
          </label>
          <input type="text" id="{{ str_replace(' ','', $value->name) }}" class="form-control @error('new_alternative_value') 'is-invalid' : '' @enderror" name="new_alternative_value[]" placeholder="Enter the value" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57)|| event.charCode == 46)" maxlength="5" autocomplete="off" required>

          @error('new_alternative_value')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      @endforeach
    @endif

    <button type="submit" class="btn btn-primary mb-3">Save Changes</button>
    <a href="/dashboard/alternatives" class="btn btn-danger mb-3">Cancel</a>
  </form>
@endsection