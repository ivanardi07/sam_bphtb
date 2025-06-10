<?php

namespace BAPENDAKOTAMALANG\ESignBsrePhp;

use GuzzleHttp\Client as GuzzleClient;
use PhpParser\Node\Stmt\TryCatch;

class ESignBsre
{
    private $http;
    private $baseUrl;
    private $username;
    private $password;
    private $file;
    private $fileName;
    private $view = 'invisible';
    private $timeout;

    //custom var
    // private $fileSpesiment;
    // private $fileNameSpesiment;
    // private $xAxis;
    // private $yAxis;
    // private $width;
    // private $height;
    // private $page;
    // private $reason;

    public function __construct($baseUrl, $username, $password, $timeout = 30)
    {
        $this->baseUrl = $baseUrl;
        $this->http = new GuzzleClient();
        $this->username = $username;
        $this->password = $password;
        $this->timeout = $timeout;
    }

    public function setFile($file, $fileName)
    {
        $this->file = $file;
        $this->fileName = $fileName;

        return $this;
    }

    public function setFileSpesiment($file, $fileName, $detail)
    {
        $this->fileSpesiment = $file;
        $this->fileNameSpesiment = $fileName;
        $this->xAxis = (float)$detail['xAxis'];
        $this->yAxis = (float)$detail['yAxis'];
        $this->width = (float)$detail['width'];
        $this->height = (float)$detail['height'];
        $this->page = (int)$detail['page'];
        $this->reason = $detail['reason'];
        return $this;
    }

    public function setFileSpesimentSymbols($file, $fileName, $detail)
    {
        $this->fileSpesiment = $file;
        $this->fileNameSpesiment = $fileName;
        $this->width = (float)$detail['width'];
        $this->height = (float)$detail['height'];
        $this->tag_koordinat = $detail['tag_koordinat'];
        return $this;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function sign($nik, $passphrase)
    {
        try {
            $response = $this->http->request('POST', "{$this->getBaseUrl()}/api/sign/pdf", [
                'auth' => $this->getAuth(),
                'timeout' => $this->timeout,
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => $this->file,
                        'filename' => $this->fileName
                    ],
                    [
                        'name'     => 'nik',
                        'contents' => $nik,
                    ],
                    [
                        'name'     => 'passphrase',
                        'contents' => $passphrase,
                    ],
                    [
                        'name'     => 'tampilan',
                        'contents' => 'visible',
                    ],
                    [
                        'name'     => 'image',
                        'contents' => true,
                    ],
                    [
                        'name'     => 'imageTTD',
                        'contents' => $this->fileSpesiment
                    ],
                    [
                        'name'     => 'xAxis',
                        'contents' => $this->xAxis
                    ],
                    [
                        'name'     => 'yAxis',
                        'contents' => $this->yAxis
                    ],
                    [
                        'name'     => 'width',
                        'contents' => $this->width
                    ],
                    [
                        'name'     => 'height',
                        'contents' => $this->height
                    ],
                    [
                        'name'     => 'page',
                        'contents' => $this->page
                    ],
                    [
                        'name'     => 'reason',
                        'contents' => $this->reason
                    ],
                    [
                        'name'     => 'location',
                        'contents' => 'Pemerintah Kota Malang'
                    ]

                ],
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return new ESignBsreResponse($e);
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }

        return (new ESignBsreResponse())->setFromResponse($response);
    }

    public function signSymbols($nik, $passphrase)
    {
        try {
            $response = $this->http->request('POST', "{$this->getBaseUrl()}/api/sign/pdf", [
                'auth' => $this->getAuth(),
                'timeout' => $this->timeout,
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => $this->file,
                        'filename' => $this->fileName
                    ],
                    [
                        'name'     => 'nik',
                        'contents' => $nik,
                    ],
                    [
                        'name'     => 'passphrase',
                        'contents' => $passphrase,
                    ],
                    [
                        'name'     => 'tampilan',
                        'contents' => 'visible',
                    ],
                    [
                        'name'     => 'image',
                        'contents' => true,
                    ],
                    [
                        'name'     => 'imageTTD',
                        'contents' => $this->fileSpesiment
                    ],
                    [
                        'name'     => 'width',
                        'contents' => $this->width
                    ],
                    [
                        'name'     => 'height',
                        'contents' => $this->height
                    ],
                    // [
                    //     'name'     => 'page',
                    //     'contents' => $this->page
                    // ],
                    [
                        'name'     => 'tag_koordinat',
                        'contents' => $this->tag_koordinat
                    ],
                    [
                        'name'     => 'reason',
                        'contents' => 'Dokumen Ditandatangan dengan tanggal mundur karena terkendala server down.'
                    ],
                    [
                        'name'     => 'location',
                        'contents' => 'Pemerintah Kota Malang'
                    ]

                ],
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return new ESignBsreResponse($e);
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }

        return (new ESignBsreResponse())->setFromResponse($response);
    }

    public function signInvisible($nik, $passphrase)
    {
        try {
            $response = $this->http->request('POST', "{$this->getBaseUrl()}/api/sign/pdf", [
                'auth' => $this->getAuth(),
                'timeout' => $this->timeout,
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => $this->file,
                        'filename' => $this->fileName
                    ],
                    [
                        'name'     => 'nik',
                        'contents' => $nik,
                    ],
                    [
                        'name'     => 'passphrase',
                        'contents' => $passphrase,
                    ],
                    [
                        'name'     => 'tampilan',
                        'contents' => $this->view,
                    ],
                    [
                        'name'     => 'reason',
                        'contents' => 'Dokumen telah disetujui dan ditandatangani secara elektronik',
                    ],
                    [
                        'name'     => 'location',
                        'contents' => 'Pemerintah Kota Malang'
                    ]
                ],
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return new ESignBsreResponse($e);
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }

        return (new ESignBsreResponse())->setFromResponse($response);
    }

    public function verification()
    {
        try {
            $response = $this->http->request('POST', "{$this->getBaseUrl()}/api/sign/verify", [
                'auth' => $this->getAuth(),
                'timeout' => $this->timeout,
                'multipart' => [
                    [
                        'name' => 'signed_file',
                        'contents' => $this->file,
                        'filename' => $this->fileName
                    ],
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return new ESignBsreResponse($e);
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }

        return (new ESignBsreResponse())->setFromResponse($response);
    }

    public function statusUser($nik)
    {
        try {
            $response = $this->http->request('GET', "{$this->getBaseUrl()}/api/user/status/$nik", [
                'auth' => $this->getAuth(),
                'timeout' => $this->timeout,
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return (new ESignBsreResponse())->setFromExeption($e, ESignBsreResponse::STATUS_TIMEOUT);
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }

        return (new ESignBsreResponse())->setFromResponse($response);
    }

    public function ProfilUser($nik)
    {
        try {
            $response = $this->http->request('GET', "{$this->getBaseUrl()}/api/user/profile/$nik", [
                'auth' => $this->getAuth(),
                'timeout' => $this->timeout,
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return (new ESignBsreResponse())->setFromExeption($e, ESignBsreResponse::STATUS_TIMEOUT);
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }

        return (new ESignBsreResponse())->setFromResponse($response);
    }

    private function getAuth()
    {
        return [$this->username, $this->password];
    }

    private function getBaseUrl()
    {
        return rtrim($this->baseUrl, "/");
    }
}
