<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Chinese text segmentation') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a class="navbar-brand" href="/jieba">{{ __('Chinese text segmentation') }}</a>
            </div>
        </div>
    </nav>
    <div class="container-lg">
        {{ __('Please enter the text to be segmented:') }}
        <form id="jieba-process-form" name="jieba_process_form" accept-charset="utf-8" action="/jieba-process" method="post">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <textarea style="font-size: 20px;line-height: 30px;" class="form-control" id="paragraph" name="paragraph" placeholder="{{ __('Please enter the text to be segmented. The text is limited to 140 words.') }}" rows="10">{{ __('Thailand relaxed decades-old alcohol sales restrictions, allowing consumers to buy wine, beer and spirits during previously prohibited afternoon hours in a six-month trial.') }}</textarea>
                <div class="help-block d-none">
                    {{ __('Please enter a text of 1 ~ 140 words') }}
                </div>
            </div>
            <div>
                <h4 class="pull-right" style="margin-top: 20px;">
                    <span id="paragraph-char-counter">140</span> {{ __('remaining characters') }}
                </h4>
                <button id="jieba-process-submit-btn" class="btn btn-primary btn-sm" type="submit" style="margin-top: 20px;">
                    {{ __('Get text segmentation results') }}
                </button>
            </div>
        </form>
        <div id="jieba-result-h" class="d-none">
            {{ __('Text segmentation results:') }}
        </div>
        <div id="jieba-result-block" class="d-none" style="font-size: 30px;line-height: 50px;">
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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