<?php


class Category
{

    private $title;
    private $connObj;

    public function __construct($title, $connObj)
    {
        $this->setTitle($title);
        $this->setConnObj($connObj);
    }

    // CREATE
    public static function addCategoryToDatabase($title, $connObj)
    {

        $sql = "INSERT INTO category (title) VALUES (:title)";
        $statement = $connObj->prepare($sql);
        $statement->bindParam(':title', $title, \PDO::PARAM_STR);
        $status = $statement->execute();

        return $status;
    }

    // READ
    public static function fetchCategories($connObj)
    {
        $sql = "SELECT * FROM category WHERE deleted=0";
        $statement = $connObj->query($sql);
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    // DELETE
    public static function deleteCategory($CategoryId, $connObj)
    {

        $id = $CategoryId;
        $query = "UPDATE category SET deleted=1 WHERE id=:id";
        $stmt = $connObj->prepare($query);
        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();

        return $status;
    }

    // UPDATE
    public static function editCategory($CategoryId, $title, $connObj)
    {

        $id = $CategoryId;
        $query = "UPDATE category
        SET title=:title
        WHERE id=:id";
        $stmt = $connObj->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
    }


    public static function fetchCategorieWithId($categoryId, $connObj)
    {
        $sql = "SELECT * FROM category WHERE id=:id";
        $statement = $connObj->prepare($sql);
        $statement->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $statement->execute();
        $categorie = $statement->fetch(PDO::FETCH_ASSOC);
        return $categorie;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
