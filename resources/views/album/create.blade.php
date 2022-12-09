@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Album
                    <a class="btn btn-primary" href="{{route('album.index')}}" role="button">all</a>

                </div>
                <div class="card-body">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                    @endif

                    <div class="form-group">

                        <form method='post' action="{{ route('album.store') }}">
                            @csrf
                            <input type='text' id='name' name='name'>
                            <div align="center">
                                <button type="submit" class="btn btn-info" id="submit-all">Create</button>
                            </div>

                        </form>



                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection