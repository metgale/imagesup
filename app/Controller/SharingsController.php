<?php

App::uses('AppController', 'Controller');

/**
 * Sharings Controller
 *
 * @property Sharing $Sharing
 * @property PaginatorComponent $Paginator
 */
class SharingsController extends AppController {

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
        $this->Sharing->recursive = 0;
        $this->set('sharings', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Sharing->id = $id;
        if (!$this->Sharing->exists()) {
            throw new NotFoundException(__('Invalid %s', __('sharing')));
        }
        $this->set('sharing', $this->Sharing->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($id) {
        if ($this->request->is('post')) {
            $this->Sharing->create();
            if ($this->Sharing->save($this->request->data)) {
                $this->Session->setFlash(
                        __('Album succesfully shared with the choosen doctor.'), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                        )
                );
                $this->redirect(array('controller' => 'albums', 'action' => 'index'));
            } else {
                $this->Session->setFlash(
                        __('Error occurred. Album not saved.'), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                        )
                );
            }
        }
        $album = $this->Sharing->Album->findById($id);
        $this->set('album', $album);
        $this->loadModel('User');
        $options = array(
            'User.userType' != 1
        );
        $manager = $this->User->find('list', $options);
        $this->set('manager', $manager);
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Sharing->id = $id;
        if (!$this->Sharing->exists()) {
            throw new NotFoundException(__('Invalid %s', __('sharing')));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Sharing->save($this->request->data)) {
                $this->Session->setFlash(
                        __('The %s has been saved', __('buuuuuyaaa')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                        )
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                        __('The %s could not be saved. Please, try again.', __('sharing')), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error'
                        )
                );
            }
        } else {
            $this->request->data = $this->Sharing->read(null, $id);
        }
        $albums = $this->Sharing->Album->find('list');
        $this->set(compact('albums'));
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
        $this->Sharing->id = $id;
        if (!$this->Sharing->exists()) {
            throw new NotFoundException(__('Invalid %s', __('sharing')));
        }
        if ($this->Sharing->delete()) {
            $this->Session->setFlash(
                    __('The %s deleted', __('sharing')), 'alert', array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-success'
                    )
            );
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(
                __('The %s was not deleted', __('sharing')), 'alert', array(
            'plugin' => 'TwitterBootstrap',
            'class' => 'alert-error'
                )
        );
        $this->redirect(array('action' => 'index'));
    }

}
