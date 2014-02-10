<?php

App::uses('AppController', 'Controller');

/**
 * Albums Controller
 *
 * @property Album $Album
 * @property PaginatorComponent $Paginator
 */
class AlbumsController extends AppController {

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
                    'limit' => 10,
            ));
            $sharings = $this->paginate('Sharing');
            $this->set(compact('sharings'));
            
            $this->paginate = array(
                'Sharing' => array(
                    'conditions' => array(
                        'Sharing.manager' => $this->Auth->user('id'),
                        'Sharing.active' => 0
                    ),
                    'limit' => 10,
            ));
            $inactivesharings = $this->paginate('Sharing');
            $this->set(compact('inactivesharings'));
        }
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Album->id = $id;
        if (!$this->Album->exists()) {
            throw new NotFoundException(__('Invalid %s', __('album')));
        }
        $this->set('album', $this->Album->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Album->create();
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
        if (!$this->Album->exists()) {
            throw new NotFoundException(__('Invalid %s', __('album')));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
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
