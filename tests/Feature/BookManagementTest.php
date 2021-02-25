<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_book_can_be_added_to_the_library(){
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title'=>'A creative book title',
            'author'=>'Victor',
        ]);

        $book = Book::first();
        // $response->assertOk();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
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
        // $this->withoutExceptionHandling();

        $this->post('/books', [
            'title'=>'A creative book title',
            'author'=>'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title'=>'New title',
            'author'=>'New Author',
        ]);

        $this->assertEquals("New title", Book::first()->title);
        $this->assertEquals("New Author", Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    public function test_book_can_be_deleted(){
        $this->post('/books', [
            'title'=>'New Title',
            'author'=>'New Author',
        ]);

        $this->assertCount(1, Book::all());

        $book = Book::first();
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
