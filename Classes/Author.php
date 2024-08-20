<?php


class Author
{

    private $firstName;
    private $lastName;
    private $biography;
    private $connObj;

    public function __construct($firstName, $lastName, $biography, $connObj)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setBiography($biography);
        $this->setConnObj($connObj);
    }

    // CREATE
    public function addAuthorToDatabase()
    {

        $firstName = $this->getFirstName();
        $lastName = $this->getLastName();
        $bio = $this->getBiography();
        $connObj = $this->getConnObj();

        $data = [
            'firstname' => $firstName,
            'lastname' => $lastName,
            'biography' => $bio
        ];

        $sql = "INSERT INTO author (firstname, lastname, biography) VALUES (:firstname, :lastname, :biography)";
        $statement = $connObj->prepare($sql);
        $status = $statement->execute($data);

        return $status;
    }

    // READ
    public static function fetchAuthors($connObj)
    {
        // $connObj = $this->getConnObj();
        $sql = "SELECT * FROM author WHERE deleted=0";
        $statement = $connObj->query($sql);
        $authors = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $authors;
    }

    // DELETE
    public static function deleteAuthor($authorId, $connObj)
    {


        $id = $authorId;
        $query = "UPDATE author SET deleted=1    WHERE id=:id";
        $stmt = $connObj->prepare($query);

        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();
        return $status;
    }

    // UPDATE
    public static function editAuthor(array $data, $connObj)
    {
        $query = "UPDATE author
        SET firstname=:firstname, lastname = :lastname, biography = :biography
        WHERE id=:id";

        $statement = $connObj->prepare($query);
        $status = $statement->execute($data);

        return $status;
    }


    public static function fetchAuthorWithId($authorId, $connObj)
    {

        $sql = "SELECT * FROM author WHERE id=:id";
        $statement = $connObj->prepare($sql);
        $statement->bindParam(':id', $authorId, PDO::PARAM_INT);
        $statement->execute();
        $author = $statement->fetch(PDO::FETCH_ASSOC);

        return $author;
    }


    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of biography
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set the value of biography
     *
     * @return  self
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get the value of connObj
     */
    public function getConnObj()
    {
        return $this->connObj;
    }

    /**
     * Set the value of connObj
     *
     * @return  self
     */
    public function setConnObj($connObj)
    {
        $this->connObj = $connObj;

        return $this;
    }
}
