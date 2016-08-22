<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Pictures Controller
 *
 * @property \App\Model\Table\PicturesTable $Pictures
 */
class PicturesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(array('view', 'index'));
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $pictures = $this->paginate($this->Pictures);

        $this->set(compact('pictures'));
        $this->set('_serialize', ['pictures']);
    }

    /**
     * View method
     *
     * @param string|null $id Picture id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $picture = $this->Pictures->get($id, [
            'contain' => ['Tags']
        ]);

        $this->set('picture', $picture);
        $this->set('_serialize', ['picture']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $picture = $this->Pictures->newEntity();
		
        if ($this->request->is('post')) {
			
			debug($this->request->data);
			
            $picture = $this->Pictures->patchEntity($picture, $this->request->data);
			
			$file = $picture['upload'];

			$image_upload_path = WWW_ROOT . 'img' . DS . 'upload' . DS;
			$this->log($image_upload_path);
			$this->log($file);
			
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
			$this->log($ext);
			$arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions
			
			if($file['error'])
				$this->log($file['error']);

			if (in_array($ext, $arr_ext) && is_uploaded_file($file['tmp_name']))
			{
								
				$this->log('in moved');
				
				move_uploaded_file(
					$file['tmp_name'],
					$image_upload_path . $file['name']
				);
					
				// store the filename in the array to be saved to the db
				$picture['path'] = 'upload/' . $file['name'];
				
				            if ($this->Pictures->save($picture)) {
                $this->Flash->success(__('The picture has been saved.'));

                return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The picture could not be saved. Please, try again.'));
				}
			}else {
				$this->Flash->error(__('The picture could not be uploaded. Is it a jpg, jpeg or gif? Please, try again.'));
			}
		
			

        }
        $tags = $this->Pictures->Tags->find('list', ['limit' => 200]);
        $this->set(compact('picture', 'tags'));
        $this->set('_serialize', ['picture']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Picture id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $picture = $this->Pictures->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $picture = $this->Pictures->patchEntity($picture, $this->request->data);
            if ($this->Pictures->save($picture)) {
                $this->Flash->success(__('The picture has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The picture could not be saved. Please, try again.'));
            }
        }
        $tags = $this->Pictures->Tags->find('list', ['limit' => 200]);
        $this->set(compact('picture', 'tags'));
        $this->set('_serialize', ['picture']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Picture id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $picture = $this->Pictures->get($id);
        if ($this->Pictures->delete($picture)) {
            $this->Flash->success(__('The picture has been deleted.'));
        } else {
            $this->Flash->error(__('The picture could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
	}

	public function tags() 
	{
			$tags = $this->request->params['pass'];
			$pictures = $this->Pictures->find('tagged', [
					'tags' => $tags
			]);

			$this->set([
					'pictures' => $pictures,
					'tags' => $tags
			]);
	}


}
