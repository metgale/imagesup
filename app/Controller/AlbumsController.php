<?php

App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
App::uses('Sanitize', 'Utility');
require_once APP . 'Vendor' . DS . 'PHPThumb' . DS . 'ThumbLib.inc.php';

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

    public function imageview() {
        
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
        $options = array(
            'contain' => 'Upload',
            'conditions' => array('Album.' . $this->Album->primaryKey => $id));
        $this->set('album', $this->Album->find('first', $options));


        $this->paginate = array(
            'limit' => 1,
            'order' => 'Upload.created ASC',
            'conditions' => array(
                'Upload.album_id' => $id
            )
        );
        $this->set('images', $this->paginate('Upload'));



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

        $files = (array) $this->Album->uploadedFiles($id);
        $this->set(compact('files'));

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

    public function upload() {
        // $this->log($this->request);
        if (env('SERVER_ADDR') === '127.0.0.1') {
            sleep(2);
        }
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new BadRequestException();
        }

        if (empty($this->request->data['Album']['id'])) {
            throw new BadRequestException('Missing album ID');
        }
        $albumId = (int) $this->request->data['Album']['id'];
        $album = $this->Album->find('first', array(
            'conditions' => array(
                'id' => $albumId,
                'user_id' => $this->Auth->user('id')
            )
        ));
        if (empty($album)) {
            throw new NotFoundException();
        }

        $path = WWW_ROOT . 'img' . DS . $albumId . DS;
        try {
            $name = $this->_uploadFile($this->request->params['form']['files'], $path);
        } catch (Exception $e) {
            $this->log(array($e->getMessage(), $e->getTraceAsString(), $this->request));
        }

        $response = new stdClass();
        if (empty($name)) {
            $response->error = 'abort';
            echo json_encode(array('files' => $response));
            return false;
        }

        $file = new File($path . $name);
        $data = array(
            'album_id' => $albumId,
            'user_id' => $this->Auth->user('id'),
            'name' => $name,
            'size' => $file->size(),
            'type' => $file->mime(),
        );
        if (!$this->Album->Upload->save($data)) {
            $this->log('Cannot save Upload. ' . json_encode($this->Album->Upload->validationErrors));
        }

        $response->name = $name;
        echo json_encode(array('files' => array($response)));
    }

    protected function _uploadFile($file, $path) {
        if (empty($file['name'][0]) || $file['error'][0] !== 0) {
            throw new InvalidArgumentException('Missing file name');
        }

        if (!is_file($file['tmp_name'][0])) {
            throw new RuntimeException('Invalid tmp file');
        }

        $folder = new Folder($path, true, '755');
        if ($folder->errors()) {
            throw new RuntimeException(implode('.', $folder->errors()));
        }

        $name = uniqid() . '_' . Sanitize::paranoid($file['name'][0], array('-', '_', '.'));
        if (!move_uploaded_file($file['tmp_name'][0], $path . $name)) {
            throw new RuntimeException('Cannot move tmp file');
        }
        chmod($path . $name, 0777);

        if ($file['type'][0] === 'archive/zip') {
            // unzip
            // foreach files
        }

        if (in_array($file['type'][0], array('image/jpeg', 'image/png'))) {
            $this->resize($name, $path);
        }

        return $name;
    }

    /**
     * List album files
     *
     * @param type $albumId
     * @return array
     */
    public function files($albumId) {
        $files = (array) $this->Album->uploadedFiles($albumId);
        $this->set(compact('files'));

        $this->viewPath = 'Elements';
        $this->render('files');
    }

    /**
     * Create thumb_imagename.jpg
     * @param type $name
     * @param type $path
     * @return boolean
     */
    protected function resize($name, $path) {
        $image = $path . 'thumb_' . $name;
        try {
            $thumb = PhpThumbFactory::create($path . $name);
            $thumb->adaptiveResize(175, 175);
            $thumb->show();
            $thumb->save($image);
            chmod($image, 0777);
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return false;
        }

        return true;
    }

}
