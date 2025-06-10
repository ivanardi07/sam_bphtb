<?php

// Include all necessary files for Guzzle
require_once APPPATH . 'third_party/psr/http-client/src/ClientExceptionInterface.php';
require_once APPPATH . 'third_party/psr/http-client/src/RequestExceptionInterface.php';
require_once APPPATH . 'third_party/psr/http-message/src/MessageInterface.php';
require_once APPPATH . 'third_party/psr/http-message/src/ResponseInterface.php';
require_once APPPATH . 'third_party/psr/http-message/src/StreamInterface.php';
require_once APPPATH . 'third_party/psr/http-message/src/RequestInterface.php';
require_once APPPATH . 'third_party/psr/http-message/src/UriInterface.php';
require_once APPPATH . 'third_party/psr/http-client/src/ClientInterface.php';

require_once APPPATH . 'third_party/guzzlehttp/promises/src/Is.php';
require_once APPPATH . 'third_party/guzzlehttp/promises/src/PromiseInterface.php';
require_once APPPATH . 'third_party/guzzlehttp/promises/src/Promise.php';
require_once APPPATH . 'third_party/guzzlehttp/promises/src/TaskQueueInterface.php';
require_once APPPATH . 'third_party/guzzlehttp/promises/src/TaskQueue.php';
require_once APPPATH . 'third_party/guzzlehttp/promises/src/Utils.php';
require_once APPPATH . 'third_party/guzzlehttp/promises/src/FulfilledPromise.php';
require_once APPPATH . 'third_party/guzzlehttp/promises/src/Create.php';

require_once APPPATH . 'third_party/guzzlehttp/psr7/src/Message.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/MessageTrait.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/Response.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/MimeType.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/Stream.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/AppendStream.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/StreamDecoratorTrait.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/MultipartStream.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/Request.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/Uri.php';
require_once APPPATH . 'third_party/guzzlehttp/psr7/src/Utils.php';

require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/BodySummarizerInterface.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/BodySummarizer.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Exception/GuzzleException.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Exception/TransferException.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Exception/RequestException.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Exception/BadResponseException.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Exception/ClientException.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Exception/RequestException.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/HeaderProcessor.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/EasyHandle.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/PrepareBodyMiddleware.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/RequestOptions.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/RedirectMiddleware.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Middleware.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/StreamHandler.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/CurlHandler.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/CurlFactoryInterface.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/CurlFactory.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/CurlMultiHandler.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Handler/Proxy.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Utils.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/HandlerStack.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/ClientTrait.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/ClientInterface.php';
require_once APPPATH . 'third_party/guzzlehttp/guzzle/src/Client.php';
