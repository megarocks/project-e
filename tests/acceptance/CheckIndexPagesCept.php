<?php
    $I = new AcceptanceTester($scenario);
    $I->wantTo('To check if all backend index pages can be opened');

    $I->amGoingTo('Perform login as root user');
    $I->amOnPage('/site/login');
    $I->seeElement('#credentialsloginform-email');
    $I->fillField('#credentialsloginform-email', 'root_ppd@mailinator.com');
    $I->fillField('#credentialsloginform-password', '123');
    $I->click('.login-form-submit');
    $I->waitForText('Logged as: Root');
    $I->seeCurrentUrlEquals('/');

    $screensToTest = [
        [
            'controller' => 'purchase-order',
            'title'      => 'Purchase Orders',
        ],
        [
            'controller' => 'payment',
            'title'      => 'Payments',
        ],
        [
            'controller' => 'system',
            'title'      => 'Systems',
        ],
        [
            'controller' => 'distributor',
            'title'      => 'Distributors',
        ],
        [
            'controller' => 'end-user',
            'title'      => 'End Users',
        ],
        [
            'controller' => 'sales-user',
            'title'      => 'Sales Users',
        ],
        [
            'controller' => 'manufacturer',
            'title'      => 'Manufacturers',
        ],
        [
            'controller' => 'user',
            'title'      => 'Admins',
        ],
    ];

    foreach ($screensToTest as $screen) {
        $I->amGoingTo('Open' . $screen['title'] . ' index screen');
        $I->click($screen['title']);
        $I->amOnPage('/' . $screen['controller'] . '/index');
        $I->seeInTitle($screen['title']);
        $I->seeInPageSource('<h1>' . $screen['title'] . '</h1>');

        //check datatables have beenapplied
        $I->seeElement('.dataTables_filter');
        $I->seeElement('.dataTables_info');
        $I->wait(2);
        $I->dontSee('Loading');
    }

    $I->amGoingTo('Perform logout and navigate to login form');
    $I->click('Logged as: Root');
    $I->click('Logout');
    $I->seeCurrentUrlEquals('/site/login');
    $I->dontSee('Logged as: Root');
    $I->dontSee('Logout');
    $I->see('Login');

?>
