<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_book_can_be_added_to_the_library(){
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title'=>'A creative book title',
            'author'=>'Victor',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_title_is_required(){
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title'=>'',
            'author'=>'Victor',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_author_is_required(){
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title'=>'New Title',
            'author'=>'',
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_book_can_be_updated(){
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title'=>'A creative book title',
            'author'=>'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch("/books/$book->id", [
            'title'=>'New title',
            'author'=>'New Author',
        ]);

        $response->assertOk();
        $this->assertEquals("New title", Book::first()->title);
        $this->assertEquals("New Author", Book::first()->author);
    }
}
