<?php

App::uses('AppController', 'Controller');

/**
 * Albums Controller
 *
 * @property Album $Album
 * @property PaginatorComponent $Paginator
 */
class AlbumsController extends AppController {
    public function beforeFilter() {
        $this->Auth->allow('all');
        parent::beforeFilter();
    }
    /**
     *  Layout
     *
     * @var string
     */
    public $layout = 'default';

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        if ($this->Auth->user('userType') == 0) {
            $this->paginate = array(
                'limit' => 20,
                'order' => 'Album.created DESC',
                'contain' => 'Sharing',
                'conditions' => array(
                    'Album.user_id' => $this->Auth->user('id')
                )
            );
            $this->set('albums', $this->paginate());
        } else {
            $this->paginate = array(
                'Sharing' => array(
                    'conditions' => array(
                        'Sharing.manager' => $this->Auth->user('id'),
                        'Sharing.active' => 1
                    ),
                    'contain' => 'Album',
                    'limit' => 10
            ));
            $sharings = $this->paginate('Sharing');
            $this->set(compact('sharings'));
        }
    }
    public function imageview(){
        
    }

    public function archive() {
        $this->paginate = array(
            'Sharing' => array(
                'conditions' => array(
                    'Sharing.manager' => $this->Auth->user('id'),
                    'Sharing.active' => 0
                ),
                'contain' => 'Album',
                'limit' => 10
        ));
        $inactivesharings = $this->paginate('Sharing');
        $this->set(compact('inactivesharings'));
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Album->exists($id)) {
            throw new NotFoundException(__('Invalid Album'));
        }
        $options = array('conditions' => array('Album.' . $this->Album->primaryKey => $id));
        $this->set('album', $this->Album->find('first', $options));


        $this->set('sharing', $this->Album->Sharing->findById($this->request->query('sharing_id')));

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Album->Sharing->save($this->request->data)) {
                $this->Session->setFlash(
                        __('The %s has been saved', __('album')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                        )
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                        __('The %s could not be saved. Please, try again.', __('album')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                        )
                );
            }
        } else {
            $this->request->data = $this->Album->Sharing->read(null, $id);
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->log($this->request->data);
            $this->Album->create();
            if ($this->Album->save($this->request->data)) {
                $this->Session->setFlash(
                        __('The %s has been saved, please add some photos', __('album')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                        )
                );
                $this->redirect(array('action' => 'edit', $this->Album->id));
            } else {
                $this->Session->setFlash(
                        __('The %s could not be saved. Please, try again.', __('album')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                        )
                );
            }
        }
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        
        $this->Album->id = $id;
        $this->set('album', $this->Album->findById($id));
        if (!$this->Album->exists()) {
            throw new NotFoundException(__('Invalid %s', __('album')));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            debug($this->request->data);
            die;
            if ($this->Album->save($this->request->data)) {
                $this->Session->setFlash(
                        __('The %s has been saved', __('album')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                        )
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                        __('The %s could not be saved. Please, try again.', __('album')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                        )
                );
            }
        } else {
            $this->request->data = $this->Album->read(null, $id);
        }
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Album->id = $id;
        if (!$this->Album->exists()) {
            throw new NotFoundException(__('Invalid %s', __('album')));
        }
        if ($this->Album->delete()) {
            $this->Session->setFlash(
                    __('The %s deleted', __('album')), 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-success'
                    )
            );
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(
                __('The %s was not deleted', __('album')), 'alert', array(
            'plugin' => 'TwitterBootstrap',
            'class' => 'alert-error'
                )
        );
        $this->redirect(array('action' => 'index'));
    }

}
