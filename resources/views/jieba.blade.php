<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>中文斷詞</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 70px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/jieba">中文斷詞</a>
            </div>
        </div>
    </nav>
    <div class="container-lg">
        請輸入要斷詞的短文：
        <form id="jieba-process-form" name="jieba_process_form" accept-charset="utf-8" action="/jieba-process" method="post">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <textarea style="font-size: 20px;line-height: 30px;" class="form-control" id="paragraph" name="paragraph" placeholder="請輸入要斷詞的短文，限 140 字短文" rows="10">據 NCC 公佈的今年 2 月全台 4G 電信用戶總數，中華電信的單月用戶數爆增了超過 33 萬，單月成長幅度甚至超越 2018 年 5 月「499之亂」期間的 31.5 萬，成為近年來最大的一次單月用戶成長。</textarea>
                <div class="help-block d-none">
                    請輸入 1 ~ 140 字的短文
                </div>
            </div>
            <div>
                <h4 class="pull-right" style="margin-top: 20px;">
                    <span id="paragraph-char-counter">140</span> 剩餘字元
                </h4>
                <button id="jieba-process-submit-btn" class="btn btn-primary btn-sm" type="submit" style="margin-top: 20px;">
                    取得斷詞結果
                </button>
            </div>
        </form>
        <div id="jieba-result-h" class="d-none">
            斷詞結果：
        </div>
        <div id="jieba-result-block" class="d-none" style="font-size: 30px;line-height: 50px;">
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <script src="js/simplyCountable/0.4.2/jquery.simplyCountable.js"></script>
    <script>
        $(document).ready(function() {
            $('#paragraph').simplyCountable({
                counter: '#paragraph-char-counter',
                countType: 'characters',
                maxCount: 140,
                strictMax: true,
                countDirection: 'down',
                safeClass: 'safe',
                overClass: 'over',
                thousandSeparator: ',',
                onOverCount: function(count, countable, counter) {},
                onSafeCount: function(count, countable, counter) {},
                onMaxCount: function(count, countable, counter) {}
            });

            function processValidate(formData, jqForm, options) {

                var is_validated = true;

                if (!$('#paragraph').val() || $('#paragraph').val().length > 140) {
                    $('#paragraph').parent().addClass('has-error');
                    $('#paragraph').next().removeClass('d-none');
                    is_validated = false;
                } else {
                    $('#paragraph').parent().removeClass('has-error');
                    $('#paragraph').next().addClass('d-none');
                }

                if (is_validated) {
                    $('#jieba-process-submit-btn').attr("disabled", "disabled");
                }
                return is_validated;
            }

            var options = {
                target: '#jieba-result-block',
                url: '/jieba',
                type: 'post',
                beforeSubmit: processValidate,
                success: function() {
                    if ($('#jieba-result-block').hasClass('d-none')) {
                        $('#jieba-result-h').removeClass('d-none');
                        $('#jieba-result-block').removeClass('d-none');
                    }
                    $('#jieba-process-submit-btn').removeAttr("disabled");
                }
            };
            $('#jieba-process-form').ajaxForm(options);
        });
    </script>
</body>
</html>