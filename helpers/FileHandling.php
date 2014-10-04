<?php
    class FileHandling {
    	// Lägger till en sträng i en fil. En radbrytning läggs in i slutet av strängen.
		public static function writeLineToFile($file, $line) {
			try {
				$handle = fopen($file, "a");
				if($handle) {
					fwrite($handle, $line . PHP_EOL);
				}
				fclose($handle);
			}
			catch(Exception $e) {
				throw new Exception("Error when writing to file.");
			}
		}
    }
?>