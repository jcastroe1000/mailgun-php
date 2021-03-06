<?php

/*
 * Copyright (C) 2013-2016 Mailgun
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Mailgun\Tests\Functional;

/**
 * Simple test to show how to use the MockedMailgun client.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class SendMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleExample()
    {
        // Create a Closure that validates the $files parameter to RestClient::send()
        $fileValidator = function ($files) {
            $this->assertContains(['name' => 'from',    'contents' => 'bob@example.com'], $files);
            $this->assertContains(['name' => 'to',      'contents' => 'alice@example.com'], $files);
            $this->assertContains(['name' => 'subject', 'contents' => 'Foo'], $files);
            $this->assertContains(['name' => 'text',    'contents' => 'Bar'], $files);
        };

        // Create the mocked mailgun client. We use $this->assertEquals on $method, $uri and $body parameters.
        $mailgun = MockedMailgun::createMock($this, 'POST', 'domain/messages', [], $fileValidator);

        $mailgun->sendMessage('domain', [
            'from' => 'bob@example.com',
            'to' => 'alice@example.com',
            'subject' => 'Foo',
            'text' => 'Bar', ]);
    }
}
