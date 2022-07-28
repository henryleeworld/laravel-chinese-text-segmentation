<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>中文斷詞</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" integrity="sha512-GQGU0fMMi238uA+a/bdWJfpUGKUkBdgfFdgBm72SUQ6BeyWjoY/ton0tEjH+OSH9iP4Dfh+7HM0I9f5eR0L/4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <textarea style="font-size: 20px;line-height: 30px;" class="form-control" id="paragraph" name="paragraph" placeholder="請輸入要斷詞的短文，限 140 字短文" rows="10">COVID-19 疫情嚴峻，民眾家用快篩試劑需求居高不下，尤其唾液快篩更搶手，每每一開賣就完銷，繼杏一、大樹、丁丁、佑全等連鎖藥局搶先開賣後，7-11、康是美及萊爾富隨後加入開賣行列，都造成大批排隊搶購人潮，許多民眾反應還是不容易買到。</textarea>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js" integrity="sha512-OvBgP9A2JBgiRad/mM36mkzXSXaJE9BEIENnVEmeZdITvwT09xnxLtT4twkCa8m/loMbPHsvPl0T8lRGVBwjlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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