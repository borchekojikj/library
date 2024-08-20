<?php



class User
{
    private $username;
    private $password;
    private $connObj;

    public function __construct($username, $password, $connObj)
    {
        $this->setPassword($password);
        $this->setUsername($username);
        $this->setConnObj($connObj);
    }

    public function userExists()
    {
        $connObj = $this->getConnObj();
        $username = $this->getUsername();
        $sql = "SELECT * FROM users WHERE username = :username";
        $statement = $connObj->prepare($sql);

        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!empty($user)) {
            return true;
        }
        return false;
    }

    public function saveUserToDatabase()
    {
        $connObj = $this->getConnObj();
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $statement = $connObj->prepare($sql);

        $data = [
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
        ];
        $status = $statement->execute($data);

        return $status;
    }


    public function authenticate()
    {

        $username = strtolower($this->getUsername());
        $password = $this->getPassword();
        $connObj = $this->getConnObj();

        $sql = "SELECT * FROM users WHERE username = :username";

        $statement = $connObj->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!empty($user) && password_verify($password, $user['password'])) {
            return [
                'id' => $user['id'],
                'role' => $user['role'],
                'username' => $user['username']
            ];
        } else {
            return false;
        }
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

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
