<?php

App::uses('AppModel', 'Model');

/**
 * Upload Model
 *
 * @property Upload $Upload
 */
class Upload extends AppModel {


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

        'album_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
			),
        ),
		'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
			),
        ),
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            ),
        ),
		'size' => array(
            'numeric' => array(
                'rule' => array('numeric'),
			),
        ),
		'type' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
			),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Album'
    );

}
