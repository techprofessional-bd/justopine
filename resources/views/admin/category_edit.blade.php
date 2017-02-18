@extends('home')
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Category Listing</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                <h4>What to do?</h4>
                <ul>
                    <li><a href="{{url('/admin/categories')}}">Categories Lists</a></li>
                </ul>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="col-md-12 col-xs-12">
                    <div class="box-body">
                        @foreach($cat as $category)
                        <form action="{{url('admin/categories/edit')}}" method="post" class="form-horizontal">
                            <input type="hidden" value="{{$category->id}}" id="txtCatId" name="txtCatId">
                            <div class="form-group">
                                <label for="txtCatTitle" class="control-label col-sm-2">Category Title</label>
                                <div class="col-sm-10"><input type="text" name="txtCatTitle" id="txtCatTitle" class="form-control" placeholder="Culture" value="{{$category->category_title}}"></div>
                            </div>
                            {{--<div class="form-group">
                                <label for="ddlSubcode" class="control-label col-sm-2">Subject</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="ddlSubcode" name="ddlSubcode">
                                        <option>Select Subject</option>
                                        @foreach($subjs as $subject)
                                            <option value="{{$subject->shrot_code}}" @if($subject->shrot_code==$category->sub_code){{'selected="selected'}}@endif>{{$subject->subject_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>--}}
                            <input type="submit" name="btnSubmit" value="Save Categories" class="btn btn-primary">
                        </form>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')

@endsection
