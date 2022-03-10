<?php  
	class MemosRepository extends AbstractController {
		private $connection;

        public function __construct($dbConnection) {
            $this->connection = $dbConnection;
        }

        public function createMemo($fkAuthor, $title, $text, $visibility) {
            $statement = $this->connection->prepare("
                INSERT INTO `memos` 
                (`fk_author`, `title`, `text`, `visibility`) 
                VALUES 
                (?, ?, ?, ?);
            ");

            $statement->bind_param("isss", $fkAuthor, $title, $text, $visibility);
            return $statement->execute();
        }

        public function updateMemo($fkAuthor, $date, $title, $text, $visibility) {
            $statement = $this->connection->prepare("
                UPDATE `memos` 
                SET `title` = ?, 
                `text` = ?, 
                `visibility` = ?
                WHERE `fk_author` = ?
                AND `date` = ?;
            ");

            $statement->bind_param("sssis", $title, $text, $visibility, $fkAuthor, $date);
            return $statement->execute();
        }

        public function deleteMemo($fkAuthor, $date) {
            $statement = $this->connection->prepare("
                DELETE FROM `memos` 
                WHERE `fk_author` = ?
                AND `date` = ?;
            ");

            $statement->bind_param("is", $fkAuthor, $date);
            return $statement->execute();
        }

        public function deleteMemosByAuthor($id) {
            $statement = $this->connection->prepare("
                DELETE FROM `memos` 
                WHERE `fk_author` = ?;
            ");

            $statement->bind_param("i", $id);
            return $statement->execute();
        }

        public function getMemoById($id) {
            $statement = $this->connection->prepare("
                SELECT * FROM `memos` 
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

        public function getMemoByAuthorDate($fkAuthor, $date) {
            $statement = $this->connection->prepare("
                SELECT * FROM `memos` 
                WHERE `fk_author` = ?
                AND `date` = ?;
            ");

            $statement->bind_param("is", $fkAuthor, $date);

            if (! $statement->execute()) {
                return [];
            }

            $result = $statement->get_result();
            $array = $this->output1dArray($result);
            return $this->escape1dArray($array);
        }

        public function getAuthorsLastMemo($fkAuthor) {
            $statement = $this->connection->prepare("
                SELECT * FROM `memos` 
                WHERE `fk_author` = ?
                AND `date` = (
                    SELECT MAX(`date`) FROM `memos` 
                    WHERE `fk_author` = ?
                );
            ");

            $statement->bind_param("ii", $fkAuthor, $fkAuthor);

            if (! $statement->execute()) {
                return [];
            }

            $result = $statement->get_result();
            $array = $this->output1dArray($result);
            return $this->escape1dArray($array);
        }

        public function getOpenMemos() {
            $statement = $this->connection->prepare("
                SELECT `authors`.`first_name`, 
                    `authors`.`last_name`, 
                    `memos`.`fk_author`, 
                    `memos`.`date`, 
                    `memos`.`title`, 
                    `memos`.`text`
                FROM `memos` 
                JOIN `authors` 
                ON `memos`.`fk_author` = `authors`.`id` 
                WHERE `visibility` = 'public';
            ");

            if (! $statement->execute()) {
                return [];
            }

            $result = $statement->get_result();
            $a2dArray = $result->fetch_all(MYSQLI_ASSOC);
            return $this->escape2dArray($a2dArray);
        }

        public function getMemosByAuthor($fkAuthor) {
            $statement = $this->connection->prepare("
                SELECT * FROM `memos` 
                WHERE `fk_author` = ?;
            ");

            $statement->bind_param("i", $fkAuthor);

            if (! $statement->execute()) {
                return [];
            }

            $result = $statement->get_result();
            $a2dArray = $result->fetch_all(MYSQLI_ASSOC);
            return $this->escape2dArray($a2dArray);
        }
	}
?>