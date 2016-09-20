<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Network\Exception\NotImplementedException;

class ContactForm extends Form 
{

    protected function _buildSchema(Schema $schema) 
    {
        return $schema
            ->addField('name', 'string') 
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator
            -> add('name', 'length', ['rule' => ['minLength', 10], 'messsage' => 'A name is required'])
            -> add('email', 'format', ['rule' => 'email', 'message'=>'A valid email is required']);
                   
    }

    protected function _execute(array $data) 
    {
        debug($data);
        $email = new Email('default');
        return $email
            ->to('warneke.mark@gmail.com')
            ->subject('Webseiten Kontaktanfrage von ' . $data['name'])
            ->send($data['name'] . ' ' . $data['email'] . ': ' . $data['message'] );
    }
}

?>
