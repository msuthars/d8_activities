<?php

namespace Drupal\d8_formapi\Services\Form;

use Drupal\Core\Database\Connection;

/**
 * Form Data Manager service.
 * 
 * @package Drupal\d8_formapi\Services
 */
class FormDataManager implements FormDataManagerInterface {

	/**
	 * Database Connection.
	 * 
	 * @var \Drupal\Core\Database\Connection;
	 */
	protected $connection;

	/**
	 * Form Data Manager Constructor.
	 * 
	 * @param \Drupal\Core\Database\Connection $connection
	 *   Database connection.
	 */
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}

	/**
	 * Get Last Submitted data of Subscriber Form.
	 * 
	 * @return array
	 *   Last submitted data.
	 */
	public function getSubscriberFormData() {
		$query = $this->connection->select('d8_demo', 'd8d');
		$query->fields('d8d', ['email', 'first_name', 'last_name']);
		$query->orderBy('d8d.id', 'DESC');
		$query->range(0, 1);
		$result = $query->execute()->fetchAssoc();
		return $result;
	}

	/**
	 * Save Subscriber form data.
	 * 
	 * @param array $data
	 *   User submitted (first name, last name & email) data.
	 */
	public function setSubscriberFormData($data) {
		$query = $this->connection->insert('d8_demo');
		$query->fields([
			'email' => $data['email'],
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
		]);
		$result = $query->execute();
		return $result;
	}

	/**
	 * State List according country.
	 * 
	 * @return array
	 *   Return associative array of state list.
	 */
	public function getStateList() {
		$states['IN'] = constant('self::INDIAN_STATE');
		$states['GB'] = constant('self::UK_COUNTIES');
		return $states;
	}

}