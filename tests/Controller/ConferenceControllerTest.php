<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConferenceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/conferences');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give your feedback');
    }

    public function testCommentSubmission()
    {

        $client = static::createClient();

        $client->request('GET', '/conference/amsterdam-2019');
        $client->submitForm('Submit', [
            'comment_form[author]' => 'Fabien',
            'comment_form[text]' => 'Some feedback from an automated functional test',
            'comment_form[email]' => 'me@automat.ed'
            ]
        );

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are")');
    }


    public function testConferencePage()
    {
        $client = static::createClient();

        $client->request('GET', '/conferences');
        $client->clickLink('View Amsterdam 2019');

        $this->assertPageTitleContains('Conference Guestbook');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'This conference was in');
        $this->assertSelectorExists('div:contains("There are")');
    }
}