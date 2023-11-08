<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>中文斷詞</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            padding-top: 70px;
        }
    </style>
</head>
<body>
    <nav class="navbar bg-light fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/jieba">中文斷詞</a>
            </div>
        </div>
    </nav>
    <div class="container-lg">
        請輸入要斷詞的短文：
        <form id="jieba-process-form" name="jieba_process_form" accept-charset="utf-8" action="/jieba-process" method="post">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <textarea style="font-size: 20px;line-height: 30px;" class="form-control" id="paragraph" name="paragraph" placeholder="請輸入要斷詞的短文，限 140 字短文" rows="10">今起進一步鬆綁室內口罩令，不少民眾卻細數戴口罩好處，有人說是最便宜、有效的防護，且戴習慣了不覺得麻煩，也有人提到家中有小孩跟長輩不可鬆懈，還有人說不用表情管理很棒，因此不會脫口罩，有人則說「以前會忘記戴口罩，現在一定會忘記拿下來」，但也有人直言「去賣場就不要戴口罩了」。</textarea>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/simplyCountable/0.5.0/jquery.simplyCountable.js"></script>
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