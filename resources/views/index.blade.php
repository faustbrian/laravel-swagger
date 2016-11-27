@if(app()->environment() != 'testing')
    @php
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Allow-Headers: X-Requested-With');
    @endphp
@endif
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ config('laravel-swagger.api.title') }}</title>

        <link rel="icon" type="image/png" href="{{ $assetsPath }}/images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ $assetsPath }}/images/favicon-16x16.png" sizes="16x16" />

        <link href='{{ $assetsPath }}/css/typography.css' media='screen' rel='stylesheet' type='text/css'/>
        <link href='{{ $assetsPath }}/css/reset.css' media='screen' rel='stylesheet' type='text/css'/>
        <link href='{{ $assetsPath }}/css/screen.css' media='screen' rel='stylesheet' type='text/css'/>
        <link href='{{ $assetsPath }}/css/reset.css' media='print' rel='stylesheet' type='text/css'/>
        <link href='{{ $assetsPath }}/css/print.css' media='print' rel='stylesheet' type='text/css'/>

        <script src='{{ $assetsPath }}/lib/object-assign-pollyfill.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/jquery-1.8.0.min.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/jquery.slideto.min.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/jquery.wiggle.min.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/jquery.ba-bbq.min.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/handlebars-4.0.5.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/lodash.min.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/backbone-min.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/swagger-ui.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/highlight.9.1.0.pack.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/highlight.9.1.0.pack_extended.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/jsoneditor.min.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/marked.js' type='text/javascript'></script>
        <script src='{{ $assetsPath }}/lib/swagger-oauth.js' type='text/javascript'></script>

        <!-- Some basic translations -->
        <!-- <script src='{{ $assetsPath }}/lang/translator.js' type='text/javascript'></script> -->
        <!-- <script src='{{ $assetsPath }}/lang/ru.js' type='text/javascript'></script> -->
        <!-- <script src='{{ $assetsPath }}/lang/en.js' type='text/javascript'></script> -->

        <script type="text/javascript">
            $(function () {
                var url = window.location.search.match(/url=([^&]+)/);
                if (url && url.length > 1) {
                    url = decodeURIComponent(url[1]);
                } else {
                    url = "{{ $urlToDocs }}";
                }

                hljs.configure({
                    highlightSizeThreshold: {{ $highlightThreshold }}
                });

                // Pre load translate...
                if(window.SwaggerTranslator) {
                    window.SwaggerTranslator.translate();
                }

                window.swaggerUi = new SwaggerUi({
                    url: url,
                    dom_id: "swagger-ui-container",
                    @if(array_key_exists('validatorUrl', get_defined_vars()))
                        validatorUrl: "{{ $validatorUrl ?? 'null' }}",
                    @endif
                    supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                    onComplete: function(swaggerApi, swaggerUi){
                        @if(isset($requestHeaders))
                            @foreach($requestHeaders as $requestKey => $requestValue)
                                window.swaggerUi.api.clientAuthorizations.add(
                                    "{{$requestKey}}",
                                    new SwaggerClient.ApiKeyAuthorization("{{$requestKey}}", "{{$requestValue}}", "header")
                                );
                            @endforeach
                        @endif

                        if(typeof initOAuth == "function") {
                            initOAuth({
                                clientId: "your-client-id",
                                clientSecret: "your-client-secret-if-required",
                                realm: "your-realms",
                                appName: "your-app-name",
                                scopeSeparator: ",",
                                additionalQueryStringParams: {}
                            });
                        }

                        if(window.SwaggerTranslator) {
                            window.SwaggerTranslator.translate();
                        }
                    },

                    onFailure: function(data) {
                        console.log("Unable to Load SwaggerUI");
                    },
                    docExpansion: {!! isset($docExpansion) ? '"' . $docExpansion . '"' : '"none"' !!},
                    jsonEditor: false,
                    apisSorter: "alpha",
                    defaultModelRendering: 'schema',
                    showRequestHeaders: false
                });

                function addApiKeyAuthorization(){
                    var key = $('#input_apiKey')[0].value;

                    if ("{{ $apiKeyInject }}" === "query") {
                        key = encodeURIComponent(key);
                    }

                    if(key && key.trim() != "") {
                        var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("{{$apiKeyVar}}", key, "{{$apiKeyInject}}");
                        window.swaggerUi.api.clientAuthorizations.add("{{$securityDefinition}}", apiKeyAuth);
                    }
                }

                $('#input_apiKey').change(function() {
                    addApiKeyAuthorization();
                });

                window.swaggerUi.load();

                // if you have an apiKey you would like to pre-populate on the page for demonstration purposes
                // just put it in the .env file, API_AUTH_TOKEN variable
                @if($apiKey)
                    $('#input_apiKey').val("{{$apiKey}}");
                    addApiKeyAuthorization();
                @endif
            });
        </script>
    </head>

    <body class="swagger-section">
        <div id='header'>
            <div class="swagger-ui-wrap">
                <a id="logo" href="http://swagger.io">swagger</a>
                <form id='api_selector'>
                    <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
                    <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
                    <div class='input'><a id="explore" href="#" data-sw-translate>Explore</a></div>
                </form>
            </div>
        </div>

        <div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
        <div id="swagger-ui-container" class="swagger-ui-wrap"></div>
    </body>
</html>
