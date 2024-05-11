<?php

class Logger {
	public function debug($message) {
		$this->writeLog('DEBUG', $message);
	}

	public function info($message) {
		$this->writeLog('INFO', $message);
	}

	public function error($message) {
		$this->writeLog('ERROR', $message);
	}

	private function writeLog($level, $message) {
		$timestamp = date('Y-m-d H:i:s');

		// Format the log message with the timestamp
		$log_message = "[$timestamp] [$level] $message" . PHP_EOL;

		// Write $log_message to a file or any other log destination
		// For example:
		file_put_contents(APPPATH . 'logs/logfile.log', $log_message, FILE_APPEND);
	}

//	private function writeLog($level, $message) {
//		$log_message = '[' . date('Y-m-d H:i:s') . '] [' . $level . '] ' . $message . PHP_EOL;
//		// Write $log_message to a file or any other log destination
//		// For example:
//		file_put_contents(APPPATH . 'logs/logfile.log', $log_message, FILE_APPEND);
//	}
}
