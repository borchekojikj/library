<?php

class Book
{
    private $title;
    private $publication_year;
    private $number_of_pages;
    private $photo;
    private $author;
    private $category;
    private $summary;
    private $connObj;

    public function __construct($title, $publication_year, $number_of_pages, $photo, $summary, $author, $category, $connObj)
    {
        $this->setTitle($title);
        $this->setPublication_year($publication_year);
        $this->setNumber_of_pages($number_of_pages);
        $this->setPhoto($photo);
        $this->setSummary($summary);
        $this->setAuthor($author);
        $this->setCategory($category);
        $this->setConnObj($connObj);
    }

    // CREATE
    public  function addBookToDatabase()
    {
        $title = $this->getTitle();
        $publication_year = $this->getPublication_year();
        $number_of_pages = $this->getNumber_of_pages();
        $photo = $this->getPhoto();
        $author_id = (int)$this->getAuthor();
        $category_id = (int)$this->getCategory();
        $summary = $this->getSummary();
        $connObj = $this->getConnObj();

        $data = [
            'title' => $title,
            'publication_year' => $publication_year,
            'number_of_pages' => (int)$number_of_pages,
            'photo' => $photo,
            'summary' => $summary,
            'author_id' => (int)$author_id,
            'category_id' => (int)$category_id
        ];

        $sql = "INSERT INTO book (title, publication_year, number_of_pages, photo,summary, author_id, category_id) 
                    VALUES (:title, :publication_year, :number_of_pages, :photo, :summary,:author_id, :category_id)";
        $statement = $connObj->prepare($sql);
        $status = $statement->execute($data);

        return $status;
    }

    // READ
    public static function fetchBooks($connObj)
    {
        $sql = "SELECT book.id, book.publication_year, author.firstname, author.lastname, category.title as category, book.title, book.photo FROM book JOIN author ON book.author_id = author.id JOIN category ON book.category_id = category.id WHERE category.deleted=0 AND author.deleted=0";
        $statement = $connObj->query($sql);
        $books = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $books;
    }

    // UPDATE
    public static function editBook(array $data, $connObj)
    {
        $query = "UPDATE book
        SET 
        title=:title, 
        publication_year = :publication_year, 
        photo = :photo,
        summary=:summary,
        number_of_pages = :number_of_pages,
        author_id = :author_id,
        category_id = :category_id
        WHERE id=:id";

        $statement = $connObj->prepare($query);
        $status = $statement->execute($data);

        return $status;
    }

    // DELETE
    public static function deleteBook($bookId, $connObj)
    {

        $id = $bookId;
        $query = "DELETE FROM book WHERE id=:id";
        $stmt = $connObj->prepare($query);

        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();

        return $status;
    }

    public static function fetchBookWithId($bookId, $connObj)
    {
        $sql = "SELECT * FROM book WHERE id=:id";
        $statement = $connObj->prepare($sql);
        $statement->bindParam(':id', $bookId, PDO::PARAM_INT);
        $statement->execute();
        $book = $statement->fetch(PDO::FETCH_ASSOC);
        return $book;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getPublication_year()
    {
        return $this->publication_year;
    }

    public function setPublication_year($publication_year)
    {
        $this->publication_year = $publication_year;
        return $this;
    }

    public function getNumber_of_pages()
    {
        return $this->number_of_pages;
    }

    public function setNumber_of_pages($number_of_pages)
    {
        $this->number_of_pages = $number_of_pages;
        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getConnObj()
    {
        return $this->connObj;
    }

    public function setConnObj($connObj)
    {
        $this->connObj = $connObj;
        return $this;
    }

    /**
     * Get the value of summary
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set the value of summary
     *
     * @return  self
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }
}
