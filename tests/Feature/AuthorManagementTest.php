<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/authors',[
            'name'=>"author name",
            'dob'=>'05/14/1998',
        ]);

        $author = Author::first();

        $response->assertStatus(200);

        $this->assertCount(1, Author::all());

        $this->assertInstanceOf(Carbon::class, $author->dob);   //assert dob is a carbon instance

        $this->assertEquals('1998/14/05', $author->dob->format('Y/d/m')); //assert dob is formattable carbon instance
    }
}
