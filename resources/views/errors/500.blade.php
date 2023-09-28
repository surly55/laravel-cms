@extends('layouts.master')

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red">500</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
                <p>We will work on fixing that right away. <a href="/">Return to dashboard</a>.</p>
            </div>
        </div>
    </section>
@endsection