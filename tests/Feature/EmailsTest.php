<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\AppAssertions;
use Tests\TestingEmailsListener;
use Tests\MailManagement;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EmailsTest extends TestCase
{
	use DatabaseMigrations;
    use MailManagement;
    use AppAssertions;

    // CONTACT PAGE INTERACTIONS

    /** @test */
    public function a_guest_can_ask_a_question_through_the_contact_page()
    {
        $faker = \Faker\Factory::create();
        $request = [
                'full_name' => $faker->name,
                'email' => $faker->safeEmail,
                'message' => $faker->paragraph
            ];

        $this->post('/contact/ask-a-question', $request)->assertSessionHas('contact');
        $this->seeEmailWasSent()->seeEmailSubjectIs('New Contact')->seeEmailContains($request['full_name']);
    }

    /** @test */
    public function a_guest_is_subscribed_when_submitting_a_question()
    {
        $faker = \Faker\Factory::create();
        $request = [
                'full_name' => $faker->name,
                'email' => $faker->safeEmail,
                'message' => $faker->paragraph,
                'subscribe_me' => 'on'
            ];

        $this->post('/contact/ask-a-question', $request);
        $this->assertDatabaseHas('subscriptions', [
            'email' => $request['email']
        ]);
    }

    /** @test */
    public function new_subscriptions_are_ignored_if_duplicated()
    {
        $faker = \Faker\Factory::create();
        $request = [
                'full_name' => $faker->name,
                'email' => $this->subscription->email,
                'message' => $faker->paragraph,
                'subscribe_me' => 'on'
            ];

        $this->post('/contact/ask-a-question', $request);
        $this->assertDatabaseHas('subscriptions', [
            'email' => $request['email']
        ]);
    }

    /** @test */
    public function a_guest_can_send_a_break_inquiry_through_the_contact_page()
    {
        $faker = \Faker\Factory::create();
        $request = [
                'full_name' => $faker->name,
                'email' => $faker->safeEmail,
                'news_from' => $faker->word,
                'article_title' => $faker->sentence,
                'author_name' => $faker->name,
                'article_url' => $faker->url,
                'message' => $faker->paragraph
            ];

        $this->post('/contact/break-inquiry', $request)->assertSessionHas('contact');
        $this->seeEmailWasSent()->seeEmailSubjectIs('Break Inquiry')->seeEmailContains($request['full_name']);
    }

    /** @test */
    public function a_guest_is_subscribed_when_submitting_an_inquiry()
    {
        $faker = \Faker\Factory::create();
        $request = [
                'full_name' => $faker->name,
                'email' => $faker->safeEmail,
                'news_from' => $faker->word,
                'article_title' => $faker->sentence,
                'author_name' => $faker->name,
                'article_url' => $faker->url,
                'message' => $faker->paragraph,
                'subscribe_me' => 'on'
            ];

        $this->post('/contact/break-inquiry', $request);
        $this->assertDatabaseHas('subscriptions', [
            'email' => $request['email']
        ]);
    }

    /** @test */
    public function a_guest_can_submit_a_new_break()
    {
        Storage::fake('public');
        $faker = \Faker\Factory::create();

        $request = [
                'full_name' => $faker->name,
                'institution_email' => $faker->safeEmail,
                'field_research' => $faker->word,
                'research_institute' => $faker->word,
                'original_article' => $faker->url,
                'position' => $faker->word,
                'file' => $file = UploadedFile::fake()->create('document.doc', 20),
                'message' => $faker->paragraph
            ];

        $this->post('/contact/submit-a-break', $request)->assertSessionHas('contact');

        Storage::disk('public')->assertExists('breaks/'.$request['institution_email'].'_'.Carbon::now()->toDateString().'.doc');

        $this->seeEmailWasSent()->seeEmailsSent(2);
        $this->seeEmailTo(config('app.email'))
            ->seeEmailSubjectIs('New Break Submission')
            ->seeEmailContains($request['full_name']);
    }

    /** @test */
    public function a_guest_is_subscribed_when_submitting_a_break()
    {
        $faker = \Faker\Factory::create();

        $request = [
                'full_name' => $faker->name,
                'institution_email' => $faker->safeEmail,
                'field_research' => $faker->word,
                'research_institute' => $faker->word,
                'original_article' => $faker->url,
                'position' => $faker->word,
                'file' => $file = UploadedFile::fake()->create('document.doc', 20),
                'message' => $faker->paragraph,
                'subscribe_me' => 'on'
            ];

        $this->post('/contact/submit-a-break', $request);
        $this->assertDatabaseHas('subscriptions', [
            'email' => $request['institution_email']
        ]);
    }

    // GUESTS FEEDBACK

    /** @test */
    public function a_new_breaker_receives_an_email_upon_registration()
    {
        $this->signIn();
        
        $faker = \Faker\Factory::create();

        $first_name = $faker->firstName;
        $email = $faker->safeEmail;

        $this->post('/admin/breakers', [
            'first_name' => $first_name,
            'last_name' => $faker->lastName,
            'email' => $email,
            'position' => $faker->word,
            'research_institute' => $faker->word,
            'field_research' => $faker->word,
            'general_comments' => $faker->paragraph
        ]);

        $this->seeEmailWasSent()->seeEmailTo($email)->seeEmailSubjectIs('Welcome to TheScienceBreaker!')->seeEmailContains("Hello $first_name");
    }

    /** @test */
    public function a_guest_gets_feedback_upon_submitting_a_question()
    {
        $faker = \Faker\Factory::create();

        $request = [
                'full_name' => $faker->name,
                'email' => $faker->safeEmail,
                'message' => $faker->paragraph
            ];

        $this->post('/contact/ask-a-question', $request)->assertSessionHas('contact');
        
        $this->seeEmailWasSent()->seeEmailsSent(2);

        $this->seeEmailTo($request['email'])
            ->seeEmailSubjectIs('Your message to TheScienceBreaker')
            ->seeEmailContains('Thank you for your contact');
    }

    /** @test */
    public function a_guest_gets_feedback_upon_submitting_an_inquiry()
    {
        $faker = \Faker\Factory::create();

        $request = [
                'full_name' => $faker->name,
                'email' => $faker->safeEmail,
                'news_from' => $faker->word,
                'article_title' => $faker->sentence,
                'author_name' => $faker->name,
                'article_url' => $faker->url,
                'message' => $faker->paragraph
            ];

        $this->post('/contact/break-inquiry', $request)->assertSessionHas('contact');
        
        $this->seeEmailWasSent()->seeEmailsSent(2);

        $this->seeEmailTo($request['email'])
            ->seeEmailSubjectIs('Your Break inquiry')
            ->seeEmailContains('We have received your Break inquiry');
    }
    
    /** @test */
    public function a_guest_gets_feedback_upon_submitting_a_new_break()
    {
        $faker = \Faker\Factory::create();

        $request = [
                'full_name' => $faker->name,
                'institution_email' => $faker->safeEmail,
                'field_research' => $faker->word,
                'research_institute' => $faker->word,
                'original_article' => $faker->url,
                'position' => $faker->word,
                'file' => $file = UploadedFile::fake()->create('document.doc', 20),
                'message' => $faker->paragraph
            ];

        $this->post('/contact/submit-a-break', $request)->assertSessionHas('contact');
        
        $this->seeEmailWasSent()->seeEmailsSent(2);

        $this->seeEmailTo($request['institution_email'])
            ->seeEmailSubjectIs('Your Break has been submitted!')
            ->seeEmailContains('Thank you for submitting your Break');
    }

    // BREAKERS AND MEMBERS FEEDBACK

    /** @test */
    public function breakers_and_the_editor_receive_an_email_when_their_new_break_is_published()
    {
        $this->signIn();
        
        $faker = \Faker\Factory::create();

        $breaker_one = factory('App\Author')->create();
        $breaker_two = factory('App\Author')->create();
        $editor = factory('App\Manager')->create([
            'is_editor' => 1
        ]);

        $this->post('/admin/breaks', [
            'title' => $faker->sentence,
            'content' => '<p>'.$faker->paragraph.'</p>',
            'authors' => [
                $breaker_one->id,
                $breaker_two->id
            ],
            'reading_time' => '3.5',
            'original_article' => $faker->url,
            'category_id' => '1',
            'editor_id' => $editor->id,
            'editor_pick' => '0'
        ]);  

        $this->seeEmailWasSent();
        $this->seeEmailTo($breaker_one->email)->seeEmailSubjectIs('Break published')->seeEmailContains("Congratulations $breaker_one->first_name");
        $this->seeEmailTo($breaker_two->email)->seeEmailSubjectIs('Break published')->seeEmailContains("Congratulations $breaker_two->first_name");
        $this->seeEmailTo($editor->email)->seeEmailContains("$editor->first_name");
    }
}
