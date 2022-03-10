<?php  
	class AuthorsRepository extends AbstractController {
		private $connection;

        public function __construct($dbConnection) {
            $this->connection = $dbConnection;
        }

        public function emailAddressExists($emailAddress) {
            $statement = $this->connection->prepare("
                SELECT * FROM `authors` 
                WHERE `email_address` = ?;
            ");

            $statement->bind_param("s", $emailAddress);
            
            if (! $statement->execute()) {
                return "error";
            }

            $statement->store_result();
            return $statement->num_rows != 0;
        }

        public function emailAddressBelongsToId($emailAddress, $id) {
            $statement = $this->connection->prepare("
                SELECT * FROM `authors` 
                WHERE `email_address` = ? 
                AND `id` = ?;
            ");

            $statement->bind_param("si", $emailAddress, $id);
            
            if (! $statement->execute()) {
                return "error";
            }

            $statement->store_result();
            return $statement->num_rows != 0;
        }

        public function preRegister($firstName, $lastName, $emailAddress, $password, $key) {
            $statement = $this->connection->prepare("
                INSERT INTO `authors` 
                (`first_name`, `last_name`, `email_address`, `password`, `temporary_key`) 
                VALUES 
                (?, ?, ?, ?, ?);
            ");

            $statement->bind_param("sssss", $firstName, $lastName, $emailAddress, $password, $key);
            return $statement->execute();
        }

        public function getAuthorByKey($key) {
            $statement = $this->connection->prepare("
                SELECT * FROM `authors` 
                WHERE `temporary_key` = ?;
            ");

            $statement->bind_param("s", $key);

            if (! $statement->execute()) {
                return [];
            }

            $result = $statement->get_result();
            $array = $this->output1dArray($result);
            return $this->escape1dArray($array);
        }

        public function activateAccount($id) {
            $statement = $this->connection->prepare("
                UPDATE `authors` 
                SET `active` = '1', 
                `temporary_key` = ''
                WHERE `id` = ?; 
            ");

            $statement->bind_param("i", $id);
            return $statement->execute();
        }

        public function updateAuthorAll($id, $firstName, $lastName, $emailAddress, $password, $role) {
            $statement = $this->connection->prepare("
                UPDATE `authors` 
                SET `first_name` = ?, 
                `last_name` = ?, 
                `email_address` = ?, 
                `password` = ?, 
                `role` = ? 
                WHERE `id` = ?;
            ");

            $statement->bind_param("sssssi", $firstName, $lastName, $emailAddress, $password, $role, $id);
            return $statement->execute();
        }

        public function updateAuthor($id, $firstName, $lastName, $role) {
            $statement = $this->connection->prepare("
                UPDATE `authors` 
                SET `first_name` = ?, 
                `last_name` = ?, 
                `role` = ? 
                WHERE `id` = ?;
            ");

            $statement->bind_param("sssi", $firstName, $lastName, $role, $id);
            return $statement->execute();
        }

        public function updateAuthorUser($id, $firstName, $lastName, $emailAddress) {
            $statement = $this->connection->prepare("
                UPDATE `authors` 
                SET `first_name` = ?, 
                `last_name` = ?, 
                `email_address` = ? 
                WHERE `id` = ?;
            ");

            $statement->bind_param("sssi", $firstName, $lastName, $emailAddress, $id);
            return $statement->execute();
        }

        public function updatePassword($emailAddress, $password) {
            $statement = $this->connection->prepare("
                UPDATE `authors` 
                SET `password` = ?
                WHERE `email_address` = ?; 
            ");

            $statement->bind_param("ss", $password, $emailAddress);
            return $statement->execute();
        }

        public function deleteAuthor($id) {
            $statement = $this->connection->prepare("
                DELETE FROM `authors` 
                WHERE `id` = ?;
            ");

            $statement->bind_param("i", $id);
            return $statement->execute();
        }

        public function getAuthor($id) {
            $statement = $this->connection->prepare("
                SELECT * FROM `authors` 
                WHERE `id` = ?;
            ");

            $statement->bind_param("i", $id);

            if (! $statement->execute()) {
                return [];
            }

            $result = $statement->get_result();
            $array = $this->output1dArray($result);
            return $this->escape1dArray($array);
        }

        public function getAuthorByEmailAddress($emailAddress) {
            $statement = $this->connection->prepare("
                SELECT * FROM `authors` 
                WHERE `email_address` = ?;
            ");

            $statement->bind_param("s", $emailAddress);

            if (! $statement->execute()) {
                return [];
            } 

            $result = $statement->get_result();
            $array = $this->output1dArray($result);
            return $this->escape1dArray($array);
        }

        public function getAuthors() {
            $statement = $this->connection->prepare("
                SELECT * FROM `authors`;
            ");

            if (! $statement->execute()) {
                return [];
            }

            $result = $statement->get_result();
            $a2dArray = $result->fetch_all(MYSQLI_ASSOC);
            return $this->escape2dArray($a2dArray);
        }
	}
?>