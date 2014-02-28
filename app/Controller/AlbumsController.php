<?php

App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
App::uses('Sanitize', 'Utility');
require_once APP . 'Vendor' . DS . 'PHPThumb' . DS . 'ThumbLib.inc.php';
require_once APP . 'Lib' . DS . 'nanodicom' . DS . 'nanodicom.php';
require_once APP . 'Lib' . DS . 'nanodicom' . DS . 'ExtractDataFromDiCOM.php';

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
                'contain' => array('Sharing', 'Upload' => array(
                        'conditions' => array('Upload.type' => array('image/jpeg'))
                    )),
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
                    'contain' => array('Album' => array('User', 'Upload' => array(
                                'conditions' => array('Upload.type' => array('image/jpeg'))))),
                    'limit' => 10
            ));
            $sharings = $this->paginate('Sharing');
            $this->set(compact('sharings'));
        }
    }

    public function archive() {
        $this->paginate = array(
            'Sharing' => array(
                'conditions' => array(
                    'Sharing.manager' => $this->Auth->user('id'),
                    'Sharing.active' => 0
                ),
                'contain' => array('Album' => array('User', 'Upload' => array(
                            'conditions' => array('Upload.type' => array('image/jpeg'))))),
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
    public function view($id, $folderId = null) {
        if (isset($this->request->query['success'])) {
            if ($this->request->query['success'] == true) {
                $this->Session->setFlash(
                        ('Images upload successful. You can now browse image study, or share it with doctor.'), 'alert', array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-success'
                        )
                );
            }
        }
        if (!$this->Album->exists($id)) {
            throw new NotFoundException(__('Invalid Album'));
        }

        $album = $this->Album->find('first', array(
            'conditions' => array('Album.' . $this->Album->primaryKey => $id),
            'contain' => array('Upload')
        ));


        $folders = array();
        foreach ($album['Upload'] as $image) {
            if ($image['folder'] != null) {
                $folders[$image['folder']] = $image['folder_title'];
            }
        }
        $this->set('folders', $folders);
        $this->set('id', $id);
        if (empty($folderId)) {
            $folderid = null;
        }
        $album = $this->Album->find('first', array(
            'conditions' => array('Album.' . $this->Album->primaryKey => $id),
            'contain' => array('User', 'Upload' => array(
                    'order' => 'Upload.order ASC',
                    'conditions' => array('Upload.type' => array('image/jpeg', 'image/png', 'Upload.'), 'Upload.folder' => $folderId)
                ))
        ));
        $this->set('album', $album);

        $this->set('count', count($album['Upload']));

        $options = array(
            'order' => 'Upload.order ASC',
            'conditions' => array(
                'Upload.album_id' => $id,
                'Upload.type' => array('image/jpeg', 'image/png'),
                'Upload.folder' => $folderId
            )
        );
        $imgid = $this->request->query('imgid');
        if (!empty($imgid)) {
            $options = array(
                'order' => 'Upload.order DESC',
                'conditions' => array(
                    'Upload.id' => $imgid
                )
            );
        }
        $image = $this->Album->Upload->find('first', $options);
        $this->set('image', $image);
        debug($image);
        $neighbors = array();
        if ($image) {
            $neighbors = $this->Album->Upload->find('neighbors', array(
                'field' => 'id',
                'value' => $image['Upload']['id'],
                'fields' => array('id', 'name', 'album_id', 'folder', 'order'),
                'order' => 'Upload.order DESC',
                'conditions' => array('Upload.type' => array('image/jpeg', 'image/png'),
                    'Upload.album_id' => $image['Upload']['album_id'], 'Upload.folder' => $image['Upload']['folder'])
            ));
        }
        $this->set('neighbors', $neighbors);
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
     * Jquery Upload handler
     */
    public function upload($albumId) {
        // $this->log($this->request);
        if (env('SERVER_ADDR') === '127.0.0.1') {
            sleep(2);
        }
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new BadRequestException();
        }

        if (empty($albumId)) {
            throw new BadRequestException('Missing album ID');
        }

        $album = $this->Album->find('first', array(
            'conditions' => array(
                'id' => $albumId,
                'user_id' => $this->Auth->user('id')
            )
        ));
        if (empty($album)) {
            throw new NotFoundException();
        }

        if (empty($this->request->params['form']['files'])) {
            throw new InvalidArgumentException('Missing upload file');
        }
        $file = $this->request->params['form']['files'];

        $path = WWW_ROOT . 'img' . DS . 'uploads' . DS . $albumId . DS;
        try {
            $name = $this->_uploadFile($file, $path);
        } catch (Exception $e) {
            $this->log(array($e->getMessage(), $e->getTraceAsString(), $this->request));
        }

        $response = new stdClass();
        if (empty($name)) {
            $response->error = 'abort';
            echo json_encode(array('files' => $response));
            return false;
        }

        $uploadedFile = new File($path . $name);
        $data = array(
            'album_id' => $albumId,
            'user_id' => $this->Auth->user('id'),
            'name' => $name,
            'path' => '/img/uploads/' . $albumId . '/',
            'size' => $uploadedFile->size(),
            'type' => $uploadedFile->mime(),
        );
        if (!$this->Album->Upload->save($data)) {
            $dump = array($data, $this->Album->Upload->validationErrors);
            $this->log('Save failed' . json_encode($dump));
        }

        if (in_array($uploadedFile->mime(), array('image/jpeg', 'image/png'))) {
            $this->_createThumb($name, $path);
        }

        $folders = array(); // used for redirection after upload completes
        if ($uploadedFile->mime() === 'application/zip') {
            foreach ($this->_extractDicom($name, $path, $albumId) as $image) {
                $data = array_merge($data, $image);
                $folders[] = $image['folder'];
                $this->Album->Upload->create();
                if (!$this->Album->Upload->save($data)) {
                    $dump = array($data, $this->Album->Upload->validationErrors);
                    $this->log('Save failed' . json_encode($dump));
                }
            }
        }
        sort($folders);

        $response->name = $name;
        echo json_encode(array(
            'files' => array($response),
            'folder' => empty($folders[0]) ? null : $folders[0]
        ));
    }

    /**
     * Handle HTTP POST upload
     *
     * @param type $file
     * @param type $path
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
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

        return $name;
    }

    /**
     * Create thumb_imagename.jpg
     * @param type $name
     * @param type $path
     * @return boolean
     */
    protected function _createThumb($name, $path) {
        $image = $path . 'thumb_' . $name;
        try {
            $thumb = PhpThumbFactory::create($path . $name);
            $thumb->adaptiveResize(165, 165);
            $thumb->save($image);
            chmod($image, 0777);
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return false;
        }

        return true;
    }

    protected function _extractDicom($name, $path, $albumId) {
        $zip = new ZipArchive;
        $zip->open($path . $name);
        $extractFolder = $path . rtrim($name, '.zip');
        $zip->extractTo($extractFolder);
        $zip->close();

        $folder = new Folder($extractFolder);

        // checking for nested folder
        $tree = $folder->tree(null, true, 'dir');
        $deepestFolder = end($tree);
        $convertDir = dirname($deepestFolder);

        $extractor = new DicomExtractor();
        $dicoms = $extractor->parse($convertDir, rtrim($path, DS));

        $folder->delete();
        @rmdir($extractFolder);

        $result = array();
        foreach ($dicoms as $directory) {
            foreach ($directory['images'] as $image) {
                $dicomPath = $path . $directory['directory'] . DS;
                $this->_createThumb($image['fileName'], $dicomPath);
                $uploadedFile = new File($dicomPath . $image['fileName']);
                $result[] = array(
                    'folder' => $directory['directory'],
                    'name' => $image['fileName'],
                    'path' => '/img/uploads/' . $albumId . '/' . $directory['directory'] . '/',
                    'description' => @file_get_contents($dicomPath . $image['txtFileName']),
                    'order' => $image['order'],
                    'size' => $uploadedFile->size(),
                    'type' => $uploadedFile->mime(),
                    'folder_title' => $directory['title']
                );
            }
        }
        return $result;
    }

}
