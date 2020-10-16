@extends('leadingdots.customemail.layouts.app')
@push('meta')
    <title>{{$item ? 'Update' : 'Add'}} Template</title>
    <meta content="{{$item ? 'Update' : 'Add'}} Template" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
@endpush
@push('stylesheets')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush
@section('content')
<a type="button" href="{{route('ldots.template.index')}}" class="btn btn-primary mb-2 float-right">All Templates</a>
    <div class="alert alert-success alert-dismissible" role="alert" id="msg" style="display:none;">
        <div class="alert-text"></div>
        <div class="alert-close">
            <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>
        </div>
    </div>
    
    <form action="{{route('ldots.template.store')}}" method="post" onsubmit="return {{$item ? 'updateForm(this)' : 'formSubmit(this)'}}">
        @csrf
        <input type="hidden" name="id" value="{{$item ? $item->id : false}}">

        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="template_name" value="{{$item ? $item->template_name : ''}}" placeholder="Name">
            <div class="help-block"></div>
        </div>

        <div class="form-group">
            <label>Type</label>
            <input type="text" class="form-control" name="template_type" value="{{$item ? $item->template_type : ''}}" placeholder="Type">
            <div class="help-block"></div>
        </div>

        <div class="form-group">
            <label>Subject</label>
            <input type="text" class="form-control" name="subject" value="{{$item ? $item->subject : ''}}" placeholder="Subject">
            <div class="help-block"></div>
        </div>
        
        <div class="form-group">
            <label>Tokens to be use</label>
            <div>
            @foreach($tokens as $token)
            <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="{{$token->description}}">#{{$token->token}}#</span>
            @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>Template</label>
            <textarea class="form-control" id="summernote" name="template" placeholder="Template">{{$item ? $item->template : ''}}</textarea>
            <div class="help-block"></div>
        </div>
        
        <button type="submit" class="btn btn-primary saveBtn">{{$item ? 'Update' : 'Add'}}</button>
    </form>

@stop

@push('appendJs')
    
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{asset('public/leadingdots/customemail/js/post-jobs.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 400,
            });
            
            $('[data-toggle="tooltip"]').tooltip();

            $('[data-toggle="tooltip"]').on('click', function() {
                var cursorPos = $('#summernote').prop('selectionStart');
                var v = $('#summernote').val();
                
                var textBefore = v.substring(0,  cursorPos);
                var textAfter  = v.substring(cursorPos, v.length);
                $("#summernote").summernote("code", textBefore + $(this).html() + textAfter);
            });
        });
    </script>
@endpush