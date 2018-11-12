<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->

    <head>
        @include('layouts.meta')
        @include('layouts.css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="../assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="home">
                <img src="../assets/pages/img/logo-big.png" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ route('login') }}" method="post">
                {{ csrf_field() }}
                <h3 class="form-title font-green">登入</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> 請輸入帳號與密碼. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">帳號</label>
                    <input id="lemail" type="email" class="form-control form-control-solid placeholder-no-fix" placeholder="請輸入 Email" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">密碼</label>
                    <input id="lpassword" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} placeholder-no-fix" placeholder="請輸入密碼" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">登入</button>
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />記住我
                        <span></span>
                    </label>
                    <a href="javascript:;" id="forget-password" class="forget-password">忘記密碼？</a>
                </div>
                <div class="login-options">
                    <h4>或直接以社群帳號登入</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="redirect/facebook"></a>
                        </li>
                        
                    </ul>
                </div>
                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">註冊新帳號</a>
                    </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="{{ route('password.email') }}" method="post">
                {{ csrf_field() }}
                <h3 class="font-green">忘記密碼 ?</h3>
                <p> 請輸入您註冊時的 Email 以變更密碼. </p>
                <div class="form-group">
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" />
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">返回</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">送出</button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form" action="{{ route('register') }}" method="post">
                {{ csrf_field() }}
                <h3 class="font-green">註冊新帳號</h3>
                <p class="hint"> 請輸入註冊資訊: </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">姓名</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} placeholder-no-fix" placeholder="請輸入姓名" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} placeholder-no-fix" placeholder="Email" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">密碼</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} placeholder-no-fix" placeholder="請輸入密碼" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">再次確認密碼</label>
                    <input id="password-confirm" type="password" class="form-control placeholder-no-fix" placeholder="請再次確認密碼" name="password_confirmation" required> </div>
                <div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" required /> 我同意
                        <a href="javascript:;">服務條款 </a> &
                        <a href="javascript:;">隱私權政策 </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline">返回</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">送出</button>
                </div>
            </form>
            <!-- END REGISTRATION FORM -->
        </div>

        <!-- BEGIN CORE PLUGINS -->
        @include('layouts.js')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/login.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
    </body>

</html>