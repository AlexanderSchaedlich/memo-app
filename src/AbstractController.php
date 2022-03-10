<?php 
	abstract class AbstractController {
	    // render a pages view
		protected function render($fileName, $parameters) {
			// extracts key-value pairs as variables from an associative array
			extract($parameters);
			// start the buffering
    		ob_start();
			// include the files
			include __DIR__ . "/../view/header.php";
			include __DIR__ . "/../view/{$fileName}.php";
			include __DIR__ . "/../view/footer.php";
			// end the buffering
			ob_end_flush();
		}
	    // if someone tries to access a user page without being loggeg in, go to log in
	    protected function checkLogin() {
	    	if (! isset($_SESSION["id"])) {
	    		header("Location: login");
	    	}
	    }
	    // if someone tries to access an admin page not being loggeg in or being a regular user, go to log in
	    protected function checkAdmin() {
	    	$this->checkLogin();
            
	    	if (! $_SESSION["admin"]) {
	    		header("Location: login");
	    	}
	    }
		// convert all applicable characters into html entities
        // both single and double quotes will be converted
	    protected function escape($string) {
	        return htmlentities($string, ENT_QUOTES, "UTF-8"); 
	    }

        protected function escape1dArray($array) {
            $newArray = [];

            foreach ($array as $key => $value) {
                $newArray[$key] = $this->escape($value);
            }

            return $newArray;
        }

        protected function escape2dArray($a2dArray) {
            $new2dArray = [];

            foreach ($a2dArray as $array) {
                $newArray = [];

                foreach ($array as $key => $value) {
                    $newArray[$key] = $this->escape($value);
                }

                array_push($new2dArray, $newArray);
            }

            return $new2dArray;
        }

        protected function output1dArray($result) {
            $array = $result->fetch_assoc();
            // check if there is a row
            if (is_null($array)) {
                return [];
            } else {
                return $array;
            }
        }

        protected function generatePassword() {
            // set up the characters grouping them by type
            $arrayOfStrings = [
                "abcdefghijklmnopqrstuvwxyz",
                "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
                "0123456789",
                "!#$%&()*+,-./:;=?[]{}~|@_^" // many characters for high entropy
            ];
            // generate the password length
            $length = random_int(20, 32);
            // generate a string
            $result = $this->generateString($arrayOfStrings, $length, true);

            // if the result string matches one of the top 10,000 common passwords, recreate it
            if ($this->equalsKnown($result)) {
                return $this->generatePassword();
            }

            return $result;
        }

        protected function generateURLKey() {
            // set up the characters grouping them by type
            $arrayOfStrings = [
                "abcdefghijklmnopqrstuvwxyz",
                "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
                "0123456789",
                "-._~" // these characters can be used in the url, as they have no special meaning in a url context
            ];

            return $this->generateString($arrayOfStrings, 255, false); // big length for high entropy
        }

        // $arrayOfStrings should contain an array of strings of characters of specific types (such as lowercase letters, uppercase letters, digits and special characters)
        // $length of the string to be generated
        // $allTypesAreRequired indicates that at least one character of every provided type should be used
        protected function generateString($arrayOfStrings, $length, $allTypesAreRequired) {
            $result = "";
            $characters = implode("", $arrayOfStrings);

        	// create a random string of a given length using a cryptographically secure pseudo-random integer generator
        	for ($i = 0; $i < $length; $i++) {
        		// add a random character
		        $result .= $characters[random_int(0, strlen($characters) - 1)];
		    }


            // To make sure that all character types are used, add one character of every type at a unique position.
            if ($allTypesAreRequired) {
                for ($i = 0; $i < count($arrayOfStrings); $i++) {
                    if ($i == 0) {
                        $uniqueIndexes[0] = random_int(0, strlen($result) - 1);
                    } else {
                        $uniqueIndex = $this->generateIntegerOtherThan(0, strlen($result) - 1, $uniqueIndexes);
                        array_push($uniqueIndexes, $uniqueIndex);
                    }

                    $result[$uniqueIndexes[$i]] = $arrayOfStrings[$i][random_int(0, strlen($arrayOfStrings[$i]) - 1)];
                } 
            }

		    return $result;
        }

        protected function generateIntegerOtherThan($min, $max, $referenceArray) {
            if ($max - $min < 1) {
                return null;
            }

            $result = random_int($min, $max);

            foreach ($referenceArray as $reference) {
                if ($result == $reference) {
                    return $this->generateIntegerOtherThan($min, $max, $referenceArray);
                }
            }

            return $result;
        }

        protected function equalsKnown($string) {
            // prepare an array with the top 10,000 common passwords
            $commonPasswords = file(__DIR__ . "/../top10000commonPasswords.txt", FILE_IGNORE_NEW_LINES);
            // check if the array contains the provided string
            return in_array($string, $commonPasswords);
        }
	}
?>