<?php

require_once 'database.class.php';

class Profile
{
    private $error = "";
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getError()
    {
        return $this->error;
    }

    public function getAllProfiles()
    {
        $sql = "SELECT * FROM profile";
        $query = $this->db->connect()->prepare($sql);

        try {
            if ($query->execute()) {
                return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            } else {
                $this->error = $query->errorInfo()[2];
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function getProfile($user_id)
    {
        $sql = "SELECT * FROM profile WHERE user_id = :user_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        try {
            if ($query->execute()) {
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->error = $query->errorInfo()[2];
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function insertProfile($user_id, $data)
    {
        // Prepare the SQL query dynamically
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO profile (user_id, $columns) VALUES (:user_id, $placeholders)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        // Bind parameters using a loop, handling different data types
        foreach ($data as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;  // Corrected type check
            $query->bindValue(":$key", $value, $paramType);
        }

        try {
            if ($query->execute()) {
                return $this->db->connect()->lastInsertId();
            } else {
                $this->error = $query->errorInfo()[2];
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function updateProfile($user_id, $data)
    {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");

        $sql = "UPDATE profile SET $setClause WHERE user_id = :user_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        foreach ($data as $key => $value) {

            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR; // Corrected type check
            $query->bindValue(":$key", $value, $paramType);
        }

        try {
            return $query->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }


    public function uploadImage($user_id, $uploadDirectory = 'uploads/')
    {
        $error = "";
        $imagePath = "";

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {

            $file = $_FILES['profile_image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']; // Add webp.

            if (!in_array($file['type'], $allowedTypes)) {
                $error = "Invalid file type. Allowed types: " . implode(", ", $allowedTypes);  // More informative error message

            } else {
                $filename = uniqid($user_id . '_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $imagePath = $uploadDirectory . $filename;

                if (move_uploaded_file($file['tmp_name'], $imagePath)) {
                    if ($this->updateProfileImage($user_id, $imagePath)) {
                        return $imagePath;
                    } else {
                        $error = "Failed to update profile with image path: " . $this->getError();
                        // Consider removing the uploaded file if the DB update fails:
                        unlink($imagePath); // Delete the uploaded file
                    }
                } else {
                    $error = "Error moving uploaded file. Check file permissions for the uploads directory."; // More specific error

                }
            }
        } else if (isset($_FILES['profile_image'])) {
            $error = "File upload error (Code: " . $_FILES['profile_image']['error'] . ")"; //Get specific upload error.

        } else {
            $error = "No file selected.";
        }

        $this->error = $error;
        return false;
    }


    public function updateProfileImage($userId, $fileName)
    {
        try {
            $sql = "UPDATE profile SET profile_image = :profile_image WHERE user_id = :user_id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':profile_image', $fileName, PDO::PARAM_STR);
            $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
            return $query->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }



    public function getImagePath($user_id)
    {
        $profile = $this->getProfile($user_id);
        return $profile ? ($profile['image_path'] ?? null) : null; // Use null coalescing operator
    }
}
