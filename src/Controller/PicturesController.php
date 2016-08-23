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
			
			$picture['path'] = $this->persistImage($picture['upload']);	
			debug($picture['path']);
			$picture['thumb'] = $this->persistThumbForImage($picture['path'], $picture['upload'], 20);
			debug($picture['thumb']);
			
			debug($picture);
			
			
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
	
	/**
	* Saves the given file into WWW_ROOT/img/upload
	* returns the path to the persistet image if successfull
	* @param image to persist
	* @return file path
	*/
	private function persistImage($file) {
		
		$image_path = WWW_ROOT . 'img' . DS;
		$image_upload_path = 'upload/';
		$this->log($image_upload_path);
		
		$this->log($file);
		
		$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
		$this->log($ext);
		$arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions
		
		if($file['error']) {
			$this->Flash->error(__('The picture could not be uploaded. Is it a jpg, jpeg or gif? Please, try again.'));
			return;
		} elseif(in_array($ext, $arr_ext) && is_uploaded_file($file['tmp_name']))
		{
			$this->log('in moved');
			
			move_uploaded_file(
				$file['tmp_name'],
				$image_path . $image_upload_path . $file['name']
			);
				
			// store the filename in the array to be saved to the db
			return $image_upload_path . $file['name'];
		} else {
			$this->Flash->error(__('The picture could not be stored on the server. Please, try again.'));
			return;
		}
	}
	
	/**
	* compresses the given $source file and creates an image based on mime type (jpeg/png)
	* Saves the image with given quality (value between 1 - 100) at the destination path
	* @param source image
	* @param destination path to store
	* @quality quality of the saved image
	*/
	private function compressImage($source, $destination, $quality) {
		$info = getimagesize($source);
		debug($info);
		
		if ($info['mime'] == 'image/jpeg') {
			$image = imagecreatefromjpeg($source);
			debug($image);
					
			$thumb = $this->createThumb($image, 200);	
			debug($thumb);
			
			imagejpeg($thumb, $destination, $quality);
			imagedestroy($thumb);
			imagedestroy($image);
			
		} elseif($info['mime'] == 'image/png') {
			$image = imagecreatefrompng($source);
			debug($image);
			$thumb = $this->createThumb($image, 200);	
			
			imageAlphaBlending($thumb, true);
			imageSaveAlpha($thumb, true);
			$png_quality = 9 - ($quality * 9) / 100;
			imagePng($thumb, $destination, $png_quality);
			imagedestroy($thumb);
			imagedestroy($image);
		}
		
		debug($destination);
		$this->log($destination);
		
		return $destination;
	}
	
	/**
	* Saves the compresse the image 
	*/
	private function persistThumbForImage($path_to_persited, $image_meta, $quality) {
		
		$image_path = WWW_ROOT . 'img/';
		$image_thumb_path = 'upload/thumb/';
		$image_name_thumb_path = $image_thumb_path  . 'thumb_' . $image_meta['name'];
		
		$this->log($image_name_thumb_path);
		$this->compressImage($image_path . $path_to_persited, $image_path . $image_name_thumb_path, $quality);
		
		return $image_name_thumb_path;
	}
	
	/*
	* Creates new image from passed image and crops the new image to passed with
	* @param image to be cloned
	* @param width the new image should have
	*/
	private function createThumb($image, $thumbWidth) {
		$width = imagesx($image);
		$height = imagesy($image);
		$new_width = $thumbWidth;
		$new_height = floor($height * ($new_width / $width) );
		$tmp_img = imagecreatetruecolor($new_width, $new_height);
		imagecopyresized($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		debug($tmp_img);
		debug($image);
		return $tmp_img;
	}


}
