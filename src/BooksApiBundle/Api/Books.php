<?php
namespace BooksApiBundle\Api;

use Franjid\ApiWrapperBundle\Api\Api;
use Franjid\ApiWrapperBundle\Api\ApiResponse;
use Franjid\ApiWrapperBundle\Api\ApiRequest;

class Books extends Api implements BooksInterface
{
    const ROUTE = 'books';
    const REQUEST_PARAMETER_LIMIT = 'limit';
    const REQUEST_PARAMETER_OFFSET = 'offset';
    const RESPONSE_PARAMETER_STATUS = 'status';
    const RESPONSE_PARAMETER_DATA = 'data';
    const RESPONSE_PARAMETER_DATA_BOOKS = 'books';
    const SUCCESS_STATUS_CODE = 'OK';

    /**
     * {@inheritdoc}
     */
    public function getBooks($limit = null, $offset = null)
    {
        /** @var ApiRequest $request */
        $request = new ApiRequest('GET', $this::ROUTE);
        $request->setOptions($this->prepareOptions($limit, $offset));

        /** @var ApiResponse $response */
        $rawResponse = $this->send($request);
        $response = json_decode($rawResponse->getBody(), true);

        if (isset($response[$this::RESPONSE_PARAMETER_STATUS])
            && $this::SUCCESS_STATUS_CODE === $response[$this::RESPONSE_PARAMETER_STATUS]
            && isset($response[$this::RESPONSE_PARAMETER_DATA][$this::RESPONSE_PARAMETER_DATA_BOOKS])
        ) {
            return $response[$this::RESPONSE_PARAMETER_DATA][$this::RESPONSE_PARAMETER_DATA_BOOKS];
        } else {
            return false;
        }
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return array
     */
    private function prepareOptions($limit = null, $offset = null)
    {
        $options  = [];

        if (null !== $limit) {
            $options[$this::REQUEST_PARAMETER_LIMIT] = (int) $limit;
        }

        if (null !== $offset) {
            $options[$this::REQUEST_PARAMETER_OFFSET] = (int) $offset;
        }

        return $options;
    }
}
