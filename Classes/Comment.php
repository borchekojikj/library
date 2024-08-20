<?php


class Comment
{

    private $bookId;
    private $status;
    private $userId;
    private $comment_text;
    private $connObj;
    private $date;
    public function __construct($bookId, $status, $userId, $comment_text, $date, $connObj)
    {
        $this->setBookId($bookId);
        $this->setStatus($status);
        $this->setUserId($userId);
        $this->setComment_text($comment_text);
        $this->setConnObj($connObj);
        $this->setDate($date);
    }

    public function addCommentToDatabase()
    {

        $bookId = $this->getBookId();
        $status = $this->getStatus();
        $userId = $this->getUserId();
        $date = $this->getDate();
        $comment_text = $this->getComment_text();
        $connObj = $this->getConnObj();

        $data = [
            'comment_text' => $comment_text,
            'status' => $status,
            'user_id' => $userId,
            'book_id' => $bookId,
            'date' => $date,
        ];

        $sql = "INSERT INTO comment (comment_text, status, user_id, book_id,date) VALUES (:comment_text, :status, :user_id, :book_id,  :date)";
        $statement = $connObj->prepare($sql);
        $status = $statement->execute($data);

        return $status;
    }

    public static function checkIfAuthorHasComment($bookId, $userId, $connObj)
    {

        $data = [
            'user_id' => $userId,
            'book_id' => $bookId,
        ];

        $sql = "SELECT * FROM comment WHERE book_id=:book_id AND user_id=:user_id";
        $statement = $connObj->prepare($sql);
        $statement->execute($data);
        $status = $statement->fetch(PDO::FETCH_ASSOC);
        return $status;
    }

    public static function fetchCommentsForBook($book_id, $connObj)
    {
        $sql = "SELECT comment.id, comment.comment_text, comment.status, users.username, comment.user_id, comment.date FROM comment JOIN users ON comment.user_id = users.id WHERE book_id = :book_id";
        $statement = $connObj->prepare($sql);
        $statement->bindParam(":book_id", $book_id, PDO::PARAM_INT);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $comments;
    }


    public static function deleteComment($commentId, $connObj)
    {

        $id = $commentId;
        $query = "DELETE FROM comment WHERE id=:id";
        $stmt = $connObj->prepare($query);

        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();

        return $status;
    }




    public  static function fetchComments($connObj)
    {
        $sql = "SELECT comment.id, comment.comment_text, users.username, comment.status, book.title FROM comment JOIN users ON comment.user_id = users.id JOIN book ON comment.book_id = book.id ORDER BY comment.status ";
        $statement = $connObj->query($sql);
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }


    public static function aproveComment($commentId, $connObj)
    {

        $id = $commentId;
        $query = "UPDATE comment
        SET status=1
        WHERE id=:id";
        $stmt = $connObj->prepare($query);
        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();
        return $status;
    }


    public static function declineComment($commentId, $connObj)
    {

        $id = $commentId;
        $query = "UPDATE comment
        SET status=2
        WHERE id=:id";
        $stmt = $connObj->prepare($query);
        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();
        return $status;
    }


    public static function fetchAllPendingComments($connObj)
    {
        $sql = "SELECT * FROM comment WHERE status=0";
        $statement = $connObj->query($sql);
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }


    public static function fetchCommentsForUser($userId, $connObj)
    {
        $sql = "SELECT * FROM comment WHERE user_id=:id";
        $statement = $connObj->prepare($sql);
        $statement->bindParam(':id', $userId, PDO::PARAM_INT);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
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
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Get the value of comment_text
     */
    public function getComment_text()
    {
        return $this->comment_text;
    }

    /**
     * Set the value of comment_text
     *
     * @return  self
     */
    public function setComment_text($comment_text)
    {
        $this->comment_text = $comment_text;

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

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}
