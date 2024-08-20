<?php


class Note
{

    private $bookId;
    private $userId;
    private $note;
    private $connObj;

    public function __construct($bookId, $userId, $note, $connObj)
    {
        $this->setBookId($bookId);
        $this->setUserId($userId);
        $this->setNote($note);
        $this->setConnObj($connObj);
    }

    public function addNoteToDatabase()
    {

        $bookId = $this->getBookId();
        $userId = $this->getUserId();
        $comment_text = $this->getNote();
        $connObj = $this->getConnObj();

        $data = [
            'note' => $comment_text,
            'user_id' => $userId,
            'book_id' => $bookId,
        ];

        $sql = "INSERT INTO notes (note,  user_id, book_id) VALUES (:note, :user_id, :book_id)";
        $statement = $connObj->prepare($sql);
        $status = $statement->execute($data);
        return $status;
    }


    public static function fetchUserNotes($bookId, $userId, $connObj)
    {

        $data = [
            'user_id' => $userId,
            'book_id' => $bookId,
        ];
        $sql = "SELECT * FROM notes WHERE book_id=:book_id AND user_id=:user_id";
        $statement = $connObj->prepare($sql);
        $statement->execute($data);
        $notes = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $notes;
    }



    public static function deleteNoteById($noteId, $connObj)
    {
        $id = $noteId;
        $query = "DELETE FROM notes WHERE id=:id";
        $stmt = $connObj->prepare($query);

        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();

        return $status;
    }

    public static function editNote($noteId, $content, $connObj)
    {
        $id = $noteId;
        $content = $content;
        $query = "UPDATE notes
        SET note=:note
        WHERE id=:id";
        $stmt = $connObj->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':note', $content);
        $status = $stmt->execute();

        return $status;
    }

    /**
     * Get the value of bookId
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * Set the value of bookId
     *
     * @return  self
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @return  self
     */
    public function setNote($note)
    {
        $this->note = $note;

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
