<?php
namespace BooksApiBundle\Api;

use Franjid\ApiWrapperBundle\Api\ApiInterface;

interface BooksInterface extends ApiInterface
{
    const DIC_NAME = 'BooksApiBundle.Api.Books';

    /**
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getBooks($limit = null, $offset = null);

}