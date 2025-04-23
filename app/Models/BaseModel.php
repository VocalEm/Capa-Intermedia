<?php

namespace App\Models;

use App\Core\Database;

class BaseModel
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
}
