@extends('layout.app')

@section('title')
    {{ 'Review List' }}
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
                        Reviews
                    </div>
                    <div class="card-body pb-0">
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>User</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            <tbody>
                                @if ($review->isNotEmpty())
                                    @foreach ($review as $allreview)
                                        <tr>
                                            <td>{{ $allreview->book->title }}</td>
                                            <td>{{ $allreview->review }}</td>
                                            <td><i class="fa-regular fa-star"></i> {{ $allreview->rating }}</td>
                                            <td>{{ $allreview->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($allreview->created_at)->format('d M,Y') }}</td>
                                            <td>
                                                @if ($allreview->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('review.edit', $allreview->id) }}"
                                                    class="btn btn-primary btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="deleteReview({{ $allreview->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            </thead>
                        </table>
                        {{ $review->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('script')
    <script>
        function deleteReview(id) {
            if (confirm('Do You want to delete data ..?')) {
                $.ajax({
                    url: "{{ route('review.destroy') }}",
                    type: 'delete',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    // headers:{
                    //     'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    // },
                    success: function(res) {
                        window.location.href = "{{ route('review.index') }}"
                    }
                })
            }
        }
    </script>
@endsection
