<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ResendNotificationCommandTest extends KernelTestCase
{
    public function testResendNotificationCommand()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:resend-notifications');
        $commandTester = new CommandTester($command);

        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }
}