<?php
    $I = new AcceptanceTester($scenario);
    $I->wantTo('Ensure that login and logout works');

    $I->amGoingTo('Perform login as root user');
    $I->amOnPage('/site/login');
    $I->seeElement('#credentialsloginform-email');
    $I->fillField('#credentialsloginform-email', 'root_ppd@mailinator.com');
    $I->fillField('#credentialsloginform-password', '123');
    $I->click('.login-form-submit');
    $I->waitForText('Logged as: Root');
    $I->amOnPage('/');

    $I->amGoingTo('Perform logout and navigate to login form');
    $I->seeLink('Logout');
    $I->click('Logged as: Root');
    $I->click('Logout');
    $I->amOnPage('/site/login');
    $I->dontSee('Logged as: Root');
