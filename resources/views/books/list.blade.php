@extends('layout.app')

@section('title')
    {{ 'Books List' }}
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
                        Books
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('books.add') }}" class="btn btn-primary">Add Book</a>
                            <form action="" method="GET">
                                <div class="d-flex">
                                    <input type="text" class="form-control" name="keyword"
                                        value="{{ Request::get('keyword') }}">
                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                    <a href="{{ route('books.index') }}" class="btn btn-dark ms-2">Clear</a>
                                </div>
                            </form>
                        </div>
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>SR</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            <tbody>
                                @if ($books->isNotEmpty())
                                    @foreach ($books as $key => $book)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>3.0 (3 Reviews)</td>
                                            <td>{{ $book->status == '1' ? 'Active' : 'Not Active' }}</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm"><i
                                                        class="fa-regular fa-star"></i></a>
                                                <a href="{{ route('books.edit', $book->id) }}"
                                                    class="btn btn-primary btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="deletebook({{ $book->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            </thead>
                        </table>
                        @if ($books->isNotEmpty())
                            {{ $books->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function deletebook(id) {
            if (confirm('Do You want to delete data ..?')) {
                $.ajax({
                    url: "{{ route('books.destroy') }}",
                    type: 'delete',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    // headers:{
                    //     'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    // },
                    success: function(res) {
                        window.location.href = "{{ route('books.index') }}"
                    }
                })
            }
        }
    </script>
@endsection
