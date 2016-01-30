@extends('PodmView::layout')
@section('content')
<section>
    <div class="row">
        <form class="col s12 l4 offset-l4" method="post" action="{{ $form->action }}">
            <div class="input-field">
                <i class="material-icons prefix">account_circle</i>
                <input type="email" class="validate" name="email">
                <label>Account</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input type="password" class="validate" name="password">
                <label>Password</label>
            </div>
            <div class="input-field">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <button class="btn waves-effect waves-light" type="submit" name="action">Login
                    <i class="material-icons right">play_arrow</i>
                </button>
            </div>
        </form>
    </div>
</section>
@if (!empty($errors))
    @push('podm-scripts')
        Materialize.toast('{{ $errors }}', 400000);
    @endpush
@endif
@endsection
