<?php

require_once CORE_TEST_CASES . DS . 'Model' . DS . "ModelTestBase.php";
App::uses('WikiAppModel', 'Wiki.Model');

class WikiAppModelTest extends BaseModelTest {

	/**
	 * testGet function
	 * @retun void
	 */
	public function testGet() {
		$this->loadFixtures('User');
		$model = new WikiAppModel(array(
				'table' => 'users',
				'alias' => 'User',
			));

		$model->id = 1;
		$model->read();

		$this->assertEqual($model->get('user'), $model->data['User']['user']);
		$this->assertEqual($model->get('User.user'), $model->data['User']['user']);

		$model->set('user', '');

		$this->assertTrue($model->check('user'));
		$this->assertTrue($model->check('User.user'));
		$this->assertFalse($model->check('id'));
		$this->assertFalse($model->check('User.id'));
	}

}