<?php

namespace Tests;

use PHPUnit\Runner\Extension\Extension as BaseExtension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use PHPUnit\Event\TestRunner\ExecutionStarted;
use PHPUnit\Event\TestRunner\ExecutionStartedSubscriber;
use PHPUnit\Event\TestRunner\ExecutionFinished;
use PHPUnit\Event\TestRunner\ExecutionFinishedSubscriber;
use Algolia\AlgoliaSearch\Api\SearchClient;

class Extension implements BaseExtension {
	public function bootstrap( Configuration $configuration, Facade $facade, ParameterCollection $parameters ): void {
		$facade->registerSubscriber( new OnStart() );
		$facade->registerSubscriber( new OnFinish() );
	}
}

class OnStart implements ExecutionStartedSubscriber {
	public function notify( ExecutionStarted $event ): void {
        $client = SearchClient::create(env('ALGOLIA_APP_ID'), env('ALGOLIA_SECRET'));
        $client->clearObjects('questions');
	}
}

class OnFinish implements ExecutionFinishedSubscriber {
	public function notify( ExecutionFinished $event ): void {
		// Runs on test finish.
	}
}
