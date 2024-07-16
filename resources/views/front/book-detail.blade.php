@extends('layout.app')
@section('content')
    <div class="container mt-3 ">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <a href="{{ url('/') }}" class="text-decoration-none text-dark ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
                </a>
                <div class="row mt-4">
                    <div class="col-md-4">
                        @if ($book->image)
                            <a href="{{ route('book.detail', $book->id) }}"><img
                                    src="{{ asset('storage/books/' . $book->image) }}" alt=""
                                    class="card-img-top"></a>
                        @else
                            <a href="{{ route('book.detail', $book->id) }}"><img src="https://dummyimage.com/900x1400"
                                    alt="" class="card-img-top"></a>
                        @endif
                    </div>
                    <div class="col-md-8">
                        @include('layout.message')
                        <h3 class="h2 mb-3">Atomic Habits</h3>
                        <div class="h4 text-muted">James Clear</div>
                        <div class="star-rating d-inline-flex ml-2" title="">
                            <span class="rating-text theme-font theme-yellow">5.0</span>
                            <div class="star-rating d-inline-flex mx-2" title="">
                                <div class="back-stars ">
                                    <i class="fa fa-star " aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <div class="front-stars" style="width: 100%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="theme-font text-muted">(0 Review)</span>
                        </div>
                        <div class="content mt-3">
                            <p>
                                "Atomic Habits" presents a refreshing perspective on habit formation, emphasizing the
                                importance of making small, incremental improvements consistently. Clear introduces the
                                concept of "atomic habits," which are tiny changes that compound over time to produce
                                significant outcomes. By dissecting the components of habit formation – cue, craving,
                                response, and reward – Clear provides readers with a deeper understanding of how habits are
                                formed and how they can be effectively modified. Through engaging storytelling and practical
                                examples, he illustrates how individuals can harness the power of habit to create lasting
                                change in various areas of their lives.
                            </p>
                            <p>
                                Moreover, "Atomic Habits" offers a roadmap for overcoming common obstacles to habit
                                formation, such as procrastination, lack of motivation, and inconsistency. Clear advocates
                                for designing environments that support desired behaviors and implementing strategies for
                                breaking bad habits and replacing them with positive ones. With its clear, actionable advice
                                and evidence-based insights, "Atomic Habits" empowers readers to take control of their
                                habits and ultimately transform their lives for the better.
                            </p>
                        </div>
                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h2 class="h3 mb-4">Readers also enjoyed</h2>
                            </div>
                            @if ($bookRelated->isNotEmpty())
                                @foreach ($bookRelated as $relbook)
                                    <div class="col-md-4 col-lg-4 mb-4">
                                        <div class="card border-0 shadow-lg">
                                            @if ($relbook->image)
                                                <a href="{{ route('book.detail', $relbook->id) }}"><img
                                                        src="{{ asset('storage/books/' . $relbook->image) }}" alt=""
                                                        class="card-img-top"></a>
                                            @else
                                                <a href="{{ route('book.detail', $relbook->id) }}"><img
                                                        src="https://dummyimage.com/900x1400" alt=""
                                                        class="card-img-top"></a>
                                            @endif
                                            <div class="card-body">
                                                <h3 class="h4 heading">{{ $relbook->title }}</h3>
                                                <p>{{ $relbook->author }}</p>
                                                <div class="star-rating d-inline-flex ml-2" title="">
                                                    <span class="rating-text theme-font theme-yellow">0.0</span>
                                                    <div class="star-rating d-inline-flex mx-2" title="">
                                                        <div class="back-stars ">
                                                            <i class="fa fa-star " aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <div class="front-stars" style="width: 70%">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="theme-font text-muted">(0)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12  mt-4">

                                <div class="d-flex justify-content-between">
                                    <h3>Reviews</h3>
                                    <div>
                                        @if (Auth::check())
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Add Review
                                            </button>
                                        @else
                                            <a href="{{ route('account.login') }}" class="btn btn-primary">Add Review </a>
                                        @endif
                                    </div>
                                </div>

                                @if ($book->reviews->isNotEmpty())
                                    @foreach ($book->reviews as $review)
                                        <div class="card border-0 shadow-lg my-4">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-3">
                                                        {{ $review->user->name }}</h4>
                                                        <span
                                                            class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('d M,Y') }}</span>
                                                </div>

                                                @php
                                                    $ratingPer = ($review->rating / 5) * 100;
                                                @endphp
                                                <div class="mb-3">
                                                    <div class="star-rating d-inline-flex" title="">
                                                        <div class="star-rating d-inline-flex " title="">
                                                            <div class="back-stars ">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <div class="front-stars"
                                                                    style="width:{{ $ratingPer }}%">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <p>{{ $review->review }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-danger">
                                        <h3>No Review Found</h3>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Review for <strong>Atomic Habits</strong>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <form action="" id="bookReviewForm" name="bookReviewForm">
                    <div class="modal-body">
                        <input type="hidden" name="book_id" value="{{ $book->id }}" />
                        <div class="mb-3">
                            <label for="" class="form-label">Review</label>
                            <textarea name="review" id="review" class="form-control" cols="5" rows="5" placeholder="Review"></textarea>
                            <p class="invalid-feedback" id="review-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <p class="invalid-feedback" id="rating-error"></p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submitBtnClick" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#bookReviewForm").submit(function(e) {

            e.preventDefault();
            $.ajax({
                url: "{{ route('book.saveReview') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: $("#bookReviewForm").serializeArray(),
                success: function(res) {
                    if (res.status == false) {
                        var error = res.errors;
                        if (error.review) {
                            $("#review").addClass('is-invalid');
                            $("#review-error").html(error.review);
                        } else {
                            $("#review").removeClass('is-invalid');
                            $("#review-error").html('');
                        }
                    } else {
                        window.location.href = "{{ route('book.detail', $book->id) }}"
                    }
                }
            })
        })
    </script>
@endsection
