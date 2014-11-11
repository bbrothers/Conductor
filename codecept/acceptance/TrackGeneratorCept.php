<?php

$outputDir = './tests/acceptance/tmp';
$stubDir = './tests/acceptance/stubs';
$track = 'Foo';

$I = new AcceptanceTester($scenario);

$I->wantTo("Create a command, handler and response");

$I->runShellCommand("php artisan conductor:track $track --properties='bar, baz' --path='$outputDir'");

$I->seeInShellOutput('Conductor Track Created');

$I->openFile("{$outputDir}/{$track}Request.php");
$I->seeFileContentsEqual(file_get_contents("{$stubDir}/{$track}Request.stub"));

$I->openFile("{$outputDir}/{$track}Handler.php");
$I->seeFileContentsEqual(file_get_contents("{$stubDir}/{$track}Handler.stub"));

$I->openFile("{$outputDir}/{$track}Response.php");
$I->seeFileContentsEqual(file_get_contents("{$stubDir}/{$track}Response.stub"));

$I->cleanDir($outputDir);
