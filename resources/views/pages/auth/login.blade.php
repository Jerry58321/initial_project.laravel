@extends('layouts.auth')

@section('content')
    <div class="login-logo">
        <b>
            12312
        </b>
    </div>
    <div class="login-box-body login-body">
        <form action="/login" method="post">
            @if ($errors->count())
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;{{ $errors->first() }}
                </div>
            @elseif (session()->has('logoutMessage'))
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;{{ session('logoutMessage') }}
                </div>
            @endif
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="{{ trans('auth.account') }}" name="account">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="{{ trans('auth.password') }}" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">

                <img src="{{ Captcha::src() }}" alt="captcha" class="captcha-img" data-refresh-config="default">
                <i class="fa fa-lg fa-refresh" aria-hidden="true" id="refresh-captcha"></i>
                <input type="text" name="captcha">

            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label><input type="checkbox"> {{ trans('auth.remember_me') }}</label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('auth.sign_in') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div style="text-align: center; background-color: white; padding-bottom: 10px;display: flex">
        @foreach(['cn'=>"简体中文",'tw'=>"繁體中文",'vn'=>"Người việt nam"] as $key => $lang)
            <a href="{{url('language/'.$key)}}">
                <img id="{{ $key }}" class="login-lang-pic" src="{{url('images/lang/icon_'.$key.'.png')}}" alt="error">
                <span>{{ $lang }}</span>
            </a>
        @endforeach
    </div>
@endsection

@section('script')
    <script>
    $(document).ready(function () {
        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });

        $('#refresh-captcha').click(() => {
            $('[alt="captcha"]').attr('src', '/captcha/default?' + Math.random());
        });

        var lang = {!! json_encode(session('lang')) !!} || 'tw';
        $('.login-lang-pic').map(function() {
            if($(this).attr('id') !== lang) {
                $(this).addClass('gray-scale');
            }
        });
    });
    </script>
@endsection

