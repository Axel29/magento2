<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Customer\Test\Unit\Observer;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Logger;
use Magento\Customer\Observer\LogLastLoginAtObserver;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LogLastLoginAtObserverTest extends TestCase
{
    /**
     * @var LogLastLoginAtObserver
     */
    protected $logLastLoginAtObserver;

    /**
     * @var Logger|MockObject
     */
    protected $loggerMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->loggerMock = $this->createMock(Logger::class);
        $this->logLastLoginAtObserver = new LogLastLoginAtObserver($this->loggerMock);
    }

    /**
     * @return void
     */
    public function testLogLastLoginAt()
    {
        $id = 1;

        $observerMock = $this->createMock(Observer::class);
        $eventMock = $this->getMockBuilder(Event::class)
            ->addMethods(['getCustomer'])
            ->disableOriginalConstructor()
            ->getMock();
        $customerMock = $this->createMock(Customer::class);

        $observerMock->expects($this->once())
            ->method('getEvent')
            ->willReturn($eventMock);
        $eventMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn($customerMock);
        $customerMock->expects($this->once())
            ->method('getId')
            ->willReturn($id);

        $this->loggerMock->expects($this->once())
            ->method('log');

        $this->logLastLoginAtObserver->execute($observerMock);
    }
}
