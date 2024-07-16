@extends('layout.app')

@section('title')
    {{ 'Update Review' }}
@endsection

@section('content')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layout.sidebar')
            </div>
            <div class="col-md-9">
                @include('layout.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Update Review
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('review.update', $review->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="author" class="form-label">Review</label>
                                <textarea name="review" id="review" class="form-control @error('review') is-invalid @enderror " placeholder="Review"
                                    cols="30" rows="5">{{ old('review', $review->review) }}</textarea>
                                @error('review')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status"
                                    class="form-label @error('status') is-invalid @enderror">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $review->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $review->status == 0 ? 'selected' : '' }}>Block</option>
                                </select>
                                @error('status')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
