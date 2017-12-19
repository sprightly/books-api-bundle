<?php
namespace BooksApiBundle\Tests\Api;

use BooksApiBundle\Api\Books;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class BooksTest extends TestCase
{
    public function testNoRequestIfExistsCache()
    {
        $expectedBooksData = ['anything'];

        /** @var $booksApi Books|\PHPUnit_Framework_MockObject_MockObject */
        $booksApi = $this->getMockBuilder(Books::class)
            ->setMethods(['send'])
            ->disableOriginalConstructor()
            ->getMock();

        $booksApi->expects($this->never())
            ->method('send');

        /** @var CacheItemInterface|\PHPUnit_Framework_MockObject_MockObject $cacheItem */
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->expects($this->any())
            ->method('isHit')
            ->willReturn(true);
        $cacheItem->expects($this->any())
            ->method('get')
            ->willReturn($expectedBooksData);

        /** @var CacheItemPoolInterface|\PHPUnit_Framework_MockObject_MockObject $cachePool */
        $cachePool = $this->createMock(CacheItemPoolInterface::class);
        $cachePool->expects($this->any())
            ->method('getItem')
            ->willReturn($cacheItem);

        $booksApi->setCachePool($cachePool);

        $this->assertEquals($expectedBooksData, $booksApi->getBooks());
    }
}
