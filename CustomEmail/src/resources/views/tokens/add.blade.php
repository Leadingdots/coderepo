@extends('leadingdots.customemail.layouts.app')
@push('meta')
    <title>{{$item ? 'Update' : 'Add'}} Token</title>
    <meta content="{{$item ? 'Update' : 'Add'}} Token" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
@endpush
@section('content')
<a type="button" href="{{route('ldots.token.index')}}" class="btn btn-primary mb-2 float-right">All Tokens</a>
    <div class="alert alert-success alert-dismissible" role="alert" id="msg" style="display:none;">
        <div class="alert-text"></div>
        <div class="alert-close">
            <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>
        </div>
    </div>
    
    <form action="{{route('ldots.token.store')}}" method="post" onsubmit="return {{$item ? 'updateForm(this)' : 'formSubmit(this)'}}">
        @csrf
        <input type="hidden" name="id" value="{{$item ? $item->id : false}}">

        <div class="form-group">
            <label>Token</label>
            <input type="text" class="form-control" name="token" value="{{$item ? $item->token : ''}}" placeholder="Token">
            <div class="help-block"></div>
        </div>

        <div class="form-group">
            <label>Detail</label>
            <input type="text" class="form-control" name="description" value="{{$item ? $item->description : ''}}" placeholder="Detail">
            <div class="help-block"></div>
        </div>
        
        <button type="submit" class="btn btn-primary saveBtn">{{$item ? 'Update' : 'Add'}}</button>
    </form>

@stop

@push('appendJs')
    <script src="{{asset('public/leadingdots/customemail/js/post-jobs.js') }}" type="text/javascript" charset="utf-8"></script>
@endpush